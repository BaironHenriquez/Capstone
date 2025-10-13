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
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tecnico_id')->nullable()->constrained('tecnicos')->onDelete('set null');
            $table->enum('tipo_trabajo', ['instalacion', 'mantenimiento', 'reparacion', 'soporte', 'general'])->default('general');
            $table->json('habilidades')->nullable(); // ['cableado', 'soldadura', 'instalacion_software']
            $table->enum('nivel_experiencia', ['principiante', 'intermedio', 'avanzado'])->default('principiante');
            $table->string('zona_trabajo', 100)->nullable();
            $table->boolean('disponible')->default(true);
            $table->string('telefono_trabajo', 20)->nullable();
            $table->string('horario_trabajo', 100)->nullable();
            $table->decimal('salario_por_hora', 8, 2)->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'vacaciones', 'licencia', 'suspendido'])->default('activo');
            $table->date('fecha_ingreso')->nullable();
            $table->text('notas_admin')->nullable();
            $table->foreignId('servicio_tecnico_id')->constrained('servicios_tecnicos')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('user_id');
            $table->index('tecnico_id');
            $table->index('servicio_tecnico_id');
            $table->index('estado');
            $table->index('disponible');
            $table->index('tipo_trabajo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};
