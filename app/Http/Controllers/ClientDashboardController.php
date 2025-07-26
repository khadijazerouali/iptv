<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use App\Models\SupportTicket;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClientDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $section = $request->get('section', 'overview');

        // Statistiques générales
        $stats = [
            'total_subscriptions' => $user->subscriptions()->count(),
            'active_subscriptions' => $user->subscriptions()->where('status', 'active')->count(),
            'total_support_tickets' => $user->supportTickets()->count(),
            'open_support_tickets' => $user->supportTickets()->where('status', 'open')->count(),
        ];

        // Abonnements récents
        $recentSubscriptions = $user->subscriptions()
            ->with(['product', 'product.category', 'payments'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Tickets de support récents
        $recentSupportTickets = $user->supportTickets()
            ->with('ticketReplies')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Données pour les graphiques
        $monthlyData = $this->getMonthlyData($user);

        // Données par section
        $sectionData = [];
        
        switch ($section) {
            case 'profile':
                $sectionData = $this->getProfileData($user);
                break;
            case 'orders':
                $sectionData = $this->getOrdersData($user);
                break;
            case 'support':
                $sectionData = $this->getSupportData($user);
                break;
            case 'settings':
                $sectionData = $this->getSettingsData($user);
                break;
            default:
                $sectionData = $this->getOverviewData($user);
                break;
        }

        return view('dashboard.index', compact(
            'stats',
            'recentSubscriptions',
            'recentSupportTickets',
            'monthlyData',
            'sectionData',
            'section'
        ));
    }

    private function getOverviewData($user)
    {
        // Abonnements actifs avec détails
        $activeSubscriptions = $user->subscriptions()
            ->with(['product', 'product.category', 'payments'])
            ->where('status', 'active')
            ->get();

        // Prochaines échéances (utiliser end_date au lieu de next_billing_date)
        $upcomingExpirations = $user->subscriptions()
            ->with('product')
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->where('end_date', '<=', now()->addDays(30))
            ->get();

        // Activité récente
        $recentActivity = collect();

        // Ajouter les abonnements récents
        foreach ($user->subscriptions()->latest()->take(3)->get() as $subscription) {
            $recentActivity->push([
                'type' => 'subscription',
                'title' => 'Nouvel abonnement',
                'description' => $subscription->product->title ?? 'Abonnement #' . $subscription->id,
                'date' => $subscription->created_at,
                'icon' => 'fas fa-tv',
                'color' => 'primary'
            ]);
        }

        // Ajouter les tickets de support récents
        foreach ($user->supportTickets()->latest()->take(3)->get() as $ticket) {
            $recentActivity->push([
                'type' => 'support',
                'title' => 'Ticket de support',
                'description' => $ticket->subject,
                'date' => $ticket->created_at,
                'icon' => 'fas fa-headset',
                'color' => 'warning'
            ]);
        }

        // Ajouter les paiements récents
        foreach ($user->subscriptions()->with('payments')->get() as $subscription) {
            foreach ($subscription->payments()->latest()->take(2)->get() as $payment) {
                $recentActivity->push([
                    'type' => 'payment',
                    'title' => 'Paiement effectué',
                    'description' => 'Paiement pour ' . ($subscription->product->title ?? 'Abonnement #' . $subscription->id),
                    'date' => $payment->created_at,
                    'icon' => 'fas fa-credit-card',
                    'color' => 'success'
                ]);
            }
        }

        // Trier par date
        $recentActivity = $recentActivity->sortByDesc('date')->take(10);

        return [
            'activeSubscriptions' => $activeSubscriptions,
            'upcomingBills' => $upcomingExpirations, // Renommé pour la cohérence
            'recentActivity' => $recentActivity
        ];
    }

    private function getProfileData($user)
    {
        return [
            'user' => $user,
            'subscriptionCount' => $user->subscriptions()->count(),
            'supportTicketCount' => $user->supportTickets()->count(),
            'memberSince' => $user->created_at->diffForHumans(),
            'lastLogin' => $user->last_login_at ?? $user->created_at,
        ];
    }

    private function getOrdersData($user)
    {
        $subscriptions = $user->subscriptions()
            ->with(['product', 'product.category', 'payments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalSpent = $user->subscriptions()
            ->with('payments')
            ->get()
            ->sum(function ($subscription) {
                return $subscription->payments->sum('amount');
            });

        $monthlySpending = $user->subscriptions()
            ->with('payments')
            ->whereHas('payments', function ($query) {
                $query->whereMonth('created_at', now()->month);
            })
            ->get()
            ->sum(function ($subscription) {
                return $subscription->payments->where('created_at', '>=', now()->startOfMonth())->sum('amount');
            });

        return [
            'subscriptions' => $subscriptions,
            'totalSpent' => $totalSpent,
            'monthlySpending' => $monthlySpending,
        ];
    }

    private function getSupportData($user)
    {
        $supportTickets = $user->supportTickets()
            ->with('ticketReplies')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ticketStats = [
            'total' => $user->supportTickets()->count(),
            'open' => $user->supportTickets()->where('status', 'open')->count(),
            'in_progress' => $user->supportTickets()->where('status', 'in_progress')->count(),
            'resolved' => $user->supportTickets()->where('status', 'resolved')->count(),
            'closed' => $user->supportTickets()->where('status', 'closed')->count(),
        ];

        return [
            'supportTickets' => $supportTickets,
            'ticketStats' => $ticketStats,
        ];
    }

    private function getSettingsData($user)
    {
        return [
            'user' => $user,
            'notifications' => [
                'email_notifications' => true,
                'sms_notifications' => false,
                'billing_reminders' => true,
                'support_updates' => true,
            ],
        ];
    }

    private function getMonthlyData($user)
    {
        $months = collect();
        $subscriptions = collect();
        $payments = collect();

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');
            
            $months->push($monthName);
            
            // Abonnements créés ce mois
            $monthSubscriptions = $user->subscriptions()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $subscriptions->push($monthSubscriptions);
            
            // Paiements ce mois
            $monthPayments = $user->subscriptions()
                ->with('payments')
                ->get()
                ->sum(function ($subscription) use ($date) {
                    return $subscription->payments
                        ->where('created_at', '>=', $date->startOfMonth())
                        ->where('created_at', '<=', $date->endOfMonth())
                        ->sum('amount');
                });
            $payments->push($monthPayments);
        }

        return [
            'months' => $months,
            'subscriptions' => $subscriptions,
            'payments' => $payments,
        ];
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telephone' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
        ]);

        try {
            $user->fill($validated);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil mis à jour avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du profil'
            ], 500);
        }
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'billing_reminders' => 'boolean',
            'support_updates' => 'boolean',
        ]);

        // Ici vous pourriez sauvegarder les préférences dans une table séparée
        // Pour l'instant, on simule la sauvegarde

        return response()->json([
            'success' => true,
            'message' => 'Paramètres mis à jour avec succès'
        ]);
    }

    public function downloadInvoice($subscriptionId)
    {
        $user = Auth::user();
        
        $subscription = $user->subscriptions()
            ->where('id', $subscriptionId)
            ->with(['product', 'payments'])
            ->firstOrFail();

        // Ici vous généreriez le PDF de la facture
        // Pour l'instant, on simule le téléchargement

        return response()->json([
            'success' => true,
            'message' => 'Facture téléchargée avec succès',
            'filename' => 'facture-' . $subscription->id . '.pdf'
        ]);
    }
}
