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
        $this->middleware('auth');
        // $this->middleware('subscription'); // Comentado para desarrollo
    }

    /**
     * Mostrar listado principal de clientes con estadísticas
     */
    public function index(Request $request)
    {
        // Estadísticas generales
        $totalClientes = Cliente::count();
        $clientesActivos = Cliente::where('estado', 'activo')->count();
        $clientesVip = Cliente::where('tipo_cliente', 'vip')->count();
        $clientesConOrdenes = Cliente::has('ordenes')->count();

        // Query base con relaciones
        $query = Cliente::with(['ordenes', 'servicioTecnico'])
            ->withCount([
                'ordenes',
                'ordenes as ordenes_completadas_count' => function($q) {
                    $q->where('estado', 'completada');
                },
                'ordenes as ordenes_pendientes_count' => function($q) {
                    $q->whereIn('estado', ['pendiente', 'en_progreso']);
                }
            ]);

        // Aplicar filtros de búsqueda
        if ($request->filled('buscar')) {
            $termino = $request->buscar;
            $query->buscar($termino);
        }

        // Filtro por estado
        if ($request->filled('estado') && $request->estado !== 'todos') {
            $query->where('estado', $request->estado);
        }

        // Filtro por tipo de cliente
        if ($request->filled('tipo_cliente') && $request->tipo_cliente !== 'todos') {
            $query->where('tipo_cliente', $request->tipo_cliente);
        }

        // Filtro por servicio técnico
        if ($request->filled('servicio_tecnico') && $request->servicio_tecnico !== 'todos') {
            $query->where('servicio_tecnico_id', $request->servicio_tecnico);
        }

        // Ordenamiento
        $orderBy = $request->get('orden', 'created_at');
        $orderDirection = $request->get('direccion', 'desc');
        
        switch ($orderBy) {
            case 'nombre':
                $query->orderBy('nombre', $orderDirection)
                      ->orderBy('apellido', $orderDirection);
                break;
            case 'ordenes':
                $query->withCount('ordenes')->orderBy('ordenes_count', $orderDirection);
                break;
            case 'ultima_orden':
                $query->leftJoin('ordenes_servicio as os', function($join) {
                    $join->on('clientes.id', '=', 'os.cliente_id')
                         ->whereNull('os.deleted_at');
                })->select('clientes.*')
                ->orderBy(DB::raw('MAX(os.created_at)'), $orderDirection)
                ->groupBy('clientes.id');
                break;
            default:
                $query->orderBy($orderBy, $orderDirection);
        }

        // Paginación
        $clientes = $query->paginate(12)->withQueryString();

        // Obtener servicios técnicos para filtros
        $serviciosTecnicos = ServicioTecnico::all();

        return view('clientes.gestion-clientes', compact(
            'clientes',
            'totalClientes',
            'clientesActivos', 
            'clientesVip',
            'clientesConOrdenes',
            'serviciosTecnicos'
        ));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $serviciosTecnicos = ServicioTecnico::all();
        return view('clientes.create', compact('serviciosTecnicos'));
    }

    /**
     * Almacenar nuevo cliente
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email',
            'telefono' => 'required|string|max:20',
            'rut' => 'required|string|max:12|unique:clientes,rut',
            'direccion' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:150',
            'tipo_cliente' => 'required|in:regular,vip,corporativo',
            'estado' => 'required|in:activo,inactivo',
            'servicio_tecnico_id' => 'required|exists:servicio_tecnicos,id',
            'notas' => 'nullable|string|max:1000'
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
            'servicio_tecnico_id.required' => 'Debe seleccionar un servicio técnico.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            Cliente::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'rut' => $request->rut,
                'direccion' => $request->direccion,
                'empresa' => $request->empresa,
                'tipo_cliente' => $request->tipo_cliente,
                'estado' => $request->estado,
                'servicio_tecnico_id' => $request->servicio_tecnico_id,
                'notas' => $request->notas
            ]);

            DB::commit();

            return redirect()->route('admin.clientes.index')
                ->with('success', 'Cliente creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al crear el cliente: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id)
    {
        $cliente = Cliente::with(['ordenes', 'servicioTecnico'])->findOrFail($id);
        $serviciosTecnicos = ServicioTecnico::all();
        
        return view('clientes.edit', compact('cliente', 'serviciosTecnicos'));
    }

    /**
     * Actualizar cliente
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:clientes,email,' . $id,
            'telefono' => 'required|string|max:20',
            'rut' => 'required|string|max:12|unique:clientes,rut,' . $id,
            'direccion' => 'required|string|max:255',
            'empresa' => 'nullable|string|max:150',
            'tipo_cliente' => 'required|in:regular,vip,corporativo',
            'estado' => 'required|in:activo,inactivo,vip,moroso',
            'servicio_tecnico_id' => 'required|exists:servicio_tecnicos,id',
            'notas' => 'nullable|string|max:1000'
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
            'servicio_tecnico_id.required' => 'Debe seleccionar un servicio técnico.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            $cliente->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'rut' => $request->rut,
                'direccion' => $request->direccion,
                'empresa' => $request->empresa,
                'tipo_cliente' => $request->tipo_cliente,
                'estado' => $request->estado,
                'servicio_tecnico_id' => $request->servicio_tecnico_id,
                'notas' => $request->notas
            ]);

            DB::commit();

            return redirect()->route('admin.clientes.index')
                ->with('success', 'Cliente actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al actualizar el cliente: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Cambiar estado del cliente (activo/inactivo)
     */
    public function toggleStatus($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            
            $nuevoEstado = $cliente->estado === 'activo' ? 'inactivo' : 'activo';
            $cliente->update(['estado' => $nuevoEstado]);

            $mensaje = $nuevoEstado === 'activo' ? 'Cliente activado exitosamente.' : 'Cliente desactivado exitosamente.';

            return redirect()->back()->with('success', $mensaje);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cambiar el estado del cliente.');
        }
    }

    /**
     * Eliminar cliente (soft delete)
     */
    public function destroy($id)
    {
        try {
            $cliente = Cliente::findOrFail($id);
            
            // Verificar si tiene órdenes activas
            $ordenesActivas = $cliente->ordenes()->whereIn('estado', ['pendiente', 'en_progreso'])->count();
            
            if ($ordenesActivas > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede eliminar el cliente porque tiene órdenes de servicio activas.');
            }

            $cliente->delete();

            return redirect()->back()->with('success', 'Cliente eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el cliente.');
        }
    }

    /**
     * Ver detalle del cliente con sus órdenes
     */
    public function show($id)
    {
        $cliente = Cliente::with([
            'ordenes' => function($query) {
                $query->with(['tecnico'])
                      ->orderBy('created_at', 'desc');
            },
            'servicioTecnico'
        ])->findOrFail($id);

        // Estadísticas del cliente
        $estadisticas = [
            'total_ordenes' => $cliente->totalOrdenes(),
            'ordenes_completadas' => $cliente->ordenesCompletadas(),
            'ordenes_pendientes' => $cliente->ordenesPendientes(),
            'valor_total_gastado' => $cliente->valorTotalGastado(),
            'ultima_orden' => $cliente->ultimaOrden()
        ];

        return view('clientes.show', compact('cliente', 'estadisticas'));
    }
}