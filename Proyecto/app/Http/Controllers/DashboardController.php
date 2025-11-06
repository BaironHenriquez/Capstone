<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\OrdenServicio;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mostrar dashboard principal basado en el rol del usuario
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga rol
        if (!$user->role) {
            return redirect()->route('setup.technical-service')
                ->with('error', 'Necesitas completar tu configuración antes de acceder al dashboard.');
        }

        // Redirigir según el rol del usuario
        switch ($user->role->nombre_rol) {
            case 'Administrador':
                return $this->adminDashboard($user);
            case 'Técnico':
                return $this->technicianDashboard($user);
            case 'Trabajador':
                return $this->workerDashboard($user);
            default:
                return redirect()->route('setup.technical-service')
                    ->with('error', 'Rol no reconocido. Contacta al administrador.');
        }
    }

    /**
     * Dashboard para Administrador
     */
    public function adminDashboard()
    {
        $user = auth()->user();
        $servicioTecnicoId = $user && $user->servicioTecnico ? $user->servicioTecnico->id : null;
        
        // Estadísticas de clientes reales
        $estadisticasClientes = [
            'total' => Cliente::when($servicioTecnicoId, function($query) use ($servicioTecnicoId) {
                return $query->where('servicio_tecnico_id', $servicioTecnicoId);
            })->count(),
            'nuevos_mes' => Cliente::when($servicioTecnicoId, function($query) use ($servicioTecnicoId) {
                return $query->where('servicio_tecnico_id', $servicioTecnicoId);
            })->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year)
              ->count(),
            'nuevos_semana' => Cliente::when($servicioTecnicoId, function($query) use ($servicioTecnicoId) {
                return $query->where('servicio_tecnico_id', $servicioTecnicoId);
            })->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
              ->count(),
        ];

        // Datos para gráfico de clientes por mes (últimos 6 meses)
        $clientesPorMes = [];
        for ($i = 5; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $clientesPorMes[] = [
                'mes' => $fecha->format('M Y'),
                'cantidad' => Cliente::where('servicio_tecnico_id', $servicioTecnicoId)
                    ->whereMonth('created_at', $fecha->month)
                    ->whereYear('created_at', $fecha->year)
                    ->count()
            ];
        }

        // Resumen de órdenes reales desde la base de datos
        $resumenOrdenes = [
            'total' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->count(),
            'pendientes' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'pendiente')
                ->count(),
            'en_progreso' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'en_progreso')
                ->count(),
            'completadas' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'completada')
                ->count(),
            'en_revision' => 0 // Estado no usado actualmente
        ];
        
        // Obtener técnicos reales del servicio técnico
        $tecnicos = DB::table('tecnicos')
            ->where('tecnicos.servicio_tecnico_id', $servicioTecnicoId)
            ->select(
                'tecnicos.id',
                DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
                'tecnicos.especialidades',
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ("pendiente", "en_progreso")) as ordenes_asignadas'),
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado = "completada") as ordenes_completadas')
            )
            ->get()
            ->map(function($tecnico) {
                // Calcular carga de trabajo (asumiendo máximo 10 órdenes)
                $cargaTrabajo = min(($tecnico->ordenes_asignadas / 10) * 100, 100);
                
                // Determinar estado
                if ($cargaTrabajo >= 90) {
                    $estado = 'sobrecargado';
                } elseif ($cargaTrabajo >= 70) {
                    $estado = 'activo';
                } else {
                    $estado = 'disponible';
                }
                
                // Decodificar especialidades JSON y tomar la primera
                $especialidades = json_decode($tecnico->especialidades, true);
                $especialidad = is_array($especialidades) && count($especialidades) > 0 
                    ? ucfirst($especialidades[0]) 
                    : 'General';
                
                return [
                    'id' => $tecnico->id,
                    'nombre' => $tecnico->nombre,
                    'ordenes_asignadas' => $tecnico->ordenes_asignadas,
                    'ordenes_completadas' => $tecnico->ordenes_completadas,
                    'carga_trabajo' => round($cargaTrabajo),
                    'especialidad' => $especialidad,
                    'estado' => $estado
                ];
            })
            ->toArray();
        
        // Generar alertas basadas en datos reales
        $alertas = [];
        
        // Alertas de órdenes retrasadas (más de 7 días desde fecha programada)
        $ordenesRetrasadas = DB::table('ordenes_servicio')
            ->join('clientes', 'ordenes_servicio.cliente_id', '=', 'clientes.id')
            ->join('tecnicos', 'ordenes_servicio.tecnico_id', '=', 'tecnicos.id')
            ->where('ordenes_servicio.servicio_tecnico_id', $servicioTecnicoId)
            ->where('ordenes_servicio.estado', '!=', 'completada')
            ->whereNotNull('ordenes_servicio.fecha_programada')
            ->whereDate('ordenes_servicio.fecha_programada', '<', now()->subDays(7))
            ->select(
                'ordenes_servicio.numero_orden',
                'clientes.nombre as cliente',
                DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as tecnico'),
                DB::raw('DATEDIFF(NOW(), ordenes_servicio.fecha_programada) as dias_retraso')
            )
            ->limit(3)
            ->get();
        
        foreach ($ordenesRetrasadas as $orden) {
            $alertas[] = [
                'tipo' => 'retraso_critico',
                'orden' => $orden->numero_orden,
                'cliente' => $orden->cliente,
                'dias_retraso' => $orden->dias_retraso,
                'tecnico' => $orden->tecnico,
                'prioridad' => 'alta'
            ];
        }
        
        // Alertas de técnicos sobrecargados
        foreach ($tecnicos as $tecnico) {
            if ($tecnico['carga_trabajo'] >= 90) {
                $alertas[] = [
                    'tipo' => 'sobrecarga_tecnico',
                    'tecnico' => $tecnico['nombre'],
                    'carga' => $tecnico['carga_trabajo'],
                    'ordenes_pendientes' => $tecnico['ordenes_asignadas'],
                    'prioridad' => 'media'
                ];
            }
        }
        
        // Métricas calculadas
        $ordenesCompletadasMesActual = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->where('estado', 'completada')
            ->whereMonth('updated_at', now()->month)
            ->whereYear('updated_at', now()->year)
            ->count();
            
        $ordenesCompletadasMesAnterior = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->where('estado', 'completada')
            ->whereMonth('updated_at', now()->subMonth()->month)
            ->whereYear('updated_at', now()->subMonth()->year)
            ->count();
        
        $crecimiento = 0;
        if ($ordenesCompletadasMesAnterior > 0) {
            $crecimiento = (($ordenesCompletadasMesActual - $ordenesCompletadasMesAnterior) / $ordenesCompletadasMesAnterior) * 100;
        }
        
        $metricas = [
            'tiempo_promedio_resolucion' => 3.2, // Esto requeriría un cálculo más complejo
            'satisfaccion_cliente' => 94, // Esto requeriría una tabla de valoraciones
            'ordenes_mes_actual' => $ordenesCompletadasMesActual,
            'ordenes_mes_anterior' => $ordenesCompletadasMesAnterior,
            'crecimiento' => round($crecimiento, 1)
        ];

        // Productividad semanal - Órdenes creadas por día de la semana actual
        $productividadSemanal = [];
        $inicioSemana = now()->startOfWeek(); // Lunes
        
        for ($i = 0; $i < 7; $i++) {
            $fecha = $inicioSemana->copy()->addDays($i);
            $ordenesCreadas = DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereDate('created_at', $fecha->toDateString())
                ->count();
            
            $productividadSemanal[] = $ordenesCreadas;
        }

        return view('admin.dashboard-admin', compact(
            'user', 
            'estadisticasClientes',
            'clientesPorMes',
            'resumenOrdenes', 
            'tecnicos',
            'alertas',
            'metricas',
            'productividadSemanal'
        ));
    }

    /**
     * Dashboard para Técnico
     */
    private function technicianDashboard($user)
    {
        return view('tecnico.dashboard-tecnico', [
            'user' => $user,
            'servicioTecnico' => $user->servicioTecnico
        ]);
    }

    /**
     * Resumen del Técnico con datos reales
     */
    public function tecnicoResumen($id = null)
    {
        // Si no se proporciona ID, intentar obtener el primer técnico activo
        if (!$id) {
            $tecnico = \App\Models\Tecnico::where('estado', 'activo')
                ->whereNull('deleted_at')
                ->first();
            
            if (!$tecnico) {
                return redirect()->route('dashboard')->with('error', 'No se encontró información del técnico');
            }
        } else {
            // Si se proporciona ID, buscar ese técnico específico
            $tecnico = \App\Models\Tecnico::findOrFail($id);
        }

        // Obtener órdenes asignadas al técnico
        $ordenesAsignadas = OrdenServicio::where('tecnico_id', $tecnico->id)
            ->with(['cliente', 'equipo'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Estadísticas
        $stats = [
            'total_asignadas' => $ordenesAsignadas->count(),
            'en_progreso' => $ordenesAsignadas->whereIn('estado', ['en_proceso', 'en_progreso'])->count(),
            'completadas' => $ordenesAsignadas->whereIn('estado', ['completado', 'completada'])->count(),
            'pendientes' => $ordenesAsignadas->whereIn('estado', ['pendiente', 'asignada'])->count(),
            'urgentes' => $ordenesAsignadas->where('prioridad', 'alta')->whereNotIn('estado', ['completado', 'completada', 'cancelado', 'cancelada'])->count(),
            'completadas_semana' => $ordenesAsignadas->whereIn('estado', ['completado', 'completada'])
                ->where('updated_at', '>=', now()->startOfWeek())->count(),
            'nuevas_hoy' => $ordenesAsignadas->where('created_at', '>=', now()->startOfDay())->count(),
        ];

        // Calcular carga laboral (porcentaje basado en órdenes activas)
        $maxOrdenes = 20; // Máximo de órdenes que un técnico debería manejar
        $ordenesActivas = $stats['en_progreso'] + $stats['pendientes'];
        $stats['carga_laboral'] = min(100, round(($ordenesActivas / $maxOrdenes) * 100));

        // Últimas órdenes activas (no completadas ni canceladas)
        $ordenesActivas = $ordenesAsignadas->whereNotIn('estado', ['completado', 'completada', 'cancelado', 'cancelada'])
            ->take(10);

        // Calcular progreso semanal
        $totalSemana = $ordenesAsignadas->where('created_at', '>=', now()->startOfWeek())->count();
        $completadasSemana = $stats['completadas_semana'];
        $progresoSemana = $totalSemana > 0 ? round(($completadasSemana / $totalSemana) * 100) : 0;

        // Crear objeto user simulado con datos del técnico
        $user = (object) [
            'id' => $tecnico->id,
            'name' => $tecnico->nombre . ' ' . $tecnico->apellido,
            'email' => $tecnico->email
        ];

        return view('admin.tecnicos.resumen', compact(
            'user',
            'tecnico',
            'stats',
            'ordenesActivas',
            'progresoSemana',
            'totalSemana'
        ));
    }

    /**
     * Dashboard para Trabajador
     */
    private function workerDashboard($user)
    {
        return view('trabajador.dashboard-trabajador', [
            'user' => $user,
            'servicioTecnico' => $user->servicioTecnico
        ]);
    }

    /**
     * Obtener métricas en tiempo real para el dashboard
     */
    public function getMetrics(Request $request)
    {
        $user = auth()->user();
        $servicioTecnicoId = $user && $user->servicioTecnico ? $user->servicioTecnico->id : null;
        
        // Obtener datos actualizados
        $resumenOrdenes = [
            'total' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->count(),
            'pendientes' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'pendiente')
                ->count(),
            'en_progreso' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'en_progreso')
                ->count(),
            'completadas' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'completada')
                ->whereMonth('updated_at', now()->month)
                ->whereYear('updated_at', now()->year)
                ->count(),
        ];

        // Obtener carga laboral actualizada de técnicos
        $tecnicosData = DB::table('tecnicos')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->select(
                'tecnicos.id',
                DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
                'tecnicos.especialidades',
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ("pendiente", "en_progreso")) as ordenes_asignadas'),
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado = "completada") as ordenes_completadas')
            )
            ->get()
            ->map(function($tecnico) {
                // Calcular carga de trabajo (asumiendo máximo 10 órdenes)
                $cargaTrabajo = min(($tecnico->ordenes_asignadas / 10) * 100, 100);
                
                // Determinar estado
                if ($cargaTrabajo >= 90) {
                    $estado = 'sobrecargado';
                } elseif ($cargaTrabajo >= 70) {
                    $estado = 'activo';
                } else {
                    $estado = 'disponible';
                }
                
                // Decodificar especialidades JSON y tomar la primera
                $especialidades = json_decode($tecnico->especialidades, true);
                $especialidad = is_array($especialidades) && count($especialidades) > 0 
                    ? ucfirst($especialidades[0]) 
                    : 'General';
                
                return [
                    'id' => $tecnico->id,
                    'nombre' => $tecnico->nombre,
                    'ordenes_asignadas' => $tecnico->ordenes_asignadas,
                    'ordenes_completadas' => $tecnico->ordenes_completadas,
                    'carga_trabajo' => round($cargaTrabajo),
                    'especialidad' => $especialidad,
                    'estado' => $estado
                ];
            })
            ->toArray();
        
        return response()->json([
            'resumenOrdenes' => $resumenOrdenes,
            'tecnicos' => $tecnicosData
        ]);
    }
}
