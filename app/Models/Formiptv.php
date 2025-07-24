<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formiptv extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'duration',
        'price',
        'device',
        'application',
        'channels',
        'vods',
        'adulte',
        'product_uuid',
        'mac_address',
        'device_id',
        'device_key',
        'otp_code',
        'formuler_mac',
        'mag_adresse',
        'note',
        'subscription_uuid',
    ];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    public function subscription()
    {
        return $this->belongsTo(
            Subscription::class,
            'subscription_uuid',
            'uuid'
        );
    }
}
