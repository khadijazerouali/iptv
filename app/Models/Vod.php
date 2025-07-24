<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vod extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = ['title'];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

}
