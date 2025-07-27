<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type', // percentage, fixed
        'discount_value',
        'min_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'is_active',
        'applies_to', // all, specific_products, specific_categories
        'applies_to_ids', // JSON array of product/category IDs
        'email_sent_count',
        'last_sent_at'
    ];

    protected $casts = [
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'is_active' => 'boolean',
        'applies_to_ids' => 'array',
        'last_sent_at' => 'datetime'
    ];

    /**
     * Générer un code promo unique
     */
    public static function generateUniqueCode($length = 8)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * Vérifier si le code est valide
     */
    public function isValid()
    {
        $now = Carbon::now();
        
        return $this->is_active &&
               $this->valid_from <= $now &&
               $this->valid_until >= $now &&
               $this->used_count < $this->usage_limit;
    }

    /**
     * Calculer la réduction
     */
    public function calculateDiscount($subtotal)
    {
        if ($this->discount_type === 'percentage') {
            $discount = ($subtotal * $this->discount_value) / 100;
            if ($this->max_discount) {
                $discount = min($discount, $this->max_discount);
            }
            return $discount;
        }

        return $this->discount_value;
    }

    /**
     * Vérifier si le code s'applique à un produit
     */
    public function appliesToProduct($productId)
    {
        if ($this->applies_to === 'all') {
            return true;
        }

        if ($this->applies_to === 'specific_products' && is_array($this->applies_to_ids)) {
            return in_array($productId, $this->applies_to_ids);
        }

        return false;
    }

    /**
     * Incrémenter le compteur d'utilisation
     */
    public function incrementUsage()
    {
        $this->increment('used_count');
    }

    /**
     * Incrémenter le compteur d'envoi d'email
     */
    public function incrementEmailSent()
    {
        $this->increment('email_sent_count');
        $this->update(['last_sent_at' => now()]);
    }

    /**
     * Scope pour les codes actifs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope pour les codes valides
     */
    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
                    ->where('valid_from', '<=', $now)
                    ->where('valid_until', '>=', $now)
                    ->whereRaw('used_count < usage_limit');
    }

    /**
     * Obtenir le statut du code
     */
    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        $now = Carbon::now();
        
        if ($this->valid_from > $now) {
            return 'pending';
        }
        
        if ($this->valid_until < $now) {
            return 'expired';
        }
        
        if ($this->used_count >= $this->usage_limit) {
            return 'exhausted';
        }
        
        return 'active';
    }

    /**
     * Obtenir le statut en français
     */
    public function getStatusTextAttribute()
    {
        $statuses = [
            'inactive' => 'Inactif',
            'pending' => 'En attente',
            'active' => 'Actif',
            'expired' => 'Expiré',
            'exhausted' => 'Épuisé'
        ];

        return $statuses[$this->status] ?? 'Inconnu';
    }

    /**
     * Obtenir la couleur du statut
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'inactive' => 'gray',
            'pending' => 'yellow',
            'active' => 'green',
            'expired' => 'red',
            'exhausted' => 'red'
        ];

        return $colors[$this->status] ?? 'gray';
    }
} 