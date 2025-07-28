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
                @php
                    // Déterminer le rôle affiché
                    $displayRole = $user->email === 'admin@admin.com' ? 'admin' : ($user->role ?? 'user');
                    $isMainAdmin = $user->email === 'admin@admin.com';
                    $currentUserIsAdmin = auth()->user()->email === 'admin@admin.com';
                @endphp
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $user->id }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                @if($isMainAdmin)
                                    <div class="bg-danger bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-crown text-danger"></i>
                                    </div>
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">
                                    {{ $user->name }}
                                    @if($isMainAdmin)
                                        <span class="badge badge-danger ms-2">Super Admin</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted">{{ $user->email }}</span>
                    </td>
                    <td>
                        @if($isMainAdmin)
                            <!-- L'admin principal ne peut pas être modifié -->
                            <div class="d-flex align-items-center">
                                <select class="form-select form-select-sm me-2" style="width: auto;" disabled>
                                    <option value="admin" selected>Administrateur</option>
                                </select>
                                <span class="badge badge-danger">Immutable</span>
                            </div>
                        @elseif($currentUserIsAdmin)
                            <!-- Seul l'admin principal peut modifier les rôles -->
                            <div class="d-flex align-items-center">
                                <select class="form-select form-select-sm me-2" style="width: auto;" 
                                        onchange="updateUserRole({{ $user->id }}, this.value, '{{ $user->role }}')"
                                        data-original-role="{{ $user->role }}">
                                    <option value="user" {{ $displayRole == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                    <option value="admin" {{ $displayRole == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                </select>
                                <button class="btn btn-outline-secondary btn-sm" 
                                        onclick="cancelRoleChange({{ $user->id }})" 
                                        style="display: none;" 
                                        id="cancelBtn{{ $user->id }}">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                        @else
                            <!-- Les autres utilisateurs voient seulement le rôle -->
                            <span class="badge badge-{{ $displayRole == 'admin' ? 'danger' : 'primary' }}">
                                {{ $displayRole == 'admin' ? 'Administrateur' : 'Utilisateur' }}
                            </span>
                        @endif
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
                            @if($currentUserIsAdmin && !$isMainAdmin)
                                <button class="btn btn-outline-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @elseif($isMainAdmin)
                                <span class="badge badge-danger">Protégé</span>
                            @else
                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                    <i class="fas fa-lock"></i>
                                </button>
                            @endif
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
            </div>
        </div>
    </div>
</div>

<script>
// Variables pour suivre les changements de rôle
let roleChanges = {};

// Fonctions pour la gestion des utilisateurs
function updateUserRole(userId, newRole, originalRole) {
    const selectElement = event.target;
    const cancelBtn = document.getElementById(`cancelBtn${userId}`);
    
    // Sauvegarder le changement
    roleChanges[userId] = {
        newRole: newRole,
        originalRole: originalRole,
        selectElement: selectElement
    };
    
    // Afficher le bouton d'annulation
    if (cancelBtn) {
        cancelBtn.style.display = 'inline-block';
    }
    
    // Changer la couleur du select pour indiquer un changement
    selectElement.classList.add('border-warning');
    
    // Afficher le bouton de sauvegarde
    const saveBtn = document.getElementById('saveRoleChangesBtn');
    if (saveBtn) {
        saveBtn.style.display = 'inline-block';
    }
    
    showNotification(`Rôle modifié vers ${newRole}. Cliquez sur l'icône d'annulation pour annuler.`, 'warning');
}

function cancelRoleChange(userId) {
    const change = roleChanges[userId];
    if (change) {
        // Restaurer la valeur originale
        change.selectElement.value = change.originalRole;
        change.selectElement.classList.remove('border-warning');
        
        // Masquer le bouton d'annulation
        const cancelBtn = document.getElementById(`cancelBtn${userId}`);
        if (cancelBtn) {
            cancelBtn.style.display = 'none';
        }
        
        // Supprimer le changement de la liste
        delete roleChanges[userId];
        
        // Masquer le bouton de sauvegarde si plus de changements
        const saveBtn = document.getElementById('saveRoleChangesBtn');
        if (saveBtn && Object.keys(roleChanges).length === 0) {
            saveBtn.style.display = 'none';
        }
        
        showNotification('Modification annulée', 'info');
    }
}

function saveRoleChanges() {
    const changes = Object.keys(roleChanges);
    if (changes.length === 0) {
        showNotification('Aucune modification à sauvegarder', 'info');
        return;
    }
    
    showLoading();
    
    // Préparer les données pour l'envoi
    const changesData = {};
    changes.forEach(userId => {
        changesData[userId] = {
            newRole: roleChanges[userId].newRole,
            originalRole: roleChanges[userId].originalRole
        };
    });
    
    // Envoyer les modifications au serveur
    fetch('/admin/users/update-roles', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ changes: changesData })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        hideLoading();
        if (data.success) {
            showNotification('Rôles mis à jour avec succès', 'success');
            // Vider la liste des changements
            roleChanges = {};
            // Masquer tous les boutons d'annulation
            document.querySelectorAll('[id^="cancelBtn"]').forEach(btn => {
                btn.style.display = 'none';
            });
            // Retirer les bordures de warning
            document.querySelectorAll('.border-warning').forEach(select => {
                select.classList.remove('border-warning');
            });
            // Masquer le bouton de sauvegarde
            const saveBtn = document.getElementById('saveRoleChangesBtn');
            if (saveBtn) {
                saveBtn.style.display = 'none';
            }
            // Recharger la page pour afficher les nouveaux rôles
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification('Erreur lors de la mise à jour des rôles: ' + (data.message || 'Erreur inconnue'), 'error');
        }
    })
    .catch(error => {
        hideLoading();
        showNotification('Erreur lors de la mise à jour des rôles: ' + error.message, 'error');
        console.error('Error:', error);
    });
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

function deleteUser(userId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')) {
        showLoading();
        
        fetch(`/admin/users/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            hideLoading();
            if (data.success) {
                showNotification(`Utilisateur #${userId} supprimé avec succès`, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification('Erreur lors de la suppression: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            showNotification('Erreur lors de la suppression: ' + error.message, 'error');
            console.error('Error:', error);
        });
    }
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

// Ajouter un bouton pour sauvegarder tous les changements de rôle
document.addEventListener('DOMContentLoaded', function() {
    const tableHeader = document.querySelector('.table-header');
    if (tableHeader) {
        const saveButton = document.createElement('button');
        saveButton.className = 'btn btn-success btn-sm';
        saveButton.innerHTML = '<i class="fas fa-save me-2"></i>Sauvegarder les modifications';
        saveButton.onclick = saveRoleChanges;
        saveButton.style.display = 'none';
        saveButton.id = 'saveRoleChangesBtn';
        
        const headerActions = tableHeader.querySelector('.d-flex');
        if (headerActions) {
            headerActions.appendChild(saveButton);
        }
    }
});
</script>
@endsection 