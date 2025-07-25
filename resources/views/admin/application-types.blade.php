@extends('layouts.admin')

@section('title', 'Gestion des types d\'applications')

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
            <button class="btn btn-primary" onclick="showNotification('Fonctionnalité en cours de développement', 'info')">
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
                <h3>8</h3>
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
                <h3>6</h3>
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
                <h3>2</h3>
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
                <h3>2,456</h3>
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
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Toutes les plateformes</option>
                <option value="android">Android</option>
                <option value="ios">iOS</option>
                <option value="web">Web</option>
                <option value="smarttv">Smart TV</option>
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
                                <div class="fw-semibold text-dark">IPTV Smarters Pro</div>
                                <small class="text-muted">Application Android premium</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            <i class="fab fa-android me-1"></i>
                            Android
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">v3.2.1</div>
                        <small class="text-muted">Dernière mise à jour</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Active
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">1,234</div>
                            <small>téléchargements</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewApplication(1)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editApplication(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer cette application ?">
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
                                    <i class="fab fa-apple text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">IPTV Smarters iOS</div>
                                <small class="text-muted">Application iOS native</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fab fa-apple me-1"></i>
                            iOS
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">v2.8.5</div>
                        <small class="text-muted">Dernière mise à jour</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Active
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">567</div>
                            <small>téléchargements</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewApplication(2)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editApplication(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer cette application ?">
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
                                    <i class="fas fa-globe text-warning"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">IPTV Web Player</div>
                                <small class="text-muted">Lecteur web moderne</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-globe me-1"></i>
                            Web
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">v1.5.2</div>
                        <small class="text-muted">En développement</small>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-pause me-1"></i>
                            En développement
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div class="fw-semibold text-dark">89</div>
                            <small>téléchargements</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewApplication(3)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editApplication(3)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer cette application ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
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
function viewApplication(applicationId) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        document.getElementById('applicationModalContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informations de l'application</h6>
                    <p><strong>Nom:</strong> Application #${applicationId}</p>
                    <p><strong>Plateforme:</strong> Android</p>
                    <p><strong>Version:</strong> v3.2.1</p>
                    <p><strong>Statut:</strong> Active</p>
                </div>
                <div class="col-md-6">
                    <h6>Statistiques</h6>
                    <p><strong>Téléchargements:</strong> 1,234</p>
                    <p><strong>Note moyenne:</strong> 4.8/5</p>
                    <p><strong>Utilisateurs actifs:</strong> 987</p>
                </div>
            </div>
            <hr>
            <div class="mt-3">
                <h6>Fonctionnalités requises</h6>
                <div class="bg-light p-3 rounded">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Champs techniques</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Device ID</li>
                                <li><i class="fas fa-check text-success me-2"></i>Device Key</li>
                                <li><i class="fas fa-times text-danger me-2"></i>OTP Code</li>
                                <li><i class="fas fa-check text-success me-2"></i>Smart STB MAC</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">Spécifications</h6>
                            <ul class="list-unstyled">
                                <li><strong>API:</strong> RESTful</li>
                                <li><strong>Authentification:</strong> OAuth 2.0</li>
                                <li><strong>Streaming:</strong> HLS/DASH</li>
                                <li><strong>Encodage:</strong> H.264/H.265</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        new bootstrap.Modal(document.getElementById('applicationModal')).show();
    }, 500);
}

function editApplication(applicationId) {
    showNotification('Fonctionnalité de modification en cours de développement', 'info');
}

// Recherche en temps réel
document.querySelector('input[placeholder="Rechercher une application..."]').addEventListener('input', function(e) {
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