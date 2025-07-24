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
        Schema::create('site_packs', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('title');
            $table->string('sub_title');
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();
            $table->string('button')->nullable();
            $table->string('icon_url')->nullable();
            $table->string('color1')->nullable();
            $table->string('color2')->nullable();
            $table->boolean('active')->default(true);
            $table->string('style')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_packs');
    }
};
