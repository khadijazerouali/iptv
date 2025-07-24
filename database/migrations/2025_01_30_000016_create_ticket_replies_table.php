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
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('support_ticket_uuid');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->foreign('support_ticket_uuid')->references('uuid')->on('support_tickets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
};
