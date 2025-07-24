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