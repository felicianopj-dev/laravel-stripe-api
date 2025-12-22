<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            $table
                ->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            
            $table->string('status', 20)->default('pending'); // pending|paid|failed|refunded
            $table->unsignedBigInteger('amount_cents');
            $table->string('currency', 10)->default('brl');
            $table->string('stripe_checkout_session_id')->nullable()->index();
            $table->string('stripe_payment_intent_id')->nullable()->index();
            $table->string('stripe_customer_id')->nullable()->index();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
