<?php

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 

    return new class extends Migration 
    { 
        public function up(): void 
        {
            Schema::create('articles', function (Blueprint $table) { $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('image_url')->nullable();
            $table->string('keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('content');
            $table->text('excerpt')->nullable(); // Excerpt
            $table->dateTime('published_at')->nullable(); // Date
            $table->string('author')->nullable(); // Author
            $table->boolean('is_featured')->default(false); // Featured
            $table->integer('read_time')->nullable(); // Read time (in minutes)
            $table->timestamps();
        });
    }

        public function down(): void
        {
            Schema::dropIfExists('articles');
        }
    };