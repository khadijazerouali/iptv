@extends('layouts.main')

@section('title', 'Mon Dashboard')

@section('content')


<div class="dashboard-container">
    
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        ☰
    </button>

    <!-- Overlay for mobile -->
    <div class="overlay" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2 class="sidebar-title">Mon Dashboard</h2>
            <div class="user-welcome">
                Bienvenue, {{ $user->name }}
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a class="sidebar-link active" onclick="showSection('profile')" data-section="profile">
                    <span class="sidebar-icon">👤</span>
                    Mes Informations
                </a>
            </li>
     
            <li class="sidebar-item">
                <a class="sidebar-link" onclick="showSection('commandes')" data-section="commandes">
                    <span class="sidebar-icon">📦</span>
                    Mes Commandes
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" onclick="showSection('panier')" data-section="panier">
                    <span class="sidebar-icon">🛒</span>
                    Mon Panier
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" onclick="showSection('support')" data-section="support">
                    <span class="sidebar-icon">🛠️</span>
                    Support
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Profile Section - Mes Informations Personnelles -->
        <section class="content-section" id="profile" style="display: block;">
            <div class="section-header">
                <h2 class="section-title">Mes Informations Personnelles</h2>
                <p class="section-subtitle">Mettez à jour vos données de profil (Email non modifiable)</p>
            </div>

            <div class="info-card">
                <form action="{{ route('dashboard.updateProfile') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nom :</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
                        <small class="form-text text-muted">L'adresse e-mail ne peut pas être modifiée.</small>
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone :</label>
                        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="ville">Ville :</label>
                        <input type="text" id="ville" name="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville', $user->ville) }}">
                        @error('ville')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-actions" style="margin-top: 1.5rem; text-align: right;">
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Commandes Section - From Subscriptions -->
        <section class="content-section" id="commandes" style="display: none;">
            <div class="section-header">
                <h1 class="section-title">Mes Commandes</h1>
                <p class="section-subtitle">Historique de vos achats et formations</p>
            </div>
        
            @if($subscriptions->count() > 0)
                <div class="grid">
                    @foreach($subscriptions as $subscription)
                        <div class="card">
                            <h3 class="card-title">Commande #{{ $subscription->number_order }}</h3>
                            
                            <div class="card-meta">
                                <strong>Date début:</strong> {{ $subscription->start_date }}<br>
                                <strong>Date fin:</strong> {{ $subscription->end_date }}<br>
                                <strong>Produit UUID:</strong> {{ $subscription->product_uuid }}<br>
                                <strong>Quantité:</strong> {{ $subscription->quantity }}<br>
                                <strong>Status:</strong> {{ $subscription->status }}<br>
                            </div>
        
                            <div class="card-description">
                                <strong>Note:</strong><br>
                                {{ $subscription->note ?? 'Aucune note.' }}
                            </div>

                            <!-- Product Option -->
                            @if($subscription->productOption)
                                <div><strong>Option Produit:</strong> {{ $subscription->productOption->name }}</div>
                            @endif

                            <!-- Application Type -->
                            @if($subscription->applicationType)
                                <div><strong>Type d'application:</strong> {{ $subscription->applicationType->name }}</div>
                            @endif

                            <!-- Device Type -->
                            @if($subscription->deviceType)
                                <div><strong>Type de device:</strong> {{ $subscription->deviceType->name }}</div>
                            @endif

                            <!-- VODs -->
                            @if($subscription->vods && $subscription->vods->count())
                                <div><strong>VODs:</strong>
                                    <ul>
                                        @foreach($subscription->vods as $vod)
                                            <li>{{ $vod->title }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Infos MAC -->
                            <div>
                                @if($subscription->macaddress)
                                    <div><strong>MAC Address:</strong> {{ $subscription->macaddress }}</div>
                                @endif

                                @if($subscription->magaddress)
                                    <div><strong>MAG Address:</strong> {{ $subscription->magaddress }}</div>
                                @endif

                                @if($subscription->formulermac)
                                    <div><strong>Formuler MAC:</strong> {{ $subscription->formulermac }}</div>
                                @endif

                                @if($subscription->formulermag)
                                    <div><strong>Formuler MAG:</strong> {{ $subscription->formulermag }}</div>
                                @endif
                            </div>
                            
                            <div style="margin-top: 1rem;">
                                <button onclick="showOrderDetails({{ $subscription->id }})" class="btn">Voir Détails</button>
                                <button onclick="downloadInvoice({{ $subscription->id }})" class="btn btn-secondary" style="margin-left: 0.5rem;">Télécharger facture</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <h3>Aucune commande trouvée</h3>
                    <p>Vous n'avez pas encore passé de commande.</p>
                </div>
            @endif
        </section>

        <!-- Panier Section - Session Based -->
        <section class="content-section" id="panier" style="display: none;">
            <div class="section-header">
                <h1 class="section-title">Mon Panier</h1>
                <p class="section-subtitle">Articles en attente d'achat</p>
            </div>
        
            @if($cartItems->count() > 0)
                <div class="grid">
                    @foreach($cartItems as $id => $cartItem)
                        <div class="card">
                            <h3 class="card-title">{{ $cartItem['title'] }}</h3>
                            <div class="card-meta">
                                Prix: <span class="price">{{ number_format($cartItem['price'], 2) }}€</span> • 
                                Durée: {{ $cartItem['duration_hours'] ?? '?' }}h • 
                                Niveau: {{ ucfirst($cartItem['level'] ?? 'N/A') }}
                            </div>
                            <p class="card-description">{{ $cartItem['description'] ?? 'Aucune description.' }}</p>
                            <div style="margin-top: 1rem;">
                                <a href="#" class="btn">Acheter maintenant</a>
                                <form method="POST" action="{{ route('cart.remove', $id) }}" style="display: inline-block; margin-left: 0.5rem;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
        
                    <!-- Cart Total -->
                    <div class="card" style="border-color: rgb(0, 107, 179); background-color: #f8fafc;">
                        <h3 class="card-title" style="color: rgb(0, 107, 179);">Total du panier</h3>
                        <div class="card-meta">
                            {{ $cartItems->count() }} article{{ $cartItems->count() > 1 ? 's' : '' }} • 
                            Total: <span class="price" style="font-size: 1.5rem;">{{ number_format($cartTotal, 2) }}€</span>
                        </div>
                        <div style="margin-top: 1rem;">
                            <a href="#" class="btn" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                                Procéder au paiement
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🛒</div>
                    <h3>Votre panier est vide</h3>
                    <p>Ajoutez des formations à votre panier pour les acheter.</p>
                </div>
            @endif
        </section>

        <!-- Support Section -->
        <section class="content-section" id="support" style="display: none;">
            <div class="section-header">
                <h1 class="section-title">Support</h1>
                <p class="section-subtitle">Vos tickets de support</p>
            </div>
            
            @if($supportTickets->count() > 0)
                <div class="grid">
                    @foreach($supportTickets as $ticket)
                        <div class="card">
                            <h3 class="card-title">Ticket #{{ $ticket->id }}</h3>
                            <div class="card-meta">
                                <strong>Sujet:</strong> {{ $ticket->subject }}<br>
                                <strong>Status:</strong> {{ $ticket->status }}<br>
                                <strong>Date:</strong> {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </div>
                            <p class="card-description">{{ Str::limit($ticket->message, 100) }}</p>
                            <div style="margin-top: 1rem;">
                                <a href="#" class="btn">Voir Détails</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">🛠️</div>
                    <h3>Aucun ticket de support</h3>
                    <p>Vous n'avez pas encore créé de ticket de support.</p>
                </div>
            @endif
        </section>

    </main>
</div>

<!-- JavaScript pour la navigation des sections -->
<script>
function showSection(sectionName) {
    // Masquer toutes les sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.style.display = 'none';
    });
    
    // Afficher la section sélectionnée
    const targetSection = document.getElementById(sectionName);
    if (targetSection) {
        targetSection.style.display = 'block';
    }
    
    // Mettre à jour les liens actifs
    const links = document.querySelectorAll('.sidebar-link');
    links.forEach(link => {
        link.classList.remove('active');
    });
    
    // Ajouter la classe active au lien cliqué
    const activeLink = document.querySelector(`[data-section="${sectionName}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
    
    // Fermer la sidebar sur mobile après sélection
    closeSidebar();
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.overlay');
    
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
}

function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.overlay');
    
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
}

// Afficher la section profil par défaut au chargement
document.addEventListener('DOMContentLoaded', function() {
    showSection('profile');
});

// Fonction pour afficher les détails d'une commande
function showOrderDetails(subscriptionId) {
    // Créer une modal pour afficher les détails
    const modal = createModal('Détails de la commande #' + subscriptionId, 'order-details-modal');
    
    // Rechercher les données de la subscription
    const subscriptionCard = document.querySelector(`[data-subscription="${subscriptionId}"]`)?.closest('.card');
    if (!subscriptionCard) {
        alert('Commande non trouvée');
        return;
    }
    
    // Extraire les informations de la card
    const title = subscriptionCard.querySelector('.card-title')?.textContent || 'N/A';
    const meta = subscriptionCard.querySelector('.card-meta')?.innerHTML || 'Aucune information';
    const description = subscriptionCard.querySelector('.card-description')?.innerHTML || 'Aucune description';
    
    // Contenu de la modal
    const modalContent = `
        <div class="order-details">
            <h3>${title}</h3>
            <div class="details-section">
                <h4>Informations générales :</h4>
                <div>${meta}</div>
            </div>
            <div class="details-section">
                <h4>Notes :</h4>
                <div>${description}</div>
            </div>
            <div class="details-section">
                <h4>Actions disponibles :</h4>
                <button onclick="downloadInvoice(${subscriptionId})" class="btn btn-secondary">
                    📄 Télécharger la facture
                </button>
                <button onclick="contactSupport(${subscriptionId})" class="btn" style="margin-left: 0.5rem;">
                    💬 Contacter le support
                </button>
            </div>
        </div>
    `;
    
    showModal(modal, modalContent);
}

// Fonction pour télécharger une facture
function downloadInvoice(subscriptionId) {
    // Afficher un message de chargement
    const loadingToast = showToast('Génération de la facture en cours...', 'info');
    
    // Simuler le téléchargement (remplacez par votre logique réelle)
    setTimeout(() => {
        loadingToast.remove();
        
        const link = document.createElement('a');
        link.href = '#'; // Remplacez par l'URL de votre API
        link.download = `facture-commande-${subscriptionId}.pdf`;
        link.textContent = 'Télécharger';
        
        // Pour la démo, on affiche juste un message
        showToast(`Facture pour la commande #${subscriptionId} téléchargée avec succès !`, 'success');
        
    
    }, 2000);
}

// Fonction pour contacter le support
function contactSupport(subscriptionId) {
    const modal = createModal('Contacter le support', 'support-modal');
    const modalContent = `
        <form id="support-form">
            <div class="form-group">
                <label for="support-subject">Sujet :</label>
                <input type="text" id="support-subject" class="form-control" value="Problème avec la commande #${subscriptionId}" required>
            </div>
            <div class="form-group">
                <label for="support-message">Message :</label>
                <textarea id="support-message" class="form-control" rows="4" placeholder="Décrivez votre problème..." required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Envoyer</button>
                <button type="button" onclick="closeModal()" class="btn btn-secondary" style="margin-left: 0.5rem;">Annuler</button>
            </div>
        </form>
    `;
    
    showModal(modal, modalContent);
    
    // Gérer la soumission du formulaire
    document.getElementById('support-form').onsubmit = function(e) {
        e.preventDefault();
        const subject = document.getElementById('support-subject').value;
        const message = document.getElementById('support-message').value;
        
        // Ici vous enverriez les données à votre backend
        // fetch('/support/tickets', { method: 'POST', ... })
        
        closeModal();
        showToast('Ticket de support créé avec succès !', 'success');
    };
}

// Utilitaires pour les modals
function createModal(title, id) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.id = id;
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3>${title}</h3>
                <button onclick="closeModal()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Le contenu sera injecté ici -->
            </div>
        </div>
    `;
    return modal;
}

function showModal(modal, content) {
    modal.querySelector('.modal-body').innerHTML = content;
    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add('active'), 10);
}

function closeModal() {
    const modals = document.querySelectorAll('.modal-overlay');
    modals.forEach(modal => {
        modal.classList.remove('active');
        setTimeout(() => modal.remove(), 300);
    });
}

// Utilitaires pour les toasts
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    
    // Ajouter au DOM
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.appendChild(toast);
    
    // Auto-suppression après 5 secondes
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
    
    return toast;
}
</script>

<style>
/* Styles de base pour le dashboard */
.dashboard-container {
    display: flex;
    min-height: 100vh;
    background-color: #f8fafc;
}

/* Sidebar styles */
.sidebar {
    width: 280px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: fixed;
    height: 100vh;
    left: 0;
    top: 0;
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    z-index: 1000;
    overflow-y: auto;
}

.sidebar.active {
    transform: translateX(0);
}

.sidebar-header {
    padding: 2rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.sidebar-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0 0 0.5rem 0;
}

.user-welcome {
    font-size: 0.9rem;
    opacity: 0.8;
}

.sidebar-menu {
    list-style: none;
    padding: 1rem 0;
    margin: 0;
}

.sidebar-item {
    margin: 0;
}

.sidebar-link {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.sidebar-link:hover,
.sidebar-link.active {
    background-color: rgba(255, 255, 255, 0.1);
    border-right: 3px solid white;
}

.sidebar-icon {
    margin-right: 0.75rem;
    font-size: 1.2rem;
}

/* Mobile toggle button */
.mobile-toggle {
    position: fixed;
    top: 1rem;
    left: 1rem;
    z-index: 1001;
    background: #667eea;
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 8px;
    font-size: 1.2rem;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Overlay pour mobile */
.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.overlay.active {
    opacity: 1;
    visibility: visible;
}

/* Main content */
.main-content {
    flex: 1;
    margin-left: 0;
    padding: 2rem;
    padding-top: 4rem;
}

/* Content sections */
.content-section {
    display: none;
}

.content-section.active {
    display: block;
}

.section-header {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
}

.section-subtitle {
    color: #718096;
    margin: 0;
}

/* Cards et grilles */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.card, .info-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

.card-title {
    font-size: 1.25rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 1rem 0;
}

.card-meta {
    color: #718096;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.card-description {
    color: #4a5568;
    line-height: 1.6;
}

/* Forms */
.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Buttons */
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    background: #667eea;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    background: #5a6fd8;
    transform: translateY(-1px);
}

.btn-primary {
    background: #667eea;
}

.btn-secondary {
    background: #718096;
}

.btn-danger {
    background: #ef4444;
}

.btn-danger:hover {
    background: #dc2626;
}

/* Empty states */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #718096;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: #4a5568;
    margin-bottom: 0.5rem;
}

/* Alerts */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

/* Prix */
.price {
    font-weight: bold;
    color: #059669;
}

/* Responsive design */
@media (min-width: 768px) {
    .sidebar {
        position: relative;
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 280px;
        padding-top: 2rem;
    }
    
    .mobile-toggle {
        display: none;
    }
    
    .overlay {
        display: none;
    }
}

@media (max-width: 767px) {
    .main-content {
        margin-left: 0;
        padding: 1rem;
        padding-top: 4rem;
    }
    
    .grid {
        grid-template-columns: 1fr;
    }
}

/* Styles pour les modals */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: 12px;
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    transform: scale(0.9);
    transition: transform 0.3s ease;
}

.modal-overlay.active .modal-content {
    transform: scale(1);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-header h3 {
    margin: 0;
    color: #2d3748;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #718096;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close:hover {
    color: #4a5568;
}

.modal-body {
    padding: 1.5rem;
}

.order-details .details-section {
    margin-bottom: 1.5rem;
}

.order-details .details-section h4 {
    color: #4a5568;
    margin-bottom: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
}

/* Styles pour les toasts */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 3000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 300px;
    animation: slideIn 0.3s ease;
}

.toast-info {
    background-color: #dbeafe;
    color: #1e40af;
    border-left: 4px solid #3b82f6;
}

.toast-success {
    background-color: #d1fae5;
    color: #065f46;
    border-left: 4px solid #059669;
}

.toast-error {
    background-color: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

.toast button {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: 1rem;
    opacity: 0.7;
}

.toast button:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Styles pour les formulaires dans les modals */
.form-actions {
    margin-top: 1.5rem;
    display: flex;
    justify-content: flex-end;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}
</style>

@endsection