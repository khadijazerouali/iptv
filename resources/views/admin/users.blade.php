@extends('layouts.admin')

@section('title', 'Gestion des utilisateurs')

@section('content')
<div class="page-header fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="fas fa-users"></i>
                Gestion des utilisateurs
            </h1>
            <p class="page-subtitle">Gérez tous les utilisateurs de votre plateforme</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary" onclick="showNotification('Fonctionnalité en cours de développement', 'info')">
                <i class="fas fa-plus me-2"></i>
                Ajouter un utilisateur
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
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $users->count() }}</h3>
                <p>Total utilisateurs</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card success">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $users->where('email_verified_at', '!=', null)->count() }}</h3>
                <p>Utilisateurs vérifiés</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                <p>Nouveaux ce mois</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-details">
                <h3>{{ $users->where('role', 'admin')->count() }}</h3>
                <p>Administrateurs</p>
            </div>
        </div>
    </div>
</div>

<!-- Users Table -->
<div class="admin-card slide-in">
    <div class="table-header">
        <h5>
            <i class="fas fa-list"></i>
            Liste des utilisateurs
        </h5>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-start-0" placeholder="Rechercher un utilisateur..." id="searchInput">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                    <th>Date d'inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $user->id }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">{{ $user->name }}</div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted">{{ $user->email }}</span>
                    </td>
                    <td>
                        <select class="form-select form-select-sm" style="width: auto;" onchange="updateUserRole({{ $user->id }}, this.value)">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Utilisateur</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            <option value="super-admin" {{ $user->role == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </td>
                    <td>
                        @if($user->email_verified_at)
                            <span class="badge badge-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Vérifié
                            </span>
                        @else
                            <span class="badge badge-warning">
                                <i class="fas fa-clock me-1"></i>
                                En attente
                            </span>
                        @endif
                    </td>
                    <td>
                        <div class="text-muted">
                            <div>{{ $user->created_at->format('d/m/Y') }}</div>
                            <small>{{ $user->created_at->format('H:i') }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewUser({{ $user->id }})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-warning btn-sm" onclick="editUser({{ $user->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm" data-confirm="Êtes-vous sûr de vouloir supprimer cet utilisateur ?" onclick="deleteUser({{ $user->id }})">
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

<!-- User Details Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user"></i>
                    Détails de l'utilisateur
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="userModalContent">
                    <!-- Contenu dynamique -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Sauvegarder</button>
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la gestion des utilisateurs
function updateUserRole(userId, role) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        showNotification(`Rôle de l'utilisateur #${userId} mis à jour vers ${role}`, 'success');
    }, 1000);
}

function viewUser(userId) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        document.getElementById('userModalContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informations personnelles</h6>
                    <p><strong>Nom:</strong> Utilisateur #${userId}</p>
                    <p><strong>Email:</strong> user${userId}@example.com</p>
                    <p><strong>Rôle:</strong> Utilisateur</p>
                </div>
                <div class="col-md-6">
                    <h6>Statistiques</h6>
                    <p><strong>Commandes:</strong> 5</p>
                    <p><strong>Dernière connexion:</strong> Aujourd'hui</p>
                    <p><strong>Statut:</strong> Actif</p>
                </div>
            </div>
        `;
        
        new bootstrap.Modal(document.getElementById('userModal')).show();
    }, 500);
}

function editUser(userId) {
    showNotification('Fonctionnalité d\'édition en cours de développement', 'info');
}

function deleteUser(userId) {
    showLoading();
    
    // Simulation d'une requête AJAX
    setTimeout(() => {
        hideLoading();
        showNotification(`Utilisateur #${userId} supprimé avec succès`, 'success');
    }, 1000);
}

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
</script>
@endsection 