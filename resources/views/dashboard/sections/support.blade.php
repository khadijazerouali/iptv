<div class="section-header">
    <h1 class="section-title">Support</h1>
    <p class="section-subtitle">Vos tickets de support</p>
</div>

@if($supportTickets->count() > 0)
    <div class="grid">
        @foreach($supportTickets as $ticket)
            <div class="card">
                <h3 class="card-title">Ticket #{{ $ticket->id }}</h3>
                <div class="card-meta">
                    <strong>Sujet:</strong> {{ $ticket->subject }}<br>
                    <strong>Status:</strong> {{ $ticket->status }}<br>
                    <strong>Date:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}
                </div>
                <p class="card-description">{{ Str::limit($ticket->message, 100) }}</p>
                <div style="margin-top: 1rem;">
                    <a href="#" class="btn">Voir Détails</a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">🛠️</div>
        <h3>Aucun ticket de support</h3>
        <p>Vous n'avez pas encore créé de ticket de support.</p>
    </div>
@endif 