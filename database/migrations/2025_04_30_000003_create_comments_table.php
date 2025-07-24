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
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->string('email');
            $table->integer('rating')->nullable();
            $table->text('message')->nullable();
            $table->uuid('post_uuid');

            $table->foreign('post_uuid')->references('uuid')->on('posts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
