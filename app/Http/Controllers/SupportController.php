<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportReply;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupportController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $tickets = $user->supportTickets()
            ->with(['replies.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => $user->supportTickets()->count(),
            'open' => $user->supportTickets()->where('status', 'open')->count(),
            'in_progress' => $user->supportTickets()->where('status', 'in_progress')->count(),
            'resolved' => $user->supportTickets()->where('status', 'resolved')->count(),
        ];

        return view('support.index', compact('tickets', 'stats'));
    }

    public function create()
    {
        $categories = [
            'technical' => 'Problème technique',
            'billing' => 'Facturation',
            'account' => 'Compte utilisateur',
            'streaming' => 'Problème de streaming',
            'general' => 'Question générale',
        ];

        return view('support.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'category' => 'required|string',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $validated['priority'],
            'category' => $validated['category'],
            'status' => 'open',
        ]);

        return redirect()->route('support.show', $ticket->uuid)
            ->with('success', 'Votre ticket de support a été créé avec succès !');
    }

    public function show(SupportTicket $ticket)
    {
        // Vérifier que l'utilisateur peut voir ce ticket
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->load(['replies.user', 'user']);

        return view('support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        // Vérifier que l'utilisateur peut répondre à ce ticket
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|min:5',
        ]);

        $reply = SupportReply::create([
            'ticket_uuid' => $ticket->uuid,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_admin_reply' => false,
        ]);

        // Envoyer notification aux admins
        NotificationService::sendTicketReplyNotification($ticket, $reply);

        // Mettre à jour le statut du ticket
        if ($ticket->status === 'resolved') {
            $ticket->update(['status' => 'open']);
        }

        return back()->with('success', 'Votre réponse a été envoyée avec succès !');
    }

    public function close(SupportTicket $ticket)
    {
        // Vérifier que l'utilisateur peut fermer ce ticket
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $ticket->update(['status' => 'closed']);

        return redirect()->route('support.index')
            ->with('success', 'Le ticket a été fermé avec succès !');
    }
} 