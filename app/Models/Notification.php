<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'data',
        'read_at',
        'action_url',
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    // Types de notifications
    const TYPE_TICKET_REPLY = 'ticket_reply';
    const TYPE_TICKET_STATUS = 'ticket_status';
    const TYPE_ORDER_CONFIRMED = 'order_confirmed';
    const TYPE_ORDER_STATUS = 'order_status';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsRead(): void
    {
        $this->update(['read_at' => now()]);
    }

    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            self::TYPE_TICKET_REPLY => 'fas fa-reply',
            self::TYPE_TICKET_STATUS => 'fas fa-ticket-alt',
            self::TYPE_ORDER_CONFIRMED => 'fas fa-check-circle',
            self::TYPE_ORDER_STATUS => 'fas fa-shopping-cart',
            default => 'fas fa-bell',
        };
    }

    public function getColorAttribute(): string
    {
        return match($this->type) {
            self::TYPE_TICKET_REPLY => 'primary',
            self::TYPE_TICKET_STATUS => 'info',
            self::TYPE_ORDER_CONFIRMED => 'success',
            self::TYPE_ORDER_STATUS => 'warning',
            default => 'secondary',
        };
    }
} 