<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SiteSupportDevice extends Model
{
    use HasUuids;
    
    protected $fillable = ['image', 'alt', 'active', 'type'];
    
    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'active' => 'boolean',
        'type' => 'string',
    ];
}
