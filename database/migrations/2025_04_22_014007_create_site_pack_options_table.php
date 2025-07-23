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
        Schema::create('site_pack_options', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('title')->nullable();
            $table->boolean('active')->default(true);
            $table->uuid('site_pack_uuid');
            $table->foreign('site_pack_uuid')->references('uuid')->on('site_packs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_pack_options');
    }
};
