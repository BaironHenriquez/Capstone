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
        // Agregar soft deletes a clientes si no existe
        if (!Schema::hasColumn('clientes', 'deleted_at')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Agregar soft deletes a trabajadores si no existe
        if (!Schema::hasColumn('trabajadores', 'deleted_at')) {
            Schema::table('trabajadores', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Agregar soft deletes a marcas si no existe
        if (!Schema::hasColumn('marcas', 'deleted_at')) {
            Schema::table('marcas', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Agregar soft deletes a cliente_equipos si no existe
        if (!Schema::hasColumn('cliente_equipos', 'deleted_at')) {
            Schema::table('cliente_equipos', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        // Agregar soft deletes a tecnicos si no existe
        if (!Schema::hasColumn('tecnicos', 'deleted_at')) {
            Schema::table('tecnicos', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar soft deletes de clientes
        if (Schema::hasColumn('clientes', 'deleted_at')) {
            Schema::table('clientes', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Eliminar soft deletes de trabajadores
        if (Schema::hasColumn('trabajadores', 'deleted_at')) {
            Schema::table('trabajadores', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Eliminar soft deletes de marcas
        if (Schema::hasColumn('marcas', 'deleted_at')) {
            Schema::table('marcas', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Eliminar soft deletes de cliente_equipos
        if (Schema::hasColumn('cliente_equipos', 'deleted_at')) {
            Schema::table('cliente_equipos', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        // Eliminar soft deletes de tecnicos
        if (Schema::hasColumn('tecnicos', 'deleted_at')) {
            Schema::table('tecnicos', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
