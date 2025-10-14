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
        // $this->middleware('auth'); // Comentado para desarrollo
        // $this->middleware('subscription'); // Comentado para desarrollo
    }

    /**
     * Mostrar listado principal de clientes con estadísticas
     */
    public function index(Request $request)
    {
        // Estadísticas simuladas
        $totalClientes = 78;
        $clientesActivos = 65;
        $clientesInactivos = 13;
        $clientesConOrdenes = 54;

        // Clientes simulados chilenos - Servicio técnico de reparación
        $allClientes = collect([
            (object)[
                'id' => 1,
                'nombre' => 'Juan Carlos',
                'apellido' => 'Pérez González',
                'email' => 'jperez@gmail.com',
                'telefono' => '+56 9 8765 4321',
                'rut' => '12.345.678-9',
                'empresa' => null,
                'tipo_cliente' => 'particular',
                'estado' => 'activo',
                'ordenes_count' => 15,
                'ordenes_completadas_count' => 13,
                'ordenes_pendientes_count' => 2,
                'ultima_orden' => now()->subDays(3),
                'created_at' => now()->subMonths(14)
            ],
            (object)[
                'id' => 2,
                'nombre' => 'María Elena',
                'apellido' => 'González López',
                'email' => 'mgonzalez@hotmail.com',
                'telefono' => '+56 9 7654 3210',
                'rut' => '11.234.567-8',
                'empresa' => null,
                'tipo_cliente' => 'particular',
                'estado' => 'activo',
                'ordenes_count' => 23,
                'ordenes_completadas_count' => 20,
                'ordenes_pendientes_count' => 3,
                'ultima_orden' => now()->subDays(1),
                'created_at' => now()->subMonths(18)
            ],
            (object)[
                'id' => 3,
                'nombre' => 'Pedro Antonio',
                'apellido' => 'Silva Rojas',
                'email' => 'psilva@gmail.com',
                'telefono' => '+56 9 6543 2109',
                'rut' => '10.123.456-7',
                'empresa' => null,
                'tipo_cliente' => 'particular',
                'estado' => 'activo',
                'ordenes_count' => 12,
                'ordenes_completadas_count' => 10,
                'ordenes_pendientes_count' => 2,
                'ultima_orden' => now()->subDays(7),
                'created_at' => now()->subMonths(10)
            ],
            (object)[
                'id' => 4,
                'nombre' => 'Carmen Rosa',
                'apellido' => 'Muñoz Fernández',
                'email' => 'cmunoz@outlook.com',
                'telefono' => '+56 9 5432 1098',
                'rut' => '15.678.901-2',
                'empresa' => null,
                'tipo_cliente' => 'particular',
                'estado' => 'activo',
                'ordenes_count' => 18,
                'ordenes_completadas_count' => 16,
                'ordenes_pendientes_count' => 2,
                'ultima_orden' => now()->subDays(2),
                'created_at' => now()->subMonths(16)
            ],
            (object)[
                'id' => 5,
                'nombre' => 'José Miguel',
                'apellido' => 'Hernández Castro',
                'email' => 'jhernandez@gmail.com',
                'telefono' => '+56 9 4321 0987',
                'rut' => '14.567.890-1',
                'empresa' => null,
                'tipo_cliente' => 'particular',
                'estado' => 'activo',
                'ordenes_count' => 9,
                'ordenes_completadas_count' => 8,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(5),
                'created_at' => now()->subMonths(8)
            ],
            
            // Clientes Regulares - Pequeñas empresas
            (object)[
                'id' => 6,
                'nombre' => 'Andrea Beatriz',
                'apellido' => 'Morales Santander',
                'email' => 'amorales@restatech.cl',
                'telefono' => '+56 9 3210 9876',
                'rut' => '13.456.789-0',
                'empresa' => 'RestaTech Ltda.',
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 6,
                'ordenes_completadas_count' => 5,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(10),
                'created_at' => now()->subMonths(6)
            ],
            (object)[
                'id' => 7,
                'nombre' => 'Ricardo Esteban',
                'apellido' => 'Torres Valdivia',
                'email' => 'rtorres@consultech.cl',
                'telefono' => '+56 9 2109 8765',
                'rut' => '16.789.012-3',
                'empresa' => 'ConsulTech SpA',
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 4,
                'ordenes_completadas_count' => 3,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(15),
                'created_at' => now()->subMonths(4)
            ],
            (object)[
                'id' => 8,
                'nombre' => 'Francisca Isabel',
                'apellido' => 'Ramírez Cortés',
                'email' => 'framirez@innovasoft.cl',
                'telefono' => '+56 9 1098 7654',
                'rut' => '17.890.123-4',
                'empresa' => 'InnovaSoft Chile',
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 7,
                'ordenes_completadas_count' => 6,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(8),
                'created_at' => now()->subMonths(7)
            ],
            (object)[
                'id' => 9,
                'nombre' => 'Gabriel Alfonso',
                'apellido' => 'Mendoza Araya',
                'email' => 'gmendoza@digitech.cl',
                'telefono' => '+56 9 0987 6543',
                'rut' => '18.901.234-5',
                'empresa' => 'DigiTech Solutions',
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 3,
                'ordenes_completadas_count' => 2,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(20),
                'created_at' => now()->subMonths(3)
            ],
            
            // Clientes Particulares
            (object)[
                'id' => 10,
                'nombre' => 'Lorena Patricia',
                'apellido' => 'Espinoza Jara',
                'email' => 'lespinoza@gmail.com',
                'telefono' => '+56 9 9876 5432',
                'rut' => '19.012.345-6',
                'empresa' => null,
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 2,
                'ordenes_completadas_count' => 2,
                'ordenes_pendientes_count' => 0,
                'ultima_orden' => now()->subDays(30),
                'created_at' => now()->subMonths(5)
            ],
            (object)[
                'id' => 11,
                'nombre' => 'Cristián Alejandro',
                'apellido' => 'Vargas Soto',
                'email' => 'cvargas@outlook.com',
                'telefono' => '+56 9 8765 4321',
                'rut' => '20.123.456-7',
                'empresa' => null,
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 1,
                'ordenes_completadas_count' => 1,
                'ordenes_pendientes_count' => 0,
                'ultima_orden' => now()->subDays(45),
                'created_at' => now()->subMonths(2)
            ],
            (object)[
                'id' => 12,
                'nombre' => 'Daniela Constanza',
                'apellido' => 'Fuentes Molina',
                'email' => 'dfuentes@yahoo.com',
                'telefono' => '+56 9 7654 3210',
                'rut' => '21.234.567-8',
                'empresa' => null,
                'tipo_cliente' => 'regular',
                'estado' => 'inactivo',
                'ordenes_count' => 3,
                'ordenes_completadas_count' => 3,
                'ordenes_pendientes_count' => 0,
                'ultima_orden' => now()->subMonths(3),
                'created_at' => now()->subMonths(8)
            ],
            
            // Clientes de regiones
            (object)[
                'id' => 13,
                'nombre' => 'Mauricio Andrés',
                'apellido' => 'Lagos Pizarro',
                'email' => 'mlagos@empresavalpo.cl',
                'telefono' => '+56 9 6543 2109',
                'rut' => '22.345.678-9',
                'empresa' => 'Empresa Valparaíso SpA',
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 5,
                'ordenes_completadas_count' => 4,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(12),
                'created_at' => now()->subMonths(9)
            ],
            (object)[
                'id' => 14,
                'nombre' => 'Javiera Antonieta',
                'apellido' => 'Carrasco Núñez',
                'email' => 'jcarrasco@concesur.cl',
                'telefono' => '+56 9 5432 1098',
                'rut' => '23.456.789-0',
                'empresa' => 'Concepciones del Sur Ltda.',
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 8,
                'ordenes_completadas_count' => 7,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(6),
                'created_at' => now()->subMonths(11)
            ],
            (object)[
                'id' => 15,
                'nombre' => 'Sebastián Eduardo',
                'apellido' => 'Bravo Alcántara',
                'email' => 'sbravo@nortechile.cl',
                'telefono' => '+56 9 4321 0987',
                'rut' => '24.567.890-1',
                'empresa' => 'Norte Chile Tech',
                'tipo_cliente' => 'regular',
                'estado' => 'activo',
                'ordenes_count' => 4,
                'ordenes_completadas_count' => 3,
                'ordenes_pendientes_count' => 1,
                'ultima_orden' => now()->subDays(18),
                'created_at' => now()->subMonths(5)
            ]
        ]);

        // Aplicar filtros
        $clientes = $allClientes;
        if ($request->filled('buscar')) {
            $termino = strtolower($request->buscar);
            $clientes = $clientes->filter(function($cliente) use ($termino) {
                return stripos($cliente->nombre . ' ' . $cliente->apellido, $termino) !== false ||
                       stripos($cliente->email, $termino) !== false ||
                       stripos($cliente->rut, $termino) !== false;
            });
        }

        if ($request->filled('estado') && $request->estado !== 'todos') {
            $clientes = $clientes->filter(function($cliente) use ($request) {
                return $cliente->estado === $request->estado;
            });
        }

        if ($request->filled('tipo_cliente') && $request->tipo_cliente !== 'todos') {
            $clientes = $clientes->filter(function($cliente) use ($request) {
                return $cliente->tipo_cliente === $request->tipo_cliente;
            });
        }

        // Servicios técnicos simulados
        $serviciosTecnicos = collect([
            (object)['id' => 1, 'nombre' => 'TechService Pro'],
            (object)['id' => 2, 'nombre' => 'Servicio Premium']
        ]);

        // Estructurar datos para simular paginación
        $clientesData = (object)[
            'data' => $clientes->take(12),
            'total' => $clientes->count(),
            'current_page' => 1,
            'per_page' => 50
        ];

        return view('clientes.gestion-clientes', compact(
            'totalClientes',
            'clientesActivos', 
            'clientesInactivos',
            'clientesConOrdenes',
            'serviciosTecnicos'
        ))->with('clientes', $clientesData);
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
            'tipo_cliente' => 'required|in:particular,regular',
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
            'tipo_cliente' => 'required|in:particular,regular',
            'estado' => 'required|in:activo,inactivo',
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
        // Datos simulados del cliente según el ID
        $clientesSimulados = [
            1 => [
                'id' => 1,
                'nombre' => 'Juan Carlos',
                'apellido' => 'Pérez González',
                'rut' => '12.345.678-9',
                'email' => 'jperez@gmail.com',
                'telefono' => '+56 9 8765 4321',
                'direccion' => 'Av. Providencia 1261, Santiago',
                'ciudad' => 'Santiago',
                'region' => 'Región Metropolitana',
                'tipo_cliente' => 'Particular',
                'estado' => 'Activo',
                'fecha_registro' => '2023-01-15'
            ],
            2 => [
                'id' => 2,
                'nombre' => 'María Elena',
                'apellido' => 'González Silva',
                'rut' => '15.678.901-2',
                'email' => 'mgonzalez@gmail.com',
                'telefono' => '+56 9 7654 3210',
                'direccion' => 'Los Leones 1234, Las Condes',
                'ciudad' => 'Las Condes',
                'region' => 'Región Metropolitana',
                'tipo_cliente' => 'Particular',
                'estado' => 'Activo',
                'fecha_registro' => '2023-02-20'
            ],
            3 => [
                'id' => 3,
                'nombre' => 'Carlos Alberto',
                'apellido' => 'Mendoza Rojas',
                'rut' => '18.901.234-5',
                'email' => 'cmendoza@hotmail.com',
                'telefono' => '+56 9 6543 2109',
                'direccion' => 'San Martín 567, Valparaíso',
                'ciudad' => 'Valparaíso',
                'region' => 'Región de Valparaíso',
                'tipo_cliente' => 'Particular',
                'estado' => 'Activo',
                'fecha_registro' => '2023-03-10'
            ]
        ];

        // Obtener datos del cliente o usar el primero como default
        $clienteData = $clientesSimulados[$id] ?? $clientesSimulados[1];
        
        // Crear objeto cliente simulado
        $cliente = (object) array_merge($clienteData, [
            'ordenes' => collect([
                (object)[
                    'id' => 1,
                    'numero_orden' => 'REP-2024-001',
                    'fecha_creacion' => '2024-01-15',
                    'estado' => 'Completada',
                    'prioridad' => 'Alta',
                    'descripcion' => 'Reparación pantalla iPhone 14',
                    'equipo' => 'iPhone 14 Pro',
                    'problema' => 'Pantalla quebrada',
                    'valor' => 120000,
                    'tecnico' => (object)[
                        'nombre' => 'Carlos',
                        'apellido' => 'Morales',
                        'especialidad' => 'Dispositivos Móviles'
                    ]
                ],
                (object)[
                    'id' => 2,
                    'numero_orden' => 'REP-2024-002',
                    'fecha_creacion' => '2024-01-20',
                    'estado' => 'En Proceso',
                    'prioridad' => 'Media',
                    'descripcion' => 'Reparación MacBook Pro',
                    'equipo' => 'MacBook Pro 13"',
                    'problema' => 'No enciende, posible problema motherboard',
                    'valor' => 250000,
                    'tecnico' => (object)[
                        'nombre' => 'María',
                        'apellido' => 'Silva',
                        'especialidad' => 'Computadores'
                    ]
                ],
                (object)[
                    'id' => 3,
                    'numero_orden' => 'REP-2024-003',
                    'fecha_creacion' => '2024-01-25',
                    'estado' => 'Pendiente',
                    'prioridad' => 'Baja',
                    'descripcion' => 'Limpieza y mantenimiento PlayStation 5',
                    'equipo' => 'PlayStation 5',
                    'problema' => 'Sobrecalentamiento por polvo',
                    'valor' => 35000,
                    'tecnico' => (object)[
                        'nombre' => 'Diego',
                        'apellido' => 'Hernández',
                        'especialidad' => 'Consolas'
                    ]
                ]
            ])
        ]);

        // Estadísticas calculadas
        $estadisticas = [
            'total_ordenes' => $cliente->ordenes->count(),
            'ordenes_completadas' => $cliente->ordenes->where('estado', 'Completada')->count(),
            'ordenes_pendientes' => $cliente->ordenes->whereIn('estado', ['Pendiente', 'En Proceso'])->count(),
            'valor_total_gastado' => $cliente->ordenes->sum('valor'),
            'ultima_orden' => $cliente->ordenes->sortByDesc('fecha_creacion')->first()
        ];

        return view('clientes.show', compact('cliente', 'estadisticas'));
    }
}