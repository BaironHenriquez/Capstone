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
        
        // Obtener órdenes en proceso (activas)
        $ordenesEnProceso = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->whereIn('estado', ['asignada', 'diagnostico', 'espera_repuesto', 'en_progreso', 'listo_retiro'])
            ->with(['cliente', 'equipo.marca'])
            ->orderBy('prioridad', 'desc')
            ->orderBy('fecha_programada', 'asc')
            ->get();

        $ordenesCompletadas = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->where('estado', 'completada')
            ->whereMonth('fecha_completada', now()->month)
            ->count();

        $ordenesCanceladas = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->where('estado', 'cancelada')
            ->count();

        $ordenesPendientes = $ordenesEnProceso->whereIn('estado', ['asignada', 'diagnostico'])->count();
        $ordenesEnProgreso = $ordenesEnProceso->where('estado', 'en_progreso')->count();
        $ordenesEsperandoRepuesto = $ordenesEnProceso->where('estado', 'espera_repuesto')->count();
        $ordenesListasRetiro = $ordenesEnProceso->where('estado', 'listo_retiro')->count();

        // Estadísticas del técnico
        $estadisticas = [
            'activas' => $ordenesEnProceso->count(),
            'asignadas' => $ordenesPendientes,
            'diagnostico' => $ordenesEnProceso->where('estado', 'diagnostico')->count(),
            'en_progreso' => $ordenesEnProgreso,
            'espera_repuesto' => $ordenesEsperandoRepuesto,
            'listo_retiro' => $ordenesListasRetiro,
            'completadas_mes' => $ordenesCompletadas,
            'canceladas' => $ordenesCanceladas,
        ];

        // Alias para mantener compatibilidad con la vista
        $ordenesAsignadas = $ordenesEnProceso;

        return view('tecnico.dashboard', compact('tecnico', 'ordenesEnProceso', 'ordenesAsignadas', 'estadisticas'));
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
            'estado' => 'required|in:asignada,diagnostico,espera_repuesto,en_progreso,listo_retiro,completada,cancelada'
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

    /**
     * Vista de ganancias del técnico
     */
    public function ganancias(Request $request)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Filtros de fecha
        $fechaInicio = $request->get('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));

        // Obtener órdenes completadas con ganancias
        $ordenesCompletadas = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->where('estado', 'completada')
            ->whereBetween('fecha_completada', [$fechaInicio, $fechaFin])
            ->with(['cliente', 'equipo.marca'])
            ->orderBy('fecha_completada', 'desc')
            ->get();

        // Calcular ganancias totales
        $gananciaTotal = $ordenesCompletadas->sum('comision_tecnico');
        
        // Ganancias por mes (últimos 6 meses)
        $gananciasPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $mesNombre = $mes->locale('es')->isoFormat('MMM YYYY');
            $ganancia = OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->whereYear('fecha_completada', $mes->year)
                ->whereMonth('fecha_completada', $mes->month)
                ->sum('comision_tecnico');
            
            $gananciasPorMes[] = [
                'mes' => $mesNombre,
                'ganancia' => $ganancia
            ];
        }

        // Estadísticas
        $estadisticas = [
            'total_ganado' => $gananciaTotal,
            'ordenes_completadas' => $ordenesCompletadas->count(),
            'promedio_por_orden' => $ordenesCompletadas->count() > 0 ? $gananciaTotal / $ordenesCompletadas->count() : 0,
            'mes_actual' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->whereMonth('fecha_completada', now()->month)
                ->whereYear('fecha_completada', now()->year)
                ->sum('comision_tecnico'),
        ];

        // Top 5 órdenes más rentables
        $topOrdenes = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->where('estado', 'completada')
            ->with(['cliente', 'equipo.marca'])
            ->orderBy('comision_tecnico', 'desc')
            ->limit(5)
            ->get();

        return view('tecnico.ganancias', compact(
            'tecnico',
            'ordenesCompletadas',
            'estadisticas',
            'gananciasPorMes',
            'topOrdenes',
            'fechaInicio',
            'fechaFin'
        ));
    }

    /**
     * Vista de órdenes trabajadas (historial completo)
     */
    public function ordenesTrabajadas(Request $request)
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Consulta base
        $query = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->where('estado', 'completada')
            ->with(['cliente', 'equipo.marca']);

        // Filtros
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('fecha_completada', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if ($request->filled('cliente')) {
            $query->whereHas('cliente', function($q) use ($request) {
                $q->where('nombre_completo', 'like', '%' . $request->cliente . '%');
            });
        }

        if ($request->filled('equipo_tipo')) {
            $query->whereHas('equipo', function($q) use ($request) {
                $q->where('tipo_equipo', $request->equipo_tipo);
            });
        }

        if ($request->filled('comision_min')) {
            $query->where('comision_tecnico', '>=', $request->comision_min);
        }

        // Ordenamiento
        $ordenPor = $request->get('orden_por', 'fecha_completada');
        $direccion = $request->get('direccion', 'desc');
        $query->orderBy($ordenPor, $direccion);

        $ordenes = $query->paginate(15)->withQueryString();

        // Estadísticas del período
        $estadisticas = [
            'total_completadas' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->count(),
            'total_ganado' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->sum('comision_tecnico'),
            'promedio_duracion' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->whereNotNull('fecha_inicio_trabajo')
                ->whereNotNull('fecha_completada')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, fecha_inicio_trabajo, fecha_completada)) as promedio')
                ->value('promedio'),
            'mes_actual' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->whereMonth('fecha_completada', now()->month)
                ->count(),
        ];

        return view('tecnico.ordenes-trabajadas', compact('tecnico', 'ordenes', 'estadisticas'));
    }

    /**
     * Vista de perfil del técnico
     */
    public function perfil()
    {
        $tecnico = Auth::guard('tecnico')->user();
        
        // Cargar estadísticas del técnico
        $estadisticas = [
            'total_ordenes' => OrdenServicio::where('tecnico_id', $tecnico->id)->count(),
            'completadas' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->count(),
            'en_progreso' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->whereIn('estado', ['asignada', 'diagnostico', 'en_progreso', 'espera_repuesto'])
                ->count(),
            'calificacion_promedio' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->whereNotNull('calificacion_cliente')
                ->avg('calificacion_cliente'),
            'total_ganado' => OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->sum('comision_tecnico'),
        ];

        return view('tecnico.perfil', compact('tecnico', 'estadisticas'));
    }

    /**
     * Actualizar perfil del técnico
     */
    public function actualizarPerfil(Request $request)
    {
        $tecnico = Auth::guard('tecnico')->user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tecnicos,email,' . $tecnico->id,
            'telefono' => 'nullable|string|max:20',
            'especialidades' => 'nullable|string|max:500',
            'password' => 'nullable|min:8|confirmed',
        ]);

        try {
            // Actualizar datos básicos
            $tecnico->nombre = $request->nombre;
            $tecnico->apellido = $request->apellido;
            $tecnico->email = $request->email;
            $tecnico->telefono = $request->telefono;
            
            // Si especialidades viene como string, convertir a array
            if ($request->filled('especialidades')) {
                $especialidadesArray = array_map('trim', explode(',', $request->especialidades));
                $tecnico->especialidades = $especialidadesArray;
            }

            // Actualizar contraseña si se proporcionó
            if ($request->filled('password')) {
                $tecnico->password = bcrypt($request->password);
            }

            $tecnico->save();

            return redirect()->route('tecnico.perfil')
                ->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
                ->withInput();
        }
    }
}