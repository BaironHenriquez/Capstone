<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== BUSCAR CALIFICACIONES EN AMBAS TABLAS ===\n\n";

// Tabla 1: calificacion_tecnicos (singular - nueva)
echo "1. Tabla 'calificacion_tecnicos' (singular):\n";
try {
    $count1 = DB::table('calificacion_tecnicos')->count();
    echo "   Registros: $count1\n";
    if ($count1 > 0) {
        $data = DB::table('calificacion_tecnicos')->get();
        foreach ($data as $row) {
            echo "   - Orden ID: {$row->orden_servicio_id}, Técnico ID: {$row->tecnico_id}, Calificación: {$row->calificacion}/5\n";
        }
    }
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n";

// Tabla 2: calificaciones_tecnicos (plural - antigua)
echo "2. Tabla 'calificaciones_tecnicos' (plural):\n";
try {
    $count2 = DB::table('calificaciones_tecnicos')->count();
    echo "   Registros: $count2\n";
    if ($count2 > 0) {
        $data = DB::table('calificaciones_tecnicos')->get();
        foreach ($data as $row) {
            echo "   - Orden ID: {$row->orden_servicio_id}, Técnico ID: {$row->tecnico_id}, Calificación: {$row->calificacion}/5\n";
        }
    }
} catch (\Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

echo "\n=== MIGRAR DATOS ===\n";
// Si hay datos en la tabla plural, migrarlos a la singular
try {
    $count = DB::table('calificaciones_tecnicos')->count();
    if ($count > 0) {
        echo "Encontrados $count registros en tabla plural, migrando...\n";
        $calificaciones = DB::table('calificaciones_tecnicos')->get();
        
        foreach ($calificaciones as $cal) {
            // Verificar si ya existe en la nueva tabla
            $existe = DB::table('calificacion_tecnicos')
                ->where('orden_servicio_id', $cal->orden_servicio_id)
                ->exists();
            
            if (!$existe) {
                DB::table('calificacion_tecnicos')->insert([
                    'orden_servicio_id' => $cal->orden_servicio_id,
                    'tecnico_id' => $cal->tecnico_id,
                    'cliente_id' => $cal->cliente_id,
                    'servicio_tecnico_id' => DB::table('tecnicos')->where('id', $cal->tecnico_id)->value('servicio_tecnico_id'),
                    'calificacion' => $cal->calificacion,
                    'comentario' => $cal->comentario ?? null,
                    'created_at' => $cal->created_at ?? now(),
                    'updated_at' => $cal->updated_at ?? now(),
                ]);
                echo "  ✓ Migrado registro de orden {$cal->orden_servicio_id}\n";
            } else {
                echo "  - Ya existe registro de orden {$cal->orden_servicio_id}\n";
            }
        }
        echo "\nMigración completada!\n";
    }
} catch (\Exception $e) {
    echo "Error en migración: " . $e->getMessage() . "\n";
}
