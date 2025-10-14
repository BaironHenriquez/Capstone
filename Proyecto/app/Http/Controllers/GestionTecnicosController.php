<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trabajador;
use App\Models\Tecnico;
use App\Models\Role;
use App\Models\ServicioTecnico;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class GestionTecnicosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $estado = $request->get('estado');
        $servicio = $request->get('servicio');
        
        // Datos simulados de técnicos especialistas en reparación
        $allTecnicos = collect([
            (object)[
                'id' => 1,
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'email' => 'carlos@repairtech.cl',
                'telefono' => '+56 9 8765 4321',
                'rut' => '12.345.678-9',
                'especialidades' => ['Dispositivos Móviles', 'Tablets'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Reparación Móviles'],
                'ordenes_completadas' => 125,
                'calificacion_promedio' => 4.8,
                'created_at' => now()->subMonths(6)
            ],
            (object)[
                'id' => 2,
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'email' => 'ana@repairtech.cl',
                'telefono' => '+56 9 7654 3210',
                'rut' => '11.234.567-8',
                'especialidades' => ['Computadores', 'Laptops'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Reparación PC'],
                'ordenes_completadas' => 89,
                'calificacion_promedio' => 4.6,
                'created_at' => now()->subMonths(3)
            ],
            (object)[
                'id' => 3,
                'nombre' => 'Miguel',
                'apellido' => 'Silva',
                'email' => 'miguel@repairtech.cl',
                'telefono' => '+56 9 6543 2109',
                'rut' => '10.123.456-7',
                'especialidades' => ['Televisores', 'Consolas'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Audio & Video Repair'],
                'ordenes_completadas' => 67,
                'calificacion_promedio' => 4.5,
                'created_at' => now()->subMonth()
            ],
            (object)[
                'id' => 4,
                'nombre' => 'Sofía',
                'apellido' => 'Hernández',
                'email' => 'sofia@repairtech.cl',
                'telefono' => '+56 9 5432 1098',
                'rut' => '14.567.890-1',
                'especialidades' => ['Dispositivos Móviles', 'Consolas'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Móviles & Gaming'],
                'ordenes_completadas' => 92,
                'calificacion_promedio' => 4.9,
                'created_at' => now()->subMonths(8)
            ],
            (object)[
                'id' => 5,
                'nombre' => 'Diego',
                'apellido' => 'Morales',
                'email' => 'diego@repairtech.cl',
                'telefono' => '+56 9 4321 0987',
                'rut' => '16.789.012-3',
                'especialidades' => ['Tablets', 'Smartwatches'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Dispositivos Inteligentes'],
                'ordenes_completadas' => 78,
                'calificacion_promedio' => 4.7,
                'created_at' => now()->subMonths(5)
            ],
            (object)[
                'id' => 6,
                'nombre' => 'Valentina',
                'apellido' => 'Castro',
                'email' => 'valentina@repairtech.cl',
                'telefono' => '+56 9 3210 9876',
                'rut' => '17.890.123-4',
                'especialidades' => ['Laptops', 'Computadores'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Reparación PC'],
                'ordenes_completadas' => 103,
                'calificacion_promedio' => 4.8,
                'created_at' => now()->subMonths(10)
            ],
            (object)[
                'id' => 7,
                'nombre' => 'Roberto',
                'apellido' => 'Fuentes',
                'email' => 'roberto@repairtech.cl',
                'telefono' => '+56 9 2109 8765',
                'rut' => '18.901.234-5',
                'especialidades' => ['Televisores', 'Equipos de Audio'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Audio & Video Repair'],
                'ordenes_completadas' => 156,
                'calificacion_promedio' => 4.6,
                'created_at' => now()->subMonths(12)
            ],
            (object)[
                'id' => 8,
                'nombre' => 'Camila',
                'apellido' => 'Pérez',
                'email' => 'camila@repairtech.cl',
                'telefono' => '+56 9 1098 7654',
                'rut' => '19.012.345-6',
                'especialidades' => ['Dispositivos Móviles', 'Reparación de Pantallas'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Especialista en Pantallas'],
                'ordenes_completadas' => 134,
                'calificacion_promedio' => 4.9,
                'created_at' => now()->subMonths(7)
            ],
            (object)[
                'id' => 9,
                'nombre' => 'Andrés',
                'apellido' => 'López',
                'email' => 'andres@repairtech.cl',
                'telefono' => '+56 9 0987 6543',
                'rut' => '20.123.456-7',
                'especialidades' => ['Consolas', 'Equipos Gaming'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Gaming Specialists'],
                'ordenes_completadas' => 87,
                'calificacion_promedio' => 4.7,
                'created_at' => now()->subMonths(4)
            ],
            (object)[
                'id' => 10,
                'nombre' => 'Francisca',
                'apellido' => 'Ramírez',
                'email' => 'francisca@repairtech.cl',
                'telefono' => '+56 9 9876 5432',
                'rut' => '21.234.567-8',
                'especialidades' => ['Tablets', 'E-readers'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Dispositivos Portátiles'],
                'ordenes_completadas' => 65,
                'calificacion_promedio' => 4.5,
                'created_at' => now()->subMonths(2)
            ],
            (object)[
                'id' => 11,
                'nombre' => 'Gonzalo',
                'apellido' => 'Vargas',
                'email' => 'gonzalo@repairtech.cl',
                'telefono' => '+56 9 8765 4321',
                'rut' => '22.345.678-9',
                'especialidades' => ['Computadores', 'Servidores'],
                'estado' => 'inactivo',
                'servicioTecnico' => (object)['nombre' => 'Soporte Técnico Avanzado'],
                'ordenes_completadas' => 45,
                'calificacion_promedio' => 4.3,
                'created_at' => now()->subMonths(1)
            ],
            (object)[
                'id' => 12,
                'nombre' => 'Isidora',
                'apellido' => 'Mendoza',
                'email' => 'isidora@repairtech.cl',
                'telefono' => '+56 9 7654 3210',
                'rut' => '23.456.789-0',
                'especialidades' => ['Smartphones', 'Cámaras Digitales'],
                'estado' => 'activo',
                'servicioTecnico' => (object)['nombre' => 'Fotografía & Móviles'],
                'ordenes_completadas' => 98,
                'calificacion_promedio' => 4.8,
                'created_at' => now()->subMonths(6)
            ]
        ]);
        
        // Filtrar según búsqueda
        $tecnicos = $allTecnicos;
        if ($search) {
            $tecnicos = $tecnicos->filter(function($tecnico) use ($search) {
                return stripos($tecnico->nombre . ' ' . $tecnico->apellido, $search) !== false || 
                       stripos($tecnico->email, $search) !== false ||
                       stripos($tecnico->rut, $search) !== false;
            });
        }
        
        if ($estado && $estado !== 'todos') {
            $tecnicos = $tecnicos->filter(function($tecnico) use ($estado) {
                return $tecnico->estado === $estado;
            });
        }
        
        // Servicios técnicos especializados simulados
        $serviciosTecnicos = collect([
            (object)['id' => 1, 'nombre' => 'Reparación Móviles'],
            (object)['id' => 2, 'nombre' => 'Reparación PC'],
            (object)['id' => 3, 'nombre' => 'Audio & Video Repair'],
            (object)['id' => 4, 'nombre' => 'Móviles & Gaming'],
            (object)['id' => 5, 'nombre' => 'Dispositivos Inteligentes'],
            (object)['id' => 6, 'nombre' => 'Especialista en Pantallas'],
            (object)['id' => 7, 'nombre' => 'Gaming Specialists'],
            (object)['id' => 8, 'nombre' => 'Dispositivos Portátiles'],
            (object)['id' => 9, 'nombre' => 'Soporte Técnico Avanzado'],
            (object)['id' => 10, 'nombre' => 'Fotografía & Móviles']
        ]);
        
        // Estadísticas simuladas
        $stats = [
            'total' => $allTecnicos->count(),
            'activos' => $allTecnicos->where('estado', 'activo')->count(),
            'inactivos' => $allTecnicos->where('estado', 'inactivo')->count(),
            'baneados' => $allTecnicos->where('estado', 'baneado')->count()
        ];
        
        // Simular paginación
        $tecnicos = (object)[
            'data' => $tecnicos->take(12),
            'total' => $tecnicos->count(),
            'current_page' => 1,
            'last_page' => 1
        ];
        
        return view('tecnicos.gestion-tecnicos', compact('tecnicos', 'serviciosTecnicos', 'stats', 'search', 'estado', 'servicio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::whereIn('nombre', ['tecnico', 'trabajador'])->get();
        $serviciosTecnicos = ServicioTecnico::all();
        $tecnicos = Tecnico::all();
        
        return view('tecnicos.create', compact('roles', 'serviciosTecnicos', 'tecnicos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|unique:users,rut|max:12',
            'email' => 'required|string|email|max:255|unique:users',
            'telefono' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'servicio_tecnico_id' => 'required|exists:servicio_tecnicos,id',
            'tipo_trabajo' => 'required|string',
            'habilidades' => 'required|array|min:1',
            'nivel_experiencia' => 'required|in:junior,intermedio,senior',
            'zona_trabajo' => 'required|string',
            'telefono_trabajo' => 'nullable|string|max:15',
            'horario_trabajo' => 'required|string',
            'salario_por_hora' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Crear usuario
            $user = User::create([
                'name' => strtolower($request->nombre . $request->apellido),
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'rut' => $request->rut,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'contrasena' => $request->password,
                'role_id' => $request->role_id,
                'servicio_tecnico_id' => $request->servicio_tecnico_id,
                'email_verified_at' => now(),
            ]);

            // Crear trabajador
            Trabajador::create([
                'user_id' => $user->id,
                'tecnico_id' => $request->tecnico_id,
                'tipo_trabajo' => $request->tipo_trabajo,
                'habilidades' => $request->habilidades,
                'nivel_experiencia' => $request->nivel_experiencia,
                'zona_trabajo' => $request->zona_trabajo,
                'disponible' => true,
                'telefono_trabajo' => $request->telefono_trabajo ?: $request->telefono,
                'horario_trabajo' => $request->horario_trabajo,
                'salario_por_hora' => $request->salario_por_hora,
                'estado' => 'activo',
                'fecha_ingreso' => now(),
                'servicio_tecnico_id' => $request->servicio_tecnico_id,
            ]);

            DB::commit();
            return redirect()->route('admin.gestion-tecnicos')->with('success', 'Técnico creado exitosamente');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear el técnico: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::with('trabajador', 'role', 'servicioTecnico')->findOrFail($id);
        $roles = Role::whereIn('nombre', ['tecnico', 'trabajador'])->get();
        $serviciosTecnicos = ServicioTecnico::all();
        $tecnicos = Tecnico::all();
        
        return view('administrador.tecnicos.edit', compact('user', 'roles', 'serviciosTecnicos', 'tecnicos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'rut' => 'required|string|max:12|unique:users,rut,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'telefono' => 'required|string|max:15',
            'password' => 'nullable|string|min:6|confirmed',
            'role_id' => 'required|exists:roles,id',
            'servicio_tecnico_id' => 'required|exists:servicio_tecnicos,id',
            'tipo_trabajo' => 'required|string',
            'habilidades' => 'required|array|min:1',
            'nivel_experiencia' => 'required|in:junior,intermedio,senior',
            'zona_trabajo' => 'required|string',
            'telefono_trabajo' => 'nullable|string|max:15',
            'horario_trabajo' => 'required|string',
            'salario_por_hora' => 'required|numeric|min:0',
            'estado' => 'required|in:activo,inactivo,baneado',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Actualizar usuario
            $userData = [
                'name' => strtolower($request->nombre . $request->apellido),
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'rut' => $request->rut,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'servicio_tecnico_id' => $request->servicio_tecnico_id,
            ];

            if ($request->password) {
                $userData['password'] = Hash::make($request->password);
                $userData['contrasena'] = $request->password;
            }

            $user->update($userData);

            // Actualizar o crear trabajador
            $user->trabajador()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'tecnico_id' => $request->tecnico_id,
                    'tipo_trabajo' => $request->tipo_trabajo,
                    'habilidades' => $request->habilidades,
                    'nivel_experiencia' => $request->nivel_experiencia,
                    'zona_trabajo' => $request->zona_trabajo,
                    'telefono_trabajo' => $request->telefono_trabajo ?: $request->telefono,
                    'horario_trabajo' => $request->horario_trabajo,
                    'salario_por_hora' => $request->salario_por_hora,
                    'estado' => $request->estado,
                    'servicio_tecnico_id' => $request->servicio_tecnico_id,
                    'notas_admin' => $request->notas_admin,
                ]
            );

            DB::commit();
            return redirect()->route('admin.gestion-tecnicos')->with('success', 'Técnico actualizado exitosamente');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar el técnico: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Ban/Unban a technician
     */
    public function toggleBan($id)
    {
        $user = User::findOrFail($id);
        $trabajador = $user->trabajador;
        
        if (!$trabajador) {
            return back()->with('error', 'No se encontró el registro de trabajador');
        }

        $nuevoEstado = $trabajador->estado === 'baneado' ? 'activo' : 'baneado';
        $trabajador->update(['estado' => $nuevoEstado]);

        $mensaje = $nuevoEstado === 'baneado' ? 'Técnico baneado exitosamente' : 'Técnico desbaneado exitosamente';
        return back()->with('success', $mensaje);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            
            // Eliminar trabajador asociado
            if ($user->trabajador) {
                $user->trabajador->delete();
            }
            
            // Eliminar usuario
            $user->delete();
            
            DB::commit();
            return redirect()->route('admin.gestion-tecnicos')->with('success', 'Técnico eliminado exitosamente');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar el técnico: ' . $e->getMessage());
        }
    }
}