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
        Schema::table('marcas', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('nombre_marca');
            $table->boolean('activa')->default(true)->after('descripcion');
            $table->string('logo', 200)->nullable()->after('activa');
            $table->string('sitio_web', 255)->nullable()->after('logo');
            $table->string('pais_origen', 50)->nullable()->after('sitio_web');
            $table->string('categoria', 50)->nullable()->after('pais_origen');
            $table->softDeletes();
            
            // Índices
            $table->index(['activa', 'categoria']);
            $table->index('categoria');
            $table->index('pais_origen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('marcas', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['activa', 'categoria']);
            $table->dropIndex(['categoria']);
            $table->dropIndex(['pais_origen']);
            $table->dropColumn([
                'descripcion', 
                'activa', 
                'logo', 
                'sitio_web', 
                'pais_origen', 
                'categoria'
            ]);
        });
    }
};