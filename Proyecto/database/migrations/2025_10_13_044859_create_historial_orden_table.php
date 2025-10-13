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
        Schema::create('historial_orden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicio')->onDelete('cascade');
            $table->string('accion', 100); // 'creada', 'asignada', 'iniciada', 'completada', etc.
            $table->string('usuario', 100);
            $table->text('detalle')->nullable();
            $table->timestamp('fecha');
            $table->timestamps();

            // Índices
            $table->index('orden_servicio_id');
            $table->index('fecha');
            $table->index('accion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_orden');
    }
};
