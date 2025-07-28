<?php

namespace App\Services;

use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PromoCodeService
{
    /**
     * Valider un code promo
     */
    public function validateCode(string $code, float $subtotal = 0): array
    {
        $code = strtoupper(trim($code));
        
        // Vérifier si le code existe
        $promoCode = PromoCode::where('code', $code)->first();
        
        if (!$promoCode) {
            return [
                'valid' => false,
                'message' => 'Code promo invalide. Veuillez vérifier votre saisie.',
                'type' => 'error'
            ];
        }

        // Vérifier si le code est actif
        if (!$promoCode->is_active) {
            return [
                'valid' => false,
                'message' => 'Ce code promo n\'est plus actif.',
                'type' => 'error'
            ];
        }

        // Vérifier la date de début
        if ($promoCode->valid_from && $promoCode->valid_from > Carbon::now()) {
            return [
                'valid' => false,
                'message' => 'Ce code promo n\'est pas encore valide. Il sera actif à partir du ' . 
                            $promoCode->valid_from->format('d/m/Y à H:i'),
                'type' => 'warning'
            ];
        }

        // Vérifier la date de fin
        if ($promoCode->valid_until && $promoCode->valid_until < Carbon::now()) {
            return [
                'valid' => false,
                'message' => 'Ce code promo a expiré le ' . $promoCode->valid_until->format('d/m/Y à H:i'),
                'type' => 'error'
            ];
        }

        // Vérifier la limite d'utilisation
        if ($promoCode->used_count >= $promoCode->usage_limit) {
            return [
                'valid' => false,
                'message' => 'Ce code promo a atteint sa limite d\'utilisation (' . $promoCode->usage_limit . ' fois).',
                'type' => 'error'
            ];
        }

        // Vérifier le montant minimum
        if ($promoCode->min_amount && $subtotal < $promoCode->min_amount) {
            return [
                'valid' => false,
                'message' => 'Ce code promo nécessite un montant minimum de ' . number_format($promoCode->min_amount, 2) . '€. ' .
                            'Votre commande actuelle est de ' . number_format($subtotal, 2) . '€.',
                'type' => 'warning'
            ];
        }

        // Calculer la réduction
        $discount = $promoCode->calculateDiscount($subtotal);
        
        // Vérifier si la réduction est supérieure au sous-total
        if ($discount >= $subtotal) {
            $discount = $subtotal;
        }

        return [
            'valid' => true,
            'message' => 'Code promo valide !',
            'type' => 'success',
            'promo_code' => $promoCode,
            'discount_amount' => $discount
        ];
    }

    /**
     * Appliquer un code promo
     */
    public function applyCode(string $code, float $subtotal = 0): array
    {
        $validation = $this->validateCode($code, $subtotal);
        
        if (!$validation['valid']) {
            return $validation;
        }

        $promoCode = $validation['promo_code'];
        $discount = $validation['discount_amount'];

        // Préparer les données du code promo appliqué
        $appliedCoupon = [
            'id' => $promoCode->id,
            'code' => $promoCode->code,
            'name' => $promoCode->name,
            'discount_type' => $promoCode->discount_type,
            'discount_value' => $promoCode->discount_value,
            'discount_amount' => $discount,
            'description' => $promoCode->description,
            'min_amount' => $promoCode->min_amount,
            'max_discount' => $promoCode->max_discount
        ];

        // Sauvegarder dans la session
        session(['applied_coupon' => $appliedCoupon]);

        return [
            'valid' => true,
            'message' => 'Code promo appliqué avec succès ! Réduction de ' . number_format($discount, 2) . '€.',
            'type' => 'success',
            'applied_coupon' => $appliedCoupon,
            'discount_amount' => $discount
        ];
    }

    /**
     * Supprimer un code promo appliqué
     */
    public function removeCode(): array
    {
        session()->forget('applied_coupon');
        
        return [
            'valid' => true,
            'message' => 'Code promo supprimé.',
            'type' => 'success'
        ];
    }

    /**
     * Obtenir le code promo appliqué depuis la session
     */
    public function getAppliedCode(): ?array
    {
        return session('applied_coupon');
    }

    /**
     * Calculer le total avec réduction
     */
    public function calculateTotalWithDiscount(float $subtotal): array
    {
        $appliedCoupon = $this->getAppliedCode();
        
        if (!$appliedCoupon) {
            return [
                'subtotal' => $subtotal,
                'discount' => 0,
                'total' => $subtotal
            ];
        }

        $discount = $appliedCoupon['discount_amount'];
        $total = $subtotal - $discount;

        // S'assurer que le total ne soit pas négatif
        if ($total < 0) {
            $total = 0;
            $discount = $subtotal;
        }

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ];
    }

    /**
     * Incrémenter le compteur d'utilisation d'un code promo
     */
    public function incrementUsage(int $promoCodeId): bool
    {
        try {
            $promoCode = PromoCode::find($promoCodeId);
            if ($promoCode) {
                $promoCode->incrementUsage();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'incrémentation du compteur d\'utilisation du code promo: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Vérifier si un code promo peut être appliqué à un produit spécifique
     */
    public function canApplyToProduct(string $code, int $productId): bool
    {
        $promoCode = PromoCode::where('code', strtoupper(trim($code)))->first();
        
        if (!$promoCode) {
            return false;
        }

        return $promoCode->appliesToProduct($productId);
    }

    /**
     * Obtenir les statistiques des codes promo
     */
    public function getStats(): array
    {
        return [
            'total' => PromoCode::count(),
            'active' => PromoCode::where('is_active', true)->count(),
            'expired' => PromoCode::where('valid_until', '<', now())->count(),
            'expiring_soon' => PromoCode::where('valid_until', '>', now())
                                    ->where('valid_until', '<', now()->addDays(7))
                                    ->count(),
            'total_usage' => PromoCode::sum('used_count'),
            'total_emails_sent' => PromoCode::sum('email_sent_count')
        ];
    }
} 