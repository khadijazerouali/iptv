<?php

namespace App\Models;

use App\Helpers\SlugHelper;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryProduct extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'slug', 'description', 'icon_url'];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'category_products';

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (empty($model->slug)) {
                $model->slug = SlugHelper::generateUniqueSlug($model, $model->name);
            }
        });
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_uuid', 'uuid');
    }
}
