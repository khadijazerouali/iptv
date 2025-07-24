<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'email', 'rating', 'message', 'post_uuid'];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_uuid', 'uuid');
    }
}
