<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== VERIFICACIÓN DE TABLAS ===\n\n";

// Ver todas las tablas
$tables = DB::select('SHOW TABLES');
echo "Tablas en la base de datos:\n";
foreach ($tables as $table) {
    $tableName = array_values((array)$table)[0];
    if (strpos($tableName, 'calific') !== false) {
        echo "  ✓ $tableName (RELACIONADA CON CALIFICACIONES)\n";
        
        // Ver estructura
        $columns = DB::select("DESCRIBE $tableName");
        echo "    Columnas:\n";
        foreach ($columns as $col) {
            echo "      - {$col->Field} ({$col->Type})\n";
        }
        
        // Ver datos
        $count = DB::table($tableName)->count();
        echo "    Registros: $count\n";
        
        if ($count > 0) {
            $data = DB::table($tableName)->get();
            echo "    Datos:\n";
            foreach ($data as $row) {
                echo "      " . json_encode($row) . "\n";
            }
        }
        echo "\n";
    }
}

// Verificar específicamente calificacion_tecnicos
echo "\n=== TABLA calificacion_tecnicos ===\n";
try {
    $existe = DB::select("SHOW TABLES LIKE 'calificacion_tecnicos'");
    if (count($existe) > 0) {
        echo "✓ La tabla existe\n";
        $count = DB::table('calificacion_tecnicos')->count();
        echo "Registros: $count\n";
        
        if ($count > 0) {
            $calificaciones = DB::table('calificacion_tecnicos')->get();
            foreach ($calificaciones as $cal) {
                echo json_encode($cal) . "\n";
            }
        }
    } else {
        echo "✗ La tabla NO existe\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

// Verificar tabla alternativa
echo "\n=== TABLA calificaciones_tecnicos ===\n";
try {
    $existe = DB::select("SHOW TABLES LIKE 'calificaciones_tecnicos'");
    if (count($existe) > 0) {
        echo "✓ La tabla existe\n";
        $count = DB::table('calificaciones_tecnicos')->count();
        echo "Registros: $count\n";
        
        if ($count > 0) {
            $calificaciones = DB::table('calificaciones_tecnicos')->get();
            foreach ($calificaciones as $cal) {
                echo json_encode($cal) . "\n";
            }
        }
    } else {
        echo "✗ La tabla NO existe\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
