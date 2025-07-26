<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('admin.users', compact('users'));
    }

    public function updateRoles(Request $request): JsonResponse
    {
        // Vérifier que l'utilisateur actuel est l'admin principal
        if (auth()->user()->email !== 'admin@admin.com') {
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
        // Vérifier que l'utilisateur connecté est admin@admin.com
        if (auth()->user()->email !== 'admin@admin.com') {
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
} 