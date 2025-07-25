@extends('layouts.admin')

@section('title', 'Gestion des contacts')

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-address-book"></i>
                Gestion des contacts
            </h1>
            <p class="page-subtitle">Gérez tous les messages de contact reçus</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="showNotification('Fonctionnalité en cours de développement', 'info')">
                <i class="fas fa-plus me-2"></i>
                Nouveau contact
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
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-details">
                <h3>156</h3>
                <p>Total messages</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <h3>89</h3>
                <p>Répondus</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-details">
                <h3>23</h3>
                <p>En attente</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-details">
                <h3>44</h3>
                <p>Urgents</p>
            </div>
        </div>
    </div>
</div>

<!-- Contacts Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Liste des messages
        </h5>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Tous les statuts</option>
                <option value="new">Nouveau</option>
                <option value="replied">Répondu</option>
                <option value="urgent">Urgent</option>
            </select>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher un message...">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Expéditeur</th>
                    <th>Sujet</th>
                    <th>Statut</th>
                    <th>Priorité</th>
                    <th>Date</th>
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
                        <div class="fw-semibold text-dark">Question sur les abonnements</div>
                        <small class="text-muted">Bonjour, j'aimerais savoir...</small>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock me-1"></i>
                            En attente
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-danger">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Urgent
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
                            <button class="btn btn-outline-primary btn-sm" onclick="viewContact(1)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="replyContact(1)">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer ce message ?">
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
                        <div class="fw-semibold text-dark">Problème technique</div>
                        <small class="text-muted">Je n'arrive pas à accéder à...</small>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Répondu
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Normal
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
                            <button class="btn btn-outline-primary btn-sm" onclick="viewContact(2)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="replyContact(2)">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer ce message ?">
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
                        <div class="fw-semibold text-dark">Demande de devis</div>
                        <small class="text-muted">Bonjour, je souhaite obtenir...</small>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock me-1"></i>
                            En attente
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock me-1"></i>
                            Moyenne
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
                            <button class="btn btn-outline-primary btn-sm" onclick="viewContact(3)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="replyContact(3)">
                                <i class="fas fa-reply"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer ce message ?">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Contact Details Modal -->
<div class="modal fade" id="contactModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-envelope"></i>
                    Détails du message
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="contactModalContent">
                    <!-- Contenu dynamique -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Répondre</button>
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la gestion des contacts
function viewContact(contactId) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        document.getElementById('contactModalContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informations de l'expéditeur</h6>
                    <p><strong>Nom:</strong> Utilisateur #${contactId}</p>
                    <p><strong>Email:</strong> contact${contactId}@example.com</p>
                    <p><strong>Téléphone:</strong> +33 1 23 45 67 89</p>
                </div>
                <div class="col-md-6">
                    <h6>Détails du message</h6>
                    <p><strong>Sujet:</strong> Question importante</p>
                    <p><strong>Date:</strong> Aujourd'hui à 14:30</p>
                    <p><strong>Statut:</strong> En attente</p>
                </div>
            </div>
            <hr>
            <div class="mt-3">
                <h6>Message</h6>
                <div class="bg-light p-3 rounded">
                    <p>Bonjour,</p>
                    <p>J'aimerais obtenir des informations sur vos services IPTV. Pouvez-vous me donner plus de détails sur les abonnements disponibles ?</p>
                    <p>Merci d'avance pour votre réponse.</p>
                    <p>Cordialement,<br>Utilisateur #${contactId}</p>
                </div>
            </div>
        `;
        
        new bootstrap.Modal(document.getElementById('contactModal')).show();
    }, 500);
}

function replyContact(contactId) {
    showNotification('Fonctionnalité de réponse en cours de développement', 'info');
}

// Recherche en temps réel
document.querySelector('input[placeholder="Rechercher un message..."]').addEventListener('input', function(e) {
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