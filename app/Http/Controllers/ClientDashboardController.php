<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use App\Models\Product;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

/** @var User $user */

class ClientDashboardController extends Controller
{
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $section = $request->get('section', 'overview');

        // Statistiques générales
        $stats = [
            'total_subscriptions' => $user->subscriptions()->count(),
            'active_subscriptions' => $user->subscriptions()->where('status', 'active')->count(),
            'total_orders' => $user->subscriptions()->count(),
            'total_products' => Product::count(),
        ];

        // Abonnements récents
        $recentSubscriptions = $user->subscriptions()
            ->with(['product', 'product.category', 'payments'])
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
            'monthlyData',
            'sectionData',
            'section'
        ));
    }

    private function getOverviewData($user)
    {
        // Abonnements actifs avec détails
        $activeSubscriptions = $user->subscriptions()
            ->with(['product', 'product.category', 'payments', 'promoCode'])
            ->where('status', 'active')
            ->get();

        // Prochaines échéances (utiliser end_date au lieu de next_billing_date)
        $upcomingExpirations = $user->subscriptions()
            ->with(['product', 'promoCode'])
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
                'description' => $subscription->product->title ?? 'Abonnement #' . $subscription->number_order,
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
                    'description' => 'Paiement pour ' . ($subscription->product->title ?? 'Abonnement #' . $subscription->number_order),
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
            ->with(['product', 'product.category', 'payments', 'promoCode'])
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
            ->with('replies')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ticketStats = [
            'total' => $user->supportTickets()->count(),
            'open' => $user->supportTickets()->where('status', 'open')->count(),
            'in_progress' => $user->supportTickets()->where('status', 'in_progress')->count(),
            'resolved' => $user->supportTickets()->where('status', 'resolved')->count(),
        ];

        return [
            'supportTickets' => $supportTickets,
            'ticketStats' => $ticketStats,
        ];
    }

    private function getSettingsData($user)
    {
        $settings = $user->getSettings();
        
        return [
            'settings' => $settings,
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
        /** @var User $user */
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
        
        // Si c'est un changement de mot de passe
        if ($request->has('current_password')) {
            $validated = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:8|different:current_password',
                'new_password_confirmation' => 'required|same:new_password',
            ]);

            // Vérifier l'ancien mot de passe
            if (!Hash::check($validated['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Le mot de passe actuel est incorrect',
                    'errors' => [
                        'current_password' => ['Le mot de passe actuel est incorrect']
                    ]
                ], 422);
            }

            // Mettre à jour le mot de passe
            $user->update([
                'password' => Hash::make($validated['new_password'])
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mot de passe changé avec succès'
            ]);
        }

        // Autres paramètres
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'billing_reminders' => 'boolean',
            'support_updates' => 'boolean',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paramètres mis à jour avec succès'
        ]);
    }

    public function downloadInvoice($subscriptionUuid)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $subscription = $user->subscriptions()
            ->where('uuid', $subscriptionUuid)
            ->with(['product', 'formiptvs', 'payments'])
            ->firstOrFail();

        // Générer le PDF de la facture
        $pdf = Pdf::loadView('invoices.template', compact('subscription', 'user'));
        
        // Nom du fichier
        $filename = 'facture-' . $subscription->number_order . '.pdf';
        
        // Retourner le PDF pour téléchargement
        return $pdf->download($filename);
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        
        // Validation
        $validated = $request->validate([
            'password' => 'required|string',
            'confirmation' => 'required|string|in:SUPPRIMER',
        ]);

        // Vérifier le mot de passe
        if (!Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mot de passe incorrect',
                'errors' => [
                    'password' => ['Le mot de passe est incorrect']
                ]
            ], 422);
        }
        
        try {
            // Supprimer toutes les données associées à l'utilisateur
            $user->subscriptions()->delete();
            $user->payments()->delete();
            $user->supportTickets()->delete();
            $user->notifications()->delete();
            $user->settings()->delete();
            
            // Supprimer l'utilisateur
            $user->delete();
            
            // Déconnecter l'utilisateur
            Auth::logout();
            
            return response()->json([
                'success' => true,
                'message' => 'Compte supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du compte'
            ], 500);
        }
    }
}
