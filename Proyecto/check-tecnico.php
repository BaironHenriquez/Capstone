<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Verificando Técnicos ===\n";
$tecnicos = \App\Models\Tecnico::all(['id', 'nombre', 'apellido', 'estado']);
foreach ($tecnicos as $t) {
    echo "ID: {$t->id} - {$t->nombre} {$t->apellido} - Estado: {$t->estado}\n";
}

echo "\n=== Verificando Órdenes ===\n";
$ordenes = \App\Models\OrdenServicio::all(['id', 'numero_orden', 'estado', 'tecnico_id', 'cliente_id']);
foreach ($ordenes as $o) {
    echo "Orden #{$o->id} - {$o->numero_orden} - Estado: {$o->estado} - Técnico ID: " . ($o->tecnico_id ?? 'NULL') . " - Cliente ID: {$o->cliente_id}\n";
}

echo "\n=== URL actual del dashboard ===\n";
echo "La URL /admin/tecnicos/resumen sin ID usa el primer técnico activo\n";

$primerTecnico = \App\Models\Tecnico::where('estado', 'activo')->first();
if ($primerTecnico) {
    echo "Primer técnico activo: ID {$primerTecnico->id} - {$primerTecnico->nombre} {$primerTecnico->apellido}\n";
    
    $ordenesDelTecnico = \App\Models\OrdenServicio::where('tecnico_id', $primerTecnico->id)->count();
    echo "Órdenes asignadas a este técnico: {$ordenesDelTecnico}\n";
}
