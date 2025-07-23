<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">

<div class="container-fluid mt-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="client-sidebar">
                <div class="sidebar-header">
                    <i class="fas fa-user-circle"></i>
                    <span>Mon Espace</span>
                </div>
                
                <nav class="sidebar-nav" id="sidebar-menu">
                    <a href="#info" class="nav-item sidebar-link active" data-section="info">
                        <i class="fas fa-user"></i>
                        <span>Mes informations</span>
                    </a>
                    <a href="#commandes" class="nav-item sidebar-link" data-section="commandes">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Mes commandes</span>
                    </a>
                    <a href="#panier" class="nav-item sidebar-link" data-section="panier">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Mon panier</span>
                    </a>
                    <a href="#support" class="nav-item sidebar-link" data-section="support">
                        <i class="fas fa-headset"></i>
                        <span>Support</span>
                    </a>
                    <a href="#contact" class="nav-item sidebar-link" data-section="contact">
                        <i class="fas fa-envelope"></i>
                        <span>Contact</span>
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="main-content">
                <!-- Section: Mes informations -->
                <div id="info" class="dashboard-section active">
                    <div class="section-header">
                        <h3><i class="fas fa-user me-2"></i>Mes informations</h3>
                    </div>
                    <div class="info-cards">
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-signature"></i>
                            </div>
                            <div class="info-details">
                                <label>Nom complet</label>
                                <span>John Doe</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-details">
                                <label>Email</label>
                                <span>john.doe@example.com</span>
                            </div>
                        </div>
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="info-details">
                                <label>Date d'inscription</label>
                                <span>15 janvier 2024</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Mes commandes -->
                <div id="commandes" class="dashboard-section">
                    <div class="section-header">
                        <h3><i class="fas fa-shopping-bag me-2"></i>Mes commandes</h3>
                    </div>
                    <div class="orders-container">
                        <div class="order-card">
                            <div class="order-header">
                                <span class="order-number">#12345</span>
                                <span class="order-status status-completed">Complétée</span>
                            </div>
                            <div class="order-body">
                                <p><strong>Produit :</strong> Application Mobile Premium</p>
                                <p><strong>Date :</strong> 15/07/2025</p>
                                <p><strong>Montant :</strong> 99.99€</p>
                            </div>
                        </div>
                        
                        <div class="order-card">
                            <div class="order-header">
                                <span class="order-number">#12344</span>
                                <span class="order-status status-pending">En cours</span>
                            </div>
                            <div class="order-body">
                                <p><strong>Produit :</strong> Site Web E-commerce</p>
                                <p><strong>Date :</strong> 10/07/2025</p>
                                <p><strong>Montant :</strong> 299.99€</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Mon panier -->
                <div id="panier" class="dashboard-section">
                    <div class="section-header">
                        <h3><i class="fas fa-shopping-cart me-2"></i>Mon panier</h3>
                    </div>
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart"></i>
                        <h4>Votre panier est vide</h4>
                        <p>Découvrez nos produits et services pour commencer vos achats</p>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Parcourir les produits
                        </button>
                    </div>
                </div>

                <!-- Section: Support -->
                <div id="support" class="dashboard-section">
                    <div class="section-header">
                        <h3><i class="fas fa-headset me-2"></i>Support</h3>
                    </div>
                    <div class="support-options">
                        <div class="support-card">
                            <i class="fas fa-comments"></i>
                            <h4>Chat en direct</h4>
                            <p>Obtenez une aide immédiate de notre équipe</p>
                            <button class="btn btn-primary">Démarrer le chat</button>
                        </div>
                        <div class="support-card">
                            <i class="fas fa-ticket-alt"></i>
                            <h4>Créer un ticket</h4>
                            <p>Soumettez votre demande d'assistance</p>
                            <a href="/assistance" class="btn btn-outline-primary">Nouveau ticket</a>
                        </div>
                    </div>
                </div>

                <!-- Section: Contact -->
                <div id="contact" class="dashboard-section">
                    <div class="section-header">
                        <h3><i class="fas fa-envelope me-2"></i>Contact</h3>
                    </div>
                    <div class="contact-info">
                        <div class="contact-card">
                            <i class="fas fa-phone"></i>
                            <h4>Téléphone</h4>
                            <p>+33 1 23 45 67 89</p>
                        </div>
                        <div class="contact-card">
                            <i class="fas fa-envelope"></i>
                            <h4>Email</h4>
                            <p>contact@example.com</p>
                        </div>
                        <div class="contact-card">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>Adresse</h4>
                            <p>123 Rue de la Tech, 75001 Paris</p>
                        </div>
                    </div>
                    <a href="/contactez-nous" class="btn btn-primary mt-3">
                        <i class="fas fa-paper-plane me-2"></i>Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Sidebar Styling */ 
.client-sidebar {
    background: linear-gradient(135deg, #2043e3 0%, #0 107 179 100%);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    position: relative;
}

.client-sidebar::before {
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

.nav-item:hover,
.nav-item.active {
    background: rgba(255,255,255,0.15);
    color: white;
    transform: translateX(4px);
    padding-left: 24px;
}

.nav-item:hover::before,
.nav-item.active::before {
    height: 20px;
}

.nav-item i {
    font-size: 16px;
    width: 18px;
    text-align: center;
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.nav-item:hover i,
.nav-item.active i {
    opacity: 1;
}

/* Main Content Styling */
.main-content {
    background: rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 0;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
    overflow: hidden;
}

.dashboard-section {
    display: none;
    padding: 30px;
    animation: fadeIn 0.5s ease-in-out;
}

.dashboard-section.active {
    display: block;
}

.section-header {
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid rgba(102, 126, 234, 0.1);
}

.section-header h3 {
    color: #667eea;
    font-weight: 600;
    margin: 0;
}

/* Info Cards */
.info-cards {
    display: grid;
    gap: 20px;
}

.info-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.info-card:hover {
    transform: translateY(-2px);
}

.info-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.info-details label {
    display: block;
    color: #666;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.info-details span {
    font-size: 16px;
    font-weight: 600;
    color: #333;
}

/* Orders */
.orders-container {
    display: grid;
    gap: 20px;
}

.order-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.order-card:hover {
    transform: translateY(-2px);
}

.order-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 15px;
}

.order-number {
    font-weight: 600;
    color: #667eea;
}

.order-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.order-body p {
    margin-bottom: 8px;
    color: #666;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-state i {
    font-size: 64px;
    color: #ddd;
    margin-bottom: 20px;
}

.empty-state h4 {
    color: #666;
    margin-bottom: 10px;
}

.empty-state p {
    color: #999;
    margin-bottom: 30px;
}

/* Support Options */
.support-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.support-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: transform 0.3s ease;
}

.support-card:hover {
    transform: translateY(-4px);
}

.support-card i {
    font-size: 48px;
    color: #667eea;
    margin-bottom: 20px;
}

.support-card h4 {
    color: #333;
    margin-bottom: 10px;
}

.support-card p {
    color: #666;
    margin-bottom: 20px;
}

/* Contact Info */
.contact-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.contact-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.contact-card i {
    font-size: 32px;
    color: #667eea;
    margin-bottom: 15px;
}

.contact-card h4 {
    color: #333;
    margin-bottom: 10px;
}

.contact-card p {
    color: #666;
    margin: 0;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .client-sidebar {
        margin-bottom: 20px;
    }
    
    .dashboard-section {
        padding: 20px;
    }
    
    .info-cards,
    .support-options,
    .contact-info {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.sidebar-link');
    const sections = document.querySelectorAll('.dashboard-section');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all links and sections
            links.forEach(l => l.classList.remove('active'));
            sections.forEach(s => s.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
            
            // Show corresponding section
            const sectionId = this.getAttribute('data-section');
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.classList.add('active');
            }
        });
    });
});
</script>

</body>
</html>