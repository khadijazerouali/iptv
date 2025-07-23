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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('category_uuid');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->decimal('price_old')->nullable();
            $table->decimal('price');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->string('image')->nullable();
            $table->string('type')->nullable();
            $table->integer('view')->nullable();
            $table->foreign('category_uuid')->references('uuid')->on('category_products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
