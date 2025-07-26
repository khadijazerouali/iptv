<aside class="dashboard-sidebar" id="sidebar">
    <div class="sidebar-header text-center py-4">
        <a href="{{ route('dashboard') }}" class="sidebar-logo d-flex align-items-center justify-content-center mb-2 text-decoration-none">
            <i class="fas fa-tv fa-lg me-2 text-primary"></i>
            <span class="fw-bold text-white">IPTV Client</span>
        </a>
        <div class="user-info d-flex align-items-center justify-content-center mt-3">
            <div class="user-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:40px;height:40px;font-weight:bold;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div class="user-details text-start">
                <div class="fw-semibold text-white">{{ $user->name }}</div>
                <small class="text-white-50">{{ $user->email }}</small>
            </div>
        </div>
    </div>
    <ul class="sidebar-menu nav flex-column mt-4">
        <li class="nav-item mb-2">
            <a class="nav-link sidebar-link d-flex align-items-center" href="#" onclick="showSection('profile')" data-section="profile" id="sidebar-link-profile">
                <i class="fas fa-user sidebar-icon me-2"></i>
                Mes Informations
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link sidebar-link d-flex align-items-center" href="#" onclick="showSection('commandes')" data-section="commandes" id="sidebar-link-commandes">
                <i class="fas fa-shopping-cart sidebar-icon me-2"></i>
                Mes Commandes
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link sidebar-link d-flex align-items-center" href="#" onclick="showSection('panier')" data-section="panier" id="sidebar-link-panier">
                <i class="fas fa-shopping-basket sidebar-icon me-2"></i>
                Mon Panier
            </a>
        </li>
        <li class="nav-item mb-2">
            <a class="nav-link sidebar-link d-flex align-items-center" href="#" onclick="showSection('support')" data-section="support" id="sidebar-link-support">
                <i class="fas fa-headset sidebar-icon me-2"></i>
                Support
            </a>
        </li>
    </ul>
    <div class="sidebar-footer position-absolute w-100" style="bottom: 0; left: 0; padding: 1rem 1.5rem; border-top: 1px solid rgba(255,255,255,0.1); background: linear-gradient(180deg, transparent 0%, #2c3e50 100%);">
        <a href="{{ route('logout') }}" class="nav-link text-white d-flex align-items-center" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt me-2"></i>
            Déconnexion
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    <style>
        .dashboard-sidebar {
            width: 280px;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar-logo {
            font-size: 1.5rem;
        }
        .sidebar-link {
            color: rgba(255,255,255,0.85);
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        .sidebar-link.active, .sidebar-link:focus, .sidebar-link:hover {
            background: var(--primary-color, #0d6efd);
            color: #fff;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.15);
            transform: translateX(5px);
        }
        .sidebar-icon {
            width: 20px;
            text-align: center;
        }
        .user-avatar {
            font-size: 1.2rem;
        }
        @media (max-width: 768px) {
            .dashboard-sidebar {
                width: 100vw;
                position: fixed;
                left: 0;
                top: 0;
                height: auto;
                min-height: 100vh;
                z-index: 2000;
            }
            .sidebar-footer {
                position: static !important;
            }
        }
    </style>
    <script>
        // Gestion dynamique de l'onglet actif
        function setActiveSidebar(section) {
            document.querySelectorAll('.sidebar-link').forEach(link => link.classList.remove('active'));
            const activeLink = document.getElementById('sidebar-link-' + section);
            if (activeLink) activeLink.classList.add('active');
        }
        // Appel initial selon la section affichée
        document.addEventListener('DOMContentLoaded', function() {
            let current = document.querySelector('.content-section[style*="display: block"]');
            if (current && current.id) {
                setActiveSidebar(current.id);
            } else {
                setActiveSidebar('profile');
            }
        });
        // Synchronisation lors du changement de section
        window.showSection = function(section) {
            document.querySelectorAll('.content-section').forEach(sec => sec.style.display = 'none');
            document.getElementById(section).style.display = 'block';
            setActiveSidebar(section);
        }
    </script>
</aside> 