@extends('layouts.admin')

@section('title', 'Gestion des catégories')

@section('content')
<div class="page-header fade-in">
    <h1 class="page-title">
        <i class="fas fa-tags"></i> Gestion des catégories
    </h1>
    <div class="page-actions">
        <button class="btn btn-primary" onclick="openAddModal()">
            <i class="fas fa-plus"></i> Nouvelle catégorie
        </button>
    </div>
</div>

<!-- Statistiques -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $stats['total_categories'] }}</h3>
            <p>Total catégories</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $stats['active_categories'] }}</h3>
            <p>Catégories actives</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $stats['categories_with_products'] }}</h3>
            <p>Avec produits</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $stats['total_products'] }}</h3>
            <p>Total produits</p>
        </div>
    </div>
</div>

<!-- Contenu principal -->
<div class="admin-container">
    <!-- Catégories populaires -->
    <div class="admin-card slide-in">
        <div class="card-header">
            <h5><i class="fas fa-star"></i> Catégories les plus populaires</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($popularCategories as $category)
                <div class="col-md-4 mb-3">
                    <div class="category-card">
                        <div class="category-info">
                            <h6>{{ $category->name }}</h6>
                            <p class="text-muted">{{ $category->products_count }} produits</p>
                        </div>
                        <div class="category-actions">
                            <button class="btn btn-sm btn-outline-primary" onclick="viewCategory('{{ $category->uuid }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Liste des catégories -->
    <div class="admin-card slide-in">
        <div class="table-header">
            <h5><i class="fas fa-list"></i> Toutes les catégories</h5>
            <div class="table-actions">
                <input type="text" class="form-control" id="searchInput" placeholder="Rechercher une catégorie..." onkeyup="filterCategories()">
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table admin-table" id="categoriesTable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Produits</th>
                        <th>Statut</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr data-category-id="{{ $category->uuid }}">
                        <td>
                            <div class="category-name">
                                @if($category->icon_url)
                                    <i class="{{ $category->icon_url }}"></i>
                                @endif
                                <span>{{ $category->name }}</span>
                            </div>
                        </td>
                        <td>{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <span class="badge bg-info">{{ $category->products_count }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">Active</span>
                        </td>
                        <td>{{ $category->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary" onclick="viewCategory('{{ $category->uuid }}')" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-warning" onclick="editCategory('{{ $category->uuid }}')" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory('{{ $category->uuid }}')" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pour voir une catégorie -->
<div class="modal fade" id="viewCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewCategoryContent">
                <!-- Contenu dynamique -->
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter/modifier une catégorie -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalTitle">Nouvelle catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <input type="hidden" id="categoryId">
                    
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Nom de la catégorie *</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="categoryIconUrl" class="form-label">Icône (classe CSS)</label>
                        <input type="text" class="form-control" id="categoryIconUrl" name="icon_url" placeholder="fas fa-tag">
                        <small class="form-text text-muted">Exemple: fas fa-tag, fas fa-star, etc.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection 

@push('scripts')
<script>
// Variables globales
let currentCategoryId = null;

// Fonctions pour les catégories
function viewCategory(uuid) {
    fetch(`/admin/categories/${uuid}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const category = data.category;
                const content = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Informations générales</h6>
                            <p><strong>Nom:</strong> ${category.name}</p>
                            <p><strong>Description:</strong> ${category.description || 'Aucune description'}</p>
                            <p><strong>Icône:</strong> ${category.icon_url || 'Aucune icône'}</p>
                            <p><strong>Date de création:</strong> ${new Date(category.created_at).toLocaleDateString()}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Statistiques</h6>
                            <p><strong>Nombre de produits:</strong> ${data.products_count}</p>
                            <p><strong>Total abonnements:</strong> ${data.total_subscriptions}</p>
                            <p><strong>Revenus totaux:</strong> ${data.total_revenue} €</p>
                        </div>
                    </div>
                    ${category.products && category.products.length > 0 ? `
                    <div class="mt-4">
                        <h6>Produits de cette catégorie</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Prix</th>
                                        <th>Abonnements</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${category.products.map(product => `
                                        <tr>
                                            <td>${product.name}</td>
                                            <td>${product.price} €</td>
                                            <td>${product.subscriptions ? product.subscriptions.length : 0}</td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    </div>
                    ` : '<p class="mt-3 text-muted">Aucun produit dans cette catégorie</p>'}
                `;
                
                document.getElementById('viewCategoryContent').innerHTML = content;
                new bootstrap.Modal(document.getElementById('viewCategoryModal')).show();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des détails');
        });
}

function openAddModal() {
    currentCategoryId = null;
    document.getElementById('categoryModalTitle').textContent = 'Nouvelle catégorie';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryId').value = '';
    new bootstrap.Modal(document.getElementById('categoryModal')).show();
}

function editCategory(uuid) {
    currentCategoryId = uuid;
    document.getElementById('categoryModalTitle').textContent = 'Modifier la catégorie';
    
    // Charger les données de la catégorie
    fetch(`/admin/categories/${uuid}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const category = data.category;
                document.getElementById('categoryId').value = category.uuid;
                document.getElementById('categoryName').value = category.name;
                document.getElementById('categoryDescription').value = category.description || '';
                document.getElementById('categoryIconUrl').value = category.icon_url || '';
                new bootstrap.Modal(document.getElementById('categoryModal')).show();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du chargement des données');
        });
}

function deleteCategory(uuid) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        fetch(`/admin/categories/${uuid}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Catégorie supprimée avec succès');
                location.reload();
            } else {
                alert(data.message || 'Erreur lors de la suppression');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la suppression');
        });
    }
}

// Gestion du formulaire
document.getElementById('categoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const url = currentCategoryId ? `/admin/categories/${currentCategoryId}` : '/admin/categories';
    const method = currentCategoryId ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            bootstrap.Modal.getInstance(document.getElementById('categoryModal')).hide();
            location.reload();
        } else {
            alert(data.message || 'Erreur lors de l\'enregistrement');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'enregistrement');
    });
});

// Filtrage des catégories
function filterCategories() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('categoriesTable');
    const rows = table.getElementsByTagName('tr');
    
    for (let i = 1; i < rows.length; i++) {
        const row = rows[i];
        const nameCell = row.cells[0];
        const descriptionCell = row.cells[1];
        
        if (nameCell && descriptionCell) {
            const name = nameCell.textContent || nameCell.innerText;
            const description = descriptionCell.textContent || descriptionCell.innerText;
            
            if (name.toLowerCase().indexOf(filter) > -1 || description.toLowerCase().indexOf(filter) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
}
</script>
@endpush

@push('styles')
<style>
.category-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    background: #fff;
    transition: all 0.3s ease;
}

.category-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.category-name {
    display: flex;
    align-items: center;
    gap: 10px;
}

.category-thumb {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 4px;
}

.category-actions {
    display: flex;
    gap: 5px;
}

.table-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

#searchInput {
    max-width: 300px;
}
</style>
@endpush 