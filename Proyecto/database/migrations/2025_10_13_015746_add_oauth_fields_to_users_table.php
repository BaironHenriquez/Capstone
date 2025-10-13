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
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('email');
            $table->string('avatar')->nullable()->after('google_id');
            $table->boolean('email_verified')->default(false)->after('avatar');
            $table->string('provider')->nullable()->after('email_verified');
            $table->timestamp('trial_ends_at')->nullable()->after('provider');
            $table->boolean('is_subscribed')->default(false)->after('trial_ends_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'google_id', 
                'avatar', 
                'email_verified', 
                'provider', 
                'trial_ends_at', 
                'is_subscribed'
            ]);
        });
    }
};
