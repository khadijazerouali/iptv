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
                <h3>{{ number_format($stats['total_contacts']) }}</h3>
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
                <h3>{{ number_format($stats['replied_contacts']) }}</h3>
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
                <h3>{{ number_format($stats['pending_contacts']) }}</h3>
                <p>En attente</p>
            </div>
        </div>
    </div>
    
    <div class="stat-card info">
        <div class="stat-content">
            <div class="stat-icon">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-details">
                <h3>{{ number_format($stats['read_contacts']) }}</h3>
                <p>Lus</p>
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
            <select class="form-select form-select-sm" style="width: auto;" id="statusFilter">
                <option value="">Tous les statuts</option>
                <option value="pending">En attente</option>
                <option value="read">Lus</option>
                <option value="replied">Répondus</option>
                <option value="closed">Fermés</option>
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
                @forelse($contacts as $contact)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $loop->iteration }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-semibold text-dark">{{ $contact->name }}</div>
                                <small class="text-muted">{{ $contact->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold text-dark">{{ $contact->type ?? 'Contact général' }}</div>
                        <small class="text-muted">{{ Str::limit($contact->message, 50) }}</small>
                    </td>
                    <td>
                        @switch($contact->status)
                            @case('pending')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    En attente
                                </span>
                                @break
                            @case('read')
                                <span class="badge badge-info">
                                    <i class="fas fa-eye me-1"></i>
                                    Lu
                                </span>
                                @break
                            @case('replied')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Répondu
                                </span>
                                @break
                            @case('closed')
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Fermé
                                </span>
                                @break
                            @default
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    En attente
                                </span>
                        @endswitch
                    </td>
                    <td>
                        <span class="badge badge-info">
                            <i class="fas fa-info-circle me-1"></i>
                            Normal
                        </span>
                    </td>
                    <td>
                        <div class="text-muted">
                            <div>{{ $contact->created_at->format('d/m/Y') }}</div>
                            <small>{{ $contact->created_at->format('H:i') }}</small>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <button class="btn btn-outline-primary btn-sm" onclick="viewContact('{{ $contact->uuid }}')">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($contact->status !== 'replied')
                            <button class="btn btn-outline-success btn-sm" onclick="markAsReplied('{{ $contact->uuid }}')">
                                <i class="fas fa-reply"></i>
                            </button>
                            @endif
                            @if($contact->status !== 'closed')
                            <button class="btn btn-outline-warning btn-sm" onclick="markAsClosed('{{ $contact->uuid }}')">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteContact('{{ $contact->uuid }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="text-muted">
                            <i class="fas fa-inbox fa-2x mb-3"></i>
                            <p>Aucun message de contact trouvé</p>
                        </div>
                    </td>
                </tr>
                                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($contacts->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $contacts->links() }}
    </div>
    @endif
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
    
    fetch(`/admin/contacts/${contactId}`)
        .then(response => response.json())
        .then(contact => {
            hideLoading();
            document.getElementById('contactModalContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations de l'expéditeur</h6>
                        <p><strong>Nom:</strong> ${contact.name}</p>
                        <p><strong>Email:</strong> ${contact.email}</p>
                        <p><strong>Type:</strong> ${contact.type || 'Contact général'}</p>
                        ${contact.country ? `<p><strong>Pays:</strong> ${contact.country}</p>` : ''}
                    </div>
                    <div class="col-md-6">
                        <h6>Détails du message</h6>
                        <p><strong>Date:</strong> ${new Date(contact.created_at).toLocaleString('fr-FR')}</p>
                        <p><strong>Statut:</strong> ${getStatusLabel(contact.status)}</p>
                        ${contact.ip ? `<p><strong>IP:</strong> ${contact.ip}</p>` : ''}
                    </div>
                </div>
                <hr>
                <div class="mt-3">
                    <h6>Message</h6>
                    <div class="bg-light p-3 rounded">
                        <p>${contact.message.replace(/\n/g, '<br>')}</p>
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('contactModal')).show();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors du chargement des détails', 'error');
        });
}

// Fonction pour obtenir le label du statut
function getStatusLabel(status) {
    const labels = {
        'pending': 'En attente',
        'read': 'Lu',
        'replied': 'Répondu',
        'closed': 'Fermé'
    };
    return labels[status] || 'En attente';
}

function replyContact(contactId) {
    showNotification('Fonctionnalité de réponse en cours de développement', 'info');
}

// Marquer comme répondu
function markAsReplied(contactId) {
    if (confirm('Marquer ce contact comme répondu ?')) {
        fetch(`/admin/contacts/${contactId}/replied`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la mise à jour', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Erreur lors de la mise à jour', 'error');
        });
    }
}

// Marquer comme fermé
function markAsClosed(contactId) {
    if (confirm('Marquer ce contact comme fermé ?')) {
        fetch(`/admin/contacts/${contactId}/closed`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la mise à jour', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Erreur lors de la mise à jour', 'error');
        });
    }
}

// Supprimer un contact
function deleteContact(contactId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')) {
        fetch(`/admin/contacts/${contactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Erreur lors de la suppression', 'error');
        });
    }
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