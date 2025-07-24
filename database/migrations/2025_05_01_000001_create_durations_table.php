<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('durations', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name'); 
            $table->integer('value')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('durations');
    }
}; 