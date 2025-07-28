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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Champs pour les codes promo
            $table->unsignedBigInteger('promo_code_id')->nullable()->after('note');
            $table->string('promo_code')->nullable()->after('promo_code_id');
            $table->decimal('subtotal', 10, 2)->nullable()->after('promo_code');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('total', 10, 2)->nullable()->after('discount_amount');
            
            // Index pour les performances
            $table->index('promo_code_id');
            $table->index('promo_code');
            
            // Clé étrangère vers la table promo_codes
            $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['promo_code_id']);
            $table->dropIndex(['promo_code_id']);
            $table->dropIndex(['promo_code']);
            $table->dropColumn(['promo_code_id', 'promo_code', 'subtotal', 'discount_amount', 'total']);
        });
    }
}; 