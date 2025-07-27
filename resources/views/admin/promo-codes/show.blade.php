@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-ticket-alt me-2"></i>
                        Détails du code promo : {{ $promoCode->name }}
                    </h3>
                    <div>
                        <a href="{{ route('admin.promo-codes.edit', $promoCode) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>
                            Modifier
                        </a>
                        <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Retour
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Informations principales -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Informations générales
                                    </h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Code :</strong></td>
                                            <td><span class="badge bg-secondary font-monospace fs-6">{{ $promoCode->code }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Nom :</strong></td>
                                            <td>{{ $promoCode->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Description :</strong></td>
                                            <td>{{ $promoCode->description ?: 'Aucune description' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Statut :</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $promoCode->status_color }}">
                                                    {{ $promoCode->status_text }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Type de réduction :</strong></td>
                                            <td>
                                                @if($promoCode->discount_type === 'percentage')
                                                    <span class="badge bg-danger">Pourcentage</span>
                                                @else
                                                    <span class="badge bg-danger">Montant fixe</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Valeur :</strong></td>
                                            <td>
                                                <span class="fs-5 fw-bold text-danger">
                                                    @if($promoCode->discount_type === 'percentage')
                                                        -{{ $promoCode->discount_value }}%
                                                    @else
                                                        -{{ number_format($promoCode->discount_value, 2) }}€
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5 class="mb-3">
                                        <i class="fas fa-cog me-2"></i>
                                        Configuration
                                    </h5>
                                    
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Montant minimum :</strong></td>
                                            <td>{{ $promoCode->min_amount ? number_format($promoCode->min_amount, 2) . '€' : 'Aucun' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Réduction max :</strong></td>
                                            <td>{{ $promoCode->max_discount ? number_format($promoCode->max_discount, 2) . '€' : 'Aucune' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Limite d'usage :</strong></td>
                                            <td>{{ $promoCode->usage_limit }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Utilisations :</strong></td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    @php
                                                        $percentage = $promoCode->usage_limit > 0 ? ($promoCode->used_count / $promoCode->usage_limit) * 100 : 0;
                                                    @endphp
                                                    <div class="progress-bar bg-{{ $percentage >= 100 ? 'danger' : 'success' }}" 
                                                         style="width: {{ min($percentage, 100) }}%">
                                                        {{ $promoCode->used_count }}/{{ $promoCode->usage_limit }}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>S'applique à :</strong></td>
                                            <td>
                                                @if($promoCode->applies_to === 'all')
                                                    <span class="badge bg-primary">Tous les produits</span>
                                                @elseif($promoCode->applies_to === 'specific_products')
                                                    <span class="badge bg-info">Produits spécifiques</span>
                                                @else
                                                    <span class="badge bg-info">Catégories spécifiques</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Dates de validité -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="mb-3">
                                        <i class="fas fa-calendar me-2"></i>
                                        Période de validité
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h6>Date de début</h6>
                                                    @if($promoCode->valid_from)
                                                        <p class="mb-0">{{ $promoCode->valid_from->format('d/m/Y H:i') }}</p>
                                                        <small class="text-muted">{{ $promoCode->valid_from->diffForHumans() }}</small>
                                                    @else
                                                        <p class="mb-0 text-muted">Aucune date</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h6>Date de fin</h6>
                                                    @if($promoCode->valid_until)
                                                        <p class="mb-0">{{ $promoCode->valid_until->format('d/m/Y H:i') }}</p>
                                                        <small class="text-muted">{{ $promoCode->valid_until->diffForHumans() }}</small>
                                                    @else
                                                        <p class="mb-0 text-muted">Aucune date</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statistiques et actions -->
                        <div class="col-md-4">
                            <h5 class="mb-3">
                                <i class="fas fa-chart-bar me-2"></i>
                                Statistiques
                            </h5>
                            
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="info-box bg-primary">
                                        <div class="info-box-content p-3 text-center">
                                            <div class="info-box-number">{{ $promoCode->used_count }}</div>
                                            <div class="info-box-text">Utilisations</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="info-box bg-success">
                                        <div class="info-box-content p-3 text-center">
                                            <div class="info-box-number">{{ $promoCode->email_sent_count }}</div>
                                            <div class="info-box-text">Emails envoyés</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @if($promoCode->last_sent_at)
                            <div class="alert alert-info">
                                <h6><i class="fas fa-clock me-2"></i>Dernier envoi</h6>
                                <p class="mb-0">{{ $promoCode->last_sent_at->format('d/m/Y H:i') }}</p>
                                <small class="text-muted">{{ $promoCode->last_sent_at->diffForHumans() }}</small>
                            </div>
                            @endif
                            
                            <h5 class="mb-3 mt-4">
                                <i class="fas fa-tools me-2"></i>
                                Actions rapides
                            </h5>
                            
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-primary" 
                                        onclick="showSendModal({{ $promoCode->id }}, '{{ $promoCode->name }}')">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Envoyer aux clients
                                </button>
                                
                                <a href="{{ route('admin.promo-codes.duplicate', $promoCode) }}" class="btn btn-info">
                                    <i class="fas fa-copy me-2"></i>
                                    Dupliquer
                                </a>
                                
                                <button type="button" class="btn btn-{{ $promoCode->is_active ? 'warning' : 'success' }}" 
                                        onclick="toggleStatus({{ $promoCode->id }})">
                                    <i class="fas fa-{{ $promoCode->is_active ? 'pause' : 'play' }} me-2"></i>
                                    {{ $promoCode->is_active ? 'Désactiver' : 'Activer' }}
                                </button>
                                
                                <button type="button" class="btn btn-danger" 
                                        onclick="deletePromoCode({{ $promoCode->id }})">
                                    <i class="fas fa-trash me-2"></i>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
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
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>
                        Envoyer les emails
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
            alert(data.message);
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

function deletePromoCode(promoId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce code promo ?')) {
        fetch(`/admin/promo-codes/${promoId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.location.href = '{{ route("admin.promo-codes.index") }}';
            }
        });
    }
}
</script>
@endpush 