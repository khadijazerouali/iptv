<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('admin.users', compact('users'));
    }

    public function updateRoles(Request $request): JsonResponse
    {
        // Vérifier que l'utilisateur actuel est admin
        $currentUser = Auth::user();
        if (!$currentUser || ($currentUser->email !== 'admin@admin.com' && $currentUser->role !== 'admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        $changes = $request->input('changes', []);
        $updatedCount = 0;

        foreach ($changes as $userId => $change) {
            $user = User::find($userId);
            
            if ($user && $user->email !== 'admin@admin.com') {
                $user->role = $change['newRole'];
                $user->save();
                $updatedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$updatedCount} rôle(s) mis à jour avec succès"
        ]);
    }

    public function destroy($id)
    {
        // Vérifier que l'utilisateur connecté est admin
        $currentUser = Auth::user();
        if (!$currentUser || ($currentUser->email !== 'admin@admin.com' && $currentUser->role !== 'admin')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé'
            ], 403);
        }

        // Empêcher la suppression de admin@admin.com
        $user = User::findOrFail($id);
        if ($user->email === 'admin@admin.com') {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer le super administrateur'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès'
        ]);
    }

    public function list()
    {
        $users = User::select('id', 'name', 'email')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::with(['subscriptions', 'payments', 'supportTickets'])
            ->findOrFail($id);

        // Calculer les statistiques
        $stats = [
            'total_orders' => $user->subscriptions->count(),
            'total_payments' => $user->payments->where('status', 'completed')->count(),
            'total_revenue' => $user->payments->where('status', 'completed')->sum('amount'),
            'support_tickets' => $user->supportTickets->count(),
            'last_login' => $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais connecté',
            'status' => $user->email_verified_at ? 'Vérifié' : 'En attente',
            'registration_date' => $user->created_at->format('d/m/Y à H:i'),
            'role' => $user->email === 'admin@admin.com' ? 'Administrateur' : ($user->role === 'admin' ? 'Administrateur' : 'Utilisateur')
        ];

        return response()->json([
            'success' => true,
            'user' => $user,
            'stats' => $stats
        ]);
    }
} 