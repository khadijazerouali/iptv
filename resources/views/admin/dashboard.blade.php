@extends('layouts.admin')

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

<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard Admin
            </h1>
            <p class="page-subtitle">Vue d'ensemble de votre plateforme IPTV</p>
        </div>
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="refreshStats()">
                <i class="fas fa-sync-alt"></i>
                Actualiser
            </button>
            <button class="btn btn-outline-primary">
                <i class="fas fa-download"></i>
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
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_users']) }}</h3>
                <p>Total utilisateurs</p>
                <small class="text-success">+{{ $stats['new_users_this_month'] }} ce mois</small>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_orders']) }}</h3>
                <p>Total commandes</p>
                <small class="text-success">+{{ $stats['new_orders_this_month'] }} ce mois</small>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-euro-sign"></i>
            </div>
            <div class="stat-details">
                <h3>€{{ number_format($stats['total_revenue'], 2) }}</h3>
                <p>Chiffre d'affaires</p>
                <small class="text-info">Total des paiements</small>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_products']) }}</h3>
                <p>Produits actifs</p>
                <small class="text-primary">En ligne</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="charts-grid">
    <div class="admin-card slide-in">
        <div class="table-header">
            <h5>
                <i class="fas fa-chart-line"></i>
                Commandes mensuelles
            </h5>
        </div>
        <div class="p-3">
            <canvas id="ordersChart" width="400" height="200"></canvas>
        </div>
    </div>
    
    <div class="admin-card slide-in">
        <div class="table-header">
            <h5>
                <i class="fas fa-chart-bar"></i>
                Revenus mensuels
            </h5>
        </div>
        <div class="p-3">
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Recent Data Section -->
<div class="recent-data-grid">
    <div class="admin-card slide-in">
        <div class="table-header">
            <h5>
                <i class="fas fa-clock"></i>
                Dernières commandes
            </h5>
            <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary btn-sm">
                Voir tout
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Produit</th>
                        <th>Montant</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $order->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $order->product->title ?? 'N/A' }}</div>
                            <small class="text-muted">{{ $order->number_order }}</small>
                        </td>
                        <td>
                            <div class="fw-bold text-success fs-6">
                                @if($order->hasPromoCode())
                                    <div class="price-breakdown">
                                        <div class="original-price">
                                            <span class="text-muted text-decoration-line-through small">
                                                €{{ number_format($order->original_price, 2) }}
                                            </span>
                                        </div>
                                        <div class="final-price">
                                            €{{ number_format($order->final_price, 2) }}
                                        </div>
                                        <div class="discount-info">
                                            <small class="text-success">
                                                <i class="fas fa-tag me-1"></i>
                                                {{ $order->promo_code }}
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    €{{ number_format($order->product->price ?? 0, 2) }}
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-muted">
                                <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                <small>{{ $order->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Aucune commande récente
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="admin-card slide-in">
        <div class="table-header">
            <h5>
                <i class="fas fa-user-plus"></i>
                Nouveaux utilisateurs
            </h5>
            <a href="{{ route('admin.users') }}" class="btn btn-outline-primary btn-sm">
                Voir tout
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2 me-2">
                                    <i class="fas fa-user text-success"></i>
                                </div>
                                <div class="fw-semibold">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>
                            <small class="text-muted">{{ $user->email }}</small>
                        </td>
                        <td>
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Actif
                            </span>
                        </td>
                        <td>
                            <div class="text-muted">
                                <div>{{ $user->created_at->format('d/m/Y') }}</div>
                                <small>{{ $user->created_at->format('H:i') }}</small>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Aucun nouvel utilisateur
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Popular Products Section -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-star"></i>
            Produits les plus populaires
        </h5>
        <a href="{{ route('admin.products') }}" class="btn btn-outline-primary btn-sm">
            Voir tout
        </a>
    </div>
    <div class="popular-products-grid">
        @forelse($popularProducts as $product)
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                        <i class="fas fa-box text-primary"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $product->title }}</h6>
                        <small class="text-muted">{{ $product->category->name ?? 'N/A' }}</small>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="fw-bold text-success">€{{ number_format($product->price, 2) }}</div>
                        <small class="text-muted">{{ $product->subscriptions_count }} ventes</small>
                    </div>
                    <span class="badge badge-primary">
                        <i class="fas fa-fire me-1"></i>
                        Populaire
                    </span>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-4">
            <i class="fas fa-box fa-3x mb-3"></i>
            <p>Aucun produit populaire pour le moment</p>
        </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Données pour les graphiques
const ordersData = @json($monthlyOrders);
const revenueData = @json($monthlyRevenue);

// Graphique des commandes
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
    type: 'line',
    data: {
        labels: ordersData.map(item => {
            const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
            return months[item.month - 1];
        }),
        datasets: [{
            label: 'Commandes',
            data: ordersData.map(item => item.count),
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Graphique des revenus
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'bar',
    data: {
        labels: revenueData.map(item => {
            const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
            return months[item.month - 1];
        }),
        datasets: [{
            label: 'Revenus (€)',
            data: revenueData.map(item => item.total),
            backgroundColor: '#28a745',
            borderColor: '#28a745',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function refreshStats() {
    showLoading();
    setTimeout(() => {
        hideLoading();
        showNotification('Statistiques actualisées', 'success');
        location.reload();
    }, 1000);
}
</script>
@endsection 