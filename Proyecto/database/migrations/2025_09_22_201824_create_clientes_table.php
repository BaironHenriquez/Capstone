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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 45);
            $table->string('apellido', 45)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->string('correo', 45)->nullable();
            $table->string('direccion', 45)->nullable();
            $table->string('rut', 45)->nullable();
            $table->foreignId('servicio_tecnico_id')->constrained('servicios_tecnicos')->onDelete('cascade');
            $table->timestamps();
            
            // Índice para mejorar consultas por servicio técnico
            $table->index('servicio_tecnico_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
