<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSendPayment extends Model
{
    protected $fillable = [
        'user_id',
        'email_template_uuid',
        'url_payment',
        'subscription_uuid',
        'product_uuid',
        'status'
    ];

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $searchableFields = ['*'];

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
