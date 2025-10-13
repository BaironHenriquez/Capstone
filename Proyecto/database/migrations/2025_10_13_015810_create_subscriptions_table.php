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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plan_type'); // 'basic' or 'premium'
            $table->string('status')->default('active'); // 'active', 'cancelled', 'expired'
            $table->string('paypal_subscription_id')->nullable();
            $table->decimal('amount', 8, 2);
            $table->string('currency', 3)->default('USD');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->timestamp('cancelled_at')->nullable();
            $table->json('paypal_data')->nullable(); // Store PayPal response data
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index('paypal_subscription_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
