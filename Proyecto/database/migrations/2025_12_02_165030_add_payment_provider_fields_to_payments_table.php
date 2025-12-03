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
        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['paypal', 'transbank'])->default('paypal')->after('subscription_id');
            $table->string('payment_provider_id')->nullable()->after('payment_method');
            $table->string('transaction_token')->nullable()->after('payment_provider_id');
            $table->json('payment_provider_response')->nullable()->after('transaction_token');
            
            $table->renameColumn('paypal_payment_id', 'legacy_paypal_id');
            $table->renameColumn('paypal_payer_id', 'legacy_payer_id');
            $table->renameColumn('paypal_response', 'legacy_paypal_response');
            
            // Hacer nullable los campos legacy
            $table->string('legacy_paypal_id')->nullable()->change();
            $table->string('legacy_payer_id')->nullable()->change();
            $table->json('legacy_paypal_response')->nullable()->change();
            
            $table->index('payment_method');
            $table->index('payment_provider_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_provider_id', 'transaction_token', 'payment_provider_response']);
            
            $table->renameColumn('legacy_paypal_id', 'paypal_payment_id');
            $table->renameColumn('legacy_payer_id', 'paypal_payer_id');
            $table->renameColumn('legacy_paypal_response', 'paypal_response');
            
            $table->dropIndex(['payments_payment_method_index']);
            $table->dropIndex(['payments_payment_provider_id_index']);
        });
    }
};
