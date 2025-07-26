@extends('layouts.admin')

@section('title', 'Support et assistance')

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-headset"></i>
                Support et assistance
            </h1>
            <p class="page-subtitle">Gérez le support client et les demandes d'assistance</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="createTicket()">
                <i class="fas fa-plus me-2"></i>
                Nouveau ticket
            </button>
            <button class="btn btn-outline-primary" onclick="exportTickets()">
                <i class="fas fa-download me-2"></i>
                Exporter
            </button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_tickets']) }}</h3>
                <p>Total tickets</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['resolved_tickets']) }}</h3>
                <p>Résolus</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['in_progress']) }}</h3>
                <p>En cours</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $stats['satisfaction_score'] }}/5</h3>
                <p>Satisfaction</p>
            </div>
        </div>
    </div>
</div>

<!-- Support Tickets Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Tickets de support
        </h5>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;" id="statusFilter">
                <option value="">Tous les statuts</option>
                @foreach($statuses as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <select class="form-select form-select-sm" style="width: auto;" id="priorityFilter">
                <option value="">Toutes les priorités</option>
                @foreach($priorities as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher un ticket..." id="searchInput">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Sujet</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Réponses</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $ticket->id }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">{{ $ticket->user->name ?? 'Utilisateur inconnu' }}</div>
                                <small class="text-muted">{{ $ticket->user->email ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $ticket->subject }}</div>
                        <small class="text-muted">{{ Str::limit($ticket->message, 50) }}</small>
                    </td>
                    <td>
                        @switch($ticket->priority)
                            @case('urgent')
                                <span class="badge badge-danger">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Urgente
                                </span>
                                @break
                            @case('high')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    Élevée
                                </span>
                                @break
                            @case('medium')
                                <span class="badge badge-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Moyenne
                                </span>
                                @break
                            @case('low')
                                <span class="badge badge-secondary">
                                    <i class="fas fa-arrow-down me-1"></i>
                                    Faible
                                </span>
                                @break
                            @default
                                <span class="badge badge-info">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Moyenne
                                </span>
                        @endswitch
                    </td>
                    <td>
                        @switch($ticket->status)
                            @case('open')
                                <span class="badge badge-primary">
                                    <i class="fas fa-folder-open me-1"></i>
                                    Ouvert
                                </span>
                                @break
                            @case('in_progress')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    En cours
                                </span>
                                @break
                            @case('resolved')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Résolu
                                </span>
                                @break
                            @case('closed')
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Fermé
                                </span>
                                @break
                            @default
                                <span class="badge badge-primary">
                                    <i class="fas fa-folder-open me-1"></i>
                                    Ouvert
                                </span>
                        @endswitch
                    </td>
                    <td>
                        <span class="badge badge-info">
                            <i class="fas fa-comments me-1"></i>
                            {{ $ticket->reply_count }}
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                            <small>{{ $ticket->created_at->format('H:i') }}</small>
                            @if($ticket->days_open > 0)
                                <br><small class="text-warning">{{ $ticket->days_open }}j</small>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewTicket('{{ $ticket->uuid }}')" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($ticket->status !== 'resolved')
                            <button class="btn btn-outline-success btn-sm" onclick="resolveTicket('{{ $ticket->uuid }}')" title="Résoudre">
                                <i class="fas fa-check"></i>
                            </button>
                            @endif
                            <button class="btn btn-outline-info btn-sm" onclick="replyTicket('{{ $ticket->uuid }}')" title="Répondre">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteTicket('{{ $ticket->uuid }}')" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-ticket-alt fa-2x mb-3"></i>
                            <p>Aucun ticket de support trouvé</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($tickets->hasPages())
    <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-light rounded">
        <div class="pagination-info">
            <i class="fas fa-info-circle me-1"></i>
            Affichage de <strong>{{ $tickets->firstItem() ?? 0 }}</strong> à <strong>{{ $tickets->lastItem() ?? 0 }}</strong> sur <strong>{{ $tickets->total() }}</strong> résultats
        </div>
        <nav aria-label="Navigation des tickets">
            <ul class="pagination pagination-sm mb-0">
                {{-- Bouton Précédent --}}
                @if ($tickets->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" title="Page précédente">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $tickets->previousPageUrl() }}" rel="prev" title="Page précédente">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Numéros de pages --}}
                @php
                    $start = max(1, $tickets->currentPage() - 2);
                    $end = min($tickets->lastPage(), $tickets->currentPage() + 2);
                @endphp

                @if($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $tickets->url(1) }}">1</a>
                    </li>
                    @if($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $tickets->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $tickets->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endfor

                @if($end < $tickets->lastPage())
                    @if($end < $tickets->lastPage() - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $tickets->url($tickets->lastPage()) }}">{{ $tickets->lastPage() }}</a>
                    </li>
                @endif

                {{-- Bouton Suivant --}}
                @if ($tickets->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $tickets->nextPageUrl() }}" rel="next" title="Page suivante">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" title="Page suivante">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
</div>

<!-- Ticket Details Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-ticket-alt"></i>
                    Détails du ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="ticketModalContent">
                    <!-- Contenu dynamique -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Knowledge Base Section -->
<div class="admin-card slide-in mt-4">
    <div class="table-header">
        <h5>
            <i class="fas fa-book"></i>
            Base de connaissances
        </h5>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm" onclick="createArticle()">
                <i class="fas fa-plus me-2"></i>
                Nouvel article
            </button>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-tv text-primary"></i>
                        </div>
                        <h6 class="mb-0">Installation</h6>
                    </div>
                    <p class="text-muted small">Guide d'installation pour tous les appareils</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-primary">5 articles</span>
                        <button class="btn btn-outline-primary btn-sm" onclick="viewArticles('installation')">Voir</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-cog text-success"></i>
                        </div>
                        <h6 class="mb-0">Configuration</h6>
                    </div>
                    <p class="text-muted small">Paramètres et configuration avancée</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-success">8 articles</span>
                        <button class="btn btn-outline-success btn-sm" onclick="viewArticles('configuration')">Voir</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-tools text-warning"></i>
                        </div>
                        <h6 class="mb-0">Dépannage</h6>
                    </div>
                    <p class="text-muted small">Solutions aux problèmes courants</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-warning">12 articles</span>
                        <button class="btn btn-outline-warning btn-sm" onclick="viewArticles('depannage')">Voir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-reply"></i>
                    Répondre au ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="replyForm">
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label">Message de réponse</label>
                        <textarea class="form-control" id="replyMessage" rows="6" placeholder="Tapez votre réponse..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="markAsResolved">
                            <label class="form-check-label" for="markAsResolved">
                                Marquer comme résolu après cette réponse
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="sendReply()">Envoyer la réponse</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Ticket Modal -->
<div class="modal fade" id="createTicketModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus"></i>
                    Nouveau ticket de support
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createTicketForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ticketUser" class="form-label">Client</label>
                                <select class="form-select" id="ticketUser" required>
                                    <option value="">Sélectionner un client</option>
                                    <!-- Options will be loaded dynamically -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ticketPriority" class="form-label">Priorité</label>
                                <select class="form-select" id="ticketPriority" required>
                                    <option value="">Sélectionner une priorité</option>
                                    <option value="low">Faible</option>
                                    <option value="medium">Moyenne</option>
                                    <option value="high">Élevée</option>
                                    <option value="urgent">Urgente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="ticketSubject" class="form-label">Sujet</label>
                        <input type="text" class="form-control" id="ticketSubject" placeholder="Sujet du ticket" required>
                    </div>
                    <div class="mb-3">
                        <label for="ticketMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="ticketMessage" rows="6" placeholder="Description du problème..." required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveTicket()">Créer le ticket</button>
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la gestion des tickets
function viewTicket(ticketId) {
    showLoading();
    
    fetch(`/admin/support/${ticketId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            
            const ticket = data.ticket;
            const stats = data.stats;
            
            document.getElementById('ticketModalContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations du ticket</h6>
                        <p><strong>Numéro:</strong> #${ticket.id}</p>
                        <p><strong>Client:</strong> ${ticket.user ? ticket.user.name : 'Utilisateur inconnu'}</p>
                        <p><strong>Email:</strong> ${ticket.user ? ticket.user.email : 'N/A'}</p>
                        <p><strong>Priorité:</strong> ${getPriorityLabel(ticket.priority)}</p>
                        <p><strong>Statut:</strong> ${getStatusLabel(ticket.status)}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques</h6>
                        <p><strong>Réponses:</strong> ${stats.reply_count}</p>
                        <p><strong>Jours ouverts:</strong> ${stats.days_open}</p>
                        <p><strong>Temps de réponse:</strong> ${stats.response_time}h</p>
                        <p><strong>Date:</strong> ${new Date(ticket.created_at).toLocaleString('fr-FR')}</p>
                    </div>
                </div>
                <hr>
                <div class="mt-3">
                    <h6>Message du client</h6>
                    <div class="bg-light p-3 rounded">
                        <p>${(ticket.message || '').replace(/\n/g, '<br>')}</p>
                    </div>
                </div>
                <hr>
                <div class="mt-3">
                    <h6>Historique des réponses (${ticket.ticket_replies ? ticket.ticket_replies.length : 0})</h6>
                    <div class="bg-light p-3 rounded">
                        ${ticket.ticket_replies && ticket.ticket_replies.length > 0 ? 
                            ticket.ticket_replies.map(reply => `
                                <div class="d-flex align-items-start mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                        <i class="fas fa-headset text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <strong>${reply.user ? reply.user.name : 'Support'}</strong>
                                            <small class="text-muted">${new Date(reply.created_at).toLocaleString('fr-FR')}</small>
                                        </div>
                                        <p class="mb-0">${(reply.message || '').replace(/\n/g, '<br>')}</p>
                                    </div>
                                </div>
                            `).join('') : 
                            '<p class="text-muted mb-0">Aucune réponse pour le moment</p>'
                        }
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('ticketModal')).show();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors du chargement des détails: ' + error.message, 'error');
        });
}

function getPriorityLabel(priority) {
    const labels = {
        'urgent': 'Urgente',
        'high': 'Élevée',
        'medium': 'Moyenne',
        'low': 'Faible'
    };
    return labels[priority] || 'Moyenne';
}

function getStatusLabel(status) {
    const labels = {
        'open': 'Ouvert',
        'in_progress': 'En cours',
        'resolved': 'Résolu',
        'closed': 'Fermé'
    };
    return labels[status] || 'Ouvert';
}

function resolveTicket(ticketId) {
    if (confirm('Marquer ce ticket comme résolu ?')) {
        showLoading();
        
        fetch(`/admin/support/${ticketId}/resolve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la résolution: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de la résolution: ' + error.message, 'error');
        });
    }
}

function replyTicket(ticketId) {
    // Store the ticket ID for the reply
    window.currentTicketId = ticketId;
    
    // Clear the reply form
    document.getElementById('replyMessage').value = '';
    document.getElementById('markAsResolved').checked = false;
    
    // Show the reply modal
    new bootstrap.Modal(document.getElementById('replyModal')).show();
}

function sendReply() {
    const ticketId = window.currentTicketId;
    const message = document.getElementById('replyMessage').value;
    const markAsResolved = document.getElementById('markAsResolved').checked;

    if (!message) {
        showNotification('Le message de réponse ne peut pas être vide.', 'warning');
        return;
    }

    if (!ticketId) {
        showNotification('Erreur: ID du ticket non trouvé.', 'error');
        return;
    }

    showLoading();

    fetch(`/admin/support/${ticketId}/reply`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            message: message,
            mark_as_resolved: markAsResolved
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification(data.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('replyModal')).hide();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('Erreur lors de la réponse: ' + (data.message || 'Erreur inconnue'), 'error');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showNotification('Erreur lors de la réponse: ' + error.message, 'error');
    });
}

function deleteTicket(ticketId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?')) {
        showLoading();
        
        fetch(`/admin/support/${ticketId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la suppression: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de la suppression: ' + error.message, 'error');
        });
    }
}

// Recherche en temps réel
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filtrage par statut
document.getElementById('statusFilter').addEventListener('change', function(e) {
    filterTable();
});

// Filtrage par priorité
document.getElementById('priorityFilter').addEventListener('change', function(e) {
    filterTable();
});

function filterTable() {
    const selectedStatus = document.getElementById('statusFilter').value.toLowerCase();
    const selectedPriority = document.getElementById('priorityFilter').value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(5)'); // Colonne du statut
        const priorityCell = row.querySelector('td:nth-child(4)'); // Colonne de la priorité
        
        let showRow = true;
        
        if (statusCell && selectedStatus) {
            const statusText = statusCell.textContent.toLowerCase();
            if (!statusText.includes(selectedStatus)) {
                showRow = false;
            }
        }
        
        if (priorityCell && selectedPriority && showRow) {
            const priorityText = priorityCell.textContent.toLowerCase();
            if (!priorityText.includes(selectedPriority)) {
                showRow = false;
            }
        }
        
        row.style.display = showRow ? '' : 'none';
    });
}

// Knowledge Base Functions
function viewArticles(category) {
    showLoading();
    fetch(`/admin/knowledge-base/articles/${category}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            if (data.success) {
                showNotification(data.message, 'success');
                // You would typically display the articles in a modal or a new page
                // For now, we'll just show a notification
                console.log('Articles for category', category, data.articles);
            } else {
                showNotification('Erreur lors de la récupération des articles: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de la récupération des articles: ' + error.message, 'error');
        });
}

function createArticle() {
    showLoading();
    fetch('/admin/knowledge-base/create-article')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            if (data.success) {
                showNotification(data.message, 'success');
                // Redirect to the article creation form
                window.location.href = data.redirect_url;
            } else {
                showNotification('Erreur lors de la création de l\'article: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de la création de l\'article: ' + error.message, 'error');
        });
}

function createTicket() {
    // Load users for the dropdown
    showLoading();
    
    fetch('/admin/users/list')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            
            const userSelect = document.getElementById('ticketUser');
            userSelect.innerHTML = '<option value="">Sélectionner un client</option>';
            
            if (data.users && data.users.length > 0) {
                data.users.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.id;
                    option.textContent = `${user.name} (${user.email})`;
                    userSelect.appendChild(option);
                });
            }
            
            // Clear form
            document.getElementById('createTicketForm').reset();
            
            // Show modal
            new bootstrap.Modal(document.getElementById('createTicketModal')).show();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors du chargement des utilisateurs: ' + error.message, 'error');
        });
}

function saveTicket() {
    const userId = document.getElementById('ticketUser').value;
    const priority = document.getElementById('ticketPriority').value;
    const subject = document.getElementById('ticketSubject').value;
    const message = document.getElementById('ticketMessage').value;

    if (!userId || !priority || !subject || !message) {
        showNotification('Tous les champs sont obligatoires.', 'warning');
        return;
    }

    showLoading();

    fetch('/admin/support', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            user_id: userId,
            priority: priority,
            subject: subject,
            message: message,
            status: 'open'
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification(data.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('createTicketModal')).hide();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification('Erreur lors de la création du ticket: ' + (data.message || 'Erreur inconnue'), 'error');
        }
    })
    .catch(error => {
        hideLoading();
        console.error('Error:', error);
        showNotification('Erreur lors de la création du ticket: ' + error.message, 'error');
    });
}

function exportTickets() {
    showLoading();
    fetch('/admin/support/export')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.blob();
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'tickets_export_' + new Date().toISOString().slice(0, 10) + '.xlsx'; // Example filename
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
            hideLoading();
            showNotification('Tickets exportés avec succès!', 'success');
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de l\'exportation des tickets: ' + error.message, 'error');
        });
}
</script>
@endsection 