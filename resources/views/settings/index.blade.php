@extends('layouts.dashboard')

@section('title', 'Paramètres')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-cog me-2"></i>
                Paramètres
            </h1>
            <p class="text-muted">Gérez vos préférences et notifications</p>
        </div>
    </div>

    <div class="row">
        <!-- Paramètres de Notifications -->
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bell me-2"></i>
                        Paramètres de Notifications
                    </h5>
                </div>
                <div class="card-body">
                    <form id="notificationsForm">
                        @csrf
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" 
                                       {{ $settings->email_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">
                                    <i class="fas fa-envelope me-2"></i>
                                    Notifications par email
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications" 
                                       {{ $settings->sms_notifications ? 'checked' : '' }}>
                                <label class="form-check-label" for="sms_notifications">
                                    <i class="fas fa-mobile-alt me-2"></i>
                                    Notifications par SMS
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="billing_reminders" name="billing_reminders" 
                                       {{ $settings->billing_reminders ? 'checked' : '' }}>
                                <label class="form-check-label" for="billing_reminders">
                                    <i class="fas fa-credit-card me-2"></i>
                                    Rappels de facturation
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="newsletter_offers" name="newsletter_offers" 
                                       {{ $settings->newsletter_offers ? 'checked' : '' }}>
                                <label class="form-check-label" for="newsletter_offers">
                                    <i class="fas fa-newspaper me-2"></i>
                                    Newsletter et offres spéciales
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="support_updates" name="support_updates" 
                                       {{ $settings->support_updates ? 'checked' : '' }}>
                                <label class="form-check-label" for="support_updates">
                                    <i class="fas fa-headset me-2"></i>
                                    Mises à jour du support
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="order_updates" name="order_updates" 
                                       {{ $settings->order_updates ? 'checked' : '' }}>
                                <label class="form-check-label" for="order_updates">
                                    <i class="fas fa-shopping-cart me-2"></i>
                                    Mises à jour des commandes
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="security_alerts" name="security_alerts" 
                                       {{ $settings->security_alerts ? 'checked' : '' }}>
                                <label class="form-check-label" for="security_alerts">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Alertes de sécurité
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Sauvegarder les paramètres
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Préférences -->
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-cog me-2"></i>
                        Préférences
                    </h5>
                </div>
                <div class="card-body">
                    <form id="preferencesForm">
                        @csrf
                        <div class="mb-3">
                            <label for="language" class="form-label">
                                <i class="fas fa-language me-2"></i>
                                Langue
                            </label>
                            <select class="form-select" id="language" name="language">
                                <option value="fr" {{ $settings->language === 'fr' ? 'selected' : '' }}>Français</option>
                                <option value="en" {{ $settings->language === 'en' ? 'selected' : '' }}>English</option>
                                <option value="es" {{ $settings->language === 'es' ? 'selected' : '' }}>Español</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="timezone" class="form-label">
                                <i class="fas fa-clock me-2"></i>
                                Fuseau horaire
                            </label>
                            <select class="form-select" id="timezone" name="timezone">
                                <option value="Europe/Paris" {{ $settings->timezone === 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                                <option value="Europe/London" {{ $settings->timezone === 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                                <option value="America/New_York" {{ $settings->timezone === 'America/New_York' ? 'selected' : '' }}>America/New York</option>
                                <option value="Asia/Tokyo" {{ $settings->timezone === 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="theme" class="form-label">
                                <i class="fas fa-palette me-2"></i>
                                Thème
                            </label>
                            <select class="form-select" id="theme" name="theme">
                                <option value="light" {{ $settings->theme === 'light' ? 'selected' : '' }}>Clair</option>
                                <option value="dark" {{ $settings->theme === 'dark' ? 'selected' : '' }}>Sombre</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>
                                Sauvegarder les préférences
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sécurité -->
        <div class="col-lg-6 mb-4">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>
                        Sécurité
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('settings.profile') }}" class="btn btn-outline-primary">
                            <i class="fas fa-user-edit me-2"></i>
                            Gérer le profil
                        </a>
                        <a href="#" class="btn btn-outline-info" onclick="showChangePasswordModal()">
                            <i class="fas fa-key me-2"></i>
                            Changer le mot de passe
                        </a>
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
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Changer le mot de passe</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
// Gestion des formulaires de paramètres
document.getElementById('notificationsForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    // Convertir les checkboxes en booléens
    Object.keys(data).forEach(key => {
        data[key] = data[key] === 'on';
    });

    fetch('/settings/notifications', {
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
            showNotification(data.message, 'success');
        } else {
            showNotification('Erreur lors de la sauvegarde', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la sauvegarde', 'error');
    });
});

document.getElementById('preferencesForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

    fetch('/settings/preferences', {
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
            showNotification(data.message, 'success');
        } else {
            showNotification('Erreur lors de la sauvegarde', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la sauvegarde', 'error');
    });
});

// Fonctions pour les modals
function showChangePasswordModal() {
    const modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
}

// Gestion du changement de mot de passe
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);

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
            showNotification(data.message || 'Erreur lors du changement de mot de passe', 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors du changement de mot de passe', 'error');
    });
});


</script>
@endpush 