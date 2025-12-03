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
        // Headers para evitar caché del navegador
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        $user = auth()->user();
        $servicioTecnicoId = $user && $user->servicioTecnico ? $user->servicioTecnico->id : null;
        
        // Obtener mes, año y semana de los parámetros o usar el actual
        $mes = $request->input('mes', now()->month);
        $anio = $request->input('anio', now()->year);
        $semana = $request->input('semana', 0); // 0 = todo el mes, 1-5 = semanas específicas
        
        // Crear fecha para filtrado
        $fechaFiltro = \Carbon\Carbon::create($anio, $mes, 1);
        
        // Rango del mes completo (siempre para ingreso mensual)
        $inicioMesCompleto = $fechaFiltro->copy()->startOfMonth();
        $finMesCompleto = $fechaFiltro->copy()->endOfMonth();
        
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
            $fechaInicio = $inicioMesCompleto;
            $fechaFin = $finMesCompleto;
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
        // Nota: Usamos updated_at para estados completados/entregados y created_at para estados activos
        $resumenOrdenes = [
            'total' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where(function($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('created_at', [$fechaInicio, $fechaFin])
                          ->orWhere(function($q) use ($fechaInicio, $fechaFin) {
                              $q->whereIn('estado', ['completada', 'entregada'])
                                ->whereBetween('updated_at', [$fechaInicio, $fechaFin]);
                          });
                })
                ->count(),
            'pendientes' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->where('estado', 'pendiente')
                ->where(function($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('created_at', [$fechaInicio, $fechaFin])
                          ->orWhereBetween('updated_at', [$fechaInicio, $fechaFin]);
                })
                ->count(),
            'en_progreso' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereIn('estado', ['en_progreso', 'asignada', 'diagnostico'])
                ->where(function($query) use ($fechaInicio, $fechaFin) {
                    $query->whereBetween('created_at', [$fechaInicio, $fechaFin])
                          ->orWhereBetween('updated_at', [$fechaInicio, $fechaFin]);
                })
                ->count(),
            'completadas' => DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereIn('estado', ['completada', 'entregada'])
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
                DB::raw("(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ('completada', 'entregada') AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ordenes_completadas"),
                DB::raw("(SELECT SUM(precio_presupuestado) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ('completada', 'entregada') AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ingresos_periodo")
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
                
                // Calcular comisión del período (porcentaje sobre ingresos de órdenes completadas)
                $ingresosPeriodo = floatval($tecnico->ingresos_periodo ?? 0);
                $porcentajeComision = floatval($tecnico->comision_por_orden ?? 0);
                $comisionTotal = ($ingresosPeriodo * $porcentajeComision) / 100;
                
                return [
                    'id' => $tecnico->id,
                    'nombre' => $tecnico->nombre,
                    'ordenes_asignadas' => $tecnico->ordenes_asignadas,
                    'ordenes_completadas' => $tecnico->ordenes_completadas,
                    'carga_trabajo' => round($cargaTrabajo),
                    'especialidad' => $especialidad,
                    'estado' => $estado,
                    'ingresos_periodo' => $ingresosPeriodo,
                    'comision_por_orden' => $porcentajeComision,
                    'comision_total' => round($comisionTotal, 2)
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

        // Cálculo de ingresos - Solo de órdenes completadas/entregadas (cuando realmente se genera el ingreso)
        // Ingreso mensual SIEMPRE usa el mes completo (no importa si filtró por semana)
        $ingresoMensual = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->whereNotNull('precio_presupuestado')
            ->whereIn('estado', ['completada', 'entregada'])
            ->whereBetween('updated_at', [$inicioMesCompleto, $finMesCompleto])
            ->sum('precio_presupuestado');

        // Ingreso semanal - Si filtró por semana específica, calcular para esa semana
        // Si no filtró por semana, mostrar la primera semana del mes filtrado
        // Solo contar órdenes completadas/entregadas (cuando realmente se genera el ingreso)
        if ($semana > 0) {
            // Calcular ingreso de la semana específica seleccionada
            $ingresoSemanal = DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereNotNull('precio_presupuestado')
                ->whereIn('estado', ['completada', 'entregada'])
                ->whereBetween('updated_at', [$fechaInicio, $fechaFin])
                ->sum('precio_presupuestado');
            $rangoSemanalTexto = $fechaInicioGrafico . ' - ' . $fechaFinGrafico;
        } else {
            // Calcular la primera semana del mes filtrado
            $inicioPrimeraSemana = $inicioMesCompleto->copy();
            $finPrimeraSemana = $inicioPrimeraSemana->copy()->addDays(6)->endOfDay();
            if ($finPrimeraSemana->gt($finMesCompleto)) {
                $finPrimeraSemana = $finMesCompleto;
            }
            
            $ingresoSemanal = DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereNotNull('precio_presupuestado')
                ->whereIn('estado', ['completada', 'entregada'])
                ->whereBetween('updated_at', [$inicioPrimeraSemana, $finPrimeraSemana])
                ->sum('precio_presupuestado');
            $rangoSemanalTexto = $inicioPrimeraSemana->format('d/m') . ' - ' . $finPrimeraSemana->format('d/m/Y');
        }

        // 🏆 Empleado del Mes - Basado en órdenes completadas y calificación promedio DEL PERÍODO
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
                         AND estado IN ('completada', 'entregada')
                         AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ordenes_completadas"),
                // Calcular calificación promedio del período filtrado (solo de órdenes del período)
                DB::raw("(SELECT COALESCE(ROUND(AVG(ct.calificacion), 1), 0) 
                         FROM calificacion_tecnicos ct
                         INNER JOIN ordenes_servicio os ON ct.orden_servicio_id = os.id
                         WHERE ct.tecnico_id = tecnicos.id 
                         AND os.updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as calificacion_promedio"),
                // Contar total de calificaciones del período
                DB::raw("(SELECT COUNT(*) 
                         FROM calificacion_tecnicos ct
                         INNER JOIN ordenes_servicio os ON ct.orden_servicio_id = os.id
                         WHERE ct.tecnico_id = tecnicos.id
                         AND os.updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as total_calificaciones"),
                // Suma total de puntos de calificación del período
                DB::raw("(SELECT COALESCE(SUM(ct.calificacion), 0) 
                         FROM calificacion_tecnicos ct
                         INNER JOIN ordenes_servicio os ON ct.orden_servicio_id = os.id
                         WHERE ct.tecnico_id = tecnicos.id
                         AND os.updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as suma_calificaciones")
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
            'rangoSemanalTexto',
            'empleadoDelMes',
            'mes',
            'anio',
            'semana',
            'rangoSemana',
            'fechaInicio',
            'fechaFin'
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

        // Obtener mes y año del request o usar actual
        $mes = $request->input('mes', now()->month);
        $anio = $request->input('anio', now()->year);
        $semana = $request->input('semana', 0);
        
        // Crear rango de fechas
        $fechaFiltro = \Carbon\Carbon::create($anio, $mes, 1);
        
        if ($semana > 0) {
            $inicioMes = \Carbon\Carbon::create($anio, $mes, 1)->startOfDay();
            $inicioSemana = $inicioMes->copy()->addDays(($semana - 1) * 7);
            $finSemana = $inicioSemana->copy()->addDays(6)->endOfDay();
            $finMes = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth()->endOfDay();
            
            if ($finSemana->gt($finMes)) {
                $finSemana = $finMes;
            }
            
            $fechaInicio = $inicioSemana;
            $fechaFin = $finSemana;
        } else {
            $fechaInicio = $fechaFiltro->copy()->startOfMonth();
            $fechaFin = $fechaFiltro->copy()->endOfMonth();
        }
        
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
                DB::raw("(SELECT COUNT(*) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ('completada', 'entregada') AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ordenes_completadas"),
                DB::raw("(SELECT SUM(precio_presupuestado) FROM ordenes_servicio WHERE tecnico_id = tecnicos.id AND estado IN ('completada', 'entregada') AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ingresos_periodo")
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
                
                // Calcular comisión del período (porcentaje sobre ingresos de órdenes completadas)
                $ingresosPeriodo = floatval($tecnico->ingresos_periodo ?? 0);
                $porcentajeComision = floatval($tecnico->comision_por_orden ?? 0);
                $comisionTotal = ($ingresosPeriodo * $porcentajeComision) / 100;
                
                return [
                    'id' => $tecnico->id,
                    'nombre' => $tecnico->nombre,
                    'ordenes_asignadas' => $tecnico->ordenes_asignadas,
                    'ordenes_completadas' => $tecnico->ordenes_completadas,
                    'carga_trabajo' => round($cargaTrabajo),
                    'especialidad' => $especialidad,
                    'estado' => $estado,
                    'ingresos_periodo' => $ingresosPeriodo,
                    'comision_por_orden' => $porcentajeComision,
                    'comision_total' => round($comisionTotal, 2)
                ];
            })
            ->toArray();

        // Cálculo de ingresos según el período filtrado - Solo de órdenes completadas/entregadas
        // Ingreso mensual: usa el mes completo filtrado
        $inicioMesCompleto = \Carbon\Carbon::create($anio, $mes, 1)->startOfMonth();
        $finMesCompleto = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth();
        
        $ingresoMensual = DB::table('ordenes_servicio')
            ->where('servicio_tecnico_id', $servicioTecnicoId)
            ->whereNotNull('precio_presupuestado')
            ->whereIn('estado', ['completada', 'entregada'])
            ->whereBetween('updated_at', [$inicioMesCompleto, $finMesCompleto])
            ->sum('precio_presupuestado');

        // Ingreso semanal: usa la primera semana del mes filtrado o la semana específica
        if ($semana > 0) {
            $ingresoSemanal = DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereNotNull('precio_presupuestado')
                ->whereIn('estado', ['completada', 'entregada'])
                ->whereBetween('updated_at', [$fechaInicio, $fechaFin])
                ->sum('precio_presupuestado');
        } else {
            // Primera semana del mes filtrado
            $inicioPrimeraSemana = $inicioMesCompleto->copy();
            $finPrimeraSemana = $inicioPrimeraSemana->copy()->addDays(6)->endOfDay();
            if ($finPrimeraSemana->gt($finMesCompleto)) {
                $finPrimeraSemana = $finMesCompleto;
            }
            
            $ingresoSemanal = DB::table('ordenes_servicio')
                ->where('servicio_tecnico_id', $servicioTecnicoId)
                ->whereNotNull('precio_presupuestado')
                ->whereIn('estado', ['completada', 'entregada'])
                ->whereBetween('updated_at', [$inicioPrimeraSemana, $finPrimeraSemana])
                ->sum('precio_presupuestado');
        }
        
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
