<?php
// database/migrations/2024_01_01_000010_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('address_id')->constrained()->onDelete('restrict');
            $table->foreignId('shipping_method_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->string('shipping_tracking_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('transaction_id')->nullable();
            $table->json('payment_details')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'order_status']);
            $table->index('order_number');
            $table->index('payment_status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};