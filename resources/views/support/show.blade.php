@extends('layouts.dashboard')

@section('title', 'Support - Détails du Ticket')

@section('content')
<div class="dashboard-content">
<div class="support-container">
    <!-- Header -->
    <div class="support-header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="support-title">
                    <i class="fas fa-ticket-alt me-3"></i>
                    Ticket #{{ $ticket->id }}
            </h1>
                <p class="support-subtitle">{{ $ticket->subject }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('support.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-arrow-left me-2"></i>
                    Retour aux tickets
                </a>
                @if($ticket->status !== 'closed')
                    <form action="{{ route('support.close', $ticket->uuid) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning" 
                                onclick="return confirm('Êtes-vous sûr de vouloir fermer ce ticket ?')">
                    <i class="fas fa-times me-2"></i>
                    Fermer le ticket
                </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

        <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Ticket Details -->
                <div class="support-card mb-4">
                    <div class="support-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-info-circle me-2"></i> Détails du Ticket</h5>
                        <div class="ticket-meta">
                            <span class="badge bg-{{ $ticket->status_badge }} me-2">{{ $ticket->status_label }}</span>
                            <span class="badge bg-{{ $ticket->priority_badge }}">{{ $ticket->priority_label }}</span>
                        </div>
                        </div>
                    </div>
                    <div class="support-card-body">
                    <div class="ticket-content">
                        <div class="ticket-message">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-user me-2"></i>
                                Message initial de {{ $ticket->user->name }}
                            </h6>
                            <div class="message-content">
                                {{ $ticket->message }}
                            </div>
                        </div>
                        <div class="ticket-footer">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                            Créé le {{ $ticket->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Replies -->
                <div class="support-card">
                    <div class="support-card-header">
                        <h5>
                            <i class="fas fa-comments me-2"></i>
                        Réponses ({{ $ticket->replies->count() }})
                        </h5>
                    </div>
                    <div class="support-card-body">
                    @if($ticket->replies->count() > 0)
                        <div class="replies-container">
                            @foreach($ticket->replies as $reply)
                                <div class="reply-item {{ $reply->is_admin_reply ? 'admin-reply' : 'user-reply' }}">
                                <div class="reply-header">
                                        <div class="reply-author">
                                            <div class="author-avatar">
                                                <i class="fas {{ $reply->is_admin_reply ? 'fa-user-shield' : 'fa-user' }}"></i>
                                            </div>
                                            <div class="author-info">
                                                <div class="author-name">
                                                    {{ $reply->user->name }}
                                                    @if($reply->is_admin_reply)
                                                        <span class="badge bg-primary ms-2">Support</span>
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
                        <div class="reply-form-container" id="reply">
                            <hr class="my-4">
                            <h6 class="mb-3">
                                <i class="fas fa-reply me-2"></i>
                                Ajouter une réponse
                            </h6>
                            <form action="{{ route('support.reply', $ticket->uuid) }}" method="POST" class="reply-form">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              name="message" 
                                              rows="4"
                                              placeholder="Tapez votre réponse ici..."
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
            <div class="support-card mb-4">
                <div class="support-card-header">
                    <h5><i class="fas fa-info me-2"></i> Informations</h5>
                </div>
                <div class="support-card-body">
                    <div class="info-item">
                        <label class="info-label">Statut</label>
                        <span class="badge bg-{{ $ticket->status_badge }}">{{ $ticket->status_label }}</span>
                    </div>
                        <div class="info-item">
                        <label class="info-label">Priorité</label>
                        <span class="badge bg-{{ $ticket->priority_badge }}">{{ $ticket->priority_label }}</span>
                            </div>
                    <div class="info-item">
                        <label class="info-label">Catégorie</label>
                        <span class="info-value">{{ ucfirst($ticket->category) }}</span>
                        </div>
                        <div class="info-item">
                        <label class="info-label">Créé par</label>
                        <span class="info-value">{{ $ticket->user->name }}</span>
                        </div>
                        <div class="info-item">
                        <label class="info-label">Date de création</label>
                        <span class="info-value">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="info-item">
                        <label class="info-label">Dernière mise à jour</label>
                        <span class="info-value">{{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                            </div>
                        </div>

            <!-- Quick Actions -->
            <div class="support-card">
                <div class="support-card-header">
                    <h5><i class="fas fa-bolt me-2"></i> Actions Rapides</h5>
                </div>
                <div class="support-card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('support.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>
                            Voir tous les tickets
                        </a>
                        <a href="{{ route('support.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-plus me-2"></i>
                            Nouveau ticket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
.support-container {
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.support-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.support-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.support-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin: 0.5rem 0 0 0;
}

.support-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.support-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem 2rem;
    border-bottom: none;
}

.support-card-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.2rem;
}

.support-card-body {
    padding: 2rem;
}

.ticket-message {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1rem;
}

.message-content {
    line-height: 1.6;
    color: #495057;
}

.ticket-footer {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
    margin-top: 1rem;
}

.reply-item {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid #667eea;
}

.admin-reply {
    border-left-color: #28a745;
    background: #f8fff9;
}

.user-reply {
    border-left-color: #667eea;
    background: #f8f9fa;
}

.reply-header {
    margin-bottom: 1rem;
}

.reply-author {
    display: flex;
    align-items: center;
}

.author-avatar {
    width: 40px;
    height: 40px;
    background: #667eea;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-right: 1rem;
}

.admin-reply .author-avatar {
    background: #28a745;
}

.author-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.25rem;
}

.reply-content {
    line-height: 1.6;
    color: #495057;
}

.reply-form-container {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
}

.reply-form .form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.reply-form .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #e9ecef;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #495057;
}

.info-value {
    color: #6c757d;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .support-container {
        padding: 1rem;
    }
    
    .support-title {
        font-size: 2rem;
    }
    
    .support-card-body {
        padding: 1rem;
    }
    
    .reply-author {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .author-avatar {
        margin-bottom: 0.5rem;
        margin-right: 0;
    }
}
</style>
@endsection 