<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->float('discount')->nullable();
            $table->double('total', 8, 2);
            $table->string('payment_method');
            $table->text('notes')->nullable();
            $table->enum('payment_status', \App\Enums\PaymentStatus::values())->default('غير مدفوع');
            $table->enum('status', \App\Enums\OrderStatus::values())->default('معلّق');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
