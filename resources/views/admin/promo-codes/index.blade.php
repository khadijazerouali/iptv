@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Gestion des codes promo
                    </h3>
                    <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Nouveau code promo
                    </a>
                </div>
                
                <!-- Statistiques -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total codes</h5>
                                    <h2>{{ $stats['total'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Codes actifs</h5>
                                    <h2>{{ $stats['active'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Codes expirés</h5>
                                    <h2>{{ $stats['expired'] }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Emails envoyés</h5>
                                    <h2>{{ $stats['total_emails_sent'] }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table des codes promo -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Nom</th>
                                    <th>Réduction</th>
                                    <th>Statut</th>
                                    <th>Utilisations</th>
                                    <th>Validité</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promoCodes as $promoCode)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary font-monospace">{{ $promoCode->code }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $promoCode->name }}</strong>
                                        @if($promoCode->description)
                                            <br><small class="text-muted">{{ Str::limit($promoCode->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($promoCode->discount_type === 'percentage')
                                            <span class="badge bg-danger">-{{ $promoCode->discount_value }}%</span>
                                        @else
                                            <span class="badge bg-danger">-{{ number_format($promoCode->discount_value, 2) }}€</span>
                                        @endif
                                        @if($promoCode->max_discount)
                                            <br><small class="text-muted">Max: {{ number_format($promoCode->max_discount, 2) }}€</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusConfig = [
                                                'inactive' => ['class' => 'secondary', 'icon' => 'times-circle', 'label' => 'Inactif'],
                                                'pending' => ['class' => 'warning', 'icon' => 'clock', 'label' => 'En attente'],
                                                'active' => ['class' => 'success', 'icon' => 'check-circle', 'label' => 'Actif'],
                                                'expired' => ['class' => 'danger', 'icon' => 'calendar-times', 'label' => 'Expiré'],
                                                'exhausted' => ['class' => 'danger', 'icon' => 'exclamation-triangle', 'label' => 'Épuisé']
                                            ];
                                            $status = $promoCode->status;
                                            $config = $statusConfig[$status] ?? $statusConfig['inactive'];
                                        @endphp
                                        <span class="badge bg-{{ $config['class'] }} bg-opacity-10 text-{{ $config['class'] }} border border-{{ $config['class'] }} border-opacity-25 px-3 py-2">
                                            <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $promoCode->used_count }} / {{ $promoCode->usage_limit }}
                                        @if($promoCode->email_sent_count > 0)
                                            <br><small class="text-muted">{{ $promoCode->email_sent_count }} emails envoyés</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($promoCode->valid_from && $promoCode->valid_until)
                                            <small>
                                                Du: {{ $promoCode->valid_from->format('d/m/Y') }}<br>
                                                Au: {{ $promoCode->valid_until->format('d/m/Y') }}
                                            </small>
                                        @else
                                            <span class="text-muted">Illimitée</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" 
                                                    onclick="showSendModal({{ $promoCode->id }}, '{{ $promoCode->name }}')">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                            <a href="{{ route('admin.promo-codes.edit', $promoCode) }}" 
                                               class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-info" 
                                                    onclick="duplicatePromoCode({{ $promoCode->id }})">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-{{ $promoCode->is_active ? 'warning' : 'success' }}" 
                                                    onclick="toggleStatus({{ $promoCode->id }})">
                                                <i class="fas fa-{{ $promoCode->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="deletePromoCode({{ $promoCode->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-ticket-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Aucun code promo créé pour le moment.</p>
                                        <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>
                                            Créer le premier code promo
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($promoCodes->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $promoCodes->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'envoi d'email -->
<div class="modal fade" id="sendPromoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-paper-plane me-2"></i>
                    Envoyer le code promo
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="sendPromoForm">
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Sélectionnez les utilisateurs à qui envoyer le code promo <strong id="promoName"></strong>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sélectionner les utilisateurs :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label" for="selectAll">
                                <strong>Sélectionner tous les utilisateurs</strong>
                            </label>
                        </div>
                        <hr>
                        <div id="usersList" style="max-height: 300px; overflow-y: auto;">
                            <!-- Liste des utilisateurs chargée via AJAX -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-warning" onclick="sendToAllUsers()">
                        <i class="fas fa-broadcast-tower me-2"></i>
                        Envoyer à tous les utilisateurs
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>
                        Envoyer aux sélectionnés
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentPromoId = null;

function showSendModal(promoId, promoName) {
    currentPromoId = promoId;
    document.getElementById('promoName').textContent = promoName;
    
    // Charger la liste des utilisateurs
    fetch('/admin/promo-codes/users')
        .then(response => response.json())
        .then(users => {
            const usersList = document.getElementById('usersList');
            usersList.innerHTML = '';
            
            users.forEach(user => {
                const div = document.createElement('div');
                div.className = 'form-check';
                div.innerHTML = `
                    <input class="form-check-input user-checkbox" type="checkbox" name="user_ids[]" value="${user.id}" id="user_${user.id}">
                    <label class="form-check-label" for="user_${user.id}">
                        ${user.name} (${user.email})
                    </label>
                `;
                usersList.appendChild(div);
            });
        });
    
    const modal = new bootstrap.Modal(document.getElementById('sendPromoModal'));
    modal.show();
}

// Gestion de la sélection "Tout sélectionner"
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Envoi du formulaire
document.getElementById('sendPromoForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const selectedUsers = Array.from(document.querySelectorAll('.user-checkbox:checked'))
        .map(checkbox => checkbox.value);
    
    if (selectedUsers.length === 0) {
        alert('Veuillez sélectionner au moins un utilisateur.');
        return;
    }
    
    const formData = new FormData();
    formData.append('user_ids', JSON.stringify(selectedUsers));
    
    fetch(`/admin/promo-codes/${currentPromoId}/send`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let message = data.message;
            if (data.errors && data.errors.length > 0) {
                message += '\n\nErreurs détaillées:\n' + data.errors.join('\n');
            }
            alert(message);
            bootstrap.Modal.getInstance(document.getElementById('sendPromoModal')).hide();
            location.reload();
        } else {
            alert('Erreur lors de l\'envoi des emails.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'envoi des emails.');
    });
});

function sendToAllUsers() {
    if (!confirm('Êtes-vous sûr de vouloir envoyer ce code promo à TOUS les utilisateurs actifs ?')) {
        return;
    }
    
    fetch(`/admin/promo-codes/${currentPromoId}/send-all`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let message = data.message;
            if (data.errors && data.errors.length > 0) {
                message += '\n\nErreurs détaillées:\n' + data.errors.join('\n');
            }
            alert(message);
            bootstrap.Modal.getInstance(document.getElementById('sendPromoModal')).hide();
            location.reload();
        } else {
            alert(data.message || 'Erreur lors de l\'envoi des emails.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'envoi des emails.');
    });
}

function toggleStatus(promoId) {
    if (confirm('Voulez-vous changer le statut de ce code promo ?')) {
        fetch(`/admin/promo-codes/${promoId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload();
            }
        });
    }
}

function duplicatePromoCode(promoId) {
    if (confirm('Voulez-vous dupliquer ce code promo ?')) {
        window.location.href = `/admin/promo-codes/${promoId}/duplicate`;
    }
}

function deletePromoCode(promoId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce code promo ?')) {
        fetch(`/admin/promo-codes/${promoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Erreur lors de la suppression du code promo.');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la suppression du code promo.');
        });
    }
}
</script>
@endpush 