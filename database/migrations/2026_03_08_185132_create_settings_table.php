<?php
// database/migrations/2024_01_01_000023_create_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, number, boolean, json
            $table->string('group')->default('general'); // general, payment, shipping, etc.
            $table->timestamps();
            
            // Indexes
            $table->index('group');
            $table->index('key');
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'ShopO', 'type' => 'text', 'group' => 'general', 'created_at' => now()],
            ['key' => 'site_email', 'value' => 'info@shopo.com', 'type' => 'text', 'group' => 'general', 'created_at' => now()],
            ['key' => 'site_phone', 'value' => '+1 234 567 890', 'type' => 'text', 'group' => 'general', 'created_at' => now()],
            ['key' => 'site_address', 'value' => '123 Main St, New York, USA', 'type' => 'text', 'group' => 'general', 'created_at' => now()],
            ['key' => 'tax_rate', 'value' => '10', 'type' => 'number', 'group' => 'tax', 'created_at' => now()],
            ['key' => 'currency', 'value' => 'USD', 'type' => 'text', 'group' => 'payment', 'created_at' => now()],
            ['key' => 'free_shipping_threshold', 'value' => '100', 'type' => 'number', 'group' => 'shipping', 'created_at' => now()],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};