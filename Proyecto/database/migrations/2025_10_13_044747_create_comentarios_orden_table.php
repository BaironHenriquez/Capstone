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
        Schema::create('comentarios_orden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicio')->onDelete('cascade');
            $table->string('usuario', 100);
            $table->enum('tipo_usuario', ['tecnico', 'cliente', 'administrador', 'trabajador'])->default('tecnico');
            $table->text('comentario');
            $table->boolean('es_interno')->default(false); // si es solo para personal interno
            $table->json('archivos_adjuntos')->nullable();
            $table->timestamps();

            // Índices
            $table->index('orden_servicio_id');
            $table->index('tipo_usuario');
            $table->index('es_interno');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios_orden');
    }
};
