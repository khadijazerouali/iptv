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
        Schema::create('email_send_templates', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('email_template_uuid');
            $table->unsignedBigInteger('user_id');
            $table->string('duration')->nullable();
            $table->date('date_expiration')->nullable();
            $table->string('utilisateur')->nullable();
            $table->string('password')->nullable();
            $table->string('url_server')->nullable();
            $table->string('port')->nullable();
            $table->string('lien_m3u')->nullable();
            $table->string('application_name')->nullable();
            $table->string('application_url')->nullable();
            $table->uuid('subscription_uuid')->nullable();
            $table->uuid('product_uuid')->nullable();
            $table->string('status')->default('active');
            $table->foreign('email_template_uuid')->references('uuid')->on('email_templates')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('subscription_uuid')->references('uuid')->on('subscriptions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('product_uuid')->references('uuid')->on('products')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_send_templates');
    }
};
