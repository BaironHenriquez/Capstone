<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('roles')->insert([
            'nombre_rol' => 'Super Admin',
            'descripcion' => 'Super usuario con acceso completo a métricas globales y gestión de todos los servicios técnicos',
            'jerarquia' => 4,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('roles')->where('nombre_rol', 'Super Admin')->delete();
    }
};
