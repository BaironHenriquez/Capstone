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
        Schema::create('tareas_trabajador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->foreignId('orden_servicio_id')->nullable()->constrained('ordenes_servicio')->onDelete('set null');
            $table->string('titulo', 200);
            $table->text('descripcion');
            $table->enum('estado', ['asignada', 'en_progreso', 'completada', 'cancelada'])->default('asignada');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media');
            $table->timestamp('fecha_asignada')->useCurrent();
            $table->timestamp('fecha_completada')->nullable();
            $table->decimal('horas_trabajadas', 5, 2)->nullable();
            $table->integer('calificacion')->nullable(); // 1-5 estrellas
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Índices
            $table->index('trabajador_id');
            $table->index('orden_servicio_id');
            $table->index('estado');
            $table->index('prioridad');
            $table->index('fecha_asignada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_trabajador');
    }
};
