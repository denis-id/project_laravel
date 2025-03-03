<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->integer('stock');
            $table->foreignId('product_id')->constrained();
            $table->timestamps();
        });     
}

    public function down(): void
    {      
        Schema::dropIfExists('product_variants');
    }
};