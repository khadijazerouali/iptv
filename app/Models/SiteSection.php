<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Scopes\Searchable;

class SiteSection extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'description', 'image', 'icon', 'icon_url', 'image_url'];

    protected $searchableFields = ['*'];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';


}
