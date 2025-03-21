<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('phone');
            $table->enum('status', ['PENDING','FAILED','PAID']);
            $table->float('price');
            $table->string('url')->nullable();
            $table->string('payment_channel')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->text('address');
            $table->text('address_description');
            $table->string('city');
            $table->string('postal_code');
            $table->string('country');
            $table->string('products_name', 500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};