<?php
// database/migrations/2024_01_01_000009_create_carts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable(); // For guest users
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_attribute_id')->nullable()->constrained('product_attributes')->onDelete('set null');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->enum('status', ['active', 'checked_out', 'abandoned'])->default('active');
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index(['session_id', 'status']);
            $table->index('product_id');
            
            // Unique constraint to prevent duplicates
            $table->unique(['user_id', 'session_id', 'product_id', 'product_attribute_id'], 'cart_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carts');
    }
};