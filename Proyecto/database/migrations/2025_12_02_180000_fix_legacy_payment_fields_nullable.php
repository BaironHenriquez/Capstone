<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Primero agregar los nuevos campos
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['paypal', 'transbank'])->default('paypal')->after('subscription_id');
            $table->string('payment_provider_id')->nullable()->after('payment_method');
            $table->string('transaction_token')->nullable()->after('payment_provider_id');
            $table->json('payment_provider_response')->nullable()->after('transaction_token');
        });
        
        // Hacer nullable los campos viejos de PayPal
        DB::statement('ALTER TABLE payments MODIFY paypal_payment_id VARCHAR(255) NULL');
        DB::statement('ALTER TABLE payments MODIFY paypal_payer_id VARCHAR(255) NULL');
        DB::statement('ALTER TABLE payments MODIFY paypal_response JSON NULL');
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_provider_id', 'transaction_token', 'payment_provider_response']);
        });
    }
};
