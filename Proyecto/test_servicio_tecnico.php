<?php

/**
 * Script de prueba para verificar la funcionalidad del servicio técnico
 * Ejecutar con: php test_servicio_tecnico.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\ServicioTecnico;
use Illuminate\Support\Facades\DB;

echo "=== TEST DE SERVICIO TÉCNICO ===\n\n";

// 1. Verificar estructura de la tabla
echo "1. Verificando estructura de la tabla servicios_tecnicos:\n";
$columns = DB::select("SHOW COLUMNS FROM servicios_tecnicos");
foreach ($columns as $column) {
    echo "   - {$column->Field} ({$column->Type})\n";
}
echo "\n";

// 2. Verificar relaciones en el modelo
echo "2. Verificando relaciones del modelo:\n";
$servicioTecnico = new ServicioTecnico();
echo "   - Fillable: " . implode(', ', $servicioTecnico->getFillable()) . "\n";
echo "   - Tabla: " . $servicioTecnico->getTable() . "\n\n";

// 3. Buscar un usuario con suscripción
echo "3. Buscando usuarios con suscripción activa:\n";
$usuarios = User::where('is_subscribed', true)->get();
echo "   - Total usuarios con suscripción: " . $usuarios->count() . "\n";

if ($usuarios->count() > 0) {
    $usuario = $usuarios->first();
    echo "   - Usuario encontrado: {$usuario->name} (ID: {$usuario->id})\n";
    echo "   - Email: {$usuario->email}\n";
    
    // 4. Verificar si tiene servicio técnico
    echo "\n4. Verificando servicio técnico del usuario:\n";
    $servicio = $usuario->servicioTecnico;
    
    if ($servicio) {
        echo "   ✓ Usuario TIENE servicio técnico configurado:\n";
        echo "     - ID: {$servicio->id}\n";
        echo "     - Nombre: {$servicio->nombre_servicio}\n";
        echo "     - Dirección: {$servicio->direccion}\n";
        echo "     - Teléfono: {$servicio->telefono}\n";
        echo "     - Correo: {$servicio->correo}\n";
        echo "     - RUT: {$servicio->rut}\n";
        echo "     - Activo: " . ($servicio->activo ? 'Sí' : 'No') . "\n";
    } else {
        echo "   ✗ Usuario NO tiene servicio técnico configurado\n";
        echo "   - Necesita completar el formulario en /setup/technical-service\n";
    }
} else {
    echo "   ✗ No hay usuarios con suscripción activa\n";
}

echo "\n5. Total de servicios técnicos registrados: " . ServicioTecnico::count() . "\n";

$servicios = ServicioTecnico::with('user')->get();
if ($servicios->count() > 0) {
    echo "\nServicios técnicos existentes:\n";
    foreach ($servicios as $servicio) {
        $usuario = $servicio->user;
        echo "   - ID: {$servicio->id} | Usuario: " . ($usuario ? $usuario->name : 'N/A') . " | Nombre: {$servicio->nombre_servicio}\n";
    }
}

echo "\n=== FIN DEL TEST ===\n";
