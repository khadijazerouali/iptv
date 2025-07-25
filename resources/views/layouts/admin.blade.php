<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - IPTV Admin</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Admin Global CSS -->
    <link href="{{ asset('assets/css/admin-global.css') }}" rel="stylesheet">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            overflow-x: hidden;
        }
        
        /* Layout principal avec sidebar fixe */
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar fixe et indépendante */
        .admin-sidebar {
            width: 280px;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }
        
        /* Contenu principal */
        .admin-main {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: calc(100vw - 280px);
        }
        
        /* Contenu principal */
        .admin-content {
            flex: 1;
            padding: 2rem;
            background: #f8f9fa;
            min-height: calc(100vh - 200px);
        }
        
        /* Navigation sur toute la largeur */
        .navbar {
            width: 100vw;
            margin-left: 0;
            position: relative;
            z-index: 999;
            background: #000000 !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        /* Amélioration des éléments de la navbar */
        .navbar-brand {
            color: #ffffff !important;
        }
        
        .navbar-brand img {
            filter: brightness(1.2) contrast(1.1);
        }
        
        .nav-link {
            color: #ffffff !important;
            font-weight: 600 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: #007bff !important;
            transform: translateY(-1px);
        }
        
        .nav-link.active {
            color: #007bff !important;
            border-bottom: 2px solid #007bff;
        }
        
        /* Bouton Commander Maintenant */
        .button {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #ffffff !important;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }
        
        .button:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }
        
        .button .icon {
            width: 16px;
            height: 16px;
            transition: transform 0.3s ease;
        }
        
        .button:hover .icon {
            transform: translateX(3px);
        }
        
        /* Icône panier */
        .fa-cart-shopping {
            color: #ffffff !important;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }
        
        .fa-cart-shopping:hover {
            color: #007bff !important;
            transform: scale(1.1);
        }
        
        /* Dropdown menu */
        .dropdown-menu {
            background: #ffffff;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            border-radius: 10px;
            margin-top: 10px;
        }
        
        .dropdown-item {
            color: #333333 !important;
            font-weight: 500;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            color: #007bff !important;
            transform: translateX(5px);
        }
        
        /* Navbar toggler pour mobile */
        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.1) !important;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Container de la navbar */
        .navbar .container-fluid {
            padding: 0 2rem;
        }
        
        /* Responsive pour la navbar */
        @media (max-width: 768px) {
            .navbar .container-fluid {
                padding: 0 1rem;
            }
            
            .nav-link {
                padding: 15px 0;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            
            .button {
                margin: 10px 0;
                justify-content: center;
            }
        }
        
        /* Footer sur toute la largeur */
        footer {
            width: 100vw;
            margin-left: 0;
            position: relative;
            z-index: 998;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .admin-sidebar.show {
                transform: translateX(0);
            }
            
            .admin-main {
                margin-left: 0;
                width: 100vw;
            }
            
            .admin-content {
                padding: 1rem;
                min-height: calc(100vh - 150px);
            }
            
            .navbar {
                width: 100vw;
            }
            
            footer {
                width: 100vw;
            }
        }
        
        /* Améliorations spécifiques pour l'admin */
        .admin-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }
        
        /* Animation d'entrée pour les pages */
        .admin-content {
            animation: fadeIn 0.8s ease-out;
        }
        
        /* Effet de profondeur pour les cartes */
        .admin-card {
            position: relative;
        }
        
        .admin-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
            pointer-events: none;
            border-radius: inherit;
        }
        
        /* Amélioration des boutons */
        .btn {
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        /* Amélioration des tableaux */
        .table tbody tr {
            position: relative;
        }
        
        .table tbody tr::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,0,0,0.05), transparent);
        }
        
        /* Effet de focus amélioré */
        .form-control:focus {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }
        
        /* Animation pour les badges */
        .badge {
            position: relative;
            overflow: hidden;
        }
        
        .badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .badge:hover::before {
            left: 100%;
        }
        
        /* Amélioration des modals */
        .modal-content {
            position: relative;
            overflow: hidden;
        }
        
        .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }
        
        /* Effet de chargement */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        /* Notifications */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            color: white;
            font-weight: 500;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .notification.show {
            transform: translateX(0);
        }
        
        .notification.success {
            background: var(--success-gradient);
        }
        
        .notification.error {
            background: var(--danger-gradient);
        }
        
        .notification.warning {
            background: var(--warning-gradient);
        }
        
        .notification.info {
            background: var(--info-gradient);
        }
        
        /* Toggle sidebar pour mobile */
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: block;
            }
        }
        
        /* Amélioration de l'espacement */
        .admin-content {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
        
        /* Ajustement pour éviter les débordements */
        .admin-main {
            overflow-x: hidden;
        }
        
        /* Amélioration de la lisibilité */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        footer {
            background: #343a40 !important;
            margin-top: auto;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation sur toute la largeur -->
    @include('livewire.inc.header')
    
    <div class="admin-wrapper">
        <!-- Sidebar fixe et indépendante -->
        <div class="admin-sidebar">
            @include('partials.admin-sidebar')
        </div>
        
        <!-- Contenu principal -->
        <div class="admin-main">
            <!-- Contenu principal -->
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Footer sur toute la largeur -->
    @include('livewire.inc.footer')
    
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <div class="loading-spinner"></div>
    </div>
    
    <!-- Notifications Container -->
    <div id="notificationsContainer"></div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Livewire Scripts -->
    @livewireScripts
    
    <!-- Admin Global JS -->
    <script>
        // Fonction pour afficher les notifications
        function showNotification(message, type = 'info', duration = 5000) {
            const container = document.getElementById('notificationsContainer');
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.textContent = message;
            
            container.appendChild(notification);
            
            // Animation d'entrée
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            // Auto-suppression
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    container.removeChild(notification);
                }, 300);
            }, duration);
        }
        
        // Fonction pour afficher/masquer le loading
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }
        
        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }
        
        // Toggle sidebar pour mobile
        function toggleSidebar() {
            const sidebar = document.querySelector('.admin-sidebar');
            sidebar.classList.toggle('show');
        }
        
        // Amélioration des formulaires
        document.addEventListener('DOMContentLoaded', function() {
            // Effet de focus pour les inputs
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Animation pour les cartes
            const cards = document.querySelectorAll('.admin-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });
            
            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease-out';
                observer.observe(card);
            });
            
            // Amélioration des boutons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    // Effet de ripple
                    const ripple = document.createElement('span');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.width = ripple.style.height = size + 'px';
                    ripple.style.left = x + 'px';
                    ripple.style.top = y + 'px';
                    ripple.classList.add('ripple');
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Fermer sidebar sur mobile quand on clique à l'extérieur
            document.addEventListener('click', function(e) {
                const sidebar = document.querySelector('.admin-sidebar');
                const toggle = document.querySelector('.sidebar-toggle');
                
                if (window.innerWidth <= 768 && 
                    !sidebar.contains(e.target) && 
                    !toggle.contains(e.target) && 
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        });
        
        // Gestion des erreurs globales
        window.addEventListener('error', function(e) {
            console.error('Erreur JavaScript:', e.error);
            showNotification('Une erreur est survenue', 'error');
        });
        
        // Amélioration de l'UX pour les actions importantes
        document.addEventListener('click', function(e) {
            if (e.target.matches('[data-confirm]')) {
                if (!confirm(e.target.dataset.confirm)) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 