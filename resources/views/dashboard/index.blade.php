@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('content')
<style>
.price-breakdown {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.price-breakdown .original-price {
    font-size: 0.85rem;
}

.price-breakdown .final-price {
    font-size: 1rem;
}

.price-breakdown .discount-info {
    font-size: 0.75rem;
    margin-top: 2px;
}

.price-breakdown .discount-info i {
    font-size: 0.7rem;
}
</style>

<!-- Overview Section -->
@if($section == 'overview')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card primary">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $stats['total_subscriptions'] }}</h3>
                    <p>Abonnements totaux</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-tv"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card success">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $stats['active_subscriptions'] }}</h3>
                    <p>Abonnements actifs</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card warning">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $stats['total_orders'] ?? 0 }}</h3>
                    <p>Commandes totales</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>
        
        <div class="stat-card info">
            <div class="stat-content">
                <div class="stat-details">
                    <h3>{{ $stats['total_products'] ?? 0 }}</h3>
                    <p>Produits disponibles</p>
                </div>
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Active Subscriptions -->
        <div class="col-md-6 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-tv"></i> Mes Abonnements Actifs</h5>
                </div>
                <div class="card-body">
                    @if($sectionData['activeSubscriptions']->count() > 0)
                        @foreach($sectionData['activeSubscriptions'] as $subscription)
                            <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-tv text-primary"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $subscription->product->title ?? 'Abonnement #' . $subscription->id }}</h6>
                                    <small class="text-muted">
                                        {{ $subscription->product->category->name ?? 'Catégorie' }} • 
                                        {{ $subscription->created_at->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-success">Actif</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-tv fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucun abonnement actif</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-md-6 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-history"></i> Activité Récente</h5>
                </div>
                <div class="card-body">
                    @if($sectionData['recentActivity']->count() > 0)
                        @foreach($sectionData['recentActivity'] as $activity)
                            <div class="d-flex align-items-center mb-3">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-{{ $activity['color'] }} bg-opacity-10 rounded-circle p-2">
                                        <i class="{{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                    <small class="text-muted">{{ $activity['description'] }}</small>
                                    <br>
                                    <small class="text-muted">{{ $activity['date']->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune activité récente</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-line"></i> Activité Mensuelle</h5>
                </div>
                <div class="card-body">
                    <canvas id="activityChart" height="100"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Prochaines Facturations -->
        <div class="col-md-4 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-calendar"></i> Prochaines Échéances</h5>
                </div>
                <div class="card-body">
                    @if($sectionData['upcomingBills']->count() > 0)
                        @foreach($sectionData['upcomingBills'] as $bill)
                            <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $bill->product->title ?? 'Abonnement' }}</h6>
                                    <small class="text-muted">
                                        Expire le : {{ $bill->end_date ? \Carbon\Carbon::parse($bill->end_date)->format('d/m/Y') : 'Date non définie' }}
                                    </small>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge bg-warning">À renouveler</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar fa-2x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Aucune échéance à venir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Profile Section -->
@if($section == 'profile')
    <div class="row">
        <div class="col-md-8">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-user"></i> Mon Profil</h5>
                </div>
                <div class="card-body">
                    <form id="profileForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $sectionData['user']->name }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $sectionData['user']->email }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $sectionData['user']->telephone }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ville" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="ville" name="ville" value="{{ $sectionData['user']->ville }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Sauvegarder les modifications
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Informations</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Membre depuis :</strong><br>
                        <span class="text-muted">{{ $sectionData['memberSince'] }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Dernière connexion :</strong><br>
                        <span class="text-muted">{{ $sectionData['lastLogin']->diffForHumans() }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Abonnements :</strong><br>
                        <span class="text-muted">{{ $sectionData['subscriptionCount'] }}</span>
                    </div>
                    <div class="mb-3">
                                        <strong>Commandes :</strong><br>
                <span class="text-muted">{{ $sectionData['orderCount'] ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Orders Section -->
@if($section == 'orders')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card primary">
                <div class="stat-content">
                    <div class="stat-details">
                        <h3>{{ $sectionData['subscriptions']->total() }}</h3>
                        <p>Total commandes</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card success">
                <div class="stat-content">
                    <div class="stat-details">
                        <h3>{{ number_format($sectionData['totalSpent'], 2) }} €</h3>
                        <p>Total dépensé</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-euro-sign"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card info">
                <div class="stat-content">
                    <div class="stat-details">
                        <h3>{{ number_format($sectionData['monthlySpending'], 2) }} €</h3>
                        <p>Ce mois</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <div class="table-header">
            <h5><i class="fas fa-list"></i> Mes Commandes</h5>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produit</th>
                        <th>Statut</th>
                        <th>Prix</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sectionData['subscriptions'] as $subscription)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">#{{ $subscription->number_order }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $subscription->product->title ?? 'Produit #' . $subscription->number_order }}</div>
                                <small class="text-muted">{{ $subscription->product->category->name ?? 'Catégorie' }}</small>
                            </td>
                            <td>
                                @switch($subscription->status)
                                    @case('active')
                                        <span class="badge bg-success">Actif</span>
                                        @break
                                    @case('pending')
                                        <span class="badge bg-warning">En attente</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge bg-danger">Annulé</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">{{ $subscription->status }}</span>
                                @endswitch
                            </td>
                            <td>
                                @if($subscription->hasPromoCode())
                                    <div class="price-breakdown">
                                        <div class="original-price">
                                            <span class="text-muted text-decoration-line-through">
                                                {{ number_format($subscription->original_price, 2) }}€
                                            </span>
                                        </div>
                                        <div class="final-price">
                                            <strong class="text-success">
                                                {{ number_format($subscription->final_price, 2) }}€
                                            </strong>
                                        </div>
                                        <div class="discount-info">
                                            <small class="text-success">
                                                <i class="fas fa-tag me-1"></i>
                                                Code {{ $subscription->promo_code }} 
                                                (-{{ number_format($subscription->discount_amount, 2) }}€)
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <strong>{{ number_format($subscription->product->price ?? 0, 2) }}€</strong>
                                @endif
                            </td>
                            <td>
                                <div class="text-muted">
                                    <div>{{ $subscription->created_at->format('d/m/Y') }}</div>
                                    <small>{{ $subscription->created_at->format('H:i') }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <button class="btn btn-outline-primary btn-sm" onclick="viewOrder('{{ $subscription->uuid }}')" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success btn-sm" onclick="downloadInvoice('{{ $subscription->uuid }}')" title="Facture">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                                <p class="text-muted mb-0">Aucune commande trouvée</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($sectionData['subscriptions']->hasPages())
            <div class="d-flex justify-content-center p-3">
                {{ $sectionData['subscriptions']->links() }}
            </div>
        @endif
    </div>
@endif

<!-- Support Section -->
@if($section == 'support')
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="dashboard-card">
                <div class="card-body text-center">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-ticket-alt fa-2x text-primary"></i>
                    </div>
                    <h3 class="text-primary">{{ $sectionData['ticketStats']['total'] ?? 0 }}</h3>
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
                    <h3 class="text-warning">{{ $sectionData['ticketStats']['open'] ?? 0 }}</h3>
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
                    <h3 class="text-info">{{ $sectionData['ticketStats']['in_progress'] ?? 0 }}</h3>
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
                    <h3 class="text-success">{{ $sectionData['ticketStats']['resolved'] ?? 0 }}</h3>
                    <p class="text-muted mb-0">Résolus</p>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5><i class="fas fa-headset me-2"></i> Mes Tickets de Support</h5>
                <a href="{{ route('support.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>
                    Nouveau ticket
                </a>
            </div>
        </div>
        <div class="card-body">
            @if(isset($sectionData['supportTickets']) && $sectionData['supportTickets']->count() > 0)
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Sujet</th>
                                <th>Catégorie</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sectionData['supportTickets'] as $ticket)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">#{{ $ticket->id }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $ticket->subject }}</div>
                                        <small class="text-muted">{{ Str::limit($ticket->message, 50) }}</small>
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
                                        <div class="text-muted">
                                            <div>{{ $ticket->created_at->format('d/m/Y') }}</div>
                                            <small>{{ $ticket->created_at->format('H:i') }}</small>
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

                @if($sectionData['supportTickets']->hasPages())
                    <div class="d-flex justify-content-center p-3">
                        {{ $sectionData['supportTickets']->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-4">
                    <i class="fas fa-headset fa-2x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Aucun ticket de support</p>
                    <a href="{{ route('support.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-2"></i>
                        Créer votre premier ticket
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif

<!-- Settings Section -->
@if($section == 'settings')
    <div class="row">
        <div class="col-md-8">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-cog"></i> Paramètres de Notifications</h5>
                </div>
                <div class="card-body">
                    <form id="settingsForm">
                        @csrf
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" checked>
                                <label class="form-check-label" for="email_notifications">
                                    Notifications par email
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications">
                                <label class="form-check-label" for="sms_notifications">
                                    Notifications par SMS
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="billing_reminders" name="billing_reminders" checked>
                                <label class="form-check-label" for="billing_reminders">
                                    Rappels de facturation
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" checked>
                            <label class="form-check-label" for="newsletter">
                                Newsletter et offres spéciales
                            </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Sauvegarder les paramètres
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5><i class="fas fa-shield-alt"></i> Sécurité</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('settings.password') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-key me-2"></i>
                            Changer le mot de passe
                        </a>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('settings.profile') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-user-edit me-2"></i>
                            Modifier le profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
// Chart initialization
document.addEventListener('DOMContentLoaded', function() {
    @if($section == 'overview' && isset($monthlyData))
        const ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyData['months']),
                datasets: [{
                    label: 'Abonnements',
                    data: @json($monthlyData['subscriptions']),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    tension: 0.4
                }, {
                    label: 'Paiements (€)',
                    data: @json($monthlyData['payments']),
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    @endif
});

// Profile form submission
document.getElementById('profileForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    showLoading();
    
    const formData = new FormData(this);
    
    fetch('/dashboard/profile/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification(data.message, 'success');
        } else {
            showNotification('Erreur lors de la mise à jour', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showNotification('Erreur de connexion', 'error');
    });
});

// Settings form submission
document.getElementById('settingsForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    showLoading();
    
    const formData = new FormData(this);
    
    fetch('/dashboard/settings/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification(data.message, 'success');
        } else {
            showNotification('Erreur lors de la mise à jour', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showNotification('Erreur de connexion', 'error');
    });
});

// View order function
function viewOrder(orderUuid) {
    window.location.href = `/order/${orderUuid}`;
}

// Download invoice function
function downloadInvoice(orderUuid) {
    showLoading();
    
    // Créer un lien temporaire pour télécharger le PDF
    const link = document.createElement('a');
    link.href = `/dashboard/orders/${orderUuid}/invoice`;
    link.download = `facture-${orderUuid}.pdf`;
    link.style.display = 'none';
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    hideLoading();
    showNotification('Facture téléchargée avec succès', 'success');
}
</script>
@endsection 