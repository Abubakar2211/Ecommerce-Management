<?php
// database/migrations/2024_01_01_000020_create_seller_profiles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seller_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('shop_name');
            $table->string('shop_logo')->nullable();
            $table->string('shop_cover')->nullable();
            $table->text('shop_description')->nullable();
            $table->string('shop_address')->nullable();
            $table->string('business_license')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->json('payment_info')->nullable(); // Bank account, PayPal, etc.
            $table->json('social_links')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('is_approved');
            $table->index('shop_name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_profiles');
    }
};