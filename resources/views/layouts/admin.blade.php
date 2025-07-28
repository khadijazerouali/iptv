<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - IPTV Admin</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Admin Dashboard CSS -->
    <link href="{{ asset('assets/css/admin-dashboard.css') }}" rel="stylesheet">
    
    <!-- Livewire Styles -->
    @livewireStyles
    
    @stack('styles')
</head>
<body>
    <!-- Navigation simple comme dans l'image -->
    <nav class="admin-navbar">
        <div class="nav-container">
            <div class="nav-left">
                <h1 class="nav-title">
                    <i class="fas fa-bell"></i>
                    Tableau de bord
                </h1>
            </div>
            <div class="nav-right">
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <a href="{{ route('home') }}" class="nav-home-btn">
                    <i class="fas fa-home"></i>
                    Accueil
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Séparateur -->
    <div class="nav-separator"></div>
    
    <!-- Layout avec sidebar -->
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            @include('partials.admin-sidebar')
        </aside>
        
        <!-- Contenu principal -->
        <div class="admin-main">
            <div class="admin-content">
                @yield('content')
            </div>
        </div>
    </div>
    
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
    
    <!-- Admin Scripts -->
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
            const cards = document.querySelectorAll('.admin-card, .stat-card');
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
        });
        
        // Gestion des erreurs globales
        window.addEventListener('error', function(e) {
            console.error('Erreur JavaScript:', e.error);
            showNotification('Une erreur est survenue', 'error');
        });
    </script>
    
    @stack('scripts')
</body>
</html> 