<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\ServicioTecnico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenServicioController extends Controller
{
    /**
     * 📋 Listar órdenes de servicio
     */
    public function index(Request $request)
    {
        // El trait BelongsToServicioTecnico filtra automáticamente por servicio técnico
        $query = OrdenServicio::with(['cliente', 'tecnico', 'equipo.marca']);

        if ($request->filled('buscar')) {
            $query->where('numero_orden', 'like', "%{$request->buscar}%")
                  ->orWhere('descripcion_problema', 'like', "%{$request->buscar}%");
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        $ordenPor = $request->get('orden_por', 'created_at');
        $direccion = $request->get('direccion', 'desc');

        $ordenes = $query->orderBy($ordenPor, $direccion)->paginate(10);

        // Calcular estadísticas solo del servicio técnico actual
        $estadisticas = [
            'total' => OrdenServicio::count(),
            'pendientes' => OrdenServicio::where('estado', 'pendiente')->count(),
            'en_progreso' => OrdenServicio::where('estado', 'en_progreso')->count(),
            'completadas' => OrdenServicio::where('estado', 'completada')->count(),
            'retrasadas' => OrdenServicio::whereDate('fecha_aprox_entrega', '<', now())
                                        ->whereNotIn('estado', ['completada', 'cancelada'])
                                        ->count()
        ];

        return view('admin.ordenes.index', compact('ordenes', 'estadisticas'));
    }

    /**
     * 🆕 Formulario de creación
     */
    public function create()
    {
        // Obtener solo los clientes del servicio técnico del usuario autenticado
        // El trait BelongsToServicioTecnico filtra automáticamente
        $clientes = Cliente::orderBy('nombre')->get();
        
        // Obtener equipos que pertenecen a clientes del servicio técnico
        $servicioTecnicoId = Auth::user()->servicioTecnico->id;
        $equipos = Equipo::with('marca')
            ->whereHas('clienteEquipos.cliente', function($query) use ($servicioTecnicoId) {
                $query->where('servicio_tecnico_id', $servicioTecnicoId);
            })
            ->orderBy('modelo')
            ->get();
        
        // Generar número de orden sugerido
        $numeroOrdenSugerido = OrdenServicio::generarNumeroOrden($servicioTecnicoId);
        
        return view('admin.ordenes.create', compact('clientes', 'equipos', 'numeroOrdenSugerido'));
    }

    /**
     * 💾 Guardar nueva orden
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tipo_servicio'        => 'required|string|max:100',
                'descripcion_problema' => 'required|string|min:5',
                'prioridad'            => 'required|string|in:baja,media,alta,urgente',
                'estado'               => 'nullable|string|max:45',
                'precio_presupuestado' => 'nullable|numeric',
                'abono'                => 'nullable|numeric',
                'contacto_en_sitio'    => 'nullable|string|max:100',
                'telefono_contacto'    => 'nullable|string|max:20',
                'ubicacion_servicio'   => 'nullable|string|max:200',
                'medio_de_pago'        => 'nullable|string|max:45',
                'tipo_de_trabajo'      => 'nullable|string|max:45',
                'fecha_programada'     => 'nullable|date',
                'fecha_aprox_entrega'  => 'nullable|date',
                'horas_estimadas'      => 'nullable|numeric',
                'cliente_id'           => 'required|exists:clientes,id',
                'equipo_id'            => 'required|exists:equipos,id',
            ]);

            // Obtener servicio técnico del usuario autenticado
            $user = Auth::user();
            if (!$user || !$user->servicioTecnico) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: Usuario no tiene servicio técnico asociado'
                ], 403);
            }

            $servicioTecnicoId = $user->servicioTecnico->id;

            // Verificar que el cliente pertenece al servicio técnico
            $cliente = Cliente::withoutGlobalScope('servicio_tecnico')
                ->where('id', $request->cliente_id)
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->first();

            if (!$cliente) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: El cliente seleccionado no pertenece a su servicio técnico'
                ], 403);
            }

            // Generar número de orden correlativo por servicio técnico
            $numeroOrden = $request->numero_orden ?? OrdenServicio::generarNumeroOrden($servicioTecnicoId);

            $precio = $request->input('precio_presupuestado', 0);
            $abono  = $request->input('abono', 0);
            $saldo  = $precio - $abono;

            // Crear orden (el trait asigna automáticamente servicio_tecnico_id)
            $orden = OrdenServicio::create([
                'numero_orden'         => $numeroOrden,
                'estado'               => $request->estado ?? 'pendiente',
                'prioridad'            => $request->prioridad ?? 'media',
                'fecha_ingreso'        => $request->fecha_ingreso ?? now(),
                'descripcion_problema' => $request->descripcion_problema,
                'tipo_servicio'        => $request->tipo_servicio ?? 'mantenimiento',
                'tipo_de_trabajo'      => $request->tipo_de_trabajo ?? 'En Taller',
                'precio_presupuestado' => $precio,
                'precio_total'         => $precio,
                'abono'                => $abono,
                'saldo'                => $saldo,
                'medio_de_pago'        => $request->medio_de_pago ?? 'Tarjeta',
                'ubicacion_servicio'   => $request->ubicacion_servicio,
                'contacto_en_sitio'    => $request->contacto_en_sitio,
                'telefono_contacto'    => $request->telefono_contacto,
                'fecha_programada'     => $request->fecha_programada,
                'fecha_aprox_entrega'  => $request->fecha_aprox_entrega,
                'horas_estimadas'      => $request->horas_estimadas,
                'servicio_tecnico_id'  => $servicioTecnicoId,
                'user_id'              => $user->id,
                'cliente_id'           => $request->cliente_id,
                'equipo_id'            => $request->equipo_id,
                'tecnico_id'           => $request->tecnico_id ?? null, // Asignar técnico si viene en el request
            ]);

            return redirect()->route('ordenes.index')
                ->with('success', '✅ Orden #' . $orden->numero_orden . ' creada correctamente');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', '❌ Error de validación: Por favor verifica los datos ingresados');
        } catch (\Throwable $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', '❌ Error al crear la orden: ' . $e->getMessage());
        }
    }

    /**
     * 👁️ Mostrar detalles de una orden
     */
    public function show($id)
    {
        $orden = OrdenServicio::findOrFail($id);
        return view('admin.ordenes.show', compact('orden'));
    }

    /**
     * 🔎 Buscar orden por número (vista pública)
     */
    public function buscar(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string|max:20'
        ]);

        $numeroOrden = trim($request->input('order_code'));
        
        // Log para debug
        \Log::info('Buscando orden: ' . $numeroOrden);
        
        // Buscar la orden con todas sus relaciones disponibles
        $orden = OrdenServicio::with([
            'cliente',
            'tecnico',
            'equipo.marca'
        ])
        ->where(function($query) use ($numeroOrden) {
            $query->where('numero_orden', $numeroOrden)
                  ->orWhere('numero_orden', strtoupper($numeroOrden))
                  ->orWhere('numero_orden', 'LIKE', '%' . $numeroOrden . '%');
        })
        ->first();
        
        \Log::info('Orden encontrada: ' . ($orden ? $orden->id : 'No encontrada'));

        if (!$orden) {
            // Verificar cuántas órdenes hay en total
            $total = OrdenServicio::count();
            $ultimasOrdenes = OrdenServicio::select('numero_orden')->orderBy('id', 'desc')->limit(3)->pluck('numero_orden')->toArray();
            
            $mensaje = "No se encontró ninguna orden con el código: {$numeroOrden}. ";
            $mensaje .= "Total de órdenes en BD: {$total}. ";
            if (!empty($ultimasOrdenes)) {
                $mensaje .= "Últimas órdenes: " . implode(', ', $ultimasOrdenes);
            }
            
            return back()
                ->with('error', $mensaje)
                ->withInput();
        }

        // Cargar relaciones opcionales si existen
        try {
            $orden->load(['comentarios', 'historial']);
        } catch (\Exception $e) {
            \Log::warning('Error cargando relaciones: ' . $e->getMessage());
        }

        // Si es una petición AJAX, devolver JSON
        if ($request->wantsJson()) {
            return response()->json($orden);
        }

        // Si es una petición normal, devolver vista
        return view('shared.orden-publica', compact('orden'));
    }

    /**
     * 📡 Estado público vía API
     */
    public function apiEstado($numeroOrden)
    {
        $orden = OrdenServicio::where('numero_orden', $numeroOrden)->first();

        if (!$orden) {
            return response()->json(['error' => 'Orden no encontrada'], 404);
        }

        return response()->json([
            'numero_orden'     => $orden->numero_orden,
            'estado'           => ucfirst($orden->estado),
            'descripcion'      => $orden->descripcion_problema,
            'fecha_ingreso'    => optional($orden->fecha_ingreso)->format('Y-m-d'),
            'fecha_estimada'   => optional($orden->fecha_aprox_entrega)->format('Y-m-d'),
            'fecha_completada' => optional($orden->fecha_completada)->format('Y-m-d'),
        ]);
    }

    /**
     * 🔄 Actualizar estado de una orden (inline)
     */
    public function updateEstado(Request $request, $id)
    {
        try {
            $request->validate([
                'estado' => 'required|string|in:pendiente,en_progreso,completada'
            ]);

            $orden = OrdenServicio::findOrFail($id);
            $orden->estado = $request->estado;
            $orden->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente',
                'orden' => $orden
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ⚡ Actualizar prioridad de una orden (inline)
     */
    public function updatePrioridad(Request $request, $id)
    {
        try {
            $request->validate([
                'prioridad' => 'required|string|in:baja,media,alta,urgente'
            ]);

            $orden = OrdenServicio::findOrFail($id);
            $orden->prioridad = $request->prioridad;
            $orden->save();

            return response()->json([
                'success' => true,
                'message' => 'Prioridad actualizada correctamente',
                'orden' => $orden
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la prioridad: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🗑️ Eliminar una orden de servicio
     */
    public function destroy($id)
    {
        try {
            $orden = OrdenServicio::findOrFail($id);
            
            // Guardar información para el mensaje
            $numeroOrden = $orden->numero_orden;
            
            // Eliminar la orden (esto también eliminará registros relacionados si hay cascada)
            $orden->delete();

            return response()->json([
                'success' => true,
                'message' => "Orden {$numeroOrden} eliminada correctamente"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la orden: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * 📊 Vista de órdenes históricas con detalles y precios
     */
    public function historicas(Request $request)
    {
        $query = OrdenServicio::with(['cliente', 'tecnico', 'equipo.marca', 'historial']);

        // Filtros
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('numero_orden', 'like', "%{$buscar}%")
                  ->orWhere('descripcion_problema', 'like', "%{$buscar}%")
                  ->orWhereHas('cliente', function($q) use ($buscar) {
                      $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%");
                  });
            });
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_ingreso', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_ingreso', '<=', $request->fecha_hasta);
        }

        if ($request->filled('tecnico_id')) {
            $query->where('tecnico_id', $request->tecnico_id);
        }

        // Ordenamiento
        $ordenPor = $request->get('orden_por', 'fecha_ingreso');
        $direccion = $request->get('direccion', 'desc');
        $ordenes = $query->orderBy($ordenPor, $direccion)->paginate(20);

        // Estadísticas generales
        $estadisticas = [
            'total_ordenes' => OrdenServicio::count(),
            'completadas' => OrdenServicio::where('estado', 'completada')->count(),
            'total_facturado' => OrdenServicio::whereNotNull('precio_presupuestado')->sum('precio_presupuestado'),
            'promedio_precio' => OrdenServicio::whereNotNull('precio_presupuestado')->avg('precio_presupuestado'),
            'mes_actual' => OrdenServicio::whereMonth('fecha_ingreso', now()->month)
                                        ->whereYear('fecha_ingreso', now()->year)
                                        ->count(),
            'facturado_mes' => OrdenServicio::whereMonth('fecha_ingreso', now()->month)
                                           ->whereYear('fecha_ingreso', now()->year)
                                           ->whereNotNull('precio_presupuestado')
                                           ->sum('precio_presupuestado'),
        ];

        // Obtener lista de técnicos para filtro
        $tecnicos = \App\Models\Tecnico::whereNull('deleted_at')
                                      ->select('id', 'nombre', 'apellido')
                                      ->get();

        return view('admin.ordenes.historicas', compact('ordenes', 'estadisticas', 'tecnicos'));
    }
}
