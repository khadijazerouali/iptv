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
        Schema::create('form_revendeurs', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('number')->nullable();
            $table->string('name');
            $table->string('email');
            $table->integer('quantity')->default(1)->nullable();
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
        Schema::dropIfExists('form_revendeurs');
    }
};
