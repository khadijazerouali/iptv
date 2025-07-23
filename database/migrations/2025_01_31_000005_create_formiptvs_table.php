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
        Schema::create('formiptvs', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('duration');
            $table->decimal('price');
            $table->string('device')->nullable();
            $table->string('application')->nullable();
            $table->text('channels')->nullable();
            $table->text('vods')->nullable();
            $table->string('adulte')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('device_id')->nullable();
            $table->string('device_key')->nullable();
            $table->string('otp_code')->nullable();
            $table->string('formuler_mac')->nullable(); 
            $table->string('mag_adresse')->nullable();
            $table->string('note')->nullable();
            $table->uuid('subscription_uuid');
            $table->foreign('subscription_uuid')
                ->references('uuid')
                ->on('subscriptions')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formiptvs');
    }
};
