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
        Schema::create('tecnicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->json('especialidades')->nullable(); // ['computadoras', 'moviles', 'redes']
            $table->enum('nivel_experiencia', ['junior', 'semi-senior', 'senior', 'experto'])->default('junior');
            $table->json('certificaciones')->nullable();
            $table->string('zona_trabajo', 100)->nullable();
            $table->boolean('disponible')->default(true);
            $table->integer('carga_trabajo_actual')->default(0); // porcentaje 0-100
            $table->string('telefono_trabajo', 20)->nullable();
            $table->string('horario_trabajo', 100)->nullable();
            $table->decimal('salario_base', 10, 2)->nullable();
            $table->decimal('comision_por_orden', 8, 2)->nullable();
            $table->enum('estado', ['activo', 'inactivo', 'vacaciones', 'licencia', 'suspendido'])->default('activo');
            $table->date('fecha_ingreso')->nullable();
            $table->text('notas_admin')->nullable();
            $table->foreignId('servicio_tecnico_id')->constrained('servicios_tecnicos')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            // Índices
            $table->index('user_id');
            $table->index('servicio_tecnico_id');
            $table->index('estado');
            $table->index('disponible');
            $table->index('carga_trabajo_actual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tecnicos');
    }
};
