<?php
// database/migrations/2024_01_01_000018_create_comments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name')->nullable(); // For guest comments
            $table->string('email')->nullable(); // For guest comments
            $table->text('comment');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            
            // Indexes
            $table->index(['post_id', 'is_approved']);
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};