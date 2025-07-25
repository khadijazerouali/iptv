<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Devicetype;
use App\Models\Applicationtype;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DeviceTypeController extends Controller
{
    public function index()
    {
        // Statistiques des types d'appareils
        $stats = [
            'total_types' => Devicetype::count(),
            'active_types' => Devicetype::count(), // Tous les types sont considérés comme actifs
            'paused_types' => 0, // Pas de statut pause dans cette table
            'active_users' => Subscription::distinct('user_id')->count(),
        ];

        // Types d'appareils avec leurs applications
        $deviceTypes = Devicetype::with(['applicationTypes'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques d'utilisation par type d'appareil
        foreach ($deviceTypes as $deviceType) {
            $deviceType->usage_count = Subscription::whereHas('formiptvs', function($query) use ($deviceType) {
                $query->where('device', $deviceType->name);
            })->count();
        }

        // Catégories pour le filtre
        $categories = [
            'mobile' => 'Mobile',
            'tv' => 'Smart TV',
            'box' => 'Box IPTV',
            'computer' => 'Ordinateur'
        ];

        return view('admin.device-types', compact('stats', 'deviceTypes', 'categories'));
    }

    public function show($uuid)
    {
        $deviceType = Devicetype::with(['applicationTypes'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Statistiques du type d'appareil
        $deviceStats = [
            'total_users' => Subscription::whereHas('formiptvs', function($query) use ($deviceType) {
                $query->where('device', $deviceType->name);
            })->distinct()->count('user_id'),
            'monthly_users' => Subscription::whereHas('formiptvs', function($query) use ($deviceType) {
                $query->where('device', $deviceType->name);
            })->whereMonth('created_at', Carbon::now()->month)->distinct()->count('user_id'),
            'applications_count' => $deviceType->applicationTypes->count(),
            'compatibility_score' => $this->calculateCompatibilityScore($deviceType),
        ];

        return response()->json([
            'deviceType' => $deviceType,
            'stats' => $deviceStats
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $deviceType = Devicetype::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Type d\'appareil créé avec succès',
            'deviceType' => $deviceType
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $deviceType = Devicetype::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $deviceType->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Type d\'appareil mis à jour avec succès',
            'deviceType' => $deviceType
        ]);
    }

    public function destroy($uuid)
    {
        $deviceType = Devicetype::where('uuid', $uuid)->firstOrFail();
        $deviceType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Type d\'appareil supprimé avec succès'
        ]);
    }

    public function getAll()
    {
        $deviceTypes = Devicetype::orderBy('name')->get(['uuid', 'name']);
        
        return response()->json($deviceTypes);
    }

    private function calculateCompatibilityScore($deviceType)
    {
        // Tous les types d'appareils sont considérés comme 100% compatibles
        return 100;
    }
} 