<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use Illuminate\Http\Request;

class OrdenServicioController extends Controller
{
    /**
     * 📋 Listar órdenes de servicio
     */
    public function index(Request $request)
    {
        $query = OrdenServicio::query();

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

        return view('ordenes.index', compact('ordenes'));
    }

    /**
     * 🆕 Formulario de creación
     */
    public function create()
    {
        return view('ordenes.create');
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
            ]);

            // Generar número de orden
            $numeroOrden = OrdenServicio::generarNumeroOrden(1); // 1 = ID del servicio técnico

            $precio = $request->input('precio_presupuestado', 0);
            $abono  = $request->input('abono', 0);
            $saldo  = $precio - $abono;

            // Crear orden
            $orden = OrdenServicio::create([
                'numero_orden'         => $numeroOrden,
                'estado'               => $request->estado ?? 'Recibido',
                'prioridad'            => $request->prioridad,
                'fecha_ingreso'        => now(),
                'descripcion_problema' => $request->descripcion_problema,
                'tipo_de_trabajo'      => $request->tipo_servicio,
                'precio_presupuestado' => $precio,
                'abono'                => $abono,
                'saldo'                => $saldo,
                'medio_de_pago'        => $request->medio_de_pago,
                'ubicacion_servicio'   => $request->ubicacion_servicio,
                'contacto_en_sitio'    => $request->contacto_en_sitio,
                'telefono_contacto'    => $request->telefono_contacto,
                'fecha_programada'     => $request->fecha_programada,
                'fecha_aprox_entrega'  => $request->fecha_aprox_entrega,
                'horas_estimadas'      => $request->horas_estimadas,
                'tipo_de_trabajo'      => $request->tipo_de_trabajo,
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Orden creada correctamente',
                'orden'   => $orden,
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error al crear la orden',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * 👁️ Mostrar detalles de una orden
     */
    public function show($id)
    {
        $orden = OrdenServicio::findOrFail($id);
        return view('ordenes.show', compact('orden'));
    }

    /**
     * 🔎 Buscar orden por número
     */
    public function buscar(Request $request)
    {
        $numeroOrden = $request->input('numero_orden');
        $orden = OrdenServicio::where('numero_orden', $numeroOrden)->first();

        if (!$orden) {
            return response()->json(['error' => 'Orden no encontrada'], 404);
        }

        return response()->json($orden);
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
}
