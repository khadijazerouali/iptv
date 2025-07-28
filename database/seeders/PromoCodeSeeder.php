<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PromoCode;
use Carbon\Carbon;

class PromoCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Codes promo actifs
        PromoCode::create([
            'code' => 'WELCOME20',
            'name' => 'Code de bienvenue',
            'description' => '20% de réduction pour les nouveaux clients',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'min_amount' => 20,
            'max_discount' => 50,
            'usage_limit' => 100,
            'used_count' => 25,
            'valid_from' => Carbon::now()->subMonth(),
            'valid_until' => Carbon::now()->addYear(),
            'is_active' => true,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        PromoCode::create([
            'code' => 'SAVE10',
            'name' => 'Économisez 10€',
            'description' => '10€ de réduction sur votre commande',
            'discount_type' => 'fixed',
            'discount_value' => 10,
            'min_amount' => 50,
            'max_discount' => null,
            'usage_limit' => 50,
            'used_count' => 15,
            'valid_from' => Carbon::now()->subWeek(),
            'valid_until' => Carbon::now()->addMonth(),
            'is_active' => true,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        PromoCode::create([
            'code' => 'SUMMER25',
            'name' => 'Promotion été',
            'description' => '25% de réduction pour l\'été',
            'discount_type' => 'percentage',
            'discount_value' => 25,
            'min_amount' => 30,
            'max_discount' => 75,
            'usage_limit' => 200,
            'used_count' => 80,
            'valid_from' => Carbon::now()->subMonth(),
            'valid_until' => Carbon::now()->addMonth(),
            'is_active' => true,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        // Code promo expiré
        PromoCode::create([
            'code' => 'EXPIRED',
            'name' => 'Code expiré',
            'description' => 'Ce code a expiré',
            'discount_type' => 'percentage',
            'discount_value' => 15,
            'min_amount' => null,
            'max_discount' => null,
            'usage_limit' => 10,
            'used_count' => 5,
            'valid_from' => Carbon::now()->subMonth(),
            'valid_until' => Carbon::now()->subDay(),
            'is_active' => true,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        // Code promo futur
        PromoCode::create([
            'code' => 'FUTURE',
            'name' => 'Code futur',
            'description' => 'Ce code sera valide dans le futur',
            'discount_type' => 'fixed',
            'discount_value' => 5,
            'min_amount' => null,
            'max_discount' => null,
            'usage_limit' => 20,
            'used_count' => 0,
            'valid_from' => Carbon::now()->addWeek(),
            'valid_until' => Carbon::now()->addMonth(),
            'is_active' => true,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        // Code promo épuisé
        PromoCode::create([
            'code' => 'EXHAUSTED',
            'name' => 'Code épuisé',
            'description' => 'Ce code a atteint sa limite d\'utilisation',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'min_amount' => null,
            'max_discount' => null,
            'usage_limit' => 5,
            'used_count' => 5,
            'valid_from' => Carbon::now()->subMonth(),
            'valid_until' => Carbon::now()->addMonth(),
            'is_active' => true,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        // Code promo inactif
        PromoCode::create([
            'code' => 'INACTIVE',
            'name' => 'Code inactif',
            'description' => 'Ce code est désactivé',
            'discount_type' => 'fixed',
            'discount_value' => 15,
            'min_amount' => null,
            'max_discount' => null,
            'usage_limit' => 10,
            'used_count' => 2,
            'valid_from' => Carbon::now()->subMonth(),
            'valid_until' => Carbon::now()->addMonth(),
            'is_active' => false,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        // Code promo avec montant minimum élevé
        PromoCode::create([
            'code' => 'BIGORDER',
            'name' => 'Grande commande',
            'description' => '30% de réduction pour les commandes de plus de 100€',
            'discount_type' => 'percentage',
            'discount_value' => 30,
            'min_amount' => 100,
            'max_discount' => 100,
            'usage_limit' => 25,
            'used_count' => 8,
            'valid_from' => Carbon::now()->subMonth(),
            'valid_until' => Carbon::now()->addMonth(),
            'is_active' => true,
            'applies_to' => 'all',
            'applies_to_ids' => null,
        ]);

        $this->command->info('Codes promo de test créés avec succès !');
        $this->command->info('Codes valides : WELCOME20, SAVE10, SUMMER25, BIGORDER');
        $this->command->info('Codes invalides : EXPIRED, FUTURE, EXHAUSTED, INACTIVE');
    }
} 