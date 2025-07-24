<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SiteCardInfo extends Model
{
    use HasUuids;
    
    protected $fillable = ['icon', 'title', 'text', 'active'];
    
    
    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'active' => 'boolean',
    ];
}
