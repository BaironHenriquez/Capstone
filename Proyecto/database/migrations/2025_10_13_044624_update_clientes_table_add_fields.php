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
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('empresa', 100)->nullable()->after('rut');
            $table->enum('tipo_cliente', ['regular', 'vip', 'corporativo'])->default('regular')->after('empresa');
            $table->enum('estado', ['activo', 'inactivo', 'vip', 'moroso'])->default('activo')->after('tipo_cliente');
            $table->text('notas')->nullable()->after('estado');
            $table->softDeletes()->after('updated_at');
            
            // Índices adicionales
            $table->index('estado');
            $table->index('tipo_cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn(['empresa', 'tipo_cliente', 'estado', 'notas']);
            $table->dropSoftDeletes();
            $table->dropIndex(['estado']);
            $table->dropIndex(['tipo_cliente']);
        });
    }
};
