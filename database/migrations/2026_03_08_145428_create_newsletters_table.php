<?php
// database/migrations/2024_01_01_000015_create_newsletters_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->boolean('is_subscribed')->default(true);
            $table->timestamp('subscribed_at')->useCurrent();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('email');
            $table->index('is_subscribed');
        });
    }

    public function down()
    {
        Schema::dropIfExists('newsletters');
    }
};