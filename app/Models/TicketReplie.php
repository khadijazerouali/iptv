<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketReplie extends Model
{
    use HasUuids;
    use HasFactory;
    use Searchable;

    protected $fillable = ['support_ticket_uuid', 'user_id', 'message'];

    protected $searchableFields = ['*'];
    
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'ticket_replies';

    public function supportTicket()
    {
        return $this->belongsTo(
            SupportTicket::class,
            'support_ticket_uuid',
            'uuid'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
