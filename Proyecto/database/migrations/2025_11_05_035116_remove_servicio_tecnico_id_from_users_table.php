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
            // Eliminar la clave foránea y la columna servicio_tecnico_id
            $table->dropForeign(['servicio_tecnico_id']);
            $table->dropColumn('servicio_tecnico_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Restaurar la columna y la clave foránea si se revierte
            $table->foreignId('servicio_tecnico_id')->nullable()->after('role_id')->constrained('servicios_tecnicos')->onDelete('cascade');
            $table->index('servicio_tecnico_id');
        });
    }
};
