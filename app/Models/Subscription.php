<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\Devicetype;
use App\Models\Applicationtype;
use App\Models\ProductOption;

class Subscription extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'number_order',
        'user_id',
        'start_date',
        'end_date',
        'product_uuid',
        'status',
        'quantity',
        'note',
        'promo_code_id',
        'promo_code',
        'subtotal',
        'discount_amount',
        'total',
    ];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($subscription) {
            if (empty($subscription->number_order)) {
                $subscription->number_order = self::generateUniqueOrderNumber();
            }
        });
    }

    public static function generateUniqueOrderNumber()
    {
        $prefix = '#P';

        do {
            $random = mt_rand(100000, 999999);
            $number = $prefix . $random;
        } while (
            self::where('number_order', $number)->exists()
        );

        return $number;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'subscription_uuid', 'uuid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_uuid', 'uuid');
    }

    public function formRenouvellements()
    {
        return $this->hasMany(
            FormRenouvellement::class,
            'subscription_uuid',
            'uuid'
        );
    }

    public function formiptvs()
    {
        return $this->hasMany(Formiptv::class, 'subscription_uuid', 'uuid');
    }

    public function formRevendeurs()
    {
        return $this->hasMany(
            FormRevendeur::class,
            'subscription_uuid',
            'uuid'
        );
    }
    public function vods() {
        // Les VODs sont stockées dans formiptvs.vods comme texte
        // Cette méthode retourne une collection vide pour éviter les erreurs
        return collect();
    }

     public function deviceType() {
        return $this->belongsTo(Devicetype::class, 'devicetype_uuid', 'uuid');
    }

     public function applicationType() {
        return $this->belongsTo(Applicationtype::class, 'applicationtype_uuid', 'uuid');
    }

     public function productOption() {
        return $this->belongsTo(ProductOption::class, 'productoption_uuid', 'uuid');
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class, 'promo_code_id');
    }

    /**
     * Obtenir le prix original (avant réduction)
     */
    public function getOriginalPriceAttribute()
    {
        return $this->subtotal ?? ($this->product->price * $this->quantity);
    }

    /**
     * Obtenir le prix final (après réduction)
     */
    public function getFinalPriceAttribute()
    {
        return $this->total ?? $this->getOriginalPriceAttribute();
    }

    /**
     * Vérifier si un code promo a été appliqué
     */
    public function hasPromoCode()
    {
        return !empty($this->promo_code) && $this->discount_amount > 0;
    }

    /**
     * Obtenir le pourcentage de réduction
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->subtotal && $this->subtotal > 0) {
            return round(($this->discount_amount / $this->subtotal) * 100, 2);
        }
        return 0;
    }
}
