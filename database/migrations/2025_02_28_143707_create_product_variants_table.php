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
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('variant_name');
            $table->string('size')->default(''); 
            $table->integer('stock')->default(0);
            $table->timestamps();
        });     
}

    public function down(): void
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });
        
        Schema::dropIfExists('product_variants');
    }
};