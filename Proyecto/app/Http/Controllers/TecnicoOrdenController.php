<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TecnicoOrdenController extends Controller
{
    /**
     * Dashboard del técnico con sus órdenes asignadas
     */
    public function dashboard()
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Obtener órdenes asignadas al técnico
        $ordenesAsignadas = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->whereIn('estado', ['asignada', 'en_progreso', 'diagnostico'])
            ->with(['cliente', 'equipo.marca'])
            ->orderBy('prioridad', 'desc')
            ->orderBy('fecha_programada', 'asc')
            ->get();

        $ordenesCompletadas = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->where('estado', 'completada')
            ->whereMonth('fecha_completada', now()->month)
            ->count();

        $ordenesPendientes = $ordenesAsignadas->whereIn('estado', ['asignada', 'diagnostico'])->count();
        $ordenesEnProgreso = $ordenesAsignadas->where('estado', 'en_progreso')->count();

        // Estadísticas del técnico
        $estadisticas = [
            'asignadas' => $ordenesAsignadas->count(),
            'pendientes' => $ordenesPendientes,
            'en_progreso' => $ordenesEnProgreso,
            'completadas_mes' => $ordenesCompletadas,
        ];

        return view('tecnico.dashboard', compact('tecnico', 'ordenesAsignadas', 'estadisticas'));
    }

    public function index()
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Obtener todas las órdenes del técnico con relaciones
        $ordenes = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->with(['cliente', 'equipo.marca'])
            ->orderBy('prioridad', 'desc')
            ->orderBy('fecha_programada', 'asc')
            ->paginate(15);

        return view('tecnico.ordenes.index', compact('tecnico', 'ordenes'));
    }

    public function show(OrdenServicio $orden)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Verificar que la orden pertenece al técnico
        if ($orden->tecnico_id !== $tecnico->id) {
            abort(403, 'No tienes permiso para ver esta orden');
        }

        // Cargar las relaciones necesarias
        $orden->load(['cliente', 'equipo.marca']);
        
        return view('tecnico.ordenes.show', compact('orden'));
    }

    public function actualizarEstado(Request $request, OrdenServicio $orden)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Verificar que la orden pertenece al técnico
        if ($orden->tecnico_id !== $tecnico->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta orden'
            ], 403);
        }

        $request->validate([
            'estado' => 'required|in:asignada,diagnostico,en_progreso,completada,cancelada'
        ]);

        try {
            $orden->update([
                'estado' => $request->estado
            ]);

            // Si cambia a en_progreso por primera vez, registrar fecha de inicio
            if ($request->estado === 'en_progreso' && !$orden->fecha_inicio_trabajo) {
                $orden->update(['fecha_inicio_trabajo' => now()]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    public function agregarDiagnostico(Request $request, OrdenServicio $orden)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        if ($orden->tecnico_id !== $tecnico->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta orden'
            ], 403);
        }

        $request->validate([
            'diagnostico' => 'required|string|min:10'
        ]);

        try {
            $orden->update([
                'dictamen_tecnico' => $request->diagnostico,
                'estado' => 'diagnostico'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Diagnóstico agregado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar el diagnóstico'
            ], 500);
        }
    }

    public function agregarObservacion(Request $request, OrdenServicio $orden)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        if ($orden->tecnico_id !== $tecnico->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta orden'
            ], 403);
        }

        $request->validate([
            'observacion' => 'required|string'
        ]);

        try {
            $orden->update([
                'observaciones_tecnico' => $request->observacion
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Observación agregada correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar la observación'
            ], 500);
        }
    }

    public function completar(Request $request, OrdenServicio $orden)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        if ($orden->tecnico_id !== $tecnico->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta orden'
            ], 403);
        }

        $request->validate([
            'dictamen_tecnico' => 'required|string|min:20',
            'observaciones_tecnico' => 'nullable|string',
            'costo_total' => 'required|numeric|min:0',
            'fecha_completada' => 'required|date'
        ]);

        try {
            $orden->update([
                'estado' => 'completada',
                'dictamen_tecnico' => $request->dictamen_tecnico,
                'observaciones_tecnico' => $request->observaciones_tecnico,
                'costo_total' => $request->costo_total,
                'fecha_completada' => $request->fecha_completada
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Orden completada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al completar la orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Subir fotos del técnico (antes y después)
     */
    public function subirFoto(Request $request, OrdenServicio $orden)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Verificar que la orden pertenece al técnico
        if ($orden->tecnico_id !== $tecnico->id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para modificar esta orden'
            ], 403);
        }

        $request->validate([
            'foto' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:10240',
            'columna' => 'required|in:fotos_antes,fotos_despues'
        ]);

        try {
            $columna = $request->columna;
            $archivo = $request->file('foto');

            // Usar el servicio BunnyCDN para subir
            $bunnyCdnService = new \App\Services\BunnyCdnService();
            $resultado = $bunnyCdnService->uploadImage($archivo, 'tecnico-fotos');

            if (!$resultado['success']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al subir la foto a Bunny CDN'
                ], 500);
            }

            // Obtener las fotos actuales
            $fotosActuales = $orden->$columna ?? [];
            if (!is_array($fotosActuales)) {
                $fotosActuales = [];
            }

            // Agregar la nueva foto
            $fotosActuales[] = $resultado['url'];

            // Actualizar la orden
            $orden->update([
                $columna => $fotosActuales
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Foto subida correctamente',
                'url' => $resultado['url']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir la foto: ' . $e->getMessage()
            ], 500);
        }
    }
}