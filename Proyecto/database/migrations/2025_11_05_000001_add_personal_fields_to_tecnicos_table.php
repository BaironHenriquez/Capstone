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
        Schema::table('tecnicos', function (Blueprint $table) {
            // Agregar campos personales después de user_id
            $table->string('nombre', 100)->after('user_id');
            $table->string('apellido', 100)->after('nombre');
            $table->string('rut', 20)->unique()->after('apellido');
            $table->string('email', 150)->unique()->after('rut');
            $table->string('telefono', 20)->after('email');
            $table->date('fecha_nacimiento')->nullable()->after('telefono');
            $table->text('direccion')->nullable()->after('fecha_nacimiento');
            $table->string('ciudad', 100)->nullable()->after('direccion');
            $table->string('region', 100)->nullable()->after('ciudad');
            
            // Hacer user_id nullable ya que los técnicos pueden existir sin usuario del sistema
            $table->foreignId('user_id')->nullable()->change();
            
            // Índices para búsquedas
            $table->index('rut');
            $table->index('email');
            $table->index(['nombre', 'apellido']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->dropIndex(['tecnicos_rut_index']);
            $table->dropIndex(['tecnicos_email_index']);
            $table->dropIndex(['tecnicos_nombre_apellido_index']);
            
            $table->dropColumn([
                'nombre',
                'apellido',
                'rut',
                'email',
                'telefono',
                'fecha_nacimiento',
                'direccion',
                'ciudad',
                'region'
            ]);
        });
    }
};
