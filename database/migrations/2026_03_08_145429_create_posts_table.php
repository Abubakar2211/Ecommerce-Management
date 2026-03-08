<?php
// database/migrations/2024_01_01_000017_create_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('excerpt')->nullable();
            $table->string('featured_image')->nullable();
            $table->json('meta_data')->nullable();
            $table->integer('views_count')->default(0);
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index(['is_published', 'published_at']);
            $table->index('author_id');
            $table->fullText(['title', 'content']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
};