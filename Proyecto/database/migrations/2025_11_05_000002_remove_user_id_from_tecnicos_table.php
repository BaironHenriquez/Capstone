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
            // Eliminar la foreign key constraint primero
            $table->dropForeign(['user_id']);
            
            // Eliminar el índice
            $table->dropIndex(['user_id']);
            
            // Eliminar la columna
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('cascade');
            $table->index('user_id');
        });
    }
};
