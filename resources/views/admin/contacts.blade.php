@extends('layouts.admin')

@section('title', 'Gestion des contacts')

@section('content')
<style>
/* Styles personnalisés pour la pagination */
.pagination {
    gap: 2px;
}

.pagination .page-link {
    border: 1px solid #e9ecef;
    color: #495057;
    background-color: #fff;
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    transition: all 0.2s ease-in-out;
}

.pagination .page-link:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
    color: #495057;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    font-weight: 600;
}

.pagination .page-item.disabled .page-link {
    background-color: #f8f9fa;
    border-color: #e9ecef;
    color: #6c757d;
    cursor: not-allowed;
}

.pagination .page-link:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    outline: none;
}

/* Animation pour les transitions de page */
.admin-card {
    transition: opacity 0.3s ease-in-out;
}

.admin-card.loading {
    opacity: 0.6;
    pointer-events: none;
}

/* Amélioration de l'affichage des statistiques de pagination */
.pagination-info {
    font-size: 0.875rem;
    color: #6c757d;
    font-weight: 500;
}

/* Responsive pour la pagination */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
        align-items: center !important;
    }
    
    .pagination {
        justify-content: center;
    }
}
</style>

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
                <input type="text" class="form-control border-start-0" placeholder="Rechercher un message..." id="searchInput">
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Expéditeur</th>
                    <th>Sujet</th>
                    <th>Statut</th>
                    <th>Priorité</th>
                    <th>Date/Heure</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                <tr>
                    <td>
                        <span class="fw-bold text-primary">#{{ $contact->id }}</span>
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
                                    EN ATTENTE
                                </span>
                                @break
                            @case('read')
                                <span class="badge badge-info">
                                    <i class="fas fa-eye me-1"></i>
                                    LU
                                </span>
                                @break
                            @case('replied')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle me-1"></i>
                                    RÉPONDU
                                </span>
                                @break
                            @case('closed')
                                <span class="badge badge-secondary">
                                    <i class="fas fa-times-circle me-1"></i>
                                    FERMÉ
                                </span>
                                @break
                            @default
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    EN ATTENTE
                                </span>
                        @endswitch
                    </td>
                    <td>
                        <span class="badge badge-info">
                            <i class="fas fa-info-circle me-1"></i>
                            NORMAL
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
                            <button class="btn btn-outline-primary btn-sm" onclick="viewContact('{{ $contact->uuid }}')" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>
                            @if($contact->status !== 'replied')
                            <button class="btn btn-outline-success btn-sm" onclick="markAsReplied('{{ $contact->uuid }}')" title="Marquer comme répondu">
                                <i class="fas fa-reply"></i>
                            </button>
                            @endif
                            @if($contact->status !== 'closed')
                            <button class="btn btn-outline-warning btn-sm" onclick="markAsClosed('{{ $contact->uuid }}')" title="Marquer comme fermé">
                                <i class="fas fa-times"></i>
                            </button>
                            @endif
                            <button class="btn btn-outline-danger btn-sm" onclick="deleteContact('{{ $contact->uuid }}')" title="Supprimer">
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
    <div class="d-flex justify-content-between align-items-center mt-4 p-3 bg-light rounded">
        <div class="pagination-info">
            <i class="fas fa-info-circle me-1"></i>
            Affichage de <strong>{{ $contacts->firstItem() ?? 0 }}</strong> à <strong>{{ $contacts->lastItem() ?? 0 }}</strong> sur <strong>{{ $contacts->total() }}</strong> résultats
        </div>
        <nav aria-label="Navigation des contacts">
            <ul class="pagination pagination-sm mb-0">
                {{-- Bouton Précédent --}}
                @if ($contacts->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link" title="Page précédente">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $contacts->previousPageUrl() }}" rel="prev" title="Page précédente">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                @endif

                {{-- Numéros de pages --}}
                @php
                    $start = max(1, $contacts->currentPage() - 2);
                    $end = min($contacts->lastPage(), $contacts->currentPage() + 2);
                @endphp

                @if($start > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $contacts->url(1) }}">1</a>
                    </li>
                    @if($start > 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $contacts->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $contacts->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endfor

                @if($end < $contacts->lastPage())
                    @if($end < $contacts->lastPage() - 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $contacts->url($contacts->lastPage()) }}">{{ $contacts->lastPage() }}</a>
                    </li>
                @endif

                {{-- Bouton Suivant --}}
                @if ($contacts->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $contacts->nextPageUrl() }}" rel="next" title="Page suivante">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link" title="Page suivante">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
    @endif
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
            </div>
        </div>
    </div>
</div>

<script>
// Fonctions pour la gestion des contacts
function viewContact(contactId) {
    showLoading();
    
    fetch(`/admin/contacts/${contactId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(contact => {
            hideLoading();
            document.getElementById('contactModalContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informations de l'expéditeur</h6>
                        <p><strong>Nom:</strong> ${contact.name || 'N/A'}</p>
                        <p><strong>Email:</strong> ${contact.email || 'N/A'}</p>
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
                        <p>${(contact.message || '').replace(/\n/g, '<br>')}</p>
                    </div>
                </div>
            `;
            
            new bootstrap.Modal(document.getElementById('contactModal')).show();
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors du chargement des détails: ' + error.message, 'error');
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

// Marquer comme répondu
function markAsReplied(contactId) {
    if (confirm('Marquer ce contact comme répondu ?')) {
        showLoading();
        
        fetch(`/admin/contacts/${contactId}/replied`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
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
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la mise à jour: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de la mise à jour: ' + error.message, 'error');
        });
    }
}

// Marquer comme fermé
function markAsClosed(contactId) {
    if (confirm('Marquer ce contact comme fermé ?')) {
        showLoading();
        
        fetch(`/admin/contacts/${contactId}/closed`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
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
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la mise à jour: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de la mise à jour: ' + error.message, 'error');
        });
    }
}

// Supprimer un contact
function deleteContact(contactId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce contact ?')) {
        showLoading();
        
        fetch(`/admin/contacts/${contactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
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
                showNotification(data.message, 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showNotification('Erreur lors de la suppression: ' + (data.message || 'Erreur inconnue'), 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.error('Error:', error);
            showNotification('Erreur lors de la suppression: ' + error.message, 'error');
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

// Filtrage par statut
document.getElementById('statusFilter').addEventListener('change', function(e) {
    const selectedStatus = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const statusCell = row.querySelector('td:nth-child(4)'); // Colonne du statut
        if (statusCell) {
            const statusText = statusCell.textContent.toLowerCase();
            if (!selectedStatus || statusText.includes(selectedStatus)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});

// Amélioration de la pagination
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des effets de chargement lors de la navigation
    const paginationLinks = document.querySelectorAll('.pagination .page-link');
    
    paginationLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Ajouter une classe de chargement à la carte principale
            const adminCard = document.querySelector('.admin-card');
            if (adminCard) {
                adminCard.classList.add('loading');
            }
            
            // Afficher un indicateur de chargement
            showNotification('Chargement de la page...', 'info');
        });
    });
    
    // Améliorer l'affichage des informations de pagination
    const paginationInfo = document.querySelector('.pagination-info');
    if (paginationInfo) {
        // Ajouter une animation subtile
        paginationInfo.style.transition = 'opacity 0.3s ease-in-out';
        
        // Améliorer l'accessibilité
        paginationInfo.setAttribute('role', 'status');
        paginationInfo.setAttribute('aria-live', 'polite');
    }
    
    // Ajouter des raccourcis clavier pour la navigation
    document.addEventListener('keydown', function(e) {
        // Ctrl + ← pour page précédente
        if (e.ctrlKey && e.key === 'ArrowLeft') {
            const prevLink = document.querySelector('.pagination .page-link[rel="prev"]');
            if (prevLink) {
                e.preventDefault();
                prevLink.click();
            }
        }
        
        // Ctrl + → pour page suivante
        if (e.ctrlKey && e.key === 'ArrowRight') {
            const nextLink = document.querySelector('.pagination .page-link[rel="next"]');
            if (nextLink) {
                e.preventDefault();
                nextLink.click();
            }
        }
    });
    
    // Améliorer l'expérience mobile
    if (window.innerWidth <= 768) {
        const pagination = document.querySelector('.pagination');
        if (pagination) {
            pagination.style.flexWrap = 'wrap';
            pagination.style.justifyContent = 'center';
        }
    }
});
</script>
@endsection 