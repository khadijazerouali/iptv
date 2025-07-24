<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('product_uuid');
            $table->string('name');
            $table->string('email');
            $table->string('review')->nullable();
            $table->integer('rating')->default(5)->nullable();
            $table->foreign('product_uuid')->references('uuid')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
