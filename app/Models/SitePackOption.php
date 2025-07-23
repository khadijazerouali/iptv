<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SitePackOption extends Model
{
    use HasUuids;
    
    protected $fillable = ['title', 'active', 'site_pack_uuid'];
    
    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'active' => 'boolean',
    ];
    
    public function sitePack()
    {
        return $this->belongsTo(SitePack::class, 'site_pack_uuid');
    }
}
