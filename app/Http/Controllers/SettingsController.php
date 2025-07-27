<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $settings = $user->getSettings();

        return view('settings.index', compact('settings'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('settings.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'billing_reminders' => 'boolean',
            'newsletter_offers' => 'boolean',
            'support_updates' => 'boolean',
            'order_updates' => 'boolean',
            'security_alerts' => 'boolean',
            'language' => 'string|in:fr,en,es',
            'timezone' => 'string',
            'theme' => 'string|in:light,dark',
        ]);

        $user = Auth::user();
        
        // Mettre à jour les paramètres
        UserSettings::updateSettings($user->id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Paramètres mis à jour avec succès !'
        ]);
    }

    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'billing_reminders' => 'boolean',
            'newsletter_offers' => 'boolean',
            'support_updates' => 'boolean',
            'order_updates' => 'boolean',
            'security_alerts' => 'boolean',
        ]);

        $user = Auth::user();
        
        // Mettre à jour seulement les paramètres de notifications
        UserSettings::updateSettings($user->id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Paramètres de notifications mis à jour !'
        ]);
    }

    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'language' => 'string|in:fr,en,es',
            'timezone' => 'string',
            'theme' => 'string|in:light,dark',
        ]);

        $user = Auth::user();
        
        // Mettre à jour seulement les préférences
        UserSettings::updateSettings($user->id, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Préférences mises à jour !'
        ]);
    }
} 