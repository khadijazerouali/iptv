<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; height: 100vh;">

<div class="admin-sidebar">
    <div class="sidebar-header">
        <i class="fas fa-user-shield"></i>
        <span>Admin Panel</span>
    </div>
    
    <nav class="sidebar-nav">
        <a href="/admin/users" class="nav-item">
            <i class="fas fa-users"></i>
            <span>Gestion des utilisateurs</span>
        </a>
        <a href="/admin/contacts" class="nav-item">
            <i class="fas fa-address-book"></i>
            <span>Gestion des contacts</span>
        </a>
        <a href="/admin/categories" class="nav-item">
            <i class="fas fa-tags"></i>
            <span>Gestion des catégories</span>
        </a>
        <a href="/admin/products" class="nav-item">
            <i class="fas fa-box"></i>
            <span>Gestion des produits</span>
        </a>
        <a href="/admin/device-types" class="nav-item">
            <i class="fas fa-mobile-alt"></i>
            <span>Types d'appareils</span>
        </a>
        <a href="/admin/application-types" class="nav-item">
            <i class="fas fa-apps"></i>
            <span>Types d'applications</span>
        </a>
        <a href="/admin/orders" class="nav-item">
            <i class="fas fa-shopping-cart"></i>
            <span>Gestion des commandes</span>
        </a>
        <a href="/admin/support" class="nav-item">
            <i class="fas fa-headset"></i>
            <span>Support</span>
        </a>
    </nav>
</div>

<style>
.admin-sidebar {
    width: 100%;
    height: 100vh;
    background: linear-gradient(135deg, #1d42e6 0%, #234fe0 100%);
    overflow: hidden;
    backdrop-filter: blur(10px);
    position: relative;
}

.admin-sidebar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.1);
    pointer-events: none;
}

.sidebar-header {
    background: rgba(255,255,255,0.15);
    padding: 24px 20px;
    color: white;
    font-size: 18px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-header i {
    font-size: 20px;
    color: #ffd700;
}

.sidebar-nav {
    padding: 8px 0;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 16px 20px;
    color: rgba(255,255,255,0.9);
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    font-size: 14px;
    font-weight: 500;
}

.nav-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 0;
    background: #ffd700;
    border-radius: 0 2px 2px 0;
    transition: height 0.3s ease;
}

.nav-item:hover {
    background: rgba(255,255,255,0.15);
    color: white;
    transform: translateX(4px);
    padding-left: 24px;
}

.nav-item:hover::before {
    height: 20px;
}

.nav-item i {
    font-size: 16px;
    width: 18px;
    text-align: center;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.nav-item:hover i {
    opacity: 1;
}

.nav-item:active {
    transform: translateX(2px) scale(0.98);
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

.admin-sidebar {
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
    .admin-sidebar {
        width: 100%;
    }
}
</style>

</body>
</html>