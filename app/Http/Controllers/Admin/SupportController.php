<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportReply;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function index()
    {
        // Statistiques du support
        $stats = [
            'total_tickets' => SupportTicket::count(),
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
            'in_progress_tickets' => SupportTicket::where('status', 'in_progress')->count(),
            'resolved_tickets' => SupportTicket::where('status', 'resolved')->count(),
            'urgent_tickets' => SupportTicket::where('priority', 'urgent')->count(),
        ];

        // Tickets avec pagination
        $tickets = SupportTicket::with(['user', 'replies.user'])
            ->orderByRaw("CASE 
                WHEN priority = 'urgent' THEN 1 
                WHEN priority = 'high' THEN 2 
                WHEN priority = 'medium' THEN 3 
                WHEN priority = 'low' THEN 4 
                ELSE 5 END")
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.support.index', compact('stats', 'tickets'));
    }

    public function show(SupportTicket $ticket)
    {
        $ticket->load(['user', 'replies.user']);
        
        return view('admin.support.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string|min:5',
            'status' => 'nullable|in:open,in_progress,resolved,closed',
        ]);

        // Sauvegarder l'ancien statut
        $oldStatus = $ticket->status;

        // Créer la réponse
        $reply = SupportReply::create([
            'ticket_uuid' => $ticket->uuid,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_admin_reply' => true,
        ]);

        // Envoyer notification au client
        NotificationService::sendTicketReplyNotification($ticket, $reply);

        // Mettre à jour le statut si fourni
        if (isset($validated['status'])) {
            $ticket->update(['status' => $validated['status']]);
            
            // Envoyer notification de changement de statut
            if ($oldStatus !== $validated['status']) {
                NotificationService::sendTicketStatusNotification($ticket, $oldStatus, $validated['status']);
            }
        }

        return back()->with('success', 'Réponse envoyée avec succès !');
    }

    public function updateStatus(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $oldStatus = $ticket->status;
        $ticket->update(['status' => $validated['status']]);

        // Envoyer notification de changement de statut
        if ($oldStatus !== $validated['status']) {
            NotificationService::sendTicketStatusNotification($ticket, $oldStatus, $validated['status']);
        }

        return back()->with('success', 'Statut mis à jour avec succès !');
    }

    public function assign(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $ticket->update(['assigned_to' => $validated['assigned_to']]);

        return back()->with('success', 'Ticket assigné avec succès !');
    }
} 