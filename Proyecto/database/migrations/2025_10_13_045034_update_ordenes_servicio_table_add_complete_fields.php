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
        Schema::table('ordenes_servicio', function (Blueprint $table) {
            // Renombrar y agregar campos para compatibilidad con el modelo
            $table->string('numero_orden', 50)->nullable()->after('id');
            $table->foreignId('tecnico_id')->nullable()->after('user_id')->constrained('tecnicos')->onDelete('set null');
            $table->enum('tipo_servicio', ['reparacion', 'mantenimiento', 'instalacion', 'consultoria', 'soporte'])->default('reparacion')->after('tecnico_id');
            $table->renameColumn('estado_os', 'estado');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])->default('media')->after('estado');
            $table->timestamp('fecha_programada')->nullable()->after('prioridad');
            $table->timestamp('fecha_iniciada')->nullable()->after('fecha_programada');
            $table->timestamp('fecha_completada')->nullable()->after('fecha_iniciada');
            $table->renameColumn('costo_total', 'precio_presupuestado');
            $table->decimal('precio_total', 10, 2)->nullable()->after('precio_presupuestado');
            $table->decimal('horas_estimadas', 5, 2)->nullable()->after('precio_total');
            $table->decimal('horas_trabajadas', 5, 2)->nullable()->after('horas_estimadas');
            $table->string('ubicacion_servicio', 200)->nullable()->after('horas_trabajadas');
            $table->string('contacto_en_sitio', 100)->nullable()->after('ubicacion_servicio');
            $table->string('telefono_contacto', 20)->nullable()->after('contacto_en_sitio');
            $table->json('equipos_necesarios')->nullable()->after('telefono_contacto');
            $table->json('materiales_usados')->nullable()->after('equipos_necesarios');
            $table->text('observaciones_tecnico')->nullable()->after('materiales_usados');
            $table->text('observaciones_cliente')->nullable()->after('observaciones_tecnico');
            $table->integer('calificacion_cliente')->nullable()->after('observaciones_cliente');
            $table->text('firma_cliente')->nullable()->after('calificacion_cliente');
            $table->json('fotos_antes')->nullable()->after('firma_cliente');
            $table->json('fotos_despues')->nullable()->after('fotos_antes');
            $table->json('archivos_adjuntos')->nullable()->after('fotos_despues');
            $table->boolean('requiere_aprobacion')->default(false)->after('archivos_adjuntos');
            $table->string('aprobado_por', 100)->nullable()->after('requiere_aprobacion');
            $table->timestamp('fecha_aprobacion')->nullable()->after('aprobado_por');
            $table->text('motivo_rechazo')->nullable()->after('fecha_aprobacion');
            $table->softDeletes()->after('updated_at');

            // Índices adicionales
            $table->index('numero_orden');
            $table->index('tecnico_id');
            $table->index('tipo_servicio');
            $table->index('prioridad');
            $table->index('fecha_programada');
            $table->index('fecha_completada');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ordenes_servicio', function (Blueprint $table) {
            $table->dropColumn([
                'numero_orden', 'tipo_servicio', 'prioridad', 'fecha_programada', 
                'fecha_iniciada', 'fecha_completada', 'precio_total', 'horas_estimadas', 
                'horas_trabajadas', 'ubicacion_servicio', 'contacto_en_sitio', 
                'telefono_contacto', 'equipos_necesarios', 'materiales_usados', 
                'observaciones_tecnico', 'observaciones_cliente', 'calificacion_cliente', 
                'firma_cliente', 'fotos_antes', 'fotos_despues', 'archivos_adjuntos', 
                'requiere_aprobacion', 'aprobado_por', 'fecha_aprobacion', 'motivo_rechazo'
            ]);
            $table->dropForeign(['tecnico_id']);
            $table->dropColumn('tecnico_id');
            $table->renameColumn('estado', 'estado_os');
            $table->renameColumn('precio_presupuestado', 'costo_total');
            $table->dropSoftDeletes();
            
            // Eliminar índices
            $table->dropIndex(['numero_orden']);
            $table->dropIndex(['tecnico_id']);
            $table->dropIndex(['tipo_servicio']);
            $table->dropIndex(['prioridad']);
            $table->dropIndex(['fecha_programada']);
            $table->dropIndex(['fecha_completada']);
        });
    }
};
