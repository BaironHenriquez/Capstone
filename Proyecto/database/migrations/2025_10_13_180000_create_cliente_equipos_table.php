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
        Schema::create('cliente_equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            $table->string('numero_serie', 100)->unique();
            $table->date('fecha_compra')->nullable();
            $table->date('fecha_garantia')->nullable();
            $table->enum('estado', ['operativo', 'mantenimiento', 'reparacion', 'fuera_servicio', 'retirado'])->default('operativo');
            $table->text('observaciones')->nullable();
            $table->decimal('precio_compra', 12, 2)->nullable();
            $table->string('proveedor', 100)->nullable();
            $table->string('ubicacion', 200)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            // Índices
            $table->index(['cliente_id', 'activo']);
            $table->index(['equipo_id', 'estado']);
            $table->index(['estado', 'activo']);
            $table->index('numero_serie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_equipos');
    }
};