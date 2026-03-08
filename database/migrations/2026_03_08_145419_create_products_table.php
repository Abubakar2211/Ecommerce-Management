<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('short_description')->nullable();
            $table->decimal('base_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->bigInteger('views_count')->default(0);
            $table->bigInteger('sold_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            $table->index(['is_active', 'is_featured']);
            $table->fullText(['name', 'description']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};