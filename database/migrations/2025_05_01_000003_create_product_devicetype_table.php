<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_devicetype', function (Blueprint $table) {
            $table->uuid('product_uuid');
            $table->uuid('devicetype_uuid');
            $table->primary(['product_uuid', 'devicetype_uuid']);
            $table->foreign('product_uuid')->references('uuid')->on('products')->cascadeOnDelete();
            $table->foreign('devicetype_uuid')->references('uuid')->on('devicetypes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_devicetype');
    }
}; 