<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSendTemplate extends Model
{
    protected $fillable = [
        'email_template_uuid',
        'user_id',
        'duration',
        'date_expiration',
        'utilisateur',
        'password',
        'url_server',
        'port',
        'lien_m3u',
        'application_name',
        'application_url',
        'subscription_uuid',
        'product_uuid',
        'status'
    ];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emailTemplate()
    {
        return $this->belongsTo(EmailTemplate::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
