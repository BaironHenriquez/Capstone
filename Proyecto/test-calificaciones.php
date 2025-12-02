<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== VERIFICACIÓN DE CALIFICACIONES ===\n\n";

// 1. Total de calificaciones
$totalCalificaciones = DB::table('calificacion_tecnicos')->count();
echo "Total de calificaciones en BD: $totalCalificaciones\n\n";

// 2. Calificaciones por técnico
echo "Calificaciones por técnico:\n";
$calificacionesPorTecnico = DB::table('calificacion_tecnicos')
    ->join('tecnicos', 'calificacion_tecnicos.tecnico_id', '=', 'tecnicos.id')
    ->select(
        'tecnicos.id',
        DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
        DB::raw('COUNT(*) as total_calificaciones'),
        DB::raw('SUM(calificacion_tecnicos.calificacion) as suma_puntos'),
        DB::raw('AVG(calificacion_tecnicos.calificacion) as promedio')
    )
    ->groupBy('tecnicos.id', 'tecnicos.nombre', 'tecnicos.apellido')
    ->get();

foreach ($calificacionesPorTecnico as $cal) {
    echo "  - {$cal->nombre}: {$cal->total_calificaciones} calificaciones, Suma: {$cal->suma_puntos}, Promedio: " . number_format($cal->promedio, 1) . "/5\n";
}

echo "\n";

// 3. Órdenes completadas este mes
echo "Órdenes completadas en Diciembre 2025:\n";
$ordenesCompletadas = DB::table('ordenes_servicio')
    ->join('tecnicos', 'ordenes_servicio.tecnico_id', '=', 'tecnicos.id')
    ->where('ordenes_servicio.estado', 'completada')
    ->whereMonth('ordenes_servicio.updated_at', 12)
    ->whereYear('ordenes_servicio.updated_at', 2025)
    ->select(
        'tecnicos.id',
        DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
        DB::raw('COUNT(*) as ordenes_completadas')
    )
    ->groupBy('tecnicos.id', 'tecnicos.nombre', 'tecnicos.apellido')
    ->get();

foreach ($ordenesCompletadas as $orden) {
    echo "  - {$orden->nombre}: {$orden->ordenes_completadas} órdenes\n";
}

echo "\n";

// 4. Consulta del empleado del mes (igual que en el controlador)
echo "=== EMPLEADO DEL MES ===\n";
$empleadoDelMes = DB::table('tecnicos')
    ->select(
        'tecnicos.id',
        DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
        DB::raw('(SELECT COUNT(*) FROM ordenes_servicio 
                 WHERE tecnico_id = tecnicos.id 
                 AND estado = "completada" 
                 AND MONTH(updated_at) = MONTH(NOW()) 
                 AND YEAR(updated_at) = YEAR(NOW())) as ordenes_completadas'),
        DB::raw('(SELECT COALESCE(ROUND(AVG(calificacion), 1), 0) 
                 FROM calificacion_tecnicos 
                 WHERE tecnico_id = tecnicos.id) as calificacion_promedio'),
        DB::raw('(SELECT COUNT(*) 
                 FROM calificacion_tecnicos 
                 WHERE tecnico_id = tecnicos.id) as total_calificaciones'),
        DB::raw('(SELECT COALESCE(SUM(calificacion), 0) 
                 FROM calificacion_tecnicos 
                 WHERE tecnico_id = tecnicos.id) as suma_calificaciones')
    )
    ->whereNull('tecnicos.deleted_at')
    ->havingRaw('ordenes_completadas > 0')
    ->orderByDesc('ordenes_completadas')
    ->orderByDesc('calificacion_promedio')
    ->first();

if ($empleadoDelMes) {
    echo "Nombre: {$empleadoDelMes->nombre}\n";
    echo "Órdenes completadas este mes: {$empleadoDelMes->ordenes_completadas}\n";
    echo "Total calificaciones: {$empleadoDelMes->total_calificaciones}\n";
    echo "Suma de puntos: {$empleadoDelMes->suma_calificaciones}\n";
    echo "Promedio: {$empleadoDelMes->calificacion_promedio}/5\n";
    
    if ($empleadoDelMes->total_calificaciones > 0) {
        $calificacionCalculada = round($empleadoDelMes->suma_calificaciones / $empleadoDelMes->total_calificaciones, 1);
        echo "Calificación calculada manualmente: $calificacionCalculada/5\n";
    }
} else {
    echo "No hay empleado del mes (no hay órdenes completadas este mes)\n";
}
