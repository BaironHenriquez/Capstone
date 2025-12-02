<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ÓRDENES COMPLETADAS - ÚLTIMAS 10 ===\n\n";

$ordenes = DB::table('ordenes_servicio')
    ->where('ordenes_servicio.estado', 'completada')
    ->join('tecnicos', 'ordenes_servicio.tecnico_id', '=', 'tecnicos.id')
    ->select(
        'ordenes_servicio.numero_orden',
        DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as tecnico'),
        DB::raw('DATE(ordenes_servicio.updated_at) as fecha_completada'),
        DB::raw('MONTH(ordenes_servicio.updated_at) as mes'),
        DB::raw('YEAR(ordenes_servicio.updated_at) as anio')
    )
    ->orderBy('ordenes_servicio.updated_at', 'desc')
    ->limit(10)
    ->get();

foreach ($ordenes as $orden) {
    echo sprintf(
        "%s - %s - Completada: %s (Mes: %d/%d)\n",
        $orden->numero_orden,
        $orden->tecnico,
        $orden->fecha_completada,
        $orden->mes,
        $orden->anio
    );
}

echo "\n=== CONTEO POR MES ===\n\n";

// Noviembre 2025
$noviembre = DB::table('ordenes_servicio')
    ->where('estado', 'completada')
    ->whereMonth('updated_at', 11)
    ->whereYear('updated_at', 2025)
    ->count();

echo "Noviembre 2025: $noviembre órdenes\n";

// Diciembre 2025
$diciembre = DB::table('ordenes_servicio')
    ->where('estado', 'completada')
    ->whereMonth('updated_at', 12)
    ->whereYear('updated_at', 2025)
    ->count();

echo "Diciembre 2025: $diciembre órdenes\n";

echo "\n=== ÓRDENES POR TÉCNICO EN DICIEMBRE 2025 ===\n\n";

$tecnicosDiciembre = DB::table('tecnicos')
    ->leftJoin('ordenes_servicio', function($join) {
        $join->on('tecnicos.id', '=', 'ordenes_servicio.tecnico_id')
            ->where('ordenes_servicio.estado', '=', 'completada')
            ->whereMonth('ordenes_servicio.updated_at', '=', 12)
            ->whereYear('ordenes_servicio.updated_at', '=', 2025);
    })
    ->select(
        DB::raw('CONCAT(tecnicos.nombre, " ", tecnicos.apellido) as tecnico'),
        DB::raw('COUNT(ordenes_servicio.id) as ordenes_completadas')
    )
    ->groupBy('tecnicos.id', 'tecnicos.nombre', 'tecnicos.apellido')
    ->having('ordenes_completadas', '>', 0)
    ->orderByDesc('ordenes_completadas')
    ->get();

foreach ($tecnicosDiciembre as $tec) {
    echo sprintf("%s: %d órdenes\n", $tec->tecnico, $tec->ordenes_completadas);
}
