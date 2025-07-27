<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Envoyer l'email de bienvenue à un nouvel utilisateur
     */
    public static function sendWelcomeEmail(User $user): bool
    {
        try {
            Mail::send('emails.welcome', ['user' => $user], function($message) use($user) {
                $message->to($user->email);
                $message->subject('🎉 Bienvenue sur IPTV Service !');
            });
            
            Log::info('Email de bienvenue envoyé à: ' . $user->email);
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur envoi email bienvenue: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Envoyer l'email de réinitialisation de mot de passe
     */
    public static function sendPasswordResetEmail(User $user, string $token): bool
    {
        try {
            Mail::send('emails.reset-password', ['user' => $user, 'token' => $token], function($message) use($user) {
                $message->to($user->email);
                $message->subject('🔐 Réinitialisation de votre mot de passe IPTV');
            });
            
            Log::info('Email de réinitialisation envoyé à: ' . $user->email);
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur envoi email réinitialisation: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Envoyer un email de notification personnalisé
     */
    public static function sendNotificationEmail(User $user, string $subject, string $template, array $data = []): bool
    {
        try {
            Mail::send($template, array_merge(['user' => $user], $data), function($message) use($user, $subject) {
                $message->to($user->email);
                $message->subject($subject);
            });
            
            Log::info('Email de notification envoyé à: ' . $user->email);
            return true;
        } catch (\Exception $e) {
            Log::error('Erreur envoi email notification: ' . $e->getMessage());
            return false;
        }
    }
} 