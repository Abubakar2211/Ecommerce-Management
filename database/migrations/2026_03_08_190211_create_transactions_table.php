<?php
// database/migrations/2024_01_01_000022_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->string('transaction_id')->nullable(); // Gateway transaction ID
            $table->enum('gateway', ['stripe', 'paypal', 'razorpay', 'cash_on_delivery', 'bank_transfer']);
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->json('gateway_request')->nullable();
            $table->json('gateway_response')->nullable();
            $table->json('error_details')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('order_id');
            $table->index('transaction_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};