<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\Cliente;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $servicioTecnicoId = $user->servicio_tecnico_id;
        
        $query = OrdenServicio::where('servicio_tecnico_id', $servicioTecnicoId)
            ->with(['cliente', 'tecnico.user']);

        // Búsqueda
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('tecnico_id')) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        // Ordenamiento
        $ordenPor = $request->get('orden_por', 'created_at');
        $direccion = $request->get('direccion', 'desc');
        $query->orderBy($ordenPor, $direccion);

        $ordenes = $query->paginate(15)->withQueryString();

        // Estadísticas
        $estadisticas = [
            'total' => OrdenServicio::where('servicio_tecnico_id', $servicioTecnicoId)->count(),
            'pendientes' => OrdenServicio::where('servicio_tecnico_id', $servicioTecnicoId)->pendientes()->count(),
            'en_progreso' => OrdenServicio::where('servicio_tecnico_id', $servicioTecnicoId)->enProgreso()->count(),
            'completadas' => OrdenServicio::where('servicio_tecnico_id', $servicioTecnicoId)->completadas()->count(),
            'retrasadas' => OrdenServicio::where('servicio_tecnico_id', $servicioTecnicoId)->retrasadas()->count()
        ];

        // Datos para filtros
        $tecnicos = Tecnico::where('servicio_tecnico_id', $servicioTecnicoId)
            ->with('user')->get();

        return view('ordenes.index', compact('ordenes', 'estadisticas', 'tecnicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $servicioTecnicoId = $user->servicio_tecnico_id;
        
        $clientes = Cliente::where('servicio_tecnico_id', $servicioTecnicoId)->activos()->get();
        $tecnicos = Tecnico::where('servicio_tecnico_id', $servicioTecnicoId)->disponibles()->get();

        return view('ordenes.create', compact('clientes', 'tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_servicio' => 'required|in:reparacion,mantenimiento,instalacion,consultoria,soporte',
            'descripcion_problema' => 'required|string|max:1000',
            'prioridad' => 'required|in:baja,media,alta,urgente',
            'fecha_programada' => 'nullable|date|after:today',
            'precio_presupuestado' => 'nullable|numeric|min:0',
            'horas_estimadas' => 'nullable|numeric|min:0|max:999.99',
            'ubicacion_servicio' => 'nullable|string|max:200',
            'contacto_en_sitio' => 'nullable|string|max:100',
            'telefono_contacto' => 'nullable|string|max:20',
            'equipos_necesarios' => 'nullable|array',
            'observaciones_tecnico' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();
        
        $orden = OrdenServicio::create([
            'numero_orden' => OrdenServicio::generarNumeroOrden($user->servicio_tecnico_id),
            'cliente_id' => $request->cliente_id,
            'tipo_servicio' => $request->tipo_servicio,
            'descripcion_problema' => $request->descripcion_problema,
            'estado' => 'pendiente',
            'prioridad' => $request->prioridad,
            'fecha_programada' => $request->fecha_programada,
            'precio_presupuestado' => $request->precio_presupuestado,
            'horas_estimadas' => $request->horas_estimadas,
            'ubicacion_servicio' => $request->ubicacion_servicio,
            'contacto_en_sitio' => $request->contacto_en_sitio,
            'telefono_contacto' => $request->telefono_contacto,
            'equipos_necesarios' => $request->equipos_necesarios ?: [],
            'observaciones_tecnico' => $request->observaciones_tecnico,
            'servicio_tecnico_id' => $user->servicio_tecnico_id
        ]);

        $orden->registrarHistorial('Orden creada', $user->name);

        return redirect()->route('ordenes.show', $orden)
            ->with('success', 'Orden de servicio creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(OrdenServicio $orden)
    {
        // Verificar que la orden pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($orden->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        $orden->load(['cliente', 'tecnico.user', 'comentarios', 'historial' => function($query) {
            $query->orderBy('fecha', 'desc');
        }]);

        return view('ordenes.show', compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrdenServicio $orden)
    {
        // Verificar que la orden pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($orden->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        if (!$orden->puedeSerEditada()) {
            return redirect()->route('ordenes.show', $orden)
                ->with('error', 'Esta orden no puede ser editada en su estado actual.');
        }

        $clientes = Cliente::where('servicio_tecnico_id', $user->servicio_tecnico_id)->activos()->get();
        $tecnicos = Tecnico::where('servicio_tecnico_id', $user->servicio_tecnico_id)->disponibles()->get();

        return view('ordenes.edit', compact('orden', 'clientes', 'tecnicos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrdenServicio $orden)
    {
        // Verificar que la orden pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($orden->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        if (!$orden->puedeSerEditada()) {
            return redirect()->route('ordenes.show', $orden)
                ->with('error', 'Esta orden no puede ser editada en su estado actual.');
        }

        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'nullable|exists:tecnicos,id',
            'tipo_servicio' => 'required|in:reparacion,mantenimiento,instalacion,consultoria,soporte',
            'descripcion_problema' => 'required|string|max:1000',
            'prioridad' => 'required|in:baja,media,alta,urgente',
            'fecha_programada' => 'nullable|date',
            'precio_presupuestado' => 'nullable|numeric|min:0',
            'horas_estimadas' => 'nullable|numeric|min:0|max:999.99',
            'ubicacion_servicio' => 'nullable|string|max:200',
            'contacto_en_sitio' => 'nullable|string|max:100',
            'telefono_contacto' => 'nullable|string|max:20',
            'equipos_necesarios' => 'nullable|array',
            'observaciones_tecnico' => 'nullable|string|max:1000'
        ]);

        $cambios = [];
        
        // Detectar cambios importantes
        if ($orden->prioridad !== $request->prioridad) {
            $cambios[] = "Prioridad cambiada de '{$orden->prioridad}' a '{$request->prioridad}'";
        }
        
        if ($orden->tecnico_id !== $request->tecnico_id) {
            if ($request->tecnico_id) {
                $tecnico = Tecnico::find($request->tecnico_id);
                $cambios[] = "Técnico asignado: {$tecnico->user->name}";
            } else {
                $cambios[] = "Técnico removido de la orden";
            }
        }

        $orden->update($request->all());

        // Registrar cambios en el historial
        if (!empty($cambios)) {
            $orden->registrarHistorial('Orden actualizada', $user->name, implode(', ', $cambios));
        }

        return redirect()->route('ordenes.show', $orden)
            ->with('success', 'Orden actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrdenServicio $orden)
    {
        // Verificar que la orden pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($orden->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        if ($orden->estado === 'completada') {
            return redirect()->route('ordenes.index')
                ->with('error', 'No se puede eliminar una orden completada.');
        }

        $numeroOrden = $orden->numero_orden;
        $orden->delete();

        return redirect()->route('ordenes.index')
            ->with('success', "Orden {$numeroOrden} eliminada exitosamente.");
    }

    /**
     * Buscar orden por número público
     */
    public function buscar(Request $request)
    {
        $numeroOrden = $request->get('numero_orden');
        
        if (!$numeroOrden) {
            return redirect()->route('home')->with('error', 'Debe ingresar un número de orden.');
        }

        $orden = OrdenServicio::where('numero_orden', $numeroOrden)->first();
        
        if (!$orden) {
            return redirect()->route('home')->with('error', 'Orden no encontrada.');
        }

        return view('ordenes.estado', compact('orden'));
    }

    /**
     * Cambiar estado de orden
     */
    public function cambiarEstado(Request $request, OrdenServicio $orden)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,asignada,en_progreso,completada,cancelada,en_revision',
            'observaciones' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();
        if ($orden->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        $estadoAnterior = $orden->estado;
        
        switch ($request->estado) {
            case 'en_progreso':
                $orden->iniciar();
                break;
            case 'completada':
                $orden->completar($request->observaciones);
                break;
            case 'cancelada':
                $orden->cancelar($request->observaciones);
                break;
            default:
                $orden->estado = $request->estado;
                $orden->save();
                $orden->registrarHistorial("Estado cambiado de '{$estadoAnterior}' a '{$request->estado}'", $user->name);
        }

        return redirect()->route('ordenes.show', $orden)
            ->with('success', 'Estado de la orden actualizado exitosamente.');
    }
}
