<div class="section-header">
    <h1 class="section-title">Support</h1>
    <p class="section-subtitle">Vos tickets de support</p>
    <div class="section-actions">
        <a href="{{ route('support.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Nouveau ticket
        </a>
        <a href="{{ route('support.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-list me-2"></i>
            Voir tous les tickets
        </a>
    </div>
</div>

@if($supportTickets->count() > 0)
    <div class="grid">
        @foreach($supportTickets->take(3) as $ticket)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ticket #{{ $ticket->id }}</h3>
                    <div class="card-status">
                        @switch($ticket->status)
                            @case('open')
                                <span class="badge badge-primary">En attente</span>
                                @break
                            @case('in_progress')
                                <span class="badge badge-warning">En cours</span>
                                @break
                            @case('resolved')
                                <span class="badge badge-success">Résolu</span>
                                @break
                            @case('closed')
                                <span class="badge badge-secondary">Fermé</span>
                                @break
                            @default
                                <span class="badge badge-primary">En attente</span>
                        @endswitch
                    </div>
                </div>
                <div class="card-meta">
                    <strong>Sujet:</strong> {{ $ticket->subject }}<br>
                    <strong>Date:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}
                </div>
                <p class="card-description">{{ Str::limit($ticket->message, 100) }}</p>
                <div class="card-actions">
                    <a href="{{ route('support.show', $ticket->uuid) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        Voir Détails
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($supportTickets->count() > 3)
        <div class="text-center mt-4">
            <a href="{{ route('support.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-list me-2"></i>
                Voir tous les tickets ({{ $supportTickets->count() }})
            </a>
        </div>
    @endif
@else
    <div class="empty-state">
        <div class="empty-state-icon">🛠️</div>
        <h3>Aucun ticket de support</h3>
        <p>Vous n'avez pas encore créé de ticket de support.</p>
        <div class="empty-state-actions">
            <a href="{{ route('support.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Créer votre premier ticket
            </a>
            <a href="{{ route('support.knowledge-base') }}" class="btn btn-outline-primary">
                <i class="fas fa-book me-2"></i>
                Consulter la base de connaissances
            </a>
        </div>
    </div>
@endif 