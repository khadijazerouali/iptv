@extends('layouts.admin')

@section('title', 'Gestion des types d\'appareils')

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-mobile-alt"></i>
                Gestion des types d'appareils
            </h1>
            <p class="page-subtitle">Gérez tous les types d'appareils supportés</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="createDeviceType()">
                <i class="fas fa-plus me-2"></i>
                Nouveau type
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
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_types']) }}</h3>
                <p>Total types</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['active_types']) }}</h3>
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
                <h3>{{ number_format($stats['paused_types']) }}</h3>
                <p>En pause</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['active_users']) }}</h3>
                <p>Utilisateurs actifs</p>
            </div>
        </div>
    </div>
</div>

<!-- Device Types Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Liste des types d'appareils
        </h5>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Toutes les catégories</option>
                <option value="mobile">Mobile</option>
                <option value="tv">Smart TV</option>
                <option value="box">Box IPTV</option>
                <option value="computer">Ordinateur</option>
            </select>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher un type d'appareil...">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type d'appareil</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Utilisateurs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deviceTypes as $deviceType)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $loop->iteration }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-mobile-alt text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">{{ $deviceType->name }}</div>
                                <small class="text-muted">Type d'appareil</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            <i class="fas fa-mobile me-1"></i>
                            Appareil
                        </span>
                    </td>

                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Actif
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">{{ $deviceType->usage_count ?? 0 }}</div>
                            <small>utilisateurs</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewDeviceType('{{ $deviceType->uuid }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editDeviceType('{{ $deviceType->uuid }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteDeviceType('{{ $deviceType->uuid }}')" data-confirm="Êtes-vous sûr de vouloir supprimer ce type d'appareil ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-mobile-alt fa-3x mb-3"></i>
                        <p>Aucun type d'appareil trouvé</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Device Type Details Modal -->
<div class="modal fade" id="deviceTypeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-mobile-alt"></i>
                    Détails du type d'appareil
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="deviceTypeModalContent">
                    <!-- Contenu dynamique -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning">Modifier</button>
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la gestion des types d'appareils
function createDeviceType() {
    document.getElementById('deviceTypeModalContent').innerHTML = `
        <form id="createDeviceTypeForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom du type d'appareil</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
            </div>
        </form>
    `;
    
    // Changer le titre et les boutons du modal
    document.querySelector('#deviceTypeModal .modal-title').innerHTML = '<i class="fas fa-plus"></i> Nouveau type d\'appareil';
    document.querySelector('#deviceTypeModal .modal-footer').innerHTML = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" onclick="saveNewDeviceType()">Créer</button>
    `;
    
    new bootstrap.Modal(document.getElementById('deviceTypeModal')).show();
}

function saveNewDeviceType() {
    const form = document.getElementById('createDeviceTypeForm');
    const formData = new FormData(form);
    
    const data = {
        name: formData.get('name')
    };
    
    showLoading();
    
    fetch('/admin/device-types', {
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
            bootstrap.Modal.getInstance(document.getElementById('deviceTypeModal')).hide();
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

function viewDeviceType(deviceTypeId) {
    showLoading();
    
    fetch(`/admin/device-types/${deviceTypeId}`)
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            // Pas de fonctionnalités spécifiques à afficher
            
            document.getElementById('deviceTypeModalContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations du type d'appareil</h6>
                        <p><strong>Nom:</strong> ${data.deviceType.name}</p>
                        <p><strong>Compatibilité:</strong> ${data.stats.compatibility_score}%</p>
                        <p><strong>Statut:</strong> Actif</p>
                        <p><strong>Date de création:</strong> ${new Date(data.deviceType.created_at).toLocaleDateString()}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques</h6>
                        <p><strong>Utilisateurs actifs:</strong> ${data.stats.total_users}</p>
                        <p><strong>Nouveaux ce mois:</strong> ${data.stats.monthly_users}</p>
                        <p><strong>Applications compatibles:</strong> ${data.stats.applications_count}</p>
                    </div>
                </div>

                ${data.deviceType.applicationTypes && data.deviceType.applicationTypes.length > 0 ? `
                <hr>
                <div class="mt-3">
                    <h6>Applications compatibles</h6>
                    <div class="row">
                        ${data.deviceType.applicationTypes.map(app => `
                            <div class="col-md-6 mb-2">
                                <span class="badge bg-primary">${app.name}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}
            `;
            
            // Changer le titre et les boutons du modal
            document.querySelector('#deviceTypeModal .modal-title').innerHTML = '<i class="fas fa-eye"></i> Détails du type d\'appareil';
            document.querySelector('#deviceTypeModal .modal-footer').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning" onclick="editDeviceType('${deviceTypeId}')">Modifier</button>
            `;
            
            new bootstrap.Modal(document.getElementById('deviceTypeModal')).show();
        })
        .catch(error => {
            hideLoading();
            showNotification('Erreur lors du chargement des données', 'error');
            console.error('Error:', error);
        });
}

function editDeviceType(deviceTypeId) {
    showLoading();
    
    fetch(`/admin/device-types/${deviceTypeId}`)
        .then(response => response.json())
        .then(data => {
            hideLoading();
            
            document.getElementById('deviceTypeModalContent').innerHTML = `
                <form id="editDeviceTypeForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom du type d'appareil</label>
                                <input type="text" class="form-control" id="name" name="name" value="${data.deviceType.name}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h6>Statistiques</h6>
                                                                <div class="row">
                                    <div class="col-md-4">
                                        <small class="text-muted">Utilisateurs actifs</small>
                                        <div class="fw-bold">${data.stats.total_users}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Nouveaux ce mois</small>
                                        <div class="fw-bold">${data.stats.monthly_users}</div>
                                    </div>
                                    <div class="col-md-4">
                                        <small class="text-muted">Applications</small>
                                        <div class="fw-bold">${data.stats.applications_count}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            `;
            
            // Changer le titre et les boutons du modal
            document.querySelector('#deviceTypeModal .modal-title').innerHTML = '<i class="fas fa-edit"></i> Modifier le type d\'appareil';
            document.querySelector('#deviceTypeModal .modal-footer').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveDeviceType('${deviceTypeId}')">Enregistrer</button>
            `;
            
            new bootstrap.Modal(document.getElementById('deviceTypeModal')).show();
        })
        .catch(error => {
            hideLoading();
            showNotification('Erreur lors du chargement des données', 'error');
            console.error('Error:', error);
        });
}

function saveDeviceType(deviceTypeId) {
    const form = document.getElementById('editDeviceTypeForm');
    const formData = new FormData(form);
    
    const data = {
        name: formData.get('name')
    };
    
    showLoading();
    
    fetch(`/admin/device-types/${deviceTypeId}`, {
        method: 'PUT',
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
            bootstrap.Modal.getInstance(document.getElementById('deviceTypeModal')).hide();
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

function deleteDeviceType(deviceTypeId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce type d\'appareil ?')) {
        showLoading();
        
        fetch(`/admin/device-types/${deviceTypeId}`, {
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
document.querySelector('input[placeholder="Rechercher un type d\'appareil..."]').addEventListener('input', function(e) {
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