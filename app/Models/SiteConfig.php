<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteConfig extends Model
{
    use HasUuids;
    use HasFactory;
    
    protected $fillable = ['name', 'value', 'type', 'icon', 'icon_url', 'image', 'image_url'];

}
