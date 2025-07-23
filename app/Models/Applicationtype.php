<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicationtype extends Model
{
    //
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'devicetype_uuid',
        'name',
        'deviceid',
        'devicekey',
        'otpcode',
        'smartstbmac',
    ];

    public function devicetype()
    {
        return $this->belongsTo(Devicetype::class, 'devicetype_uuid', 'uuid');
    }
}
