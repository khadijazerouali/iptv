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
            <button class="btn btn-primary" onclick="createOrder()">
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
                <h3>{{ number_format($stats['total_orders']) }}</h3>
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
                <h3>{{ number_format($stats['paid_orders']) }}</h3>
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
                <h3>{{ number_format($stats['pending_orders']) }}</h3>
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
                <h3>€{{ number_format($stats['total_revenue'], 2) }}</h3>
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
                <option value="pending">En attente</option>
                <option value="active">En cours</option>
                <option value="cancelled">Annulées</option>
                <option value="completed">Terminées</option>
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
                @forelse($orders as $order)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $loop->iteration }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">{{ $order->user->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ strip_tags($order->product->title ?? 'N/A') }}</div>
                    </td>
                    <td>
                        <div class="fw-bold text-success">€{{ number_format($order->total_paid ?? 0, 2) }}</div>
                        <small class="text-muted">{{ $order->payments->first()->payment_method ?? 'N/A' }}</small>
                    </td>
                    <td>
                        @php
                            $statusConfig = [
                                'pending' => ['class' => 'warning', 'icon' => 'clock', 'label' => 'En attente'],
                                'active' => ['class' => 'success', 'icon' => 'play', 'label' => 'En cours'],
                                'cancelled' => ['class' => 'danger', 'icon' => 'times', 'label' => 'Annulée'],
                                'completed' => ['class' => 'info', 'icon' => 'check', 'label' => 'Terminée']
                            ];
                            $status = $order->status ?? 'pending';
                            $config = $statusConfig[$status] ?? $statusConfig['pending'];
                        @endphp
                        <span class="badge badge-{{ $config['class'] }}">
                            <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                            {{ $config['label'] }}
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div>{{ $order->created_at->format('d/m/Y') }}</div>
                            <small>{{ $order->created_at->format('H:i') }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewOrder('{{ $order->uuid }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="activateOrder('{{ $order->uuid }}')">
                                <i class="fas fa-play"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteOrder('{{ $order->uuid }}')" data-confirm="Êtes-vous sûr de vouloir supprimer cette commande ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>Aucune commande trouvée</p>
                    </td>
                </tr>
                @endforelse
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
function createOrder() {
    // Récupérer les utilisateurs et produits disponibles
    fetch('/admin/users')
        .then(response => response.text())
        .then(html => {
            document.getElementById('orderModalContent').innerHTML = `
                <form id="createOrderForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="user_id" class="form-label">Client</label>
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="">Sélectionner un client</option>
                                    <option value="1">Client 1</option>
                                    <option value="2">Client 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="product_uuid" class="form-label">Produit</label>
                                <select class="form-select" id="product_uuid" name="product_uuid" required>
                                    <option value="">Sélectionner un produit</option>
                                    <option value="uuid1">Produit 1</option>
                                    <option value="uuid2">Produit 2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantité</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Statut</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="pending">En attente</option>
                                    <option value="cancelled">Annulée</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                    </div>
                </form>
            `;
            
            // Changer le titre et les boutons du modal
            document.querySelector('#orderModal .modal-title').innerHTML = '<i class="fas fa-plus"></i> Nouvelle commande';
            document.querySelector('#orderModal .modal-footer').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveNewOrder()">Créer</button>
            `;
            
            new bootstrap.Modal(document.getElementById('orderModal')).show();
        });
}

function saveNewOrder() {
    const form = document.getElementById('createOrderForm');
    const formData = new FormData(form);
    
    const data = {
        user_id: formData.get('user_id'),
        product_uuid: formData.get('product_uuid'),
        start_date: formData.get('start_date'),
        end_date: formData.get('end_date'),
        quantity: formData.get('quantity'),
        status: formData.get('status'),
        note: formData.get('note')
    };
    
    showLoading();
    
    fetch('/admin/orders', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification(data.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Erreur lors de la création', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showNotification('Erreur lors de la création', 'error');
        console.error('Error:', error);
    });
}

function viewOrder(orderId) {
    showLoading();
    
    fetch(`/admin/orders/${orderId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            
            // Déterminer le statut actuel
            const currentStatus = data.order.status || 'pending';
            const statusOptions = {
                'pending': { label: 'En attente', class: 'warning', icon: 'clock' },
                'active': { label: 'En cours', class: 'success', icon: 'play' },
                'cancelled': { label: 'Annulée', class: 'danger', icon: 'times' },
                'completed': { label: 'Terminée', class: 'info', icon: 'check' }
            };
            
            // Afficher les champs spécifiques à l'application
            const appSpecificFields = [];
            if (data.iptvConfig && data.iptvConfig.device_id) appSpecificFields.push(`<li><strong>Device ID:</strong> <code>${data.iptvConfig.device_id}</code></li>`);
            if (data.iptvConfig && data.iptvConfig.device_key) appSpecificFields.push(`<li><strong>Device Key:</strong> <code>${data.iptvConfig.device_key}</code></li>`);
            if (data.iptvConfig && data.iptvConfig.otp_code) appSpecificFields.push(`<li><strong>OTP Code:</strong> <code>${data.iptvConfig.otp_code}</code></li>`);
            if (data.iptvConfig && data.iptvConfig.smart_stb_mac) appSpecificFields.push(`<li><strong>Smart STB MAC:</strong> <code>${data.iptvConfig.smart_stb_mac}</code></li>`);
            
            document.getElementById('orderModalContent').innerHTML = `
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-gradient-primary text-white">
                                <h5 class="mb-0">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Commande #${data.order.number_order || 'N/A'}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-user me-2"></i>Informations client
                                        </h6>
                                        <div class="mb-2">
                                            <strong>Nom:</strong> ${data.order.user ? data.order.user.name : 'N/A'}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Email:</strong> ${data.order.user ? data.order.user.email : 'N/A'}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Date de création:</strong> ${data.order.created_at ? new Date(data.order.created_at).toLocaleDateString('fr-FR') : 'N/A'}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-box me-2"></i>Détails produit
                                        </h6>
                                        <div class="mb-2">
                                            <strong>Produit:</strong> ${data.order.product ? data.order.product.title : 'N/A'}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Quantité:</strong> ${data.order.quantity || 1}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Période:</strong> ${data.order.start_date ? new Date(data.order.start_date).toLocaleDateString('fr-FR') : 'N/A'} 
                                            ${data.order.end_date ? ' - ' + new Date(data.order.end_date).toLocaleDateString('fr-FR') : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-gradient-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-chart-line me-2"></i>Statistiques
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Total payé:</span>
                                        <strong class="text-success">€${data.stats ? (parseFloat(data.stats.total_paid) || 0).toFixed(2) : '0.00'}</strong>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Paiements:</span>
                                        <strong>${data.stats ? (parseInt(data.stats.payment_count) || 0) : 0}</strong>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Jours actifs:</span>
                                        <strong>${data.stats ? (parseInt(data.stats.days_active) || 0) : 0}</strong>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span>Statut paiement:</span>
                                        <span class="badge badge-${data.stats && data.stats.status === 'paid' ? 'success' : 'warning'}">
                                            ${data.stats && data.stats.status === 'paid' ? 'Payée' : 'En attente'}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-gradient-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-cog me-2"></i>Configuration IPTV
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-info mb-3">Informations de base</h6>
                                        <ul class="list-unstyled">
                                            <li class="mb-2"><strong>Durée:</strong> ${data.iptvConfig ? (data.iptvConfig.duration || 'N/A') : 'N/A'}</li>
                                            <li class="mb-2"><strong>Appareil:</strong> ${data.iptvConfig ? (data.iptvConfig.device || 'N/A') : 'N/A'}</li>
                                            <li class="mb-2"><strong>Application:</strong> ${data.iptvConfig ? (data.iptvConfig.application || 'N/A') : 'N/A'}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-info mb-3">Configuration spécifique à l'application</h6>
                                        <ul class="list-unstyled">
                                            ${appSpecificFields.length > 0 ? appSpecificFields.join('') : '<li class="text-muted"><em>Aucun champ spécifique requis</em></li>'}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-gradient-warning text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-edit me-2"></i>Gestion du statut
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="orderStatus" class="form-label">Statut actuel:</label>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-${statusOptions[currentStatus] ? statusOptions[currentStatus].class : 'secondary'} me-3">
                                                    <i class="fas fa-${statusOptions[currentStatus] ? statusOptions[currentStatus].icon : 'question'} me-1"></i>
                                                    ${statusOptions[currentStatus] ? statusOptions[currentStatus].label : 'Inconnu'}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="orderStatus" class="form-label">Changer le statut:</label>
                                            <select class="form-select" id="orderStatus">
                                                <option value="pending" ${currentStatus === 'pending' ? 'selected' : ''}>En attente</option>
                                                <option value="active" ${currentStatus === 'active' ? 'selected' : ''}>En cours</option>
                                                <option value="cancelled" ${currentStatus === 'cancelled' ? 'selected' : ''}>Annulée</option>
                                                <option value="completed" ${currentStatus === 'completed' ? 'selected' : ''}>Terminée</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                ${data.order.note ? `
                                <div class="mt-3">
                                    <label class="form-label">Note:</label>
                                    <div class="bg-light p-3 rounded">
                                        ${data.order.note}
                                    </div>
                                </div>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Changer le titre et les boutons du modal
            document.querySelector('#orderModal .modal-title').innerHTML = '<i class="fas fa-eye"></i> Détails de la commande';
            document.querySelector('#orderModal .modal-footer').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="updateOrderStatus('${orderId}')">
                    <i class="fas fa-save me-1"></i>Mettre à jour
                </button>
            `;
            
            new bootstrap.Modal(document.getElementById('orderModal')).show();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors du chargement des données: ' + error.message, 'error');
        });
}

function updateOrderStatus(orderId) {
    const newStatus = document.getElementById('orderStatus').value;
    
    showLoading();
    
    fetch(`/admin/orders/${orderId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            status: newStatus
        })
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification('Statut mis à jour avec succès', 'success');
            bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Erreur lors de la mise à jour', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showNotification('Erreur lors de la mise à jour', 'error');
        console.error('Error:', error);
    });
}

function activateOrder(orderId) {
    showLoading();
    
    fetch(`/admin/orders/${orderId}/activate`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification(data.message, 'success');
            bootstrap.Modal.getInstance(document.getElementById('orderModal')).hide();
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('Erreur lors de l\'activation', 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showNotification('Erreur lors de l\'activation', 'error');
        console.error('Error:', error);
    });
}

function deleteOrder(orderId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')) {
        showLoading();
        
        fetch(`/admin/orders/${orderId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification('Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            showNotification('Erreur lors de la suppression', 'error');
            console.error('Error:', error);
        });
    }
}

// Recherche en temps réel
document.querySelector('input[placeholder="Rechercher une commande..."]').addEventListener('input', function(e) {
    filterTable();
});

// Filtrage par statut
document.querySelector('select[style="width: auto;"]').addEventListener('change', function(e) {
    filterTable();
});

function filterTable() {
    const searchTerm = document.querySelector('input[placeholder="Rechercher une commande..."]').value.toLowerCase();
    const selectedStatus = document.querySelector('select[style="width: auto;"]').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const statusCell = row.querySelector('td:nth-child(5)'); // Colonne du statut
        const statusText = statusCell ? statusCell.textContent.trim() : '';
        
        const matchesSearch = text.includes(searchTerm);
        const matchesStatus = !selectedStatus || 
            (selectedStatus === 'pending' && statusText.includes('En attente')) ||
            (selectedStatus === 'active' && statusText.includes('En cours')) ||
            (selectedStatus === 'cancelled' && statusText.includes('Annulée')) ||
            (selectedStatus === 'completed' && statusText.includes('Terminée'));
        
        if (matchesSearch && matchesStatus) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection 