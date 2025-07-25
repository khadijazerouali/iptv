<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Applicationtype;
use App\Models\Devicetype;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApplicationTypeController extends Controller
{
    public function index()
    {
        // Statistiques des applications
        $stats = [
            'total_applications' => Applicationtype::count(),
            'active_applications' => Applicationtype::where('status', 'active')->count(),
            'in_development' => Applicationtype::where('status', 'development')->count(),
            'total_downloads' => $this->calculateTotalDownloads(),
        ];

        // Applications avec leurs types d'appareils
        $applications = Applicationtype::with(['devicetype'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques d'utilisation par application
        foreach ($applications as $application) {
            $application->usage_count = Subscription::whereHas('formiptvs', function($query) use ($application) {
                $query->where('application', $application->name);
            })->count();
            
            $application->download_count = rand(100, 2000); // Simulation pour l'exemple
        }

        // Plateformes pour le filtre
        $platforms = [
            'android' => 'Android',
            'ios' => 'iOS',
            'web' => 'Web',
            'smarttv' => 'Smart TV'
        ];

        return view('admin.application-types', compact('stats', 'applications', 'platforms'));
    }

    public function show($uuid)
    {
        $application = Applicationtype::with(['devicetype'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Statistiques de l'application
        $appStats = [
            'total_users' => Subscription::whereHas('formiptvs', function($query) use ($application) {
                $query->where('application', $application->name);
            })->distinct('user_id')->count(),
            'monthly_users' => Subscription::whereHas('formiptvs', function($query) use ($application) {
                $query->where('application', $application->name);
            })->whereMonth('created_at', Carbon::now()->month)->distinct('user_id')->count(),
            'downloads' => rand(500, 3000), // Simulation
            'rating' => round(rand(35, 50) / 10, 1), // Simulation
        ];

        // Fonctionnalités requises
        $requiredFeatures = [
            'deviceid' => $application->deviceid,
            'devicekey' => $application->devicekey,
            'otpcode' => $application->otpcode,
            'smartstbmac' => $application->smartstbmac,
        ];

        return response()->json([
            'application' => $application,
            'stats' => $appStats,
            'requiredFeatures' => $requiredFeatures
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'devicetype_uuid' => 'required|exists:devicetypes,uuid',
            'name' => 'required|string|max:255',
            'deviceid' => 'boolean',
            'devicekey' => 'boolean',
            'otpcode' => 'boolean',
            'smartstbmac' => 'boolean',
        ]);

        $application = Applicationtype::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Application créée avec succès',
            'application' => $application
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $application = Applicationtype::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'devicetype_uuid' => 'required|exists:devicetypes,uuid',
            'name' => 'required|string|max:255',
            'deviceid' => 'boolean',
            'devicekey' => 'boolean',
            'otpcode' => 'boolean',
            'smartstbmac' => 'boolean',
        ]);

        $application->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Application mise à jour avec succès',
            'application' => $application
        ]);
    }

    public function destroy($uuid)
    {
        $application = Applicationtype::where('uuid', $uuid)->firstOrFail();
        $application->delete();

        return response()->json([
            'success' => true,
            'message' => 'Application supprimée avec succès'
        ]);
    }

    private function calculateTotalDownloads()
    {
        // Simulation du calcul des téléchargements totaux
        return Applicationtype::count() * rand(500, 2000);
    }
} 