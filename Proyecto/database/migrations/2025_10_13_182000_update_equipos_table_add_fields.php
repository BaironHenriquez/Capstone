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
            $table->text('descripcion')->nullable()->after('marca_id');
            $table->string('numero_serie', 100)->nullable()->after('descripcion');
            $table->json('especificaciones')->nullable()->after('numero_serie');
            $table->boolean('activo')->default(true)->after('especificaciones');
            $table->string('categoria', 50)->nullable()->after('activo');
            $table->decimal('precio_referencial', 12, 2)->nullable()->after('categoria');
            $table->integer('garantia_meses')->nullable()->after('precio_referencial');
            $table->string('manual_url', 255)->nullable()->after('garantia_meses');
            $table->string('imagen', 200)->nullable()->after('manual_url');
            $table->softDeletes();
            
            // Índices
            $table->index(['marca_id', 'activo']);
            $table->index(['categoria', 'activo']);
            $table->index('numero_serie');
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['marca_id', 'activo']);
            $table->dropIndex(['categoria', 'activo']);
            $table->dropIndex(['numero_serie']);
            $table->dropIndex(['activo']);
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