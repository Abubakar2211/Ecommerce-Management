<?php
// database/migrations/2024_01_01_000011_create_order_items_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('product_attribute_id')->nullable()->constrained('product_attributes')->onDelete('set null');
            $table->string('product_name'); // Snapshot of product name at order time
            $table->text('product_attributes')->nullable(); // Snapshot of selected attributes
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Price per unit at order time
            $table->decimal('subtotal', 10, 2); // quantity * price
            $table->timestamps();
            
            // Indexes
            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};