@extends('layouts.admin')

@section('title', 'Gestion des produits')

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-box"></i>
                Gestion des produits
            </h1>
            <p class="page-subtitle">Gérez tous les produits et abonnements IPTV</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="openAddModal()">
                <i class="fas fa-plus me-2"></i>
                Nouveau produit
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
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_products']) }}</h3>
                <p>Total produits</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['active_products']) }}</h3>
                <p>Actifs</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-pause"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['paused_products']) }}</h3>
                <p>En pause</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['monthly_sales']) }}</h3>
                <p>Ventes ce mois</p>
            </div>
        </div>
    </div>
</div>

<!-- Products Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Liste des produits
        </h5>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;" id="categoryFilter">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                <option value="{{ $category->uuid }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher un produit..." id="searchInput">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Produit</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Statut</th>
                    <th>Ventes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $product->id }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->title }}" 
                                         class="product-thumbnail">
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-tv text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">{{ $product->title }}</div>
                                <small class="text-muted">{{ $product->type ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            <i class="fas fa-tag me-1"></i>
                            {{ $product->category->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-bold text-success">€{{ number_format($product->price, 2) }}</div>
                        @if($product->price_old && $product->price_old > $product->price)
                        <small class="text-muted">Prix original: €{{ number_format($product->price_old, 2) }}</small>
                        @endif
                    </td>
                    <td>
                        @if($product->status === 'active')
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Actif
                        </span>
                        @elseif($product->status === 'paused')
                        <span class="badge badge-warning">
                            <i class="fas fa-pause me-1"></i>
                            En pause
                        </span>
                        @else
                        <span class="badge badge-secondary">
                            <i class="fas fa-times me-1"></i>
                            Inactif
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">{{ $product->subscriptions_count ?? 0 }}</div>
                            <small>ventes</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewProduct('{{ $product->uuid }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editProduct('{{ $product->uuid }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteProduct('{{ $product->uuid }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-box fa-3x mb-3"></i>
                        <p>Aucun produit trouvé</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Product Details Modal -->
<div class="modal fade" id="productDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-box"></i>
                    Détails du produit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="productModalContent">
                    <!-- Contenu dynamique -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning" id="editFromDetailsBtn">Modifier</button>
            </div>
        </div>
    </div>
</div>

<script>
// Variable globale pour l'UUID du produit en cours d'édition
let currentProductUuid = null;

// Fonctions pour la gestion des produits
function viewProduct(productUuid) {
    currentProductUuid = productUuid;
    showLoading();
    
    fetch(`/admin/products/${productUuid}`)
        .then(response => response.json())
        .then(data => {
            hideLoading();
            document.getElementById('productModalContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations du produit</h6>
                        <p><strong>Nom:</strong> ${data.product.title}</p>
                        <p><strong>Catégorie:</strong> ${data.product.category?.name || 'N/A'}</p>
                        <p><strong>Prix:</strong> €${parseFloat(data.product.price).toFixed(2)}</p>
                        <p><strong>Statut:</strong> ${data.product.status}</p>
                        <p><strong>Type:</strong> ${data.product.type || 'N/A'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques</h6>
                        <p><strong>Ventes totales:</strong> ${data.stats.total_sales}</p>
                        <p><strong>Ventes ce mois:</strong> ${data.stats.monthly_sales}</p>
                        <p><strong>Revenus totaux:</strong> €${parseFloat(data.stats.total_revenue).toFixed(2)}</p>
                        <p><strong>Note moyenne:</strong> ${data.stats.average_rating}/5</p>
                    </div>
                </div>
                <hr>
                <div class="mt-3">
                    <h6>Description</h6>
                    <div class="bg-light p-3 rounded">
                        <p>${data.product.description || 'Aucune description disponible.'}</p>
                    </div>
                </div>
                ${data.product.product_options && data.product.product_options.length > 0 ? `
                <hr>
                <div class="mt-3">
                    <h6>Options du produit</h6>
                    <div class="row">
                        ${data.product.product_options.map(option => `
                        <div class="col-md-6 mb-2">
                            <div class="bg-light p-2 rounded">
                                <strong>${option.name}</strong> - €${parseFloat(option.price).toFixed(2)}
                            </div>
                        </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}
            `;
            
            new bootstrap.Modal(document.getElementById('productDetailsModal')).show();
        })
        .catch(error => {
            hideLoading();
            showNotification('Erreur lors du chargement des détails', 'error');
        });
}



function deleteProduct(productUuid) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        showLoading();
        
        fetch(`/admin/products/${productUuid}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showNotification('Produit supprimé avec succès', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            hideLoading();
            showNotification('Erreur lors de la suppression', 'error');
        });
    }
}

// Gestionnaire pour le bouton "Modifier" dans le modal de détails
document.getElementById('editFromDetailsBtn').addEventListener('click', function() {
    if (currentProductUuid) {
        bootstrap.Modal.getInstance(document.getElementById('productDetailsModal')).hide();
        editProduct(currentProductUuid);
    }
});

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

// Filtre par catégorie
document.getElementById('categoryFilter').addEventListener('change', function(e) {
    const selectedCategory = e.target.value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (!selectedCategory) {
            row.style.display = '';
            return;
        }
        
        const categoryCell = row.querySelector('td:nth-child(3)');
        if (categoryCell && categoryCell.textContent.includes(selectedCategory)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Fonction pour ouvrir la page d'ajout
function openAddModal() {
    window.location.href = '/admin/products/create';
}

// Fonction pour modifier un produit
function editProduct(productUuid) {
    window.location.href = `/admin/products/${productUuid}/edit`;
}
</script>



@endsection 