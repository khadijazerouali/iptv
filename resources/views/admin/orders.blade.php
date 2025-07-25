@extends('layouts.admin')

@section('title', 'Gestion des commandes')

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-shopping-cart"></i>
                Gestion des commandes
            </h1>
            <p class="page-subtitle">Gérez toutes les commandes et abonnements</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="showNotification('Fonctionnalité en cours de développement', 'info')">
                <i class="fas fa-plus me-2"></i>
                Nouvelle commande
            </button>
            <button class="btn btn-outline-primary">
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
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-details">
                <h3>1,234</h3>
                <p>Total commandes</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <h3>987</h3>
                <p>Payées</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-details">
                <h3>156</h3>
                <p>En attente</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-euro-sign"></i>
            </div>
            <div class="stat-details">
                <h3>€45,678</h3>
                <p>Chiffre d'affaires</p>
            </div>
        </div>
    </div>
</div>

<!-- Orders Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Liste des commandes
        </h5>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Tous les statuts</option>
                <option value="paid">Payées</option>
                <option value="pending">En attente</option>
                <option value="cancelled">Annulées</option>
            </select>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher une commande...">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Produit</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#1001</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">Jean Dupont</div>
                                <small class="text-muted">jean.dupont@email.com</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">Abonnement Premium 1 Mois</div>
                        <small class="text-muted">IPTV Smarters Pro</small>
                    </td>
                    <td>
                        <div class="fw-bold text-success">€19.99</div>
                        <small class="text-muted">PayPal</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Payée
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div>Aujourd'hui</div>
                            <small>14:30</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewOrder(1001)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="activateOrder(1001)">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir annuler cette commande ?">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#1002</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">Marie Martin</div>
                                <small class="text-muted">marie.martin@email.com</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">Abonnement Premium 1 An</div>
                        <small class="text-muted">IPTV Smarters Pro</small>
                    </td>
                    <td>
                        <div class="fw-bold text-success">€199.99</div>
                        <small class="text-muted">PayPal</small>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock me-1"></i>
                            En attente
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div>Hier</div>
                            <small>09:15</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewOrder(1002)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="activateOrder(1002)">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir annuler cette commande ?">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#1003</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">Pierre Durand</div>
                                <small class="text-muted">pierre.durand@email.com</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">Abonnement VIP À Vie</div>
                        <small class="text-muted">IPTV Smarters Pro</small>
                    </td>
                    <td>
                        <div class="fw-bold text-success">€499.99</div>
                        <small class="text-muted">PayPal</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Payée
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div>Il y a 2 jours</div>
                            <small>16:45</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewOrder(1003)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="activateOrder(1003)">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir annuler cette commande ?">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-shopping-cart"></i>
                    Détails de la commande
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="orderModalContent">
                    <!-- Contenu dynamique -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success">Activer</button>
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la gestion des commandes
function viewOrder(orderId) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        document.getElementById('orderModalContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informations de la commande</h6>
                    <p><strong>Numéro:</strong> #${orderId}</p>
                    <p><strong>Client:</strong> Jean Dupont</p>
                    <p><strong>Email:</strong> jean.dupont@email.com</p>
                    <p><strong>Statut:</strong> Payée</p>
                </div>
                <div class="col-md-6">
                    <h6>Détails du produit</h6>
                    <p><strong>Produit:</strong> Abonnement Premium 1 Mois</p>
                    <p><strong>Prix:</strong> €19.99</p>
                    <p><strong>Méthode de paiement:</strong> PayPal</p>
                    <p><strong>Date:</strong> Aujourd'hui à 14:30</p>
                </div>
            </div>
            <hr>
            <div class="mt-3">
                <h6>Configuration IPTV</h6>
                <div class="bg-light p-3 rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Informations de base</h6>
                            <ul class="list-unstyled">
                                <li><strong>Durée:</strong> 1 Mois</li>
                                <li><strong>Appareil:</strong> Android Smartphone</li>
                                <li><strong>Application:</strong> IPTV Smarters Pro</li>
                                <li><strong>Chaînes:</strong> +5000</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">Configuration spécifique</h6>
                            <ul class="list-unstyled">
                                <li><strong>Device ID:</strong> <code>ABC123XYZ</code></li>
                                <li><strong>Device Key:</strong> <code>KEY456DEF</code></li>
                                <li><strong>OTP Code:</strong> <code>789GHI</code></li>
                                <li><strong>Smart STB MAC:</strong> <code>00:1B:44:11:3A:B7</code></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        new bootstrap.Modal(document.getElementById('orderModal')).show();
    }, 500);
}

function activateOrder(orderId) {
    showNotification('Commande activée avec succès', 'success');
}

// Recherche en temps réel
document.querySelector('input[placeholder="Rechercher une commande..."]').addEventListener('input', function(e) {
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
</script>
@endsection 