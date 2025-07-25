<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Formiptv;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        // Statistiques des commandes basées sur le statut réel de la commande
        $stats = [
            'total_orders' => Subscription::count(),
            'paid_orders' => Subscription::where('status', 'active')->count(),
            'pending_orders' => Subscription::where('status', 'pending')->count(),
            'total_revenue' => Subscription::join('products', 'subscriptions.product_uuid', '=', 'products.uuid')
                ->sum('products.price'),
        ];

        // Commandes avec relations
        $orders = Subscription::with(['user', 'product', 'payments', 'formiptvs'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Ajouter des statistiques par commande
        foreach ($orders as $order) {
            $order->total_paid = $order->product->price ?? 0; // Utiliser le prix du produit
            $order->payment_status = $order->payments->where('status', 'completed')->count() > 0 ? 'paid' : 'pending';
        }

        // Statuts pour le filtre
        $statuses = [
            'pending' => 'En attente',
            'active' => 'En cours',
            'cancelled' => 'Annulées',
            'completed' => 'Terminées'
        ];

        return view('admin.orders', compact('stats', 'orders', 'statuses'));
    }

    public function show($uuid)
    {
        $order = Subscription::with(['user', 'product', 'payments', 'formiptvs'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Configuration IPTV
        $iptvConfig = [];
        if ($order->formiptvs->count() > 0) {
            $formiptv = $order->formiptvs->first();
            $iptvConfig = [
                'duration' => $formiptv->duration ?? 'N/A',
                'device' => $formiptv->device ?? 'N/A',
                'application' => $formiptv->application ?? 'N/A',
                'device_id' => $formiptv->device_id ?? null,
                'device_key' => $formiptv->device_key ?? null,
                'otp_code' => $formiptv->otp_code ?? null,
                'smart_stb_mac' => $formiptv->note ?? null, // smartstbmac est stocké dans note
            ];
        }

        // Statistiques de la commande
        $orderStats = [
            'total_paid' => $order->product->price ?? 0, // Utiliser le prix du produit
            'payment_count' => $order->payments->count(),
            'days_active' => $order->start_date ? max(0, Carbon::now()->diffInDays($order->start_date)) : 0, // Éviter les valeurs négatives
            'status' => $order->payments->where('status', 'completed')->count() > 0 ? 'paid' : 'pending',
        ];

        return response()->json([
            'order' => $order,
            'iptvConfig' => $iptvConfig,
            'stats' => $orderStats
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_uuid' => 'required|exists:products,uuid',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $order = Subscription::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Commande créée avec succès',
            'order' => $order
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $order = Subscription::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|string|in:pending,active,cancelled,completed',
        ]);

        $order->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Statut de la commande mis à jour avec succès',
            'order' => $order
        ]);
    }

    public function destroy($uuid)
    {
        $order = Subscription::where('uuid', $uuid)->firstOrFail();
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Commande supprimée avec succès'
        ]);
    }

    public function activate($uuid)
    {
        $order = Subscription::where('uuid', $uuid)->firstOrFail();
        $order->update(['status' => 'active']);

        return response()->json([
            'success' => true,
            'message' => 'Commande activée avec succès'
        ]);
    }
} 