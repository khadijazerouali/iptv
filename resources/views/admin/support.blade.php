@extends('layouts.admin')

@section('title', 'Support et assistance')

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-headset"></i>
                Support et assistance
            </h1>
            <p class="page-subtitle">Gérez le support client et les demandes d'assistance</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="showNotification('Fonctionnalité en cours de développement', 'info')">
                <i class="fas fa-plus me-2"></i>
                Nouveau ticket
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
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-details">
                <h3>89</h3>
                <p>Total tickets</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-details">
                <h3>45</h3>
                <p>Résolus</p>
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
                <p>En cours</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="stat-details">
                <h3>4.8</h3>
                <p>Satisfaction</p>
            </div>
        </div>
    </div>
</div>

<!-- Support Tickets Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Tickets de support
        </h5>
        <div class="d-flex gap-2">
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Tous les statuts</option>
                <option value="open">Ouverts</option>
                <option value="in-progress">En cours</option>
                <option value="resolved">Résolus</option>
                <option value="closed">Fermés</option>
            </select>
            <select class="form-select form-select-sm" style="width: auto;">
                <option value="">Toutes les priorités</option>
                <option value="low">Faible</option>
                <option value="medium">Moyenne</option>
                <option value="high">Élevée</option>
                <option value="urgent">Urgente</option>
            </select>
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher un ticket...">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Sujet</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#T001</span>
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
                        <div class="fw-semibold text-dark">Problème de connexion</div>
                        <small class="text-muted">Impossible d'accéder aux chaînes</small>
                    </td>
                    <td>
                        <span class="badge badge-danger">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Urgente
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock me-1"></i>
                            En cours
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
                            <button class="btn btn-outline-primary btn-sm" onclick="viewTicket('T001')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="resolveTicket('T001')">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="replyTicket('T001')">
                                <i class="fas fa-reply"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#T002</span>
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
                        <div class="fw-semibold text-dark">Question sur l'abonnement</div>
                        <small class="text-muted">Renouvellement automatique</small>
                    </td>
                    <td>
                        <span class="badge badge-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Moyenne
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-success">
                            <i class="fas fa-check-circle me-1"></i>
                            Résolu
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
                            <button class="btn btn-outline-primary btn-sm" onclick="viewTicket('T002')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="resolveTicket('T002')">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="replyTicket('T002')">
                                <i class="fas fa-reply"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#T003</span>
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
                        <div class="fw-semibold text-dark">Problème technique</div>
                        <small class="text-muted">Application qui se ferme</small>
                    </td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock me-1"></i>
                            Élevée
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-primary">
                            <i class="fas fa-folder-open me-1"></i>
                            Ouvert
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
                            <button class="btn btn-outline-primary btn-sm" onclick="viewTicket('T003')">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="resolveTicket('T003')">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="replyTicket('T003')">
                                <i class="fas fa-reply"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Ticket Details Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-ticket-alt"></i>
                    Détails du ticket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="ticketModalContent">
                    <!-- Contenu dynamique -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-info">Répondre</button>
                <button type="button" class="btn btn-success">Résoudre</button>
            </div>
        </div>
    </div>
</div>

<!-- Knowledge Base Section -->
<div class="admin-card slide-in mt-4">
    <div class="table-header">
        <h5>
            <i class="fas fa-book"></i>
            Base de connaissances
        </h5>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary btn-sm">
                <i class="fas fa-plus me-2"></i>
                Nouvel article
            </button>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-tv text-primary"></i>
                        </div>
                        <h6 class="mb-0">Installation</h6>
                    </div>
                    <p class="text-muted small">Guide d'installation pour tous les appareils</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-primary">5 articles</span>
                        <button class="btn btn-outline-primary btn-sm">Voir</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-cog text-success"></i>
                        </div>
                        <h6 class="mb-0">Configuration</h6>
                    </div>
                    <p class="text-muted small">Paramètres et configuration avancée</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-success">8 articles</span>
                        <button class="btn btn-outline-success btn-sm">Voir</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-tools text-warning"></i>
                        </div>
                        <h6 class="mb-0">Dépannage</h6>
                    </div>
                    <p class="text-muted small">Solutions aux problèmes courants</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge badge-warning">12 articles</span>
                        <button class="btn btn-outline-warning btn-sm">Voir</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la gestion des tickets
function viewTicket(ticketId) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        document.getElementById('ticketModalContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informations du ticket</h6>
                    <p><strong>Numéro:</strong> ${ticketId}</p>
                    <p><strong>Client:</strong> Jean Dupont</p>
                    <p><strong>Email:</strong> jean.dupont@email.com</p>
                    <p><strong>Priorité:</strong> Urgente</p>
                    <p><strong>Statut:</strong> En cours</p>
                </div>
                <div class="col-md-6">
                    <h6>Détails techniques</h6>
                    <p><strong>Appareil:</strong> Android Smartphone</p>
                    <p><strong>Application:</strong> IPTV Smarters Pro</p>
                    <p><strong>Version:</strong> v3.2.1</p>
                    <p><strong>Date:</strong> Aujourd'hui à 14:30</p>
                </div>
            </div>
            <hr>
            <div class="mt-3">
                <h6>Message du client</h6>
                <div class="bg-light p-3 rounded">
                    <p>Bonjour,</p>
                    <p>J'ai un problème avec mon abonnement IPTV. Je n'arrive plus à accéder aux chaînes depuis hier soir. L'application se connecte mais ne charge aucun contenu.</p>
                    <p>Pouvez-vous m'aider à résoudre ce problème ?</p>
                    <p>Merci d'avance,<br>Jean Dupont</p>
                </div>
            </div>
            <hr>
            <div class="mt-3">
                <h6>Historique des réponses</h6>
                <div class="bg-light p-3 rounded">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                            <i class="fas fa-headset text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <strong>Support Technique</strong>
                                <small class="text-muted">Il y a 2 heures</small>
                            </div>
                            <p class="mb-0">Bonjour Jean, nous avons reçu votre demande. Pouvez-vous nous donner plus de détails sur l'erreur que vous voyez ?</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        new bootstrap.Modal(document.getElementById('ticketModal')).show();
    }, 500);
}

function resolveTicket(ticketId) {
    showNotification('Ticket résolu avec succès', 'success');
}

function replyTicket(ticketId) {
    showNotification('Fonctionnalité de réponse en cours de développement', 'info');
}

// Recherche en temps réel
document.querySelector('input[placeholder="Rechercher un ticket..."]').addEventListener('input', function(e) {
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