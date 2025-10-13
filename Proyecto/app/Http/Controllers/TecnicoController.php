<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $servicioTecnicoId = $user->servicio_tecnico_id;
        
        $query = Tecnico::where('servicio_tecnico_id', $servicioTecnicoId)
            ->with(['user', 'ordenes' => function($q) {
                $q->whereIn('estado', ['pendiente', 'en_progreso'])->count();
            }]);

        // Búsqueda
        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('especialidad')) {
            $query->conEspecialidad($request->especialidad);
        }

        if ($request->filled('disponible')) {
            if ($request->disponible === '1') {
                $query->disponibles();
            } else {
                $query->where('disponible', false);
            }
        }

        // Ordenamiento
        $ordenPor = $request->get('orden_por', 'created_at');
        $direccion = $request->get('direccion', 'desc');
        $query->orderBy($ordenPor, $direccion);

        $tecnicos = $query->paginate(15)->withQueryString();

        // Estadísticas
        $estadisticas = [
            'total' => Tecnico::where('servicio_tecnico_id', $servicioTecnicoId)->count(),
            'activos' => Tecnico::where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'activo')->count(),
            'disponibles' => Tecnico::where('servicio_tecnico_id', $servicioTecnicoId)
                ->disponibles()->count(),
            'sobrecargados' => Tecnico::where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('carga_trabajo_actual', '>=', 90)->count()
        ];

        $especialidades = [
            'computadoras', 'moviles', 'redes', 'software', 'hardware', 
            'impresoras', 'servidores', 'telefonia', 'cctv', 'otros'
        ];

        return view('tecnicos.index', compact('tecnicos', 'estadisticas', 'especialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = [
            'computadoras', 'moviles', 'redes', 'software', 'hardware', 
            'impresoras', 'servidores', 'telefonia', 'cctv', 'otros'
        ];

        return view('tecnicos.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'especialidades' => 'required|array|min:1',
            'especialidades.*' => 'string|in:computadoras,moviles,redes,software,hardware,impresoras,servidores,telefonia,cctv,otros',
            'nivel_experiencia' => 'required|in:junior,semi-senior,senior,experto',
            'certificaciones' => 'nullable|array',
            'certificaciones.*' => 'string|max:100',
            'zona_trabajo' => 'nullable|string|max:100',
            'telefono_trabajo' => 'nullable|string|max:20',
            'horario_trabajo' => 'nullable|string|max:100',
            'salario_base' => 'nullable|numeric|min:0|max:9999999.99',
            'comision_por_orden' => 'nullable|numeric|min:0|max:999999.99',
            'fecha_ingreso' => 'nullable|date',
            'notas_admin' => 'nullable|string|max:1000'
        ]);

        $currentUser = Auth::user();
        
        // Crear usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'servicio_tecnico_id' => $currentUser->servicio_tecnico_id
        ]);

        // Asignar rol de técnico
        $rolTecnico = Role::where('nombre_rol', 'Técnico')->first();
        if ($rolTecnico) {
            $user->role_id = $rolTecnico->id;
            $user->save();
        }

        // Crear perfil de técnico
        $tecnico = Tecnico::create([
            'user_id' => $user->id,
            'especialidades' => $request->especialidades,
            'nivel_experiencia' => $request->nivel_experiencia,
            'certificaciones' => $request->certificaciones ?: [],
            'zona_trabajo' => $request->zona_trabajo,
            'telefono_trabajo' => $request->telefono_trabajo,
            'horario_trabajo' => $request->horario_trabajo,
            'salario_base' => $request->salario_base,
            'comision_por_orden' => $request->comision_por_orden,
            'fecha_ingreso' => $request->fecha_ingreso ?: now(),
            'notas_admin' => $request->notas_admin,
            'servicio_tecnico_id' => $currentUser->servicio_tecnico_id
        ]);

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tecnico $tecnico)
    {
        // Verificar que el técnico pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($tecnico->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        // Cargar relaciones
        $tecnico->load(['user', 'ordenes' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }, 'trabajadores']);

        // Estadísticas del técnico
        $estadisticas = [
            'total_ordenes' => $tecnico->totalOrdenesAsignadas(),
            'ordenes_completadas' => $tecnico->ordenesCompletadas(),
            'ordenes_pendientes' => $tecnico->ordenesPendientes(),
            'promedio_tiempo' => $tecnico->promedioTiempoResolucion(),
            'ingresos_mes' => $tecnico->ingresosMesActual(),
            'calificacion_promedio' => $tecnico->ordenes()
                ->where('estado', 'completada')
                ->whereNotNull('calificacion_cliente')
                ->avg('calificacion_cliente')
        ];

        return view('tecnicos.show', compact('tecnico', 'estadisticas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tecnico $tecnico)
    {
        // Verificar que el técnico pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($tecnico->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        $tecnico->load('user');
        
        $especialidades = [
            'computadoras', 'moviles', 'redes', 'software', 'hardware', 
            'impresoras', 'servidores', 'telefonia', 'cctv', 'otros'
        ];

        return view('tecnicos.edit', compact('tecnico', 'especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tecnico $tecnico)
    {
        // Verificar que el técnico pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($tecnico->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($tecnico->user_id)
            ],
            'password' => 'nullable|string|min:8',
            'especialidades' => 'required|array|min:1',
            'especialidades.*' => 'string|in:computadoras,moviles,redes,software,hardware,impresoras,servidores,telefonia,cctv,otros',
            'nivel_experiencia' => 'required|in:junior,semi-senior,senior,experto',
            'certificaciones' => 'nullable|array',
            'certificaciones.*' => 'string|max:100',
            'zona_trabajo' => 'nullable|string|max:100',
            'disponible' => 'boolean',
            'telefono_trabajo' => 'nullable|string|max:20',
            'horario_trabajo' => 'nullable|string|max:100',
            'salario_base' => 'nullable|numeric|min:0|max:9999999.99',
            'comision_por_orden' => 'nullable|numeric|min:0|max:999999.99',
            'estado' => 'required|in:activo,inactivo,vacaciones,licencia,suspendido',
            'fecha_ingreso' => 'nullable|date',
            'notas_admin' => 'nullable|string|max:1000'
        ]);

        // Actualizar usuario
        $userData = [
            'name' => $request->name,
            'email' => $request->email
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $tecnico->user->update($userData);

        // Actualizar técnico
        $tecnico->update([
            'especialidades' => $request->especialidades,
            'nivel_experiencia' => $request->nivel_experiencia,
            'certificaciones' => $request->certificaciones ?: [],
            'zona_trabajo' => $request->zona_trabajo,
            'disponible' => $request->boolean('disponible'),
            'telefono_trabajo' => $request->telefono_trabajo,
            'horario_trabajo' => $request->horario_trabajo,
            'salario_base' => $request->salario_base,
            'comision_por_orden' => $request->comision_por_orden,
            'estado' => $request->estado,
            'fecha_ingreso' => $request->fecha_ingreso,
            'notas_admin' => $request->notas_admin
        ]);

        return redirect()->route('tecnicos.show', $tecnico)
            ->with('success', 'Técnico actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tecnico $tecnico)
    {
        // Verificar que el técnico pertenece al servicio técnico del usuario
        $user = Auth::user();
        if ($tecnico->servicio_tecnico_id !== $user->servicio_tecnico_id) {
            abort(404);
        }

        // Verificar que no tenga órdenes pendientes
        if ($tecnico->ordenesPendientes() > 0) {
            return redirect()->route('tecnicos.index')
                ->with('error', 'No se puede eliminar el técnico porque tiene órdenes pendientes.');
        }

        // Eliminar usuario y técnico
        $tecnico->user->delete();
        $tecnico->delete();

        return redirect()->route('tecnicos.index')
            ->with('success', 'Técnico eliminado exitosamente.');
    }

    /**
     * Recomendar técnico para una orden
     */
    public function recomendar(Request $request)
    {
        $request->validate([
            'especialidad' => 'required|string',
            'zona' => 'nullable|string'
        ]);

        $user = Auth::user();
        
        $tecnicos = Tecnico::where('servicio_tecnico_id', $user->servicio_tecnico_id)
            ->disponibles()
            ->conEspecialidad($request->especialidad)
            ->get()
            ->map(function($tecnico) use ($request) {
                return [
                    'tecnico' => $tecnico,
                    'puntuacion' => $tecnico->recomendar($request->especialidad, $request->zona)
                ];
            })
            ->sortByDesc('puntuacion')
            ->take(5);

        return response()->json($tecnicos->values());
    }
}
