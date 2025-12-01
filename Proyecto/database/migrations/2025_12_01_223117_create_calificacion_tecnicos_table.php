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
        Schema::create('calificacion_tecnicos', function (Blueprint $table) {
            $table->id();
            
            // Relaciones principales (ON DELETE CASCADE)
            $table->foreignId('tecnico_id')
                  ->constrained('tecnicos')
                  ->onDelete('cascade')
                  ->comment('Técnico que fue calificado');
            
            $table->foreignId('orden_servicio_id')
                  ->constrained('ordenes_servicio')
                  ->onDelete('cascade')
                  ->comment('Orden de servicio asociada a la calificación');
            
            $table->foreignId('cliente_id')
                  ->constrained('clientes')
                  ->onDelete('cascade')
                  ->comment('Cliente que realizó la calificación');
            
            $table->foreignId('servicio_tecnico_id')
                  ->constrained('servicios_tecnicos')
                  ->onDelete('cascade')
                  ->comment('Servicio técnico al que pertenece');
            
            // Calificación general (1-5 estrellas)
            $table->unsignedTinyInteger('calificacion')
                  ->comment('Calificación general de 1 a 5 estrellas');
            
            // Calificaciones por aspectos específicos (1-5)
            $table->unsignedTinyInteger('puntualidad')->nullable()->comment('Calificación de puntualidad (1-5)');
            $table->unsignedTinyInteger('calidad_trabajo')->nullable()->comment('Calificación de calidad del trabajo (1-5)');
            $table->unsignedTinyInteger('atencion_cliente')->nullable()->comment('Calificación de atención al cliente (1-5)');
            $table->unsignedTinyInteger('limpieza')->nullable()->comment('Calificación de limpieza (1-5)');
            
            // Comentarios y recomendación
            $table->text('comentario')->nullable()->comment('Comentario del cliente sobre el servicio');
            $table->boolean('recomendaria')->default(true)->comment('¿Recomendaría al técnico?');
            
            // Metadatos
            $table->timestamp('fecha_calificacion')->useCurrent()->comment('Fecha en que se realizó la calificación');
            $table->ipAddress('ip_calificacion')->nullable()->comment('IP desde donde se calificó');
            $table->boolean('verificada')->default(false)->comment('Si la calificación fue verificada como legítima');
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para optimizar consultas
            $table->index(['tecnico_id', 'calificacion']);
            $table->index(['orden_servicio_id']);
            $table->index(['cliente_id']);
            $table->index(['fecha_calificacion']);
            $table->index(['servicio_tecnico_id', 'calificacion']);
            
            // Una orden solo puede tener una calificación
            $table->unique('orden_servicio_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calificacion_tecnicos');
    }
};
