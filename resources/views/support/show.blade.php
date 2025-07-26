@extends('layouts.main')

@section('title', 'Ticket #' . $ticket->id)

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('support.index') }}" class="text-decoration-none">
                            <i class="fas fa-headset me-1"></i>
                            Support
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Ticket #{{ $ticket->id }}
                    </li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold text-primary">
                <i class="fas fa-ticket-alt me-3"></i>
                {{ $ticket->subject }}
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('support.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour aux tickets
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <!-- Ticket Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Détails du ticket
                        </h5>
                        <div class="d-flex gap-2">
                            @switch($ticket->priority)
                                @case('urgent')
                                    <span class="badge bg-danger">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Urgente
                                    </span>
                                    @break
                                @case('high')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>
                                        Élevée
                                    </span>
                                    @break
                                @case('medium')
                                    <span class="badge bg-info">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Moyenne
                                    </span>
                                    @break
                                @case('low')
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-arrow-down me-1"></i>
                                        Faible
                                    </span>
                                    @break
                            @endswitch
                            
                            @switch($ticket->status)
                                @case('open')
                                    <span class="badge bg-primary">
                                        <i class="fas fa-folder-open me-1"></i>
                                        En attente
                                    </span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>
                                        En cours
                                    </span>
                                    @break
                                @case('resolved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Résolu
                                    </span>
                                    @break
                                @case('closed')
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-times-circle me-1"></i>
                                        Fermé
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Numéro :</strong> #{{ $ticket->id }}</p>
                            <p><strong>Créé le :</strong> {{ $ticket->created_at->format('d/m/Y à H:i') }}</p>
                            <p><strong>Jours ouverts :</strong> {{ $ticketStats['days_open'] }} jours</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Réponses :</strong> {{ $ticketStats['reply_count'] }}</p>
                            <p><strong>Dernière activité :</strong> 
                                @if($ticketStats['last_reply'])
                                    {{ $ticketStats['last_reply']->created_at->format('d/m/Y à H:i') }}
                                @else
                                    {{ $ticket->created_at->format('d/m/Y à H:i') }}
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6>Message initial :</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ nl2br(e($ticket->message)) }}</p>
                    </div>
                </div>
            </div>

            <!-- Replies -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Historique des réponses ({{ $ticketStats['reply_count'] }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($ticket->ticketReplies->count() > 0)
                        @foreach($ticket->ticketReplies->sortBy('created_at') as $reply)
                            <div class="d-flex mb-4">
                                <div class="flex-shrink-0">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong class="text-dark">
                                                @if($reply->user->id === $ticket->user_id)
                                                    Vous
                                                @else
                                                    Support technique
                                                @endif
                                            </strong>
                                            <small class="text-muted ms-2">
                                                {{ $reply->created_at->format('d/m/Y à H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="bg-light p-3 rounded">
                                        <p class="mb-0">{{ nl2br(e($reply->message)) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune réponse pour le moment</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Reply Form -->
            @if($ticket->status !== 'closed' && $ticket->status !== 'resolved')
                <div class="card border-0 shadow-sm" id="reply">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-reply me-2"></i>
                            Ajouter une réponse
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('support.reply', $ticket->uuid) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="message" class="form-label">Votre message</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="5" 
                                          placeholder="Tapez votre réponse..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Votre réponse sera visible par notre équipe de support
                                </small>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Envoyer la réponse
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Ce ticket est {{ $ticket->status === 'resolved' ? 'résolu' : 'fermé' }}. 
                    Si vous avez besoin d'aide supplémentaire, veuillez créer un nouveau ticket.
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        Actions
                    </h6>
                </div>
                <div class="card-body">
                    @if($ticket->status !== 'closed' && $ticket->status !== 'resolved')
                        <form action="{{ route('support.close', $ticket->uuid) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm w-100 mb-2" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir fermer ce ticket ?')">
                                <i class="fas fa-times me-2"></i>
                                Fermer le ticket
                            </button>
                        </form>
                    @endif
                    
                    <a href="{{ route('support.create') }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-plus me-2"></i>
                        Nouveau ticket
                    </a>
                </div>
            </div>

            <!-- Help -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle me-2"></i>
                        Besoin d'aide ?
                    </h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Consultez notre base de connaissances pour des solutions rapides.
                    </p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('support.knowledge-base') }}?category=depannage" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-tools me-2"></i>
                            Guide de dépannage
                        </a>
                        <a href="{{ route('support.knowledge-base') }}?category=installation" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-download me-2"></i>
                            Guides d'installation
                        </a>
                        <a href="{{ route('support.knowledge-base') }}?category=configuration" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-cog me-2"></i>
                            Configuration
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.badge {
    font-size: 0.75rem;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}
</style>

<script>
// Auto-resize textarea
document.getElementById('message').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Scroll to reply form if anchor is present
if (window.location.hash === '#reply') {
    document.getElementById('reply').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection 