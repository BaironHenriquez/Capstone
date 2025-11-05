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
            // Agregar campos de autenticación
            $table->string('password')->after('email');
            $table->foreignId('role_id')->after('password')->constrained('roles')->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable()->after('role_id');
            $table->rememberToken()->after('email_verified_at');
            
            // Índices
            $table->index('role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropIndex(['role_id']);
            $table->dropColumn(['password', 'role_id', 'email_verified_at', 'remember_token']);
        });
    }
};
