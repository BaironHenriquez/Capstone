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
        
        $query = User::with(['trabajador', 'role', 'servicioTecnico'])
                    ->whereHas('role', function($q) {
                        $q->whereIn('nombre', ['tecnico', 'trabajador']);
                    });
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('rut', 'like', "%{$search}%");
            });
        }
        
        if ($estado && $estado !== 'todos') {
            $query->whereHas('trabajador', function($q) use ($estado) {
                $q->where('estado', $estado);
            });
        }
        
        if ($servicio && $servicio !== 'todos') {
            $query->where('servicio_tecnico_id', $servicio);
        }
        
        $tecnicos = $query->orderBy('created_at', 'desc')->paginate(12);
        $serviciosTecnicos = ServicioTecnico::all();
        
        // Estadísticas
        $stats = [
            'total' => User::whereHas('role', function($q) {
                $q->whereIn('nombre', ['tecnico', 'trabajador']);
            })->count(),
            'activos' => User::whereHas('role', function($q) {
                $q->whereIn('nombre', ['tecnico', 'trabajador']);
            })->whereHas('trabajador', function($q) {
                $q->where('estado', 'activo');
            })->count(),
            'inactivos' => User::whereHas('role', function($q) {
                $q->whereIn('nombre', ['tecnico', 'trabajador']);
            })->whereHas('trabajador', function($q) {
                $q->where('estado', 'inactivo');
            })->count(),
            'baneados' => User::whereHas('role', function($q) {
                $q->whereIn('nombre', ['tecnico', 'trabajador']);
            })->whereHas('trabajador', function($q) {
                $q->where('estado', 'baneado');
            })->count(),
        ];
        
        return view('administrador.gestion-tecnicos', compact('tecnicos', 'serviciosTecnicos', 'stats', 'search', 'estado', 'servicio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::whereIn('nombre', ['tecnico', 'trabajador'])->get();
        $serviciosTecnicos = ServicioTecnico::all();
        $tecnicos = Tecnico::all();
        
        return view('administrador.tecnicos.create', compact('roles', 'serviciosTecnicos', 'tecnicos'));
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