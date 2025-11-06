<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\OrdenServicio;
use App\Models\ServicioTecnico;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GestionClientesController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $tipoCliente = $request->get('tipo_cliente');
        $estado = $request->get('estado');

        $query = Cliente::query()
            ->select('clientes.*')
            ->withCount([
                'ordenes as ordenes_count',
                'ordenes as ordenes_completadas_count' => function($q) {
                    $q->whereIn('estado', ['completado', 'completada']);
                },
                'ordenes as ordenes_pendientes_count' => function($q) {
                    $q->whereIn('estado', ['pendiente', 'asignada', 'en_proceso', 'en_progreso']);
                }
            ])
            ->with('ordenes:id,cliente_id,created_at');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('rut', 'like', "%{$search}%")
                  ->orWhere('empresa', 'like', "%{$search}%");
            });
        }

        if ($tipoCliente) {
            $query->where('tipo_cliente', $tipoCliente);
        }

        if ($estado) {
            $query->where('estado', $estado);
        }

        $clientes = $query->orderBy('created_at', 'desc')
                         ->paginate(15)
                         ->through(function($cliente) {
                             $ultimaOrden = $cliente->ordenes->sortByDesc('created_at')->first();
                             $cliente->ultima_orden = $ultimaOrden ? $ultimaOrden->created_at : null;
                             return $cliente;
                         });

        $stats = [
            'total' => Cliente::count(),
            'activos' => Cliente::where('estado', 'activo')->count(),
            'inactivos' => Cliente::where('estado', 'inactivo')->count(),
            'con_ordenes' => Cliente::has('ordenes')->count(),
            'empresas' => Cliente::where('tipo_cliente', 'corporativo')->count(),
            'nuevos_mes' => Cliente::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        return view('admin.clientes.gestion-clientes', compact('clientes', 'stats'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'apellido' => 'required|string|max:45',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'required|string|max:45',
            'rut' => 'required|string|max:45|unique:clientes,rut',
            'direccion' => 'required|string|max:45',
            'empresa' => 'nullable|string|max:100',
            'tipo_cliente' => 'required|in:regular,vip,corporativo',
            'estado' => 'required|in:activo,inactivo,vip,moroso',
            'notas' => 'nullable|string'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'rut.required' => 'El RUT es obligatorio.',
            'rut.unique' => 'Este RUT ya está registrado.',
            'direccion.required' => 'La dirección es obligatoria.',
            'tipo_cliente.required' => 'El tipo de cliente es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $cliente = Cliente::create($request->all());

            return response()->json([
                'success' => true,
                'message' => '✅ Cliente creado exitosamente',
                'cliente' => $cliente
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error al crear el cliente: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar detalle del cliente (JSON para AJAX)
     */
    public function show($id)
    {
        try {
            $cliente = Cliente::with(['ordenes' => function($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            }])->findOrFail($id);

            return response()->json([
                'success' => true,
                'cliente' => $cliente
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Cliente no encontrado'
            ], 404);
        }
    }

    /**
     * Obtener datos del cliente para editar (JSON para AJAX)
     */
    public function edit($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);

            return response()->json([
                'success' => true,
                'cliente' => $cliente
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Cliente no encontrado'
            ], 404);
        }
    }

    /**
     * Actualizar cliente (JSON para AJAX)
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:45',
            'apellido' => 'required|string|max:45',
            'email' => 'required|email|unique:clientes,email,' . $id,
            'telefono' => 'required|string|max:45',
            'rut' => 'required|string|max:45|unique:clientes,rut,' . $id,
            'direccion' => 'required|string|max:45',
            'empresa' => 'nullable|string|max:100',
            'tipo_cliente' => 'required|in:regular,vip,corporativo',
            'estado' => 'required|in:activo,inactivo,vip,moroso',
            'notas' => 'nullable|string'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'Este email ya está registrado por otro cliente.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'rut.required' => 'El RUT es obligatorio.',
            'rut.unique' => 'Este RUT ya está registrado por otro cliente.',
            'direccion.required' => 'La dirección es obligatoria.',
            'tipo_cliente.required' => 'El tipo de cliente es obligatorio.',
            'estado.required' => 'El estado es obligatorio.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $cliente->update($request->all());

            return response()->json([
                'success' => true,
                'message' => '✅ Cliente actualizado exitosamente',
                'cliente' => $cliente
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error al actualizar el cliente: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar cliente (JSON para AJAX)
     */
    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            
            // Verificar si tiene órdenes activas
            $ordenesActivas = $cliente->ordenes()
                ->whereIn('estado', ['pendiente', 'asignada', 'en_proceso', 'en_progreso'])
                ->count();
            
            if ($ordenesActivas > 0) {
                return response()->json([
                    'success' => false,
                    'message' => '❌ No se puede eliminar el cliente porque tiene ' . $ordenesActivas . ' órdenes activas.'
                ], 400);
            }

            $cliente->delete();

            return response()->json([
                'success' => true,
                'message' => '✅ Cliente eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error al eliminar el cliente'
            ], 500);
        }
    }

    /**
     * Exportar clientes a CSV
     */
    public function export()
    {
        $clientes = Cliente::with('ordenes')->get();

        $filename = 'clientes_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($clientes) {
            $file = fopen('php://output', 'w');
            
            // Encabezados del CSV
            fputcsv($file, [
                'ID',
                'Nombre',
                'Apellido',
                'RUT',
                'Email',
                'Teléfono',
                'Dirección',
                'Empresa',
                'Tipo',
                'Estado',
                'Órdenes Totales',
                'Fecha Registro'
            ]);

            // Datos
            foreach ($clientes as $cliente) {
                fputcsv($file, [
                    $cliente->id,
                    $cliente->nombre,
                    $cliente->apellido,
                    $cliente->rut,
                    $cliente->email,
                    $cliente->telefono,
                    $cliente->direccion,
                    $cliente->empresa ?? 'N/A',
                    $cliente->tipo_cliente,
                    $cliente->estado,
                    $cliente->ordenes->count(),
                    $cliente->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}