@extends('layouts.dashboard')

@section('title', 'Support - Mes Tickets')

@section('content')
<div class="dashboard-content">
    <div class="container">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="header-title">
                            <i class="fas fa-headset me-3"></i>
                            Support Client
                        </h1>
                        <p class="text-muted">Gérez vos demandes d'assistance</p>
                    </div>
                    <a href="{{ route('support.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Nouveau ticket
                    </a>
                </div>
            </div>
        </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                    </div>
                    <h3 class="text-primary">{{ $stats['total'] }}</h3>
                    <p class="text-muted mb-0">Total tickets</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                    <h3 class="text-warning">{{ $stats['open'] }}</h3>
                    <p class="text-muted mb-0">En attente</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-comments fa-2x text-info"></i>
                    </div>
                    <h3 class="text-info">{{ $stats['in_progress'] }}</h3>
                    <p class="text-muted mb-0">En cours</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                    <h3 class="text-success">{{ $stats['resolved'] }}</h3>
                    <p class="text-muted mb-0">Résolus</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets List -->
    <div class="dashboard-card">
        <div class="card-header">
            <h5><i class="fas fa-list me-2"></i> Mes Tickets de Support</h5>
        </div>
        <div class="card-body">
            @if($tickets->count() > 0)
                <div class="table-responsive">
                                            <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sujet</th>
                                <th>Catégorie</th>
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
                                        <span class="ticket-id">#{{ $ticket->id }}</span>
                                    </td>
                                    <td>
                                        <div class="ticket-subject">{{ $ticket->subject }}</div>
                                        <small class="text-muted">{{ Str::limit($ticket->message, 60) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">{{ ucfirst($ticket->category) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->priority_badge }}">{{ $ticket->priority_label }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $ticket->status_badge }}">{{ $ticket->status_label }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $ticket->replies->count() }}</span>
                                    </td>
                                    <td>
                                        <div class="ticket-date">
                                            <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $ticket->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('support.show', $ticket->uuid) }}" 
                                               class="btn btn-outline-primary btn-sm" 
                                               title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($ticket->status !== 'closed' && $ticket->status !== 'resolved')
                                                <a href="{{ route('support.show', $ticket->uuid) }}#reply" 
                                                   class="btn btn-outline-info btn-sm" 
                                                   title="Répondre">
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tickets->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-headset fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun ticket de support</h5>
                        <p class="text-muted mb-4">Vous n'avez pas encore créé de ticket de support.</p>
                        <a href="{{ route('support.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Créer votre premier ticket
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>

@endsection 