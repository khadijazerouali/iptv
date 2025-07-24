<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
        'priority',
    ];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'support_tickets';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticketReplies()
    {
        return $this->hasMany(
            TicketReplie::class,
            'support_ticket_uuid',
            'uuid'
        );
    }
}
