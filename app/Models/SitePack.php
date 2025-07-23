<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\Searchable;

class SitePack extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'sub_title', 'price', 'image', 'button', 'icon_url', 'color1','color2','active','style'];

    protected $searchableFields = ['*'];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'active' => 'boolean',
    ];

}
