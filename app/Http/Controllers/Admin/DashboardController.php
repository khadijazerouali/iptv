<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Contact;
use App\Models\SupportTicket;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Subscription::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'new_users_this_month' => User::whereRaw('strftime("%m", created_at) = ?', [sprintf('%02d', Carbon::now()->month)])->whereRaw('strftime("%Y", created_at) = ?', [Carbon::now()->year])->count(),
            'new_orders_this_month' => Subscription::whereRaw('strftime("%m", created_at) = ?', [sprintf('%02d', Carbon::now()->month)])->whereRaw('strftime("%Y", created_at) = ?', [Carbon::now()->year])->count(),
            'pending_contacts' => Contact::where('status', 'pending')->count(),
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
        ];

        // Données pour les graphiques
        $monthlyOrders = Subscription::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
            ->whereRaw('strftime("%Y", created_at) = ?', [Carbon::now()->year])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyRevenue = Payment::selectRaw('strftime("%m", created_at) as month, SUM(amount) as total')
            ->where('status', 'completed')
            ->whereRaw('strftime("%Y", created_at) = ?', [Carbon::now()->year])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Dernières commandes
        $recentOrders = Subscription::with(['user', 'product', 'promoCode'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Derniers utilisateurs
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Produits les plus populaires
        $popularProducts = Product::withCount('subscriptions')
            ->orderBy('subscriptions_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'monthlyOrders',
            'monthlyRevenue',
            'recentOrders',
            'recentUsers',
            'popularProducts'
        ));
    }
} 