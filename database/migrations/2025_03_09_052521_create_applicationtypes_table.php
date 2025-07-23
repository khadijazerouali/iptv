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
        Schema::create('applicationtypes', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('devicetype_uuid');
            $table->string('name');
            $table->boolean('deviceid')->default(0);
            $table->boolean('devicekey')->default(0);
            $table->boolean('otpcode')->default(0);
            $table->boolean('smartstbmac')->default(0);
            $table->foreign('devicetype_uuid')->references('uuid')->on('devicetypes')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicationtypes');
    }
};
