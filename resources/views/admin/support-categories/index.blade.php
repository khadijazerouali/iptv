@extends('layouts.admin')

@section('title', 'Gestion des Catégories de Support')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-tags me-2"></i>
                Catégories de Support
            </h1>
            <p class="text-muted">Gérez les types de problèmes que les clients peuvent signaler</p>
        </div>
        <button class="btn btn-primary" onclick="showCreateModal()">
            <i class="fas fa-plus me-2"></i>
            Nouvelle Catégorie
        </button>
    </div>

    <!-- Categories List -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>
                Liste des Catégories
            </h5>
        </div>
        <div class="card-body p-0">
            @if($categories->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ordre</th>
                                <th>Icône</th>
                                <th>Nom</th>
                                <th>Description</th>
                                <th>Statut</th>
                                <th>Tickets</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">{{ $category->sort_order }}</span>
                                </td>
                                <td>
                                    <i class="{{ $category->icon }} fa-lg text-primary"></i>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $category->name }}</div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($category->description, 50) }}</small>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>
                                            Actif
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-times me-1"></i>
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $category->supportTickets()->count() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-outline-primary btn-sm" onclick="editCategory('{{ $category->uuid }}')" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-{{ $category->is_active ? 'warning' : 'success' }} btn-sm" onclick="toggleStatus('{{ $category->uuid }}')" title="{{ $category->is_active ? 'Désactiver' : 'Activer' }}">
                                            <i class="fas fa-{{ $category->is_active ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                        @if($category->supportTickets()->count() === 0)
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteCategory('{{ $category->uuid }}')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Aucune catégorie</h5>
                    <p class="text-muted">Créez votre première catégorie de support</p>
                    <button class="btn btn-primary" onclick="showCreateModal()">
                        <i class="fas fa-plus me-2"></i>
                        Créer une catégorie
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create/Edit Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Nouvelle Catégorie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <input type="hidden" id="categoryUuid">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de la catégorie *</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Ex: Problème de connexion">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Description détaillée du type de problème"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="icon" class="form-label">Icône *</label>
                        <select class="form-select" id="icon" name="icon" required>
                            <option value="">Sélectionner une icône</option>
                            <option value="fas fa-wifi">WiFi (Connexion)</option>
                            <option value="fas fa-tv">TV (Chaînes)</option>
                            <option value="fas fa-mobile-alt">Mobile (Application)</option>
                            <option value="fas fa-credit-card">Paiement</option>
                            <option value="fas fa-user">Compte</option>
                            <option value="fas fa-cog">Configuration</option>
                            <option value="fas fa-exclamation-triangle">Problème technique</option>
                            <option value="fas fa-question-circle">Question générale</option>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sort_order" class="form-label">Ordre d'affichage</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                    <label class="form-check-label" for="is_active">
                                        Catégorie active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let categoryModal;

document.addEventListener('DOMContentLoaded', function() {
    categoryModal = new bootstrap.Modal(document.getElementById('categoryModal'));
    
    // Form submission
    document.getElementById('categoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        saveCategory();
    });
});

function showCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nouvelle Catégorie';
    document.getElementById('categoryForm').reset();
    document.getElementById('categoryUuid').value = '';
    categoryModal.show();
}

function editCategory(uuid) {
    // Récupérer les données de la catégorie
    fetch(`/admin/support-categories/${uuid}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const category = data.category;
                document.getElementById('modalTitle').textContent = 'Modifier la Catégorie';
                document.getElementById('categoryUuid').value = category.uuid;
                document.getElementById('name').value = category.name;
                document.getElementById('description').value = category.description || '';
                document.getElementById('icon').value = category.icon;
                document.getElementById('sort_order').value = category.sort_order;
                document.getElementById('is_active').checked = category.is_active;
                categoryModal.show();
            }
        })
        .catch(error => {
            showNotification('Erreur lors du chargement de la catégorie', 'error');
        });
}

function saveCategory() {
    const formData = new FormData(document.getElementById('categoryForm'));
    const uuid = document.getElementById('categoryUuid').value;
    
    const data = {
        name: formData.get('name'),
        description: formData.get('description'),
        icon: formData.get('icon'),
        sort_order: parseInt(formData.get('sort_order')) || 0,
        is_active: formData.get('is_active') === 'on'
    };
    
    const url = uuid ? `/admin/support-categories/${uuid}` : '/admin/support-categories';
    const method = uuid ? 'PUT' : 'POST';
    
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            categoryModal.hide();
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Erreur lors de la sauvegarde', 'error');
    });
}

function toggleStatus(uuid) {
    fetch(`/admin/support-categories/${uuid}/toggle-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => location.reload(), 1000);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        showNotification('Erreur lors de la mise à jour du statut', 'error');
    });
}

function deleteCategory(uuid) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')) {
        fetch(`/admin/support-categories/${uuid}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            showNotification('Erreur lors de la suppression', 'error');
        });
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endsection 