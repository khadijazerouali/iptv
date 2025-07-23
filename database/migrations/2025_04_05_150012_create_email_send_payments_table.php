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
        Schema::create('email_send_payments', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('email_send_uuid');
            $table->unsignedBigInteger('user_id');
            $table->string('url_payment')->nullable();
            $table->string('status')->default('pending');
            $table->foreign('email_send_uuid')->references('uuid')->on('email_send_templates')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_send_payments');
    }
};
