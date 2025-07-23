<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class SlugHelper
{
    public static function generateUniqueSlug(Model $model, $name, $column = 'slug')
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;

        $count = 1;
        while ($model->where($column, $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
