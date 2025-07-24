{{-- resources/views/dashboard/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Mon Dashboard')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: #ffffff;
        color: #333;
        line-height: 1.6;
    }

    .dashboard-container {
        display: flex;
        min-height: 100vh;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 280px;
        background-color: #ffffff;
        border-right: 1px solid #e5e7eb;
        padding: 2rem 0;
        position: fixed;
        height: 100vh;
        overflow-y: auto;
        transition: transform 0.3s ease;
    }

    .sidebar.mobile-hidden {
        transform: translateX(-100%);
    }

    .sidebar-header {
        padding: 0 2rem 2rem;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .sidebar-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: rgb(0, 107, 179);
    }

    .user-welcome {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }

    .sidebar-menu {
        list-style: none;
    }

    .sidebar-item {
        margin-bottom: 0.5rem;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 1rem 2rem;
        text-decoration: none;
        color: #6b7280;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .sidebar-link:hover {
        background-color: #f3f4f6;
        color: rgb(0, 107, 179);
    }

    .sidebar-link.active {
        background-color: rgb(0, 107, 179);
        color: white;
        border-right: 3px solid rgb(0, 107, 179);
    }

    .sidebar-icon {
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }

    /* Main Content */
    .main-content {
        flex: 1;
        margin-left: 280px;
        padding: 2rem;
        transition: margin-left 0.3s ease;
    }

    .main-content.full-width {
        margin-left: 0;
    }

    /* Mobile Toggle */
    .mobile-toggle {
        display: none;
        position: fixed;
        top: 1rem;
        left: 1rem;
        z-index: 1000;
        background: rgb(0, 107, 179);
        color: white;
        border: none;
        padding: 0.5rem;
        border-radius: 0.5rem;
        cursor: pointer;
    }

    /* Content Sections */
    .content-section {
        display: none;
    }

    .content-section.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .section-header {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 600;
        color: rgb(0, 107, 179);
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        color: #6b7280;
        font-size: 1rem;
    }

    /* Cards */
    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: border-color 0.2s ease;
    }

    .card:hover {
        border-color: rgb(0, 107, 179);
    }

    .card-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #111827;
    }

    .card-meta {
        color: #6b7280;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .card-description {
        color: #374151;
    }

    /* Grid Layout */
    .grid {
        display: grid;
        gap: 1rem;
    }

    .grid-2 {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    /* Status Badge */
    .status-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-completed {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-in-progress {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .status-cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    /* Button */
    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        background-color: rgb(0, 107, 179);
        color: white;
        text-decoration: none;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .btn:hover {
        background-color: rgb(0, 90, 150);
    }

    .btn-secondary {
        background-color: #6b7280;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
    }

    .btn-danger {
        background-color: #dc2626;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #374151;
    }

    .form-input, .form-textarea, .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s ease;
    }

    .form-input:focus, .form-textarea:focus, .form-select:focus {
        outline: none;
        border-color: rgb(0, 107, 179);
        box-shadow: 0 0 0 3px rgba(0, 107, 179, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Progress Bar */
    .progress-bar {
        width: 100%;
        height: 8px;
        background-color: #e5e7eb;
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 0.5rem;
    }

    .progress-fill {
        height: 100%;
        background-color: rgb(0, 107, 179);
        transition: width 0.3s ease;
    }

    /* Alert Messages */
    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .alert-success {
        background-color: #d1fae5;
        border: 1px solid #a7f3d0;
        color: #065f46;
    }

    .alert-error {
        background-color: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }

    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    /* Price Display */
    .price {
        font-weight: 600;
        color: rgb(0, 107, 179);
        font-size: 1.125rem;
    }

    /* Mobile Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.mobile-visible {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            padding: 1rem;
            padding-top: 4rem;
        }

        .mobile-toggle {
            display: block;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .grid-2 {
            grid-template-columns: 1fr;
        }
    }

    /* Overlay for mobile sidebar */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .overlay.active {
        display: block;
    }
</style>

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
                    <a class="sidebar-link" onclick="showSection('formations')" data-section="formations">
                        <span class="sidebar-icon">🧑‍🎓</span>
                        Mes Formations
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

        <!-- Formations Section - Dynamic Data from Database -->
        <section class="content-section active" id="formations">
            <div class="section-header">
                <h1 class="section-title">Mes Formations</h1>
                <p class="section-subtitle">Vos données personnelles</p>
            </div>
        
            <div class="info-card">
                <h3 class="card-title">{{ $user->name }}</h3>
        
                <ul class="info-list">
                    <li><strong>Email:</strong> {{ $user->email }}</li>
                    <li><strong>Téléphone:</strong> {{ $user->phone ?? 'Non renseigné' }}</li>
                    <li><strong>Ville:</strong> {{ $user->ville ?? 'Non renseignée' }}</li>
                </ul>
        
                <div class="edit-section" style="margin-top: 1rem;">
                    <a href="#" class="btn btn-secondary">Modifier mes informations</a>
                </div>
            </div>
        </section>
        

      <!-- Commandes Section - From Subscriptions -->
      <section class="content-section" id="commandes">
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
                            <a href="#" class="btn">Voir Détails</a>
                            <a href="#" class="btn btn-secondary" style="margin-left: 0.5rem;">Télécharger facture</a>
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
      <section class="content-section" id="panier">
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



        <!-- Support Section - Dynamic Data from Database -->
        {{-- <section class="content-section" id="support">
            <div class="section-header">
                <h1 class="section-title">Support</h1>
                <p class="section-subtitle">Besoin d'aide ? Contactez notre équipe</p>
            </div>
            <div class="grid grid-2">
                <div class="card">
                    <h3 class="card-title">Nouveau ticket de support</h3>
                    <form method="POST" action="{{ route('support.ticket.create') }}">
                        @csrf
                        <div class="form-group">
                            <label for="subject" class="form-label">Sujet</label>
                            <input type="text" id="subject" name="subject" class="form-input" 
                                   placeholder="Décrivez brièvement votre problème" 
                                   value="{{ old('subject') }}" required>
                            @error('subject')
                                <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="category" class="form-label">Catégorie</label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="">Sélectionnez une catégorie</option>
                                <option value="technique" {{ old('category') === 'technique' ? 'selected' : '' }}>Problème technique</option>
                                <option value="facturation" {{ old('category') === 'facturation' ? 'selected' : '' }}>Facturation</option>
                                <option value="cours" {{ old('category') === 'cours' ? 'selected' : '' }}>Question sur un cours</option>
                                <option value="autre" {{ old('category') === 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('category')
                                <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="message" class="form-label">Message</label>
                            <textarea id="message" name="message" class="form-textarea" 
                                      placeholder="Décrivez votre problème en détail..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn">Envoyer le ticket</button>
                    </form>
                </div>
                <div class="card">
                    <h3 class="card-title">Mes tickets récents</h3>
                    @if($supportTickets->count() > 0)
                        @foreach($supportTickets as $ticket)
                            <div style="margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb;">
                                <div class="card-title" style="font-size: 1rem; margin-bottom: 0.25rem;">
                                    {{ $ticket->subject }}
                                </div>
                                <div class="card-meta">
                                    #{{ $ticket->ticket_number }} • 
                                    {{ $ticket->created_at->format('d M Y') }} • 
                                    <span class="status-badge {{ $ticket->status_badge_class }}">
                                        {{ $ticket->status_label }}
                                    </span>
                                </div>
                                <div style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">
                                    {{ $ticket->category_label }}
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 2rem; color: #6b7280;">
                            <p>Aucun ticket de support pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section> --}}
    </main>
</div>

<script>
    // Navigation functionality
    function showSection(sectionId) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
        section.classList.remove('active');
    });

    const section = document.getElementById(sectionId);
    if (section) {
        section.style.display = 'block';
        section.classList.add('active');
    }

    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.classList.remove('active');
    });

    const activeLink = document.querySelector(`.sidebar-link[data-section="${sectionId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

    // Mobile sidebar functionality
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.overlay');
        
        sidebar.classList.toggle('mobile-visible');
        overlay.classList.toggle('active');
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.overlay');
        
        sidebar.classList.remove('mobile-visible');
        overlay.classList.remove('active');
    }

    // Responsive handling
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });

    // Initialize page
    document.addEventListener('DOMContentLoaded', function() {
        // Set formations as default active section
        showSection('formations');
    });
</script>
@endsection