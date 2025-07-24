<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormRenouvellement extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'duration',
        'price',
        'number',
        'product_uuid',
        'subscription_uuid',
    ];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'form_renouvellements';

    public function subscription()
    {
        return $this->belongsTo(
            Subscription::class,
            'subscription_uuid',
            'uuid'
        );
    }
}
