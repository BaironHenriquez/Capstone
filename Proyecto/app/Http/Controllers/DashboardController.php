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
                return $this->adminDashboard($request);
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
    public function adminDashboard(Request $request)
    {
        $user = auth()->user();
        $servicioTecnicoId = $user && $user->servicioTecnico ? $user->servicioTecnico->id : null;
        
        // Obtener mes, año y semana de los parámetros o usar el actual
        $mes = $request->input('mes', now()->month);
        $anio = $request->input('anio', now()->year);
        $semana = $request->input('semana', 0); // 0 = todo el mes, 1-5 = semanas específicas
        
        // Crear fecha para filtrado
        $fechaFiltro = \Carbon\Carbon::create($anio, $mes, 1);
        
        // Calcular rango de fechas según la semana seleccionada
        if ($semana > 0) {
            // Calcular el inicio y fin de la semana específica del mes
            $inicioMes = \Carbon\Carbon::create($anio, $mes, 1)->startOfDay();
            $finMes = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth()->endOfDay();
            
            // Cada semana son 7 días
            $inicioSemana = $inicioMes->copy()->addDays(($semana - 1) * 7);
            $finSemana = $inicioSemana->copy()->addDays(6)->endOfDay();
            
            // Asegurar que no exceda el mes
            if ($finSemana->gt($finMes)) {
                $finSemana = $finMes;
            }
            
            $fechaInicio = $inicioSemana;
            $fechaFin = $finSemana;
            $rangoSemana = $inicioSemana->format('d/m') . ' - ' . $finSemana->format('d/m/Y');
        } else {
            // Todo el mes
            $fechaInicio = $fechaFiltro->copy()->startOfMonth();
            $fechaFin = $fechaFiltro->copy()->endOfMonth();
            $rangoSemana = 'Todo el mes: ' . $fechaFiltro->translatedFormat('F Y');
        }
        
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

        // Resumen de órdenes reales desde la base de datos (filtrado por rango)
        $resumenOrdenes = [
            'total' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->count(),
            'pendientes' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'pendiente')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->count(),
            'en_progreso' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'en_progreso')
                ->whereBetween('created_at', [$fechaInicio, $fechaFin])
                ->count(),
            'completadas' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'completada')
                ->whereBetween('updated_at', [$fechaInicio, $fechaFin])
                ->count(),
            'en_revision' => 0 // Estado no usado actualmente
        ];
        
        // Obtener técnicos reales del servicio técnico
        $tecnicos = DB::table('tecnicos')
            ->where('tecnicos.servicio_tecnico_id', $servicioTecnicoId)
            ->whereNull('tecnicos.deleted_at')
            ->select(
                'tecnicos.id',
                DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
                'tecnicos.especialidades',
                'tecnicos.comision_por_orden',
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ("asignada", "en_progreso", "diagnostico")) as ordenes_asignadas'),
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado = "completada") as ordenes_completadas'),
                DB::raw('(SELECT SUM(precio_presupuestado) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())) as ingresos_mes')
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
                
                // Calcular comisión del mes (porcentaje sobre ingresos)
                $ingresosMes = floatval($tecnico->ingresos_mes ?? 0);
                $porcentajeComision = floatval($tecnico->comision_por_orden ?? 0);
                $comisionTotal = ($ingresosMes * $porcentajeComision) / 100;
                
                return [
                    'id' => $tecnico->id,
                    'nombre' => $tecnico->nombre,
                    'ordenes_asignadas' => $tecnico->ordenes_asignadas,
                    'ordenes_completadas' => $tecnico->ordenes_completadas,
                    'carga_trabajo' => round($cargaTrabajo),
                    'especialidad' => $especialidad,
                    'estado' => $estado,
                    'ingresos_mes' => $ingresosMes,
                    'comision_por_orden' => $porcentajeComision,
                    'comision_total' => $comisionTotal
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

        // Productividad - Órdenes creadas por día del período filtrado
        $productividadSemanal = [];
        $etiquetasDias = [];
        
        // Si es una semana específica o menos de 14 días, mostrar días
        $diasDiferencia = $fechaInicio->diffInDays($fechaFin);
        
        if ($diasDiferencia <= 7) {
            // Mostrar por días (para semanas específicas)
            for ($i = 0; $i <= $diasDiferencia; $i++) {
                $fecha = $fechaInicio->copy()->addDays($i);
                $ordenesCreadas = DB::table('ordenes_servicio')
                    ->where('servicio_tecnico_id', $servicioTecnicoId)
                    ->whereDate('created_at', $fecha->toDateString())
                    ->count();
                
                $productividadSemanal[] = $ordenesCreadas;
                $etiquetasDias[] = $fecha->translatedFormat('D d');
            }
        } else {
            // Mostrar por semanas del mes
            $inicioMes = $fechaInicio->copy();
            for ($semanaNum = 1; $semanaNum <= 5; $semanaNum++) {
                $inicioSemanaCalc = $inicioMes->copy()->addDays(($semanaNum - 1) * 7);
                $finSemanaCalc = $inicioSemanaCalc->copy()->addDays(6)->endOfDay();
                
                if ($finSemanaCalc->gt($fechaFin)) {
                    $finSemanaCalc = $fechaFin;
                }
                
                if ($inicioSemanaCalc->lte($fechaFin)) {
                    $ordenesCreadas = DB::table('ordenes_servicio')
                        ->where('servicio_tecnico_id', $servicioTecnicoId)
                        ->whereBetween('created_at', [$inicioSemanaCalc, $finSemanaCalc])
                        ->count();
                    
                    $productividadSemanal[] = $ordenesCreadas;
                    $etiquetasDias[] = "S{$semanaNum} (" . $inicioSemanaCalc->format('d/m') . ")";
                    
                    if ($finSemanaCalc->gte($fechaFin)) {
                        break;
                    }
                }
            }
        }
        
        // Fecha de inicio y fin para mostrar en el gráfico
        $fechaInicioGrafico = $fechaInicio->format('d/m');
        $fechaFinGrafico = $fechaFin->format('d/m/Y');

        // Cálculo de ingresos
        $ingresoMensual = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->whereNotNull('precio_presupuestado')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('precio_presupuestado');

        $ingresoSemanal = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->whereNotNull('precio_presupuestado')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('precio_presupuestado');

        // 🏆 Empleado del Mes - Basado en órdenes completadas y calificación promedio
        $empleadoDelMes = DB::table('tecnicos')
            ->where('tecnicos.servicio_tecnico_id', $servicioTecnicoId)
            ->whereNull('tecnicos.deleted_at')
            ->select(
                'tecnicos.id',
                DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
                'tecnicos.especialidades',
                // Contar órdenes completadas del rango filtrado
                DB::raw("(SELECT COUNT(*) FROM ordenes_servicio 
                         WHERE tecnico_id = tecnicos.id 
                         AND estado = 'completada' 
                         AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ordenes_completadas"),
                // Calcular calificación promedio general (todas las calificaciones)
                DB::raw('(SELECT COALESCE(ROUND(AVG(calificacion), 1), 0) 
                         FROM calificacion_tecnicos 
                         WHERE tecnico_id = tecnicos.id) as calificacion_promedio'),
                // Contar total de calificaciones
                DB::raw('(SELECT COUNT(*) 
                         FROM calificacion_tecnicos 
                         WHERE tecnico_id = tecnicos.id) as total_calificaciones'),
                // Suma total de puntos de calificación
                DB::raw('(SELECT COALESCE(SUM(calificacion), 0) 
                         FROM calificacion_tecnicos 
                         WHERE tecnico_id = tecnicos.id) as suma_calificaciones')
            )
            ->havingRaw('ordenes_completadas > 0')
            ->orderByDesc('ordenes_completadas')
            ->orderByDesc('calificacion_promedio')
            ->first();

        // Formatear empleado del mes
        if ($empleadoDelMes) {
            $especialidades = json_decode($empleadoDelMes->especialidades, true);
            
            // Calcular calificación real: suma de calificaciones / número de calificaciones
            $calificacionReal = $empleadoDelMes->total_calificaciones > 0 
                ? round($empleadoDelMes->suma_calificaciones / $empleadoDelMes->total_calificaciones, 1)
                : 0;
            
            $empleadoDelMes = [
                'id' => $empleadoDelMes->id,
                'nombre' => $empleadoDelMes->nombre,
                'especialidad' => is_array($especialidades) && count($especialidades) > 0 
                    ? ucfirst($especialidades[0]) 
                    : 'General',
                'ordenes_completadas' => $empleadoDelMes->ordenes_completadas,
                'calificacion' => $calificacionReal,
                'suma_puntos' => floatval($empleadoDelMes->suma_calificaciones),
                'total_calificaciones' => intval($empleadoDelMes->total_calificaciones),
                'calificacion_max' => 5
            ];
        } else {
            $empleadoDelMes = null;
        }

        return view('admin.dashboard-admin', compact(
            'user', 
            'estadisticasClientes',
            'clientesPorMes',
            'resumenOrdenes', 
            'tecnicos',
            'alertas',
            'metricas',
            'productividadSemanal',
            'etiquetasDias',
            'fechaInicioGrafico',
            'fechaFinGrafico',
            'ingresoMensual',
            'ingresoSemanal',
            'empleadoDelMes',
            'mes',
            'anio',
            'semana',
            'rangoSemana'
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
            ->whereNull('deleted_at')
            ->select(
                'tecnicos.id',
                DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
                'tecnicos.especialidades',
                'tecnicos.comision_por_orden',
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ("asignada", "en_progreso", "diagnostico")) as ordenes_asignadas'),
                DB::raw('(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado = "completada") as ordenes_completadas'),
                DB::raw('(SELECT SUM(precio_presupuestado) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())) as ingresos_mes')
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
                
                // Calcular comisión (porcentaje sobre ingresos)
                $ingresosMes = floatval($tecnico->ingresos_mes ?? 0);
                $porcentajeComision = floatval($tecnico->comision_por_orden ?? 0);
                $comisionTotal = ($ingresosMes * $porcentajeComision) / 100;
                
                return [
                    'id' => $tecnico->id,
                    'nombre' => $tecnico->nombre,
                    'ordenes_asignadas' => $tecnico->ordenes_asignadas,
                    'ordenes_completadas' => $tecnico->ordenes_completadas,
                    'carga_trabajo' => round($cargaTrabajo),
                    'especialidad' => $especialidad,
                    'estado' => $estado,
                    'comision_total' => $comisionTotal
                ];
            })
            ->toArray();

        // Calcular ingresos actualizados
        $ingresoMensual = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->whereNotNull('precio_presupuestado')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('precio_presupuestado');

        $ingresoSemanal = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->whereNotNull('precio_presupuestado')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('precio_presupuestado');
        
        // Calcular comisiones totales
        $comisionesTotales = array_sum(array_column($tecnicosData, 'comision_total'));
        
        return response()->json([
            'resumenOrdenes' => $resumenOrdenes,
            'tecnicos' => $tecnicosData,
            'ingresoMensual' => $ingresoMensual,
            'ingresoSemanal' => $ingresoSemanal,
            'comisionesTotales' => $comisionesTotales
        ]);
    }
}
