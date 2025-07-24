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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('invoice_number');
            $table->decimal('amount');
            $table->date('issued_at')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->nullable();
            $table->uuid('product_uuid');
            $table->foreign('product_uuid')->references('uuid')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->uuid('subscription_uuid');
            $table->foreign('subscription_uuid')->references('uuid')->on('subscriptions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
