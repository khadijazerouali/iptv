@extends('layouts.admin')

@section('title', 'Support - Détails du Ticket')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-ticket-alt me-2"></i>
                Ticket #{{ $ticket->id }}
            </h1>
            <p class="text-muted">{{ $ticket->subject }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.support.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Ticket Details -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>
                            Détails du Ticket
                        </h6>
                        <div class="d-flex gap-2">
                            <span class="badge bg-{{ $ticket->status_badge }}">{{ $ticket->status_label }}</span>
                            <span class="badge bg-{{ $ticket->priority_badge }}">{{ $ticket->priority_label }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="ticket-content">
                        <div class="ticket-message">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-user me-2"></i>
                                Message initial de {{ $ticket->user->name }}
                            </h6>
                            <div class="message-content p-3 bg-light rounded">
                                {{ $ticket->message }}
                            </div>
                        </div>
                        <div class="ticket-footer mt-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Créé le {{ $ticket->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Replies -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-comments me-2"></i>
                        Réponses ({{ $ticket->replies->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($ticket->replies->count() > 0)
                        <div class="replies-container">
                            @foreach($ticket->replies as $reply)
                                <div class="reply-item {{ $reply->is_admin_reply ? 'admin-reply' : 'user-reply' }} mb-3 p-3 border rounded">
                                    <div class="reply-header mb-2">
                                        <div class="reply-author d-flex align-items-center">
                                            <div class="author-avatar me-3">
                                                <i class="fas {{ $reply->is_admin_reply ? 'fa-user-shield text-success' : 'fa-user text-primary' }}"></i>
                                            </div>
                                            <div class="author-info">
                                                <div class="author-name fw-semibold">
                                                    {{ $reply->user->name }}
                                                    @if($reply->is_admin_reply)
                                                        <span class="badge bg-success ms-2">Support</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">
                                                    {{ $reply->created_at->format('d/m/Y à H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reply-content">
                                        {{ $reply->message }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                            <p class="text-muted">Aucune réponse pour le moment</p>
                        </div>
                    @endif

                    <!-- Reply Form -->
                    @if($ticket->status !== 'closed')
                        <div class="reply-form-container mt-4" id="reply">
                            <hr class="my-4">
                            <h6 class="mb-3">
                                <i class="fas fa-reply me-2"></i>
                                Répondre au ticket
                            </h6>
                            <form action="{{ route('admin.support.reply', $ticket->uuid) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              name="message" 
                                              rows="4"
                                              placeholder="Tapez votre réponse ici..."
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status" class="form-label">Changer le statut (optionnel)</label>
                                    <select class="form-select" name="status">
                                        <option value="">Garder le statut actuel</option>
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>En attente</option>
                                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>En cours</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Résolu</option>
                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Fermé</option>
                                    </select>
                                </div>
                                <div class="form-actions mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane me-2"></i>
                                        Envoyer la réponse
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="alert alert-warning">
                                <i class="fas fa-lock me-2"></i>
                                Ce ticket est fermé. Vous ne pouvez plus y répondre.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Ticket Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info me-2"></i>
                        Informations
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Statut</span>
                        <span class="badge bg-{{ $ticket->status_badge }}">{{ $ticket->status_label }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Priorité</span>
                        <span class="badge bg-{{ $ticket->priority_badge }}">{{ $ticket->priority_label }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Catégorie</span>
                        <span class="text-muted">{{ ucfirst($ticket->category) }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Client</span>
                        <span class="text-muted">{{ $ticket->user->name }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Email</span>
                        <span class="text-muted">{{ $ticket->user->email }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Créé le</span>
                        <span class="text-muted">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">Dernière mise à jour</span>
                        <span class="text-muted">{{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>
                        Actions Rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.support.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>
                            Voir tous les tickets
                        </a>
                        @if($ticket->status !== 'closed')
                            <form action="{{ route('admin.support.update-status', $ticket->uuid) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="fas fa-check me-2"></i>
                                    Marquer comme résolu
                                </button>
                            </form>
                            <form action="{{ route('admin.support.update-status', $ticket->uuid) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="closed">
                                <button type="submit" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-times me-2"></i>
                                    Fermer le ticket
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 