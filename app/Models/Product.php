<?php

namespace App\Models;

use App\Helpers\SlugHelper;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'category_uuid',
        'title',
        'slug',
        'price_old',
        'price',
        'type',
        'description',
        'image',
        'view',
        'orders',
        'status',
        
    ];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = SlugHelper::generateUniqueSlug($model, $model->title);
            }
        });
    }
    public function productOptions()
    {
        return $this->hasMany(ProductOption::class, 'product_uuid', 'uuid');
    }

    public function category()
    {
        return $this->belongsTo(
            CategoryProduct::class,
            'category_uuid',
            'uuid'
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_uuid', 'uuid');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'product_uuid', 'uuid');
    }
    public function durationOption()
    {
        return $this->belongsTo(\App\Models\ProductOption::class, 'duration_option_uuid', 'uuid');
    }
    public function devices()
    {
        return $this->belongsToMany(\App\Models\Devicetype::class, 'product_devicetype', 'product_uuid', 'devicetype_uuid');
    }
}
