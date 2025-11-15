<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Trabajador;
use App\Models\Tecnico;
use App\Models\Role;
use App\Models\ServicioTecnico;
use App\Models\OrdenServicio;
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
        
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }
        
        // Obtener el servicio técnico del usuario autenticado
        $user = auth()->user();
        $servicioTecnico = $user->servicioTecnico;
        
        if (!$servicioTecnico) {
            return redirect()->back()->with('error', 'No tienes un servicio técnico asignado. Contacta al administrador.');
        }
        
        $servicioTecnicoId = $servicioTecnico->id;
        
        // Consultar técnicos reales de la base de datos
        $query = Tecnico::with(['servicioTecnico'])
            ->withCount('ordenes')
            ->where('servicio_tecnico_id', $servicioTecnicoId);
        
        // Filtrar según búsqueda
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('rut', 'like', "%{$search}%");
            });
        }
        
        // Filtrar por estado
        if ($estado && $estado !== 'todos') {
            $query->where('estado', $estado);
        }
        
        // Filtrar por servicio técnico (si se proporciona)
        if ($servicio) {
            $query->where('servicio_tecnico_id', $servicio);
        }
        
        // Obtener técnicos con paginación
        $tecnicos = $query->paginate(12);
        
        // Calcular carga de trabajo para cada técnico
        foreach ($tecnicos as $tecnico) {
            $ordenesActivas = OrdenServicio::where('tecnico_id', $tecnico->id)
                ->whereIn('estado', ['asignada', 'en_progreso', 'diagnostico'])
                ->count();
            
            $tecnico->carga_trabajo_actual = min(100, ($ordenesActivas / 10) * 100); // Cada orden representa 10% de carga
        }
        
        // Obtener servicios técnicos
        $serviciosTecnicos = ServicioTecnico::all();
        
        // Calcular estadísticas
        $allTecnicos = Tecnico::where('servicio_tecnico_id', $servicioTecnicoId);
        $stats = [
            'total' => $allTecnicos->count(),
            'activos' => (clone $allTecnicos)->where('estado', 'activo')->count(),
            'inactivos' => (clone $allTecnicos)->where('estado', 'inactivo')->count(),
            'suspendidos' => (clone $allTecnicos)->where('estado', 'suspendido')->count()
        ];
        
        return view('admin.tecnicos.gestion-tecnicos', compact('tecnicos', 'serviciosTecnicos', 'stats', 'search', 'estado', 'servicio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            // Verificar que el usuario esté autenticado
            if (!auth()->check()) {
                return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
            }
            
            // Obtener el servicio técnico del usuario
            $user = auth()->user();
            $servicioTecnico = $user->servicioTecnico;
            
            if (!$servicioTecnico) {
                return redirect()->back()->with('error', 'No tienes un servicio técnico asignado. Contacta al administrador.');
            }
            
            return view('admin.tecnicos.create', compact('servicioTecnico'));
        } catch (\Exception $e) {
            return redirect()->route('admin.gestion-tecnicos')->with('error', 'Error al cargar el formulario: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Obtener el servicio técnico del usuario autenticado
        $servicioTecnico = auth()->user()->servicioTecnico;
        
        if (!$servicioTecnico) {
            return back()->with('error', 'No tienes un servicio técnico asignado.')->withInput();
        }
        
        $servicioTecnicoId = $servicioTecnico->id;
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'rut' => 'required|string|unique:tecnicos,rut|max:20',
            'email' => 'required|string|email|max:150|unique:tecnicos,email',
            'password' => 'required|string|min:6|confirmed',
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'especialidades' => 'required|array|min:1',
            'especialidades.*' => 'required|string',
            'nivel_experiencia' => 'required|in:junior,semi-senior,senior,experto',
            'certificaciones' => 'nullable|array',
            'certificaciones.*' => 'nullable|string',
            'zona_trabajo' => 'required|string|max:100',
            'telefono_trabajo' => 'nullable|string|max:20',
            'horario_trabajo' => 'required|string|max:100',
            'salario_base' => 'required|numeric|min:0',
            'comision_por_orden' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Crear técnico con todos sus datos (incluyendo credenciales)
            // El role_id se asigna por defecto a 2 (técnico)
            $tecnico = Tecnico::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'rut' => $request->rut,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2, // Rol de técnico por defecto
                'email_verified_at' => now(),
                'telefono' => $request->telefono,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
                'region' => $request->region,
                'especialidades' => $request->especialidades,
                'nivel_experiencia' => $request->nivel_experiencia,
                'certificaciones' => $request->certificaciones ?? [],
                'zona_trabajo' => $request->zona_trabajo,
                'disponible' => true,
                'carga_trabajo_actual' => 0,
                'telefono_trabajo' => $request->telefono_trabajo ?? $request->telefono,
                'horario_trabajo' => $request->horario_trabajo,
                'salario_base' => $request->salario_base,
                'comision_por_orden' => $request->comision_por_orden ?? 0,
                'estado' => 'activo',
                'fecha_ingreso' => now(),
                'servicio_tecnico_id' => $servicioTecnicoId,
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
        $tecnico = Tecnico::with('servicioTecnico')->findOrFail($id);
        
        // Obtener el servicio técnico del usuario autenticado
        $miServicioTecnico = auth()->user()->servicioTecnico;
        
        if (!$miServicioTecnico) {
            return redirect()->back()->with('error', 'No tienes un servicio técnico asignado.');
        }
        
        // Verificar que el técnico pertenece al mismo servicio técnico
        if ($tecnico->servicio_tecnico_id !== $miServicioTecnico->id) {
            abort(403, 'No autorizado para editar este técnico.');
        }
        
        $servicioTecnico = $miServicioTecnico;
        
        return view('admin.tecnicos.edit', compact('tecnico', 'servicioTecnico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $tecnico = Tecnico::findOrFail($id);
        
        // Obtener el servicio técnico del usuario autenticado
        $miServicioTecnico = auth()->user()->servicioTecnico;
        
        if (!$miServicioTecnico) {
            return back()->with('error', 'No tienes un servicio técnico asignado.');
        }
        
        // Verificar que el técnico pertenece al mismo servicio técnico
        if ($tecnico->servicio_tecnico_id !== $miServicioTecnico->id) {
            abort(403, 'No autorizado para editar este técnico.');
        }
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'rut' => 'required|string|max:20|unique:tecnicos,rut,' . $id,
            'email' => 'required|string|email|max:150|unique:tecnicos,email,' . $id,
            'telefono' => 'required|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'direccion' => 'nullable|string',
            'ciudad' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'especialidades' => 'required|array|min:1',
            'especialidades.*' => 'required|string',
            'nivel_experiencia' => 'required|in:junior,semi-senior,senior,experto',
            'certificaciones' => 'nullable|array',
            'certificaciones.*' => 'nullable|string',
            'zona_trabajo' => 'required|string|max:100',
            'telefono_trabajo' => 'nullable|string|max:20',
            'horario_trabajo' => 'required|string|max:100',
            'salario_base' => 'required|numeric|min:0',
            'comision_por_orden' => 'nullable|numeric|min:0',
            'estado' => 'required|in:activo,inactivo,vacaciones,licencia,suspendido',
            'notas_admin' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            // Actualizar técnico
            $tecnico->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'rut' => $request->rut,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
                'region' => $request->region,
                'especialidades' => $request->especialidades,
                'nivel_experiencia' => $request->nivel_experiencia,
                'certificaciones' => $request->certificaciones ?? [],
                'zona_trabajo' => $request->zona_trabajo,
                'telefono_trabajo' => $request->telefono_trabajo ?? $request->telefono,
                'horario_trabajo' => $request->horario_trabajo,
                'salario_base' => $request->salario_base,
                'comision_por_orden' => $request->comision_por_orden ?? 0,
                'estado' => $request->estado,
                'notas_admin' => $request->notas_admin,
            ]);

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
        $tecnico = Tecnico::findOrFail($id);
        
        // Obtener el servicio técnico del usuario autenticado
        $miServicioTecnico = auth()->user()->servicioTecnico;
        
        if (!$miServicioTecnico) {
            return back()->with('error', 'No tienes un servicio técnico asignado.');
        }
        
        // Verificar que el técnico pertenece al mismo servicio técnico
        if ($tecnico->servicio_tecnico_id !== $miServicioTecnico->id) {
            abort(403, 'No autorizado para modificar este técnico.');
        }

        $nuevoEstado = $tecnico->estado === 'suspendido' ? 'activo' : 'suspendido';
        $tecnico->update(['estado' => $nuevoEstado]);

        $mensaje = $nuevoEstado === 'suspendido' ? 'Técnico suspendido exitosamente' : 'Técnico activado exitosamente';
        return back()->with('success', $mensaje);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $tecnico = Tecnico::findOrFail($id);
            
            // Obtener el servicio técnico del usuario autenticado
            $miServicioTecnico = auth()->user()->servicioTecnico;
            
            if (!$miServicioTecnico) {
                return back()->with('error', 'No tienes un servicio técnico asignado.');
            }
            
            // Verificar que el técnico pertenece al mismo servicio técnico
            if ($tecnico->servicio_tecnico_id !== $miServicioTecnico->id) {
                abort(403, 'No autorizado para eliminar este técnico.');
            }
            
            // Eliminar técnico (soft delete)
            $tecnico->delete();
            
            DB::commit();
            return redirect()->route('admin.gestion-tecnicos')->with('success', 'Técnico eliminado exitosamente');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar el técnico: ' . $e->getMessage());
        }
    }

    /**
     * Mostrar vista de asignación de órdenes
     */
    public function asignar($id)
    {
        try {
            $tecnico = Tecnico::with(['servicioTecnico', 'ordenes'])->findOrFail($id);
            
            // Verificar que el técnico pertenezca al servicio técnico del usuario autenticado
            $miServicioTecnico = auth()->user()->servicioTecnico;
            
            if (!$miServicioTecnico) {
                return redirect()->back()->with('error', 'No tienes un servicio técnico asignado.');
            }
            
            if ($tecnico->servicio_tecnico_id !== $miServicioTecnico->id) {
                abort(403, 'No autorizado para gestionar este técnico.');
            }
            
            // Obtener órdenes activas del técnico
            $ordenesActivas = OrdenServicio::where('tecnico_id', $tecnico->id)
                ->whereIn('estado', ['pendiente', 'en_progreso', 'asignada', 'en_proceso', 'diagnostico'])
                ->with(['cliente', 'equipo'])
                ->get();
            
            // Obtener órdenes disponibles para asignar (sin técnico o con estado pendiente)
            $ordenesDisponibles = OrdenServicio::where('servicio_tecnico_id', $miServicioTecnico->id)
                ->where(function($query) {
                    $query->whereNull('tecnico_id')
                          ->orWhere('estado', 'pendiente');
                })
                ->with(['cliente', 'equipo'])
                ->orderBy('prioridad', 'desc')
                ->orderBy('fecha_ingreso', 'asc')
                ->get();
            
            // Contar órdenes completadas
            $ordenesCompletadas = OrdenServicio::where('tecnico_id', $tecnico->id)
                ->where('estado', 'completada')
                ->count();
            
            // Calcular carga laboral (asumiendo máximo 10 órdenes activas)
            $ordenesActivasCount = $ordenesActivas->count();
            $cargaTrabajo = min(($ordenesActivasCount / 10) * 100, 100);
            
            // Determinar estado del técnico
            if ($cargaTrabajo >= 90) {
                $estadoTecnico = 'sobrecargado';
            } elseif ($cargaTrabajo >= 70) {
                $estadoTecnico = 'activo';
            } else {
                $estadoTecnico = 'disponible';
            }
            
            return view('admin.tecnicos.asignar', compact(
                'tecnico', 
                'ordenesActivas', 
                'ordenesDisponibles',
                'ordenesCompletadas',
                'cargaTrabajo',
                'estadoTecnico'
            ));
            
        } catch (\Exception $e) {
            return redirect()->route('gestion-tecnicos')->with('error', 'Error al cargar la página de asignación: ' . $e->getMessage());
        }
    }

    /**
     * Asignar una orden a un técnico
     */
    public function asignarStore(Request $request, $id)
    {
        try {
            $tecnico = Tecnico::findOrFail($id);
            
            // Verificar permisos
            $miServicioTecnico = auth()->user()->servicioTecnico;
            if (!$miServicioTecnico || $tecnico->servicio_tecnico_id !== $miServicioTecnico->id) {
                abort(403, 'No autorizado.');
            }
            
            $request->validate([
                'orden_id' => 'required|exists:ordenes_servicio,id'
            ]);
            
            $orden = OrdenServicio::findOrFail($request->orden_id);
            
            // Verificar que la orden pertenezca al mismo servicio técnico
            if ($orden->servicio_tecnico_id !== $miServicioTecnico->id) {
                return back()->with('error', 'Esta orden no pertenece a tu servicio técnico.');
            }
            
            // Asignar el técnico a la orden y cambiar estado a 'en_progreso'
            $orden->update([
                'tecnico_id' => $tecnico->id,
                'estado' => 'en_progreso'
            ]);
            
            // Actualizar carga de trabajo del técnico
            $ordenesActivas = OrdenServicio::where('tecnico_id', $tecnico->id)
                ->whereIn('estado', ['asignada', 'en_proceso', 'diagnostico'])
                ->count();
            
            $tecnico->update([
                'carga_trabajo_actual' => min(100, ($ordenesActivas / 10) * 100) // Cada orden representa 10% de carga
            ]);
            
            return back()->with('success', 'Orden asignada exitosamente al técnico.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al asignar la orden: ' . $e->getMessage());
        }
    }

    /**
     * Desasignar una orden de un técnico
     */
    public function desasignar($tecnicoId, $ordenId)
    {
        try {
            $tecnico = Tecnico::findOrFail($tecnicoId);
            $orden = OrdenServicio::findOrFail($ordenId);
            
            // Verificar permisos
            $miServicioTecnico = auth()->user()->servicioTecnico;
            if (!$miServicioTecnico || $tecnico->servicio_tecnico_id !== $miServicioTecnico->id) {
                abort(403, 'No autorizado.');
            }
            
            // Verificar que la orden esté asignada a este técnico
            if ($orden->tecnico_id !== $tecnico->id) {
                return back()->with('error', 'Esta orden no está asignada a este técnico.');
            }
            
            // Desasignar
            $orden->update([
                'tecnico_id' => null,
                'estado' => 'pendiente'
            ]);
            
            // Actualizar carga de trabajo del técnico
            $ordenesActivas = OrdenServicio::where('tecnico_id', $tecnico->id)
                ->whereIn('estado', ['asignada', 'en_proceso', 'diagnostico'])
                ->count();
            
            $tecnico->update([
                'carga_trabajo_actual' => min(100, ($ordenesActivas / 10) * 100)
            ]);
            
            return back()->with('success', 'Orden desasignada exitosamente.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al desasignar la orden: ' . $e->getMessage());
        }
    }
}