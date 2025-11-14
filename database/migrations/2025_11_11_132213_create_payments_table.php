<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('payment_reference')->unique(); // N-Genius Order Reference
            $table->string('payment_id')->nullable(); // N-Genius Payment ID
            $table->string('outlet_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('AED');
            $table->enum('status', ['pending', 'processing', 'captured', 'failed', 'cancelled', 'refunded'])
                ->default('pending');
            $table->string('gateway_status')->nullable(); // N-Genius specific status
            $table->json('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['payment_reference', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
