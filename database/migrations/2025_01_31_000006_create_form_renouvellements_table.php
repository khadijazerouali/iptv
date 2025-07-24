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
        Schema::create('form_renouvellements', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('duration');
            $table->decimal('price');
            $table->string('number');
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
        Schema::dropIfExists('form_renouvellements');
    }
};
