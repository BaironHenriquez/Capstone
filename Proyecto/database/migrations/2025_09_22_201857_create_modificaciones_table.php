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
        Schema::create('modificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion', 255);
            $table->dateTime('fecha');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Usuario que hizo la modificación
            $table->foreignId('orden_servicio_id')->constrained('ordenes_servicio')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modificaciones');
    }
};
