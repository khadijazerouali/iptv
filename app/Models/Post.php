<?php

namespace App\Models;

use App\Helpers\SlugHelper;
use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'post_category_uuid',
        'title',
        'slug',
        'image',
        'description',
        'keywords',
        'content',
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

    public function postCategory()
    {
        return $this->belongsTo(
            PostCategory::class,
            'post_category_uuid',
            'uuid'
        );
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_uuid', 'uuid');
    }

}
