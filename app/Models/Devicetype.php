<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Devicetype extends Model
{
    //
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'devicetypes';

    protected $fillable = [
        'name',
        'macaddress',
        'magaddress',
        'formulermac',
    ];

    public function applicationTypes()
    {
        return $this->hasOne(ApplicationType::class, 'devicetype_uuid', 'uuid');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
