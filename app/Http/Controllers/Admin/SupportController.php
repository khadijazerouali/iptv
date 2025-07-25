<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\User;
use App\Models\TicketReplie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SupportController extends Controller
{
    public function index()
    {
        // Statistiques du support
        $stats = [
            'total_tickets' => SupportTicket::count(),
            'resolved_tickets' => SupportTicket::where('status', 'resolved')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'satisfaction_score' => $this->calculateSatisfactionScore(),
        ];

        // Tickets avec relations
        $tickets = SupportTicket::with(['user', 'ticketReplies'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Ajouter des statistiques par ticket
        foreach ($tickets as $ticket) {
            $ticket->reply_count = $ticket->ticketReplies->count();
            $ticket->last_reply = $ticket->ticketReplies->sortByDesc('created_at')->first();
            $ticket->days_open = Carbon::now()->diffInDays($ticket->created_at);
        }

        // Statuts et priorités pour les filtres
        $statuses = [
            'open' => 'Ouverts',
            'in_progress' => 'En cours',
            'resolved' => 'Résolus',
            'closed' => 'Fermés'
        ];

        $priorities = [
            'low' => 'Faible',
            'medium' => 'Moyenne',
            'high' => 'Élevée',
            'urgent' => 'Urgente'
        ];

        return view('admin.support', compact('stats', 'tickets', 'statuses', 'priorities'));
    }

    public function show($uuid)
    {
        $ticket = SupportTicket::with(['user', 'ticketReplies.user'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Statistiques du ticket
        $ticketStats = [
            'reply_count' => $ticket->ticketReplies->count(),
            'days_open' => Carbon::now()->diffInDays($ticket->created_at),
            'last_reply' => $ticket->ticketReplies->sortByDesc('created_at')->first(),
            'response_time' => $this->calculateResponseTime($ticket),
        ];

        return response()->json([
            'ticket' => $ticket,
            'stats' => $ticketStats
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $ticket = SupportTicket::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ticket créé avec succès',
            'ticket' => $ticket
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $ticket = SupportTicket::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $ticket->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ticket mis à jour avec succès',
            'ticket' => $ticket
        ]);
    }

    public function destroy($uuid)
    {
        $ticket = SupportTicket::where('uuid', $uuid)->firstOrFail();
        $ticket->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket supprimé avec succès'
        ]);
    }

    public function reply(Request $request, $uuid)
    {
        $ticket = SupportTicket::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $reply = TicketReplie::create([
            'support_ticket_uuid' => $ticket->uuid,
            'user_id' => $validated['user_id'],
            'message' => $validated['message'],
        ]);

        // Mettre à jour le statut du ticket
        $ticket->update(['status' => 'in_progress']);

        return response()->json([
            'success' => true,
            'message' => 'Réponse ajoutée avec succès',
            'reply' => $reply
        ]);
    }

    public function resolve($uuid)
    {
        $ticket = SupportTicket::where('uuid', $uuid)->firstOrFail();
        $ticket->update(['status' => 'resolved']);

        return response()->json([
            'success' => true,
            'message' => 'Ticket résolu avec succès'
        ]);
    }

    private function calculateSatisfactionScore()
    {
        // Simulation du calcul du score de satisfaction
        $resolvedTickets = SupportTicket::where('status', 'resolved')->count();
        $totalTickets = SupportTicket::count();
        
        if ($totalTickets === 0) return 0;
        
        // Simulation basée sur le ratio de tickets résolus
        $baseScore = ($resolvedTickets / $totalTickets) * 5;
        return round($baseScore, 1);
    }

    private function calculateResponseTime($ticket)
    {
        $firstReply = $ticket->ticketReplies->sortBy('created_at')->first();
        
        if (!$firstReply) {
            return Carbon::now()->diffInHours($ticket->created_at);
        }
        
        return $ticket->created_at->diffInHours($firstReply->created_at);
    }
} 