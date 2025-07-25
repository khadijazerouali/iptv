@extends('layouts.admin')

@section('title', 'Gestion des types d\'applications')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-code"></i>
                Gestion des types d'applications
            </h1>
            <p class="page-subtitle">Gérez tous les types d'applications IPTV</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="createApplication()">
                <i class="fas fa-plus me-2"></i>
                Nouvelle application
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
                <i class="fas fa-code"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_applications']) }}</h3>
                <p>Total applications</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['active_applications']) }}</h3>
                <p>Actives</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-pause"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['in_development']) }}</h3>
                <p>En développement</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-download"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['total_downloads']) }}</h3>
                <p>Téléchargements</p>
            </div>
        </div>
    </div>
</div>

<!-- Application Types Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Liste des applications
        </h5>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" id="deviceTypeFilter" style="width: auto;">
                <option value="">Tous les types d'appareils</option>
                @foreach($deviceTypes as $deviceType)
                    <option value="{{ $deviceType->name }}">{{ $deviceType->name }}</option>
                @endforeach
            </select>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher une application...">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Application</th>
                    <th>Plateforme</th>
                    <th>Version</th>
                    <th>Statut</th>
                    <th>Téléchargements</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $application)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $loop->iteration }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-code text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">{{ $application->name }}</div>
                                <small class="text-muted">Application IPTV</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            <i class="fas fa-mobile-alt me-1"></i>
                            {{ $application->devicetype->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">v1.0.0</div>
                        <small class="text-muted">Version stable</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Active
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">{{ number_format($application->usage_count ?? 0) }}</div>
                            <small>utilisateurs</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewApplication('{{ $application->uuid }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editApplication('{{ $application->uuid }}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteApplication('{{ $application->uuid }}')" data-confirm="Êtes-vous sûr de vouloir supprimer cette application ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-code fa-3x mb-3"></i>
                        <p>Aucune application trouvée</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Application Details Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-code"></i>
                    Détails de l'application
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="applicationModalContent">
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
// Fonctions pour la gestion des applications
function createApplication() {
    document.getElementById('applicationModalContent').innerHTML = `
        <form id="createApplicationForm">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom de l'application</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="devicetype_uuid" class="form-label">Type d'appareil</label>
                        <select class="form-select" id="devicetype_uuid" name="devicetype_uuid" required>
                            <option value="">Sélectionner un type d'appareil</option>
                            @foreach($deviceTypes as $deviceType)
                                <option value="{{ $deviceType->uuid }}">{{ $deviceType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Champs requis</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="deviceid" name="deviceid">
                            <label class="form-check-label" for="deviceid">Device ID</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="devicekey" name="devicekey">
                            <label class="form-check-label" for="devicekey">Device Key</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="otpcode" name="otpcode">
                            <label class="form-check-label" for="otpcode">OTP Code</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="smartstbmac" name="smartstbmac">
                            <label class="form-check-label" for="smartstbmac">Smart STB MAC</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    `;
    
    // Changer le titre et les boutons du modal
    document.querySelector('#applicationModal .modal-title').innerHTML = '<i class="fas fa-plus"></i> Nouvelle application';
    document.querySelector('#applicationModal .modal-footer').innerHTML = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" onclick="saveNewApplication()">Créer</button>
    `;
    
    new bootstrap.Modal(document.getElementById('applicationModal')).show();
}

function saveNewApplication() {
    const form = document.getElementById('createApplicationForm');
    const formData = new FormData(form);
    
    const data = {
        name: formData.get('name'),
        devicetype_uuid: formData.get('devicetype_uuid'),
        deviceid: formData.get('deviceid') === 'on',
        devicekey: formData.get('devicekey') === 'on',
        otpcode: formData.get('otpcode') === 'on',
        smartstbmac: formData.get('smartstbmac') === 'on'
    };
    
    showLoading();
    
    fetch('/admin/application-types', {
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
            bootstrap.Modal.getInstance(document.getElementById('applicationModal')).hide();
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

function viewApplication(applicationId) {
    showLoading();
    
    fetch(`/admin/application-types/${applicationId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            
            // Afficher les fonctionnalités requises
            const features = [];
            if (data.requiredFeatures && data.requiredFeatures.deviceid) features.push('Device ID');
            if (data.requiredFeatures && data.requiredFeatures.devicekey) features.push('Device Key');
            if (data.requiredFeatures && data.requiredFeatures.otpcode) features.push('OTP Code');
            if (data.requiredFeatures && data.requiredFeatures.smartstbmac) features.push('Smart STB MAC');
            
            document.getElementById('applicationModalContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations de l'application</h6>
                        <p><strong>Nom:</strong> ${data.application ? data.application.name : 'N/A'}</p>
                        <p><strong>Type d'appareil:</strong> ${data.application && data.application.devicetype ? data.application.devicetype.name : 'N/A'}</p>
                        <p><strong>Statut:</strong> Active</p>
                        <p><strong>Date de création:</strong> ${data.application && data.application.created_at ? new Date(data.application.created_at).toLocaleDateString() : 'N/A'}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Statistiques</h6>
                        <p><strong>Utilisateurs actifs:</strong> ${data.stats ? data.stats.total_users : 0}</p>
                        <p><strong>Nouveaux ce mois:</strong> ${data.stats ? data.stats.monthly_users : 0}</p>
                        <p><strong>Téléchargements:</strong> ${data.stats ? data.stats.downloads : 0}</p>
                        <p><strong>Note moyenne:</strong> ${data.stats ? data.stats.rating : 0}/5</p>
                    </div>
                </div>
                <hr>
                <div class="mt-3">
                    <h6>Champs requis</h6>
                    <div class="bg-light p-3 rounded">
                        ${features.length > 0 ? 
                            `<ul class="mb-0">
                                ${features.map(feature => `<li><i class="fas fa-check text-success me-2"></i>${feature}</li>`).join('')}
                            </ul>` : 
                            '<p class="text-muted mb-0">Aucun champ spécifique requis</p>'
                        }
                    </div>
                </div>
            `;
            
            // Changer le titre et les boutons du modal
            document.querySelector('#applicationModal .modal-title').innerHTML = '<i class="fas fa-eye"></i> Détails de l\'application';
            document.querySelector('#applicationModal .modal-footer').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning" onclick="editApplication('${applicationId}')">Modifier</button>
            `;
            
            new bootstrap.Modal(document.getElementById('applicationModal')).show();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors du chargement des données: ' + error.message, 'error');
        });
}

function editApplication(applicationId) {
    showLoading();
    
    fetch(`/admin/application-types/${applicationId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            
            document.getElementById('applicationModalContent').innerHTML = `
                <form id="editApplicationForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom de l'application</label>
                                <input type="text" class="form-control" id="name" name="name" value="${data.application ? data.application.name : ''}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="devicetype_uuid" class="form-label">Type d'appareil</label>
                                <select class="form-select" id="devicetype_uuid" name="devicetype_uuid" required>
                                    <option value="">Sélectionner un type d'appareil</option>
                                    @foreach($deviceTypes as $deviceType)
                                        <option value="{{ $deviceType->uuid }}" ${data.application && data.application.devicetype_uuid === '{{ $deviceType->uuid }}' ? 'selected' : ''}>{{ $deviceType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">Champs requis</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deviceid" name="deviceid" ${data.requiredFeatures && data.requiredFeatures.deviceid ? 'checked' : ''}>
                                    <label class="form-check-label" for="deviceid">Device ID</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="devicekey" name="devicekey" ${data.requiredFeatures && data.requiredFeatures.devicekey ? 'checked' : ''}>
                                    <label class="form-check-label" for="devicekey">Device Key</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="otpcode" name="otpcode" ${data.requiredFeatures && data.requiredFeatures.otpcode ? 'checked' : ''}>
                                    <label class="form-check-label" for="otpcode">OTP Code</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="smartstbmac" name="smartstbmac" ${data.requiredFeatures && data.requiredFeatures.smartstbmac ? 'checked' : ''}>
                                    <label class="form-check-label" for="smartstbmac">Smart STB MAC</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            `;
            
            // Changer le titre et les boutons du modal
            document.querySelector('#applicationModal .modal-title').innerHTML = '<i class="fas fa-edit"></i> Modifier l\'application';
            document.querySelector('#applicationModal .modal-footer').innerHTML = `
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="saveApplication('${applicationId}')">Sauvegarder</button>
            `;
            
            new bootstrap.Modal(document.getElementById('applicationModal')).show();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors du chargement des données: ' + error.message, 'error');
        });
}

function saveApplication(applicationId) {
    const form = document.getElementById('editApplicationForm');
    const formData = new FormData(form);
    
    const data = {
        name: formData.get('name'),
        devicetype_uuid: formData.get('devicetype_uuid'),
        deviceid: formData.get('deviceid') === 'on',
        devicekey: formData.get('devicekey') === 'on',
        otpcode: formData.get('otpcode') === 'on',
        smartstbmac: formData.get('smartstbmac') === 'on'
    };
    
    showLoading();
    
    fetch(`/admin/application-types/${applicationId}`, {
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
            bootstrap.Modal.getInstance(document.getElementById('applicationModal')).hide();
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

function deleteApplication(applicationId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette application ?')) {
        showLoading();
        
        fetch(`/admin/application-types/${applicationId}`, {
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
document.querySelector('input[placeholder="Rechercher une application..."]').addEventListener('input', function(e) {
    filterTable();
});

// Filtrage par type d'appareil
document.getElementById('deviceTypeFilter').addEventListener('change', function(e) {
    filterTable();
});

function filterTable() {
    const searchTerm = document.querySelector('input[placeholder="Rechercher une application..."]').value.toLowerCase();
    const selectedDeviceType = document.getElementById('deviceTypeFilter').value;
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        const deviceTypeCell = row.querySelector('td:nth-child(3)'); // Colonne du type d'appareil
        const deviceTypeText = deviceTypeCell ? deviceTypeCell.textContent.trim() : '';
        
        const matchesSearch = text.includes(searchTerm);
        const matchesDeviceType = !selectedDeviceType || deviceTypeText.includes(selectedDeviceType);
        
        if (matchesSearch && matchesDeviceType) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection 