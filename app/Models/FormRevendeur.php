<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormRevendeur extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'number',
        'name',
        'email',
        'quantity',
        'product_uuid',
        'subscription_uuid',
    ];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'form_revendeurs';

    public function subscription()
    {
        return $this->belongsTo(
            Subscription::class,
            'subscription_uuid',
            'uuid'
        );
    }

    protected static function booted()
    {
        static::creating(function ($subscription) {
            if (empty($subscription->number)) {
                $subscription->number = self::generateUniqueOrderNumber();
            }
        });
    }

    public static function generateUniqueOrderNumber()
    {
        $prefix = '#R';
        do {
            $random = mt_rand(100000, 999999);
            $number = $prefix . $random;
        } while (
            self::where('number', $number)->exists()
        );
        return $number;
    }
}
