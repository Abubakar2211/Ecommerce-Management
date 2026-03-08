<?php
// database/migrations/2024_01_01_000005_create_product_attributes_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('attribute_name'); // Color, Size, Storage
            $table->string('attribute_value'); // Red, XL, 256GB
            $table->decimal('price_addition', 10, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->string('sku')->nullable()->unique();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes
            $table->index(['product_id', 'attribute_name', 'is_active']);
            $table->index('attribute_value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_attributes');
    }
};