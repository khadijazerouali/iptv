<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketReplie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SupportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les tickets de l'utilisateur connecté
        $tickets = SupportTicket::with(['ticketReplies.user'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Ajouter des statistiques par ticket
        foreach ($tickets as $ticket) {
            $ticket->reply_count = $ticket->ticketReplies->count();
            $ticket->last_reply = $ticket->ticketReplies->sortByDesc('created_at')->first();
            $ticket->days_open = Carbon::now()->diffInDays($ticket->created_at);
        }

        // Statistiques générales
        $stats = [
            'total_tickets' => SupportTicket::where('user_id', $user->id)->count(),
            'open_tickets' => SupportTicket::where('user_id', $user->id)->where('status', 'open')->count(),
            'in_progress_tickets' => SupportTicket::where('user_id', $user->id)->where('status', 'in_progress')->count(),
            'resolved_tickets' => SupportTicket::where('user_id', $user->id)->where('status', 'resolved')->count(),
        ];

        return view('support.index', compact('tickets', 'stats'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Récupérer les abonnements de l'utilisateur pour le formulaire
        $subscriptions = $user->subscriptions()->with('product')->get();
        
        return view('support.create', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'subscription_id' => 'nullable|exists:subscriptions,id',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        return redirect()->route('support.show', $ticket->uuid)
            ->with('success', 'Ticket de support créé avec succès !');
    }

    public function show($uuid)
    {
        $user = Auth::user();
        
        $ticket = SupportTicket::with(['ticketReplies.user'])
            ->where('uuid', $uuid)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Statistiques du ticket
        $ticketStats = [
            'reply_count' => $ticket->ticketReplies->count(),
            'days_open' => Carbon::now()->diffInDays($ticket->created_at),
            'last_reply' => $ticket->ticketReplies->sortByDesc('created_at')->first(),
        ];

        return view('support.show', compact('ticket', 'ticketStats'));
    }

    public function reply(Request $request, $uuid)
    {
        $user = Auth::user();
        
        $ticket = SupportTicket::where('uuid', $uuid)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $reply = TicketReplie::create([
            'support_ticket_uuid' => $ticket->uuid,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        // Mettre à jour le statut du ticket
        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return redirect()->route('support.show', $ticket->uuid)
            ->with('success', 'Réponse envoyée avec succès !');
    }

    public function close($uuid)
    {
        $user = Auth::user();
        
        $ticket = SupportTicket::where('uuid', $uuid)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $ticket->update(['status' => 'closed']);

        return redirect()->route('support.index')
            ->with('success', 'Ticket fermé avec succès !');
    }

    public function knowledgeBase()
    {
        $categories = [
            'installation' => [
                'title' => 'Installation',
                'icon' => 'fas fa-download',
                'description' => 'Guides d\'installation pour tous les appareils',
                'articles' => [
                    ['id' => 1, 'title' => 'Installation sur Android', 'url' => '#'],
                    ['id' => 2, 'title' => 'Installation sur iOS', 'url' => '#'],
                    ['id' => 3, 'title' => 'Installation sur Smart TV', 'url' => '#'],
                    ['id' => 4, 'title' => 'Installation sur PC', 'url' => '#'],
                    ['id' => 5, 'title' => 'Installation sur MAC', 'url' => '#'],
                ]
            ],
            'configuration' => [
                'title' => 'Configuration',
                'icon' => 'fas fa-cog',
                'description' => 'Paramètres et configuration avancée',
                'articles' => [
                    ['id' => 6, 'title' => 'Configuration des paramètres', 'url' => '#'],
                    ['id' => 7, 'title' => 'Configuration du réseau', 'url' => '#'],
                    ['id' => 8, 'title' => 'Configuration avancée', 'url' => '#'],
                ]
            ],
            'depannage' => [
                'title' => 'Dépannage',
                'icon' => 'fas fa-tools',
                'description' => 'Solutions aux problèmes courants',
                'articles' => [
                    ['id' => 9, 'title' => 'Problèmes de connexion', 'url' => '#'],
                    ['id' => 10, 'title' => 'Problèmes de qualité vidéo', 'url' => '#'],
                    ['id' => 11, 'title' => 'Problèmes de son', 'url' => '#'],
                    ['id' => 12, 'title' => 'Problèmes de décalage', 'url' => '#'],
                ]
            ]
        ];

        return view('support.knowledge-base', compact('categories'));
    }

    public function article($category, $articleId)
    {
        // Simulation d'articles
        $articles = [
            'installation' => [
                1 => [
                    'title' => 'Installation sur Android',
                    'content' => '<h2>Guide d\'installation sur Android</h2><p>Voici les étapes pour installer notre service IPTV sur votre appareil Android...</p>',
                    'category' => 'installation'
                ],
                // ... autres articles
            ],
            'configuration' => [
                6 => [
                    'title' => 'Configuration des paramètres',
                    'content' => '<h2>Configuration des paramètres</h2><p>Apprenez à configurer les paramètres de votre application...</p>',
                    'category' => 'configuration'
                ],
                // ... autres articles
            ],
            'depannage' => [
                9 => [
                    'title' => 'Problèmes de connexion',
                    'content' => '<h2>Résolution des problèmes de connexion</h2><p>Si vous rencontrez des problèmes de connexion, voici les solutions...</p>',
                    'category' => 'depannage'
                ],
                // ... autres articles
            ]
        ];

        $article = $articles[$category][$articleId] ?? null;

        if (!$article) {
            abort(404);
        }

        return view('support.article', compact('article', 'category'));
    }
}
