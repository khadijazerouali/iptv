<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\EmailService;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Vérifier si l'utilisateur existe déjà
        $user = User::where('email', $validate['email'])->first();
        
        if (!$user) {
            $user = User::create([
                'name' => $validate['name'],
                'email' => $validate['email'],
                'password' => bcrypt($validate['password']),
            ]);
        }

        // Attribution du rôle par défaut (seulement si l'utilisateur n'a pas déjà le rôle)
        if ($user->email === 'admin@admin.com') {
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
            }
        } else {
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }
        }

        Auth::login($user);

        // Envoyer l'email de bienvenue
        try {
            EmailService::sendWelcomeEmail($user);
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas bloquer l'inscription
            Log::error('Erreur envoi email bienvenue: ' . $e->getMessage());
        }

        // Redirection après inscription
        if ($user->email === 'admin@admin.com' || $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt(['email' => $validate['email'], 'password' => $validate['password']])) {
            $user = Auth::user();
            
            // Redirection automatique pour tous les admins
            if ($user->email === 'admin@admin.com' || $user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Identifiants invalides',
        ]);
    }
}
