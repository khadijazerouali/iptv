<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_notifications',
        'sms_notifications',
        'billing_reminders',
        'newsletter_offers',
        'support_updates',
        'order_updates',
        'security_alerts',
        'language',
        'timezone',
        'theme',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'billing_reminders' => 'boolean',
        'newsletter_offers' => 'boolean',
        'support_updates' => 'boolean',
        'order_updates' => 'boolean',
        'security_alerts' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Méthodes pour obtenir les paramètres par défaut
    public static function getDefaults(): array
    {
        return [
            'email_notifications' => true,
            'sms_notifications' => false,
            'billing_reminders' => true,
            'newsletter_offers' => true,
            'support_updates' => true,
            'order_updates' => true,
            'security_alerts' => true,
            'language' => 'fr',
            'timezone' => 'Europe/Paris',
            'theme' => 'light',
        ];
    }

    // Méthode pour créer ou mettre à jour les paramètres
    public static function updateSettings(int $userId, array $settings): self
    {
        return self::updateOrCreate(
            ['user_id' => $userId],
            $settings
        );
    }
} 