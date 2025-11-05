<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $servicioTecnicoId = $user->servicioTecnico ? $user->servicioTecnico->id : null;
        
        if (!$servicioTecnicoId) {
            return redirect()->route('setup.technical-service')
                ->with('error', 'Debes configurar tu servicio técnico primero.');
        }
        
        $query = Cliente::where('servicio_tecnico_id', $servicioTecnicoId)
            ->with(['ordenes' => function($q) {
                $q->select('cliente_id', 'estado', 'precio_total')
                  ->where('estado', 'completada');
            }]);

        // Búsqueda
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_cliente')) {
            $query->where('tipo_cliente', $request->tipo_cliente);
        }

        // Ordenamiento
        $ordenPor = $request->get('orden_por', 'created_at');
        $direccion = $request->get('direccion', 'desc');
        
        if ($ordenPor === 'nombre_completo') {
            $query->orderBy('nombre', $direccion)->orderBy('apellido', $direccion);
        } else {
            $query->orderBy($ordenPor, $direccion);
        }

        $clientes = $query->paginate(15)->withQueryString();

        // Estadísticas
        $estadisticas = [
            'total' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)->count(),
            'activos' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)->activos()->count(),
            'vip' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)->vip()->count(),
            'nuevos_mes' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereMonth('created_at', now()->month)->count()
        ];

        return view('clientes.index', compact('clientes', 'estadisticas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:45',
            'apellido' => 'nullable|string|max:45',
            'correo' => 'nullable|email|max:45',
            'telefono' => 'nullable|string|max:45',
            'direccion' => 'nullable|string|max:45',
            'rut' => 'nullable|string|max:45|unique:clientes,rut',
            'empresa' => 'nullable|string|max:100',
            'tipo_cliente' => 'nullable|in:regular,vip,corporativo',
            'estado' => 'nullable|in:activo,inactivo,vip,moroso',
            'notas' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();
        
        // Establecer valores por defecto
        $data = array_merge($request->all(), [
            'servicio_tecnico_id' => $user->servicioTecnico->id,
            'tipo_cliente' => $request->tipo_cliente ?? 'regular',
            'estado' => $request->estado ?? 'activo'
        ]);
        
        $cliente = Cliente::create($data);

        // Si es una petición AJAX, devolver JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente creado exitosamente',
                'cliente' => $cliente
            ], 201);
        }

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        // Verificar que el cliente pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($cliente->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        // Cargar relaciones
        $cliente->load(['ordenes' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }]);

        // Estadísticas del cliente
        $estadisticas = [
            'total_ordenes' => $cliente->totalOrdenes(),
            'ordenes_completadas' => $cliente->ordenesCompletadas(),
            'ordenes_pendientes' => $cliente->ordenesPendientes(),
            'valor_total_gastado' => $cliente->valorTotalGastado(),
            'promedio_por_orden' => $cliente->totalOrdenes() > 0 ? 
                $cliente->valorTotalGastado() / $cliente->totalOrdenes() : 0
        ];

        return view('clientes.show', compact('cliente', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        // Verificar que el cliente pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($cliente->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Verificar que el cliente pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($cliente->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        $request->validate([
            'nombre' => 'required|string|max:45',
            'apellido' => 'nullable|string|max:45',
            'correo' => 'nullable|email|max:45',
            'telefono' => 'nullable|string|max:45',
            'direccion' => 'nullable|string|max:45',
            'rut' => [
                'nullable',
                'string',
                'max:45',
                Rule::unique('clientes', 'rut')->ignore($cliente->id)
            ],
            'empresa' => 'nullable|string|max:100',
            'tipo_cliente' => 'required|in:regular,vip,corporativo',
            'estado' => 'required|in:activo,inactivo,vip,moroso',
            'notas' => 'nullable|string|max:1000'
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar que el cliente pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($cliente->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        // Verificar que no tenga órdenes pendientes
        if ($cliente->ordenesPendientes() > 0) {
            return redirect()->route('clientes.index')
                ->with('error', 'No se puede eliminar el cliente porque tiene órdenes pendientes.');
        }

        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }

    /**
     * Buscar clientes por AJAX
     */
    public function buscar(Request $request)
    {
        $user = Auth::user();
        $termino = $request->get('termino');
        
        $clientes = Cliente::where('servicio_tecnico_id', $user->servicio_tecnico_id)
            ->buscar($termino)
            ->limit(10)
            ->get(['id', 'nombre', 'apellido', 'correo', 'telefono'])
            ->map(function($cliente) {
                return [
                    'id' => $cliente->id,
                    'text' => $cliente->nombre_completo,
                    'correo' => $cliente->correo,
                    'telefono' => $cliente->telefono
                ];
            });

        return response()->json($clientes);
    }
}
