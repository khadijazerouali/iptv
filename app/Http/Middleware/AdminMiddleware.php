<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Autoriser l'accès si l'utilisateur est admin@admin.com ou a le rôle admin
        if ($user->email === 'admin@admin.com' || $user->role === 'admin') {
            return $next($request);
        }

        // Rediriger vers le dashboard utilisateur si non autorisé
        return redirect()->route('dashboard')->with('error', 'Accès non autorisé. Vous devez être administrateur pour accéder à cette page.');
    }
} 