<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('email_notifications')->default(true);
            $table->boolean('sms_notifications')->default(false);
            $table->boolean('billing_reminders')->default(true);
            $table->boolean('newsletter_offers')->default(true);
            $table->boolean('support_updates')->default(true);
            $table->boolean('order_updates')->default(true);
            $table->boolean('security_alerts')->default(true);
            $table->string('language')->default('fr');
            $table->string('timezone')->default('Europe/Paris');
            $table->string('theme')->default('light');
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_settings');
    }
}; 