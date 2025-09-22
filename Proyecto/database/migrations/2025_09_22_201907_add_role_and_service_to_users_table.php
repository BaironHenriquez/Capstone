<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nombre', 45)->after('name');
            $table->string('apellido', 45)->nullable()->after('nombre');
            $table->string('rut', 45)->nullable()->after('apellido');
            $table->string('telefono', 45)->nullable()->after('rut');
            $table->string('contrasena', 255)->after('password');
            
            // Relaciones
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null')->after('contrasena');
            $table->foreignId('servicio_tecnico_id')->nullable()->constrained('servicios_tecnicos')->onDelete('cascade')->after('role_id');
            
            // Índices
            $table->index('servicio_tecnico_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropForeign(['servicio_tecnico_id']);
            $table->dropColumn([
                'nombre', 'apellido', 'rut', 'telefono', 'contrasena', 
                'role_id', 'servicio_tecnico_id'
            ]);
        });
    }
};
