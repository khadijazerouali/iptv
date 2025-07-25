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
            <button class="btn btn-primary" onclick="showNotification('Fonctionnalité en cours de développement', 'info')">
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
                <h3>12</h3>
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
                <h3>10</h3>
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
                <h3>2</h3>
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
                <h3>1,234</h3>
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
                    <th>Compatibilité</th>
                    <th>Statut</th>
                    <th>Utilisateurs</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#1</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-mobile-alt text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">Android Smartphone</div>
                                <small class="text-muted">Version 8.0 et supérieure</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            <i class="fas fa-mobile me-1"></i>
                            Mobile
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-success">100%</div>
                        <small class="text-muted">Toutes les fonctionnalités</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Actif
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">456</div>
                            <small>utilisateurs</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewDeviceType(1)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editDeviceType(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer ce type d'appareil ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#2</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-tv text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">Samsung Smart TV</div>
                                <small class="text-muted">Tizen OS 6.0+</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-tv me-1"></i>
                            Smart TV
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-success">95%</div>
                        <small class="text-muted">Fonctionnalités principales</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Actif
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">234</div>
                            <small>utilisateurs</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewDeviceType(2)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editDeviceType(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer ce type d'appareil ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#3</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-box text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">Formuler Z8</div>
                                <small class="text-muted">Android TV Box</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-box me-1"></i>
                            Box IPTV
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-warning">85%</div>
                        <small class="text-muted">Compatibilité partielle</small>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-pause me-1"></i>
                            En pause
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">89</div>
                            <small>utilisateurs</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewDeviceType(3)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editDeviceType(3)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer ce type d'appareil ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
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
function viewDeviceType(deviceTypeId) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        document.getElementById('deviceTypeModalContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informations du type d'appareil</h6>
                    <p><strong>Nom:</strong> Type d'appareil #${deviceTypeId}</p>
                    <p><strong>Catégorie:</strong> Mobile</p>
                    <p><strong>Compatibilité:</strong> 100%</p>
                    <p><strong>Statut:</strong> Actif</p>
                </div>
                <div class="col-md-6">
                    <h6>Statistiques</h6>
                    <p><strong>Utilisateurs actifs:</strong> 456</p>
                    <p><strong>Nouveaux ce mois:</strong> 23</p>
                    <p><strong>Note moyenne:</strong> 4.7/5</p>
                </div>
            </div>
            <hr>
            <div class="mt-3">
                <h6>Spécifications techniques</h6>
                <div class="bg-light p-3 rounded">
                    <ul>
                        <li><strong>Système d'exploitation:</strong> Android 8.0+</li>
                        <li><strong>Résolution minimale:</strong> 720p</li>
                        <li><strong>Résolution recommandée:</strong> 1080p/4K</li>
                        <li><strong>RAM minimale:</strong> 2GB</li>
                        <li><strong>Stockage:</strong> 8GB minimum</li>
                        <li><strong>Connexion:</strong> WiFi/4G/5G</li>
                    </ul>
                </div>
            </div>
        `;
        
        new bootstrap.Modal(document.getElementById('deviceTypeModal')).show();
    }, 500);
}

function editDeviceType(deviceTypeId) {
    showNotification('Fonctionnalité de modification en cours de développement', 'info');
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