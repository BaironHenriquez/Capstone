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
        Schema::table('equipos', function (Blueprint $table) {
            // Agregar soft deletes
            $table->softDeletes();
            
            // Agregar columnas faltantes
            $table->text('descripcion')->nullable()->after('marca_id');
            $table->string('numero_serie', 100)->nullable()->after('descripcion');
            $table->json('especificaciones')->nullable()->after('numero_serie');
            $table->boolean('activo')->default(true)->after('especificaciones');
            $table->string('categoria', 100)->nullable()->after('activo');
            $table->decimal('precio_referencial', 10, 2)->nullable()->after('categoria');
            $table->integer('garantia_meses')->nullable()->after('precio_referencial');
            $table->string('manual_url')->nullable()->after('garantia_meses');
            $table->string('imagen')->nullable()->after('manual_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            // Eliminar soft deletes
            $table->dropSoftDeletes();
            
            // Eliminar columnas agregadas
            $table->dropColumn([
                'descripcion',
                'numero_serie',
                'especificaciones',
                'activo',
                'categoria',
                'precio_referencial',
                'garantia_meses',
                'manual_url',
                'imagen'
            ]);
        });
    }
};
