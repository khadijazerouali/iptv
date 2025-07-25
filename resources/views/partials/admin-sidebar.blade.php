<div class="sidebar-container">
    <div class="sidebar-header">
        <div class="header-icon">
            <i class="fas fa-user-shield"></i>
        </div>
        <div class="header-content">
            <span class="header-title">Admin Panel</span>
            <span class="header-subtitle">Gestion complète</span>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ url('/') }}" class="nav-item" title="Retour à l'accueil">
            <div class="nav-icon">
                <i class="fas fa-home"></i>
            </div>
            <span class="nav-text">Accueil</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-users"></i>
            </div>
            <span class="nav-text">Gestion des utilisateurs</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.contacts') }}" class="nav-item {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-address-book"></i>
            </div>
            <span class="nav-text">Gestion des contacts</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.categories') }}" class="nav-item {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-tags"></i>
            </div>
            <span class="nav-text">Gestion des catégories</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.products') }}" class="nav-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-box"></i>
            </div>
            <span class="nav-text">Gestion des produits</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.device-types') }}" class="nav-item {{ request()->routeIs('admin.device-types*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <span class="nav-text">Types d'appareils</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.application-types') }}" class="nav-item {{ request()->routeIs('admin.application-types*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-apps"></i>
            </div>
            <span class="nav-text">Types d'applications</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.orders') }}" class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <span class="nav-text">Gestion des commandes</span>
            <div class="nav-indicator"></div>
        </a>
        <a href="{{ route('admin.support') }}" class="nav-item {{ request()->routeIs('admin.support*') ? 'active' : '' }}">
            <div class="nav-icon">
                <i class="fas fa-headset"></i>
            </div>
            <span class="nav-text">Support</span>
            <div class="nav-indicator"></div>
        </a>
    </nav>
    
    <div class="sidebar-footer">
        <div class="footer-content">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <span class="user-name">{{ auth()->user()->name ?? 'Administrateur' }}</span>
                    <span class="user-role">Super Admin</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.sidebar-container {
    width: 100%;
    height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    overflow: hidden;
    backdrop-filter: blur(10px);
    position: relative;
    box-shadow: 4px 0 20px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
}

.sidebar-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    pointer-events: none;
}

.sidebar-header {
    background: rgba(255,255,255,0.15);
    padding: 24px 20px;
    color: white;
    display: flex;
    align-items: center;
    gap: 16px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    position: relative;
    z-index: 1;
}

.header-icon {
    width: 48px;
    height: 48px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    flex-shrink: 0;
}

.header-icon i {
    font-size: 20px;
    color: #ffd700;
}

.header-content {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
}

.header-title {
    font-size: 18px;
    font-weight: 700;
    color: white;
    line-height: 1.2;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.header-subtitle {
    font-size: 12px;
    color: rgba(255,255,255,0.7);
    font-weight: 400;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.sidebar-nav {
    padding: 16px 0;
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    position: relative;
    z-index: 1;
}

.sidebar-nav::-webkit-scrollbar {
    width: 6px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: rgba(255,255,255,0.1);
    border-radius: 3px;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.3);
    border-radius: 3px;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
    background: rgba(255,255,255,0.5);
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    font-size: 14px;
    font-weight: 500;
    margin: 4px 12px;
    border-radius: 12px;
    overflow: hidden;
    white-space: nowrap;
}

.nav-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #ffd700;
    border-radius: 0 2px 2px 0;
    transform: scaleY(0);
    transition: transform 0.3s ease;
}

.nav-item:hover {
    background: rgba(255,255,255,0.15);
    color: white;
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-decoration: none;
}

.nav-item:hover::before {
    transform: scaleY(1);
}

.nav-item.active {
    background: rgba(255,255,255,0.2);
    color: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

.nav-item.active::before {
    transform: scaleY(1);
}

.nav-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.nav-item:hover .nav-icon {
    background: rgba(255,255,255,0.2);
    transform: scale(1.1);
}

.nav-item.active .nav-icon {
    background: rgba(255,215,0,0.2);
}

.nav-icon i {
    font-size: 16px;
    color: rgba(255,255,255,0.9);
    transition: all 0.3s ease;
}

.nav-item:hover .nav-icon i,
.nav-item.active .nav-icon i {
    color: white;
    transform: scale(1.1);
}

.nav-text {
    flex: 1;
    font-weight: 500;
    transition: all 0.3s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.nav-indicator {
    width: 8px;
    height: 8px;
    background: rgba(255,255,255,0.3);
    border-radius: 50%;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.nav-item:hover .nav-indicator,
.nav-item.active .nav-indicator {
    background: #ffd700;
    transform: scale(1.2);
}

.sidebar-footer {
    padding: 20px;
    border-top: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    position: relative;
    z-index: 1;
}

.footer-content {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.user-avatar i {
    color: white;
    font-size: 16px;
}

.user-details {
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
}

.user-name {
    font-size: 14px;
    font-weight: 600;
    color: white;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-role {
    font-size: 12px;
    color: rgba(255,255,255,0.7);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Animation d'entrée */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.sidebar-container {
    animation: slideIn 0.6s ease-out;
}

.nav-item {
    opacity: 0;
    animation: slideIn 0.4s ease-out forwards;
}

.nav-item:nth-child(1) { animation-delay: 0.1s; }
.nav-item:nth-child(2) { animation-delay: 0.15s; }
.nav-item:nth-child(3) { animation-delay: 0.2s; }
.nav-item:nth-child(4) { animation-delay: 0.25s; }
.nav-item:nth-child(5) { animation-delay: 0.3s; }
.nav-item:nth-child(6) { animation-delay: 0.35s; }
.nav-item:nth-child(7) { animation-delay: 0.4s; }
.nav-item:nth-child(8) { animation-delay: 0.45s; }

/* Responsive */
@media (max-width: 768px) {
    .sidebar-container {
        width: 280px;
    }
    
    .nav-text {
        display: block;
    }
    
    .user-details {
        display: flex;
    }
}
</style>