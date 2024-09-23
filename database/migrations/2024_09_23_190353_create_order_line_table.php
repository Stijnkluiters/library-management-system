<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_lines', function (Blueprint $table) {
            $table->uuid()->primary();

            $table->uuid('order_id');
            $table->foreign('order_id')->references('uuid')->on('orders');
            $table->uuid('product_id');
            $table->foreign('product_id')->references('uuid')->on('products');

            $table->unsignedBigInteger('amount');
            $table->bigInteger('price');
            $table->string('name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
