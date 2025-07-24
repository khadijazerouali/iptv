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
        Schema::create('devicetypes', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name');
            $table->boolean('macaddress')->default(0);
            $table->boolean('magaddress')->default(0);
            $table->boolean('formulermac')->default(0);
            $table->boolean('formulermag')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devicetypes');
    }
};
