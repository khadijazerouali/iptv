@extends('layouts.main')

@section('title', 'Support - Mes tickets')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="display-5 fw-bold text-primary">
                <i class="fas fa-headset me-3"></i>
                Support et assistance
            </h1>
            <p class="lead text-muted">Gérez vos tickets de support et trouvez des solutions à vos problèmes</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('support.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>
                Nouveau ticket
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-primary mb-2">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h3 class="card-title text-primary">{{ $stats['total_tickets'] }}</h3>
                    <p class="card-text text-muted">Total tickets</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-warning mb-2">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="card-title text-warning">{{ $stats['open_tickets'] }}</h3>
                    <p class="card-text text-muted">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-info mb-2">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="card-title text-info">{{ $stats['in_progress_tickets'] }}</h3>
                    <p class="card-text text-muted">En cours</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-6 text-success mb-2">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="card-title text-success">{{ $stats['resolved_tickets'] }}</h3>
                    <p class="card-text text-muted">Résolus</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Knowledge Base Quick Access -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i>
                        Base de connaissances
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <a href="{{ route('support.knowledge-base') }}?category=installation" class="text-decoration-none">
                                <div class="p-3 rounded bg-light">
                                    <i class="fas fa-download fa-2x text-primary mb-2"></i>
                                    <h6>Installation</h6>
                                    <small class="text-muted">Guides d'installation</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <a href="{{ route('support.knowledge-base') }}?category=configuration" class="text-decoration-none">
                                <div class="p-3 rounded bg-light">
                                    <i class="fas fa-cog fa-2x text-success mb-2"></i>
                                    <h6>Configuration</h6>
                                    <small class="text-muted">Paramètres avancés</small>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <a href="{{ route('support.knowledge-base') }}?category=depannage" class="text-decoration-none">
                                <div class="p-3 rounded bg-light">
                                    <i class="fas fa-tools fa-2x text-warning mb-2"></i>
                                    <h6>Dépannage</h6>
                                    <small class="text-muted">Solutions aux problèmes</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Mes tickets de support
                </h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;" id="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="open">En attente</option>
                        <option value="in_progress">En cours</option>
                        <option value="resolved">Résolus</option>
                        <option value="closed">Fermés</option>
                    </select>
                    <div class="input-group" style="width: 300px;">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Rechercher un ticket..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Sujet</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Réponses</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ $ticket->id }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $ticket->subject }}</div>
                                    <small class="text-muted">{{ Str::limit($ticket->message, 50) }}</small>
                                </td>
                                <td>
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
                                        @default
                                            <span class="badge bg-info">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Moyenne
                                            </span>
                                    @endswitch
                                </td>
                                <td>
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
                                        @default
                                            <span class="badge bg-primary">
                                                <i class="fas fa-folder-open me-1"></i>
                                                En attente
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge bg-info">
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
                                        <a href="{{ route('support.show', $ticket->uuid) }}" class="btn btn-outline-primary btn-sm" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($ticket->status !== 'closed' && $ticket->status !== 'resolved')
                                        <a href="{{ route('support.show', $ticket->uuid) }}#reply" class="btn btn-outline-info btn-sm" title="Répondre">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($tickets->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3 bg-light">
                    <div class="pagination-info">
                        <i class="fas fa-info-circle me-1"></i>
                        Affichage de <strong>{{ $tickets->firstItem() ?? 0 }}</strong> à <strong>{{ $tickets->lastItem() ?? 0 }}</strong> sur <strong>{{ $tickets->total() }}</strong> résultats
                    </div>
                    <nav aria-label="Navigation des tickets">
                        {{ $tickets->links() }}
                    </nav>
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-ticket-alt fa-3x text-muted"></i>
                    </div>
                    <h5 class="text-muted">Aucun ticket de support</h5>
                    <p class="text-muted">Vous n'avez pas encore créé de ticket de support.</p>
                    <a href="{{ route('support.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Créer votre premier ticket
                    </a>
                </div>
            @endif
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

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.badge {
    font-size: 0.75rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>

<script>
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
    const selectedStatus = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(4)'); // Colonne du statut
        
        if (statusCell && selectedStatus) {
            const statusText = statusCell.textContent.toLowerCase();
            if (!statusText.includes(selectedStatus)) {
                row.style.display = 'none';
            } else {
                row.style.display = '';
            }
        } else {
            row.style.display = '';
        }
    });
});
</script>
@endsection 