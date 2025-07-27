@extends('layouts.dashboard')

@section('title', 'Profil - Paramètres')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-user-edit me-2"></i>
                Mon Profil
            </h1>
            <p class="text-muted">Gérez vos informations personnelles et votre compte</p>
        </div>
        <div>
            <a href="{{ route('settings.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour aux paramètres
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informations du profil -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        Informations du profil
                    </h5>
                </div>
                <div class="card-body">
                    <form id="profileForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>
                                    Nom complet *
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ auth()->user()->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>
                                    Adresse email *
                                </label>
                                <input type="email" class="form-control" 
                                       id="email" value="{{ auth()->user()->email }}" readonly disabled>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    L'adresse email ne peut pas être modifiée pour des raisons de sécurité
                                </small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telephone" class="form-label">
                                    <i class="fas fa-phone me-2"></i>
                                    Téléphone
                                </label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                                       id="telephone" name="telephone" value="{{ auth()->user()->telephone }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pays" class="form-label">
                                    <i class="fas fa-globe me-2"></i>
                                    Pays
                                </label>
                                <select class="form-select @error('pays') is-invalid @enderror" id="pays" name="pays">
                                    <option value="">Sélectionner un pays</option>
                                    <option value="France" {{ auth()->user()->pays === 'France' ? 'selected' : '' }}>France</option>
                                    <option value="Belgique" {{ auth()->user()->pays === 'Belgique' ? 'selected' : '' }}>Belgique</option>
                                    <option value="Suisse" {{ auth()->user()->pays === 'Suisse' ? 'selected' : '' }}>Suisse</option>
                                    <option value="Canada" {{ auth()->user()->pays === 'Canada' ? 'selected' : '' }}>Canada</option>
                                    <option value="Maroc" {{ auth()->user()->pays === 'Maroc' ? 'selected' : '' }}>Maroc</option>
                                    <option value="Algérie" {{ auth()->user()->pays === 'Algérie' ? 'selected' : '' }}>Algérie</option>
                                    <option value="Tunisie" {{ auth()->user()->pays === 'Tunisie' ? 'selected' : '' }}>Tunisie</option>
                                </select>
                                @error('pays')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ville" class="form-label">
                                    <i class="fas fa-city me-2"></i>
                                    Ville
                                </label>
                                <input type="text" class="form-control @error('ville') is-invalid @enderror" 
                                       id="ville" name="ville" value="{{ auth()->user()->ville }}">
                                @error('ville')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="code_postal" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Code postal
                                </label>
                                <input type="text" class="form-control @error('code_postal') is-invalid @enderror" 
                                       id="code_postal" name="code_postal" value="{{ auth()->user()->code_postal }}">
                                @error('code_postal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rue" class="form-label">
                                <i class="fas fa-map me-2"></i>
                                Adresse
                            </label>
                            <input type="text" class="form-control @error('rue') is-invalid @enderror" 
                                   id="rue" name="rue" value="{{ auth()->user()->rue }}">
                            @error('rue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nom_entreprise" class="form-label">
                                <i class="fas fa-building me-2"></i>
                                Nom de l'entreprise (optionnel)
                            </label>
                            <input type="text" class="form-control @error('nom_entreprise') is-invalid @enderror" 
                                   id="nom_entreprise" name="nom_entreprise" value="{{ auth()->user()->nom_entreprise }}">
                            @error('nom_entreprise')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="commentaire" class="form-label">
                                <i class="fas fa-comment me-2"></i>
                                Commentaire (optionnel)
                            </label>
                            <textarea class="form-control @error('commentaire') is-invalid @enderror" 
                                      id="commentaire" name="commentaire" rows="3">{{ auth()->user()->commentaire }}</textarea>
                            @error('commentaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Sauvegarder les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informations du compte -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Informations du compte
                    </h5>
                </div>
                <div class="card-body">
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Membre depuis</span>
                        <span class="text-muted">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Dernière connexion</span>
                        <span class="text-muted">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between align-items-center mb-3">
                        <span class="fw-semibold">Statut</span>
                        <span class="badge bg-success">Actif</span>
                    </div>
                    @if(auth()->user()->email_verified_at)
                        <div class="info-item d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Email vérifié</span>
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>
                                Oui
                            </span>
                        </div>
                    @else
                        <div class="info-item d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold">Email vérifié</span>
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Non
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-tools me-2"></i>
                        Actions rapides
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="showChangePasswordModal()">
                            <i class="fas fa-key me-2"></i>
                            Changer le mot de passe
                        </button>
                        @if(!auth()->user()->email_verified_at)
                            <button class="btn btn-outline-warning" onclick="resendVerificationEmail()">
                                <i class="fas fa-envelope me-2"></i>
                                Renvoyer l'email de vérification
                            </button>
                        @endif
                        <button class="btn btn-outline-danger" onclick="showDeleteAccountModal()">
                            <i class="fas fa-trash me-2"></i>
                            Supprimer le compte
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Changer le mot de passe -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-key me-2"></i>
                    Changer le mot de passe
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="changePasswordForm">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Sécurité :</strong> Vous devez saisir votre mot de passe actuel pour confirmer le changement.
                    </div>
                    <div class="mb-3">
                        <label for="current_password" class="form-label">
                            <i class="fas fa-lock me-2"></i>
                            Mot de passe actuel *
                        </label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                        <div class="invalid-feedback" id="current_password_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">
                            <i class="fas fa-key me-2"></i>
                            Nouveau mot de passe *
                        </label>
                        <input type="password" class="form-control" id="new_password" name="new_password" 
                               minlength="8" required>
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Le mot de passe doit contenir au moins 8 caractères
                        </small>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">
                            <i class="fas fa-check me-2"></i>
                            Confirmer le nouveau mot de passe *
                        </label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        <div class="invalid-feedback" id="password_confirmation_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        Changer le mot de passe
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Supprimer le compte -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Supprimer le compte
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h6 class="alert-heading">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Attention ! Action irréversible
                    </h6>
                    <p class="mb-0">Cette action supprimera définitivement votre compte et toutes vos données :</p>
                    <ul class="mb-0 mt-2">
                        <li>Tous vos abonnements IPTV</li>
                        <li>Vos factures et paiements</li>
                        <li>Vos tickets de support</li>
                        <li>Toutes vos informations personnelles</li>
                    </ul>
                </div>
                <form id="deleteAccountForm">
                    @csrf
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">
                            <i class="fas fa-lock me-2"></i>
                            Mot de passe actuel *
                        </label>
                        <input type="password" class="form-control" id="delete_password" name="delete_password" required>
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Saisissez votre mot de passe pour confirmer la suppression
                        </small>
                        <div class="invalid-feedback" id="delete_password_error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="delete_confirmation" class="form-label">
                            <i class="fas fa-check me-2"></i>
                            Confirmation *
                        </label>
                        <input type="text" class="form-control" id="delete_confirmation" name="delete_confirmation" 
                               placeholder="Tapez 'SUPPRIMER' pour confirmer" required>
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Tapez exactement "SUPPRIMER" pour confirmer
                        </small>
                        <div class="invalid-feedback" id="delete_confirmation_error"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    Annuler
                </button>
                <button type="button" class="btn btn-danger" onclick="deleteAccount()">
                    <i class="fas fa-trash me-2"></i>
                    Supprimer définitivement
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Gestion du formulaire de profil
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    fetch('/dashboard/profile/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Profil mis à jour avec succès', 'success');
        } else {
            showNotification(data.message || 'Erreur lors de la mise à jour', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la mise à jour du profil', 'error');
    });
});

// Fonctions pour les modals
function showChangePasswordModal() {
    const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
}

function showDeleteAccountModal() {
    const modal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
    modal.show();
}

// Gestion du changement de mot de passe
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Réinitialiser les erreurs
    document.getElementById('current_password').classList.remove('is-invalid');
    document.getElementById('new_password').classList.remove('is-invalid');
    document.getElementById('new_password_confirmation').classList.remove('is-invalid');
    document.getElementById('current_password_error').textContent = '';
    document.getElementById('password_confirmation_error').textContent = '';
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    // Validation côté client
    if (data.new_password.length < 8) {
        document.getElementById('new_password').classList.add('is-invalid');
        showNotification('Le nouveau mot de passe doit contenir au moins 8 caractères', 'error');
        return;
    }

    if (data.new_password !== data.new_password_confirmation) {
        document.getElementById('new_password_confirmation').classList.add('is-invalid');
        document.getElementById('password_confirmation_error').textContent = 'Les mots de passe ne correspondent pas';
        showNotification('Les mots de passe ne correspondent pas', 'error');
        return;
    }

    fetch('/dashboard/settings/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Mot de passe changé avec succès', 'success');
            bootstrap.Modal.getInstance(document.getElementById('changePasswordModal')).hide();
            this.reset();
        } else {
            if (data.errors && data.errors.current_password) {
                document.getElementById('current_password').classList.add('is-invalid');
                document.getElementById('current_password_error').textContent = data.errors.current_password[0];
            }
            showNotification(data.message || 'Erreur lors du changement de mot de passe', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors du changement de mot de passe', 'error');
    });
});

// Fonction pour supprimer le compte
function deleteAccount() {
    // Réinitialiser les erreurs
    document.getElementById('delete_password').classList.remove('is-invalid');
    document.getElementById('delete_confirmation').classList.remove('is-invalid');
    document.getElementById('delete_password_error').textContent = '';
    document.getElementById('delete_confirmation_error').textContent = '';
    
    const password = document.getElementById('delete_password').value;
    const confirmation = document.getElementById('delete_confirmation').value;
    
    // Validation côté client
    if (!password) {
        document.getElementById('delete_password').classList.add('is-invalid');
        document.getElementById('delete_password_error').textContent = 'Le mot de passe est requis';
        showNotification('Veuillez saisir votre mot de passe', 'error');
        return;
    }
    
    if (confirmation !== 'SUPPRIMER') {
        document.getElementById('delete_confirmation').classList.add('is-invalid');
        document.getElementById('delete_confirmation_error').textContent = 'Veuillez taper exactement "SUPPRIMER"';
        showNotification('Veuillez taper "SUPPRIMER" pour confirmer', 'error');
        return;
    }

    fetch('/dashboard/delete-account', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            password: password,
            confirmation: confirmation
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Compte supprimé avec succès', 'success');
            setTimeout(() => {
                window.location.href = '/';
            }, 2000);
        } else {
            if (data.errors && data.errors.password) {
                document.getElementById('delete_password').classList.add('is-invalid');
                document.getElementById('delete_password_error').textContent = data.errors.password[0];
            }
            showNotification(data.message || 'Erreur lors de la suppression', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la suppression du compte', 'error');
    });
}

// Fonction pour renvoyer l'email de vérification
function resendVerificationEmail() {
    fetch('/email/verification-notification', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Email de vérification envoyé', 'success');
        } else {
            showNotification('Erreur lors de l\'envoi de l\'email', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de l\'envoi de l\'email', 'error');
    });
}
</script>
@endpush 