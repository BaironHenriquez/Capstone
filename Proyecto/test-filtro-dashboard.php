<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TEST DE FILTROS DE DASHBOARD ===\n\n";

// Simular request con noviembre 2025
$mes = 11;
$anio = 2025;
$semana = 0;

echo "Parámetros: Mes=$mes, Año=$anio, Semana=$semana\n\n";

// Crear fecha para filtrado
$fechaFiltro = \Carbon\Carbon::create($anio, $mes, 1);

// Calcular rango de fechas según la semana seleccionada
if ($semana > 0) {
    $inicioMes = \Carbon\Carbon::create($anio, $mes, 1)->startOfDay();
    $finMes = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth()->endOfDay();
    
    $inicioSemana = $inicioMes->copy()->addDays(($semana - 1) * 7);
    $finSemana = $inicioSemana->copy()->addDays(6)->endOfDay();
    
    if ($finSemana->gt($finMes)) {
        $finSemana = $finMes;
    }
    
    $fechaInicio = $inicioSemana;
    $fechaFin = $finSemana;
    $rangoSemana = $inicioSemana->format('d/m') . ' - ' . $finSemana->format('d/m/Y');
} else {
    $fechaInicio = $fechaFiltro->copy()->startOfMonth();
    $fechaFin = $fechaFiltro->copy()->endOfMonth();
    $rangoSemana = 'Todo el mes: ' . $fechaFiltro->translatedFormat('F Y');
}

echo "Rango calculado: $rangoSemana\n";
echo "Fecha Inicio: " . $fechaInicio->toDateTimeString() . "\n";
echo "Fecha Fin: " . $fechaFin->toDateTimeString() . "\n\n";

// Contar órdenes en ese rango
$ordenesNoviembre = DB::table('ordenes_servicio')
    ->where('estado', 'completada')
    ->whereBetween('updated_at', [$fechaInicio, $fechaFin])
    ->count();

echo "Órdenes completadas en noviembre 2025: $ordenesNoviembre\n\n";

// Buscar empleado del mes
$empleadoDelMes = DB::table('tecnicos')
    ->where('tecnicos.servicio_tecnico_id', 4)
    ->whereNull('tecnicos.deleted_at')
    ->select(
        'tecnicos.id',
        DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
        DB::raw("(SELECT COUNT(*) FROM ordenes_servicio 
                 WHERE tecnico_id = tecnicos.id 
                 AND estado = 'completada' 
                 AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ordenes_completadas")
    )
    ->havingRaw('ordenes_completadas > 0')
    ->orderByDesc('ordenes_completadas')
    ->first();

if ($empleadoDelMes) {
    echo "Empleado del mes encontrado:\n";
    echo "  Nombre: {$empleadoDelMes->nombre}\n";
    echo "  Órdenes completadas: {$empleadoDelMes->ordenes_completadas}\n";
} else {
    echo "NO HAY EMPLEADO DEL MES para noviembre 2025\n";
}

echo "\n=== TEST DICIEMBRE 2025 ===\n\n";

$mes = 12;
$fechaFiltro = \Carbon\Carbon::create($anio, $mes, 1);
$fechaInicio = $fechaFiltro->copy()->startOfMonth();
$fechaFin = $fechaFiltro->copy()->endOfMonth();

echo "Fecha Inicio: " . $fechaInicio->toDateTimeString() . "\n";
echo "Fecha Fin: " . $fechaFin->toDateTimeString() . "\n\n";

$ordenesDiciembre = DB::table('ordenes_servicio')
    ->where('estado', 'completada')
    ->whereBetween('updated_at', [$fechaInicio, $fechaFin])
    ->count();

echo "Órdenes completadas en diciembre 2025: $ordenesDiciembre\n\n";

$empleadoDelMes = DB::table('tecnicos')
    ->where('tecnicos.servicio_tecnico_id', 4)
    ->whereNull('tecnicos.deleted_at')
    ->select(
        'tecnicos.id',
        DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as nombre'),
        DB::raw("(SELECT COUNT(*) FROM ordenes_servicio 
                 WHERE tecnico_id = tecnicos.id 
                 AND estado = 'completada' 
                 AND updated_at BETWEEN '{$fechaInicio->toDateTimeString()}' AND '{$fechaFin->toDateTimeString()}') as ordenes_completadas")
    )
    ->havingRaw('ordenes_completadas > 0')
    ->orderByDesc('ordenes_completadas')
    ->first();

if ($empleadoDelMes) {
    echo "Empleado del mes encontrado:\n";
    echo "  Nombre: {$empleadoDelMes->nombre}\n";
    echo "  Órdenes completadas: {$empleadoDelMes->ordenes_completadas}\n";
} else {
    echo "NO HAY EMPLEADO DEL MES para diciembre 2025\n";
}
