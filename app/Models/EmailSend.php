<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSend extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'subject',
        'body',
        'status'
    ];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
