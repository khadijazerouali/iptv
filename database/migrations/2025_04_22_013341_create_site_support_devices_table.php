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
        Schema::create('site_support_devices', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('image')->nullable();
            $table->string('alt')->nullable();
            $table->boolean('active')->default(true);
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_support_devices');
    }
};
