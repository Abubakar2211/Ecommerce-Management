<?php
// database/migrations/2024_01_01_000008_create_shipping_methods_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('cost', 10, 2);
            $table->string('estimated_delivery_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        DB::table('shipping_methods')->insert([
            [
                'name' => 'Free Shipping',
                'description' => 'Delivery in 5-7 business days',
                'cost' => 0,
                'estimated_delivery_days' => '5-7 days',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [   
                'name' => 'Express Shipping',
                'description' => 'Delivery in 2-3 business days',
                'cost' => 10.00,
                'estimated_delivery_days' => '2-3 days',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Next Day Delivery',
                'description' => 'Delivery next business day',
                'cost' => 20.00,
                'estimated_delivery_days' => '1 day',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('shipping_methods');
    }
};