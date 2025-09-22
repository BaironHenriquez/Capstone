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
        Schema::create('ordenes_servicio', function (Blueprint $table) {
            $table->id();
            $table->string('estado_os', 45)->default('Recibido');
            $table->date('fecha_ingreso');
            $table->date('fecha_aprox_entrega')->nullable();
            $table->json('fotos_ingreso')->nullable();
            $table->json('videos_evidencia')->nullable();
            $table->mediumText('descripcion_problema')->nullable();
            $table->mediumText('dictamen_tecnico')->nullable();
            $table->string('medio_de_pago', 45)->nullable();
            $table->string('tipo_de_trabajo', 45)->nullable();
            $table->decimal('costo_total', 10, 2)->nullable();
            $table->decimal('abono', 10, 2)->default(0);
            $table->decimal('saldo', 10, 2)->nullable();
            
            // Relaciones principales
            $table->foreignId('servicio_tecnico_id')->constrained('servicios_tecnicos')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Técnico asignado
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('cascade');
            
            $table->timestamps();
            
            // Índices para mejorar rendimiento
            $table->index('servicio_tecnico_id');
            $table->index('estado_os');
            $table->index(['servicio_tecnico_id', 'cliente_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_servicio');
    }
};
