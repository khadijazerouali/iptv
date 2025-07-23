<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Client - Dynamique</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .dashboard-container {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .client-sidebar {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: sticky;
            top: 20px;
        }

        .sidebar-header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-header i {
            font-size: 3em;
            margin-bottom: 10px;
            display: block;
        }

        .sidebar-header span {
            font-size: 1.3em;
            font-weight: 600;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .sidebar-link:hover::before {
            left: 100%;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateX(10px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border-left: 4px solid #fff;
        }

        .sidebar-link i {
            margin-right: 12px;
            width: 20px;
            font-size: 1.1em;
        }

        .badge {
            margin-left: auto;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .main-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            min-height: 600px;
        }

        .dashboard-section {
            display: none;
            animation: slideIn 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }

        .dashboard-section.active {
            display: block;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .section-header {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .section-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .section-header h3 {
            margin: 0;
            position: relative;
            z-index: 1;
            font-weight: 600;
        }

        .info-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 20px;
        }

        .info-card {
            background: linear-gradient(135deg, #e8f4f8 0%, #d1ecf1 100%);
            border-radius: 20px;
            padding: 25px;
            display: flex;
            align-items: center;
            border-left: 6px solid #1e3c72;
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(30, 60, 114, 0.1), transparent);
            transition: left 0.6s;
        }

        .info-card:hover::before {
            left: 100%;
        }

        .info-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(30, 60, 114, 0.2);
        }

        .info-icon {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            font-size: 1.5em;
            box-shadow: 0 10px 25px rgba(30, 60, 114, 0.3);
        }

        .info-details {
            flex: 1;
        }

        .info-details label {
            display: block;
            font-weight: 600;
            color: #666;
            font-size: 0.95em;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-details span {
            font-weight: 500;
            color: #333;
            font-size: 1.2em;
        }

        .orders-container {
            display: grid;
            gap: 20px;
        }

        .order-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            border-left: 6px solid #1e3c72;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }

        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(30, 60, 114, 0.05), transparent);
            transition: left 0.6s;
        }

        .order-card:hover::before {
            left: 100%;
        }

        .order-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .order-number {
            font-weight: 700;
            color: #333;
            font-size: 1.3em;
        }

        .order-status {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.9em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .status-pending {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
        }

        .status-cancelled {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .order-body p {
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .order-body strong {
            color: #1e3c72;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 5em;
            color: #ddd;
            margin-bottom: 25px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .empty-state h4 {
            margin-bottom: 15px;
            color: #333;
            font-size: 1.8em;
        }

        .empty-state p {
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .support-options, .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }

        .support-card, .contact-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }

        .support-card::before, .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(30, 60, 114, 0.05), transparent);
            transition: left 0.6s;
        }

        .support-card:hover::before, .contact-card:hover::before {
            left: 100%;
        }

        .support-card:hover, .contact-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .support-card i, .contact-card i {
            font-size: 3em;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

        .support-card h4, .contact-card h4 {
            margin-bottom: 15px;
            color: #333;
            font-size: 1.3em;
        }

        .btn {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border: none;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(30, 60, 114, 0.4);
            background: linear-gradient(135deg, #1a3461, #245082);
        }

        .btn-outline-primary {
            border: 2px solid #1e3c72;
            color: #1e3c72;
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            border-color: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(30, 60, 114, 0.4);
        }

        .cart-item {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            border-left: 5px solid #1e3c72;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
        }

        .cart-item:hover {
            transform: translateX(10px);
        }

        .cart-total {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            margin-top: 20px;
            box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
        }

        .edit-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 10px;
            padding: 8px 15px;
            font-size: 0.9em;
        }

        .edit-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(30, 60, 114, 0.3);
            transform: translateX(400px);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .notification.show {
            transform: translateX(0);
        }

        @media (max-width: 768px) {
            .info-cards, .support-options, .contact-info {
                grid-template-columns: 1fr;
            }
            
            .client-sidebar {
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4 dashboard-container">
        <div class="row g-4">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="client-sidebar">
                    <div class="sidebar-header">
                        <i class="fas fa-user-circle"></i>
                        <span>Mon Espace</span>
                    </div>
                    
                    <nav class="sidebar-nav" id="sidebar-menu">
                        <a href="#info" class="sidebar-link active" data-section="info">
                            <i class="fas fa-user"></i>
                            <span>Mes informations</span>
                        </a>
                        <a href="#commandes" class="sidebar-link" data-section="commandes">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Mes commandes</span>
                            <span class="badge bg-primary" id="orders-count">0</span>
                        </a>
                        <a href="#panier" class="sidebar-link" data-section="panier">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Mon panier</span>
                            <span class="badge bg-success" id="cart-count">0</span>
                        </a>
                        <a href="#support" class="sidebar-link" data-section="support">
                            <i class="fas fa-headset"></i>
                            <span>Support</span>
                        </a>
                        <a href="#contact" class="sidebar-link" data-section="contact">
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
                            <button class="btn btn-sm edit-btn" onclick="editProfile()">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </button>
                        </div>
                        <div class="info-cards" id="user-info">
                            <!-- Contenu généré dynamiquement -->
                        </div>
                    </div>

                    <!-- Section: Mes commandes -->
                    <div id="commandes" class="dashboard-section">
                        <div class="section-header">
                            <h3><i class="fas fa-shopping-bag me-2"></i>Mes commandes</h3>
                        </div>
                        <div class="orders-container" id="orders-container">
                            <!-- Contenu généré dynamiquement -->
                        </div>
                    </div>

                    <!-- Section: Mon panier -->
                    <div id="panier" class="dashboard-section">
                        <div class="section-header">
                            <h3><i class="fas fa-shopping-cart me-2"></i>Mon panier</h3>
                        </div>
                        <div id="cart-content">
                            <!-- Contenu généré dynamiquement -->
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
                                <button class="btn btn-primary" onclick="startChat()">Démarrer le chat</button>
                            </div>
                            <div class="support-card">
                                <i class="fas fa-ticket-alt"></i>
                                <h4>Créer un ticket</h4>
                                <p>Soumettez votre demande d'assistance</p>
                                <button class="btn btn-outline-primary" onclick="createTicket()">Nouveau ticket</button>
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
                        <button class="btn btn-primary mt-3" onclick="contactUs()">
                            <i class="fas fa-paper-plane me-2"></i>Nous contacter
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div id="notification" class="notification">
        <span id="notification-text"></span>
    </div>

    <script>
        // Données dynamiques
        const userData = {
            fullName: "John Doe",
            email: "john.doe@example.com",
            registrationDate: "15 janvier 2024",
            phone: "+33 6 12 34 56 78",
            address: "123 Rue Example, 75001 Paris"
        };

        const ordersData = [
            {
                id: "#12345",
                status: "completed",
                statusText: "Complétée",
                product: "Application Mobile Premium",
                date: "15/07/2025",
                amount: "99.99€"
            },
            {
                id: "#12344",
                status: "pending",
                statusText: "En cours",
                product: "Site Web E-commerce",
                date: "10/07/2025",
                amount: "299.99€"
            },
            {
                id: "#12343",
                status: "cancelled",
                statusText: "Annulée",
                product: "Application Desktop",
                date: "05/07/2025",
                amount: "199.99€"
            }
        ];

        let cartData = [
            {
                id: 1,
                name: "Consultation SEO",
                price: 150,
                quantity: 1
            },
            {
                id: 2,
                name: "Design Logo",
                price: 250,
                quantity: 2
            }
        ];

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
            setupNavigation();
            loadUserInfo();
            loadOrders();
            loadCart();
            updateCounters();
        });

        function initializeDashboard() {
            showSection('info');
        }

        function setupNavigation() {
            const navLinks = document.querySelectorAll('.sidebar-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const section = this.dataset.section;
                    
                    // Mise à jour de la navigation active
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Affichage de la section
                    showSection(section);
                });
            });
        }

        function showSection(sectionId) {
            const sections = document.querySelectorAll('.dashboard-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });
            
            setTimeout(() => {
                document.getElementById(sectionId).classList.add('active');
            }, 100);
        }

        function loadUserInfo() {
            const container = document.getElementById('user-info');
            container.innerHTML = `
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-signature"></i>
                    </div>
                    <div class="info-details">
                        <label>Nom complet</label>
                        <span>${userData.fullName}</span>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="info-details">
                        <label>Email</label>
                        <span>${userData.email}</span>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-calendar"></i>
                    </div>
                    <div class="info-details">
                        <label>Date d'inscription</label>
                        <span>${userData.registrationDate}</span>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="info-details">
                        <label>Téléphone</label>
                        <span>${userData.phone}</span>
                    </div>
                </div>
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="info-details">
                        <label>Adresse</label>
                        <span>${userData.address}</span>
                    </div>
                </div>
            `;
        }

        function loadOrders() {
            const container = document.getElementById('orders-container');
            if (ordersData.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <h4>Aucune commande</h4>
                        <p>Vous n'avez pas encore passé de commande</p>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Découvrir nos services
                        </button>
                    </div>
                `;
                return;
            }

            const ordersHtml = ordersData.map(order => `
                <div class="order-card">
                    <div class="order-header">
                        <span class="order-number">${order.id}</span>
                        <span class="order-status status-${order.status}">${order.statusText}</span>
                    </div>
                    <div class="order-body">
                        <p><strong>Produit :</strong> ${order.product}</p>
                        <p><strong>Date :</strong> ${order.date}</p>
                        <p><strong>Montant :</strong> ${order.amount}</p>
                        <button class="btn btn-outline-primary btn-sm mt-2" onclick="viewOrder('${order.id}')">
                            <i class="fas fa-eye me-1"></i>Détails
                        </button>
                    </div>
                </div>
            `).join('');

            container.innerHTML = ordersHtml;
        }

        function loadCart() {
            const container = document.getElementById('cart-content');
            
            if (cartData.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-shopping-cart"></i>
                        <h4>Votre panier est vide</h4>
                        <p>Découvrez nos produits et services pour commencer vos achats</p>
                        <button class="btn btn-primary" onclick="browseProducts()">
                            <i class="fas fa-plus me-2"></i>Parcourir les produits
                        </button>
                    </div>
                `;
                return;
            }

            const cartHtml = cartData.map(item => `
                <div class="cart-item">
                    <div>
                        <h5>${item.name}</h5>
                        <p>Quantité: ${item.quantity}</p>
                    </div>
                    <div class="text-end">
                        <strong>${item.price * item.quantity}€</strong>
                        <button class="btn btn-outline-danger btn-sm ms-2" onclick="removeFromCart(${item.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');

            const total = cartData.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            container.innerHTML = cartHtml + `
                <div class="cart-total">
                    <h4>Total: ${total}€</h4>
                    <button class="btn btn-light mt-3" onclick="checkout()">
                        <i class="fas fa-credit-card me-2"></i>Procéder au paiement
                    </button>
                </div>
            `;
        }

        function updateCounters() {
            document.getElementById('orders-count').textContent = ordersData.length;
            document.getElementById('cart-count').textContent = cartData.length;
        }

        // Fonctions interactives
        function editProfile() {
            showNotification('Fonctionnalité de modification du profil en cours de développement');
        }

        function viewOrder(orderId) {
            showNotification(`Affichage des détails de la commande ${orderId}`);
        }

        function removeFromCart(itemId) {
            cartData = cartData.filter(item => item.id !== itemId);
            loadCart();
            updateCounters();
            showNotification('Produit retiré du panier');
        }

        function browseProducts() {
            showNotification('Redirection vers le catalogue des produits');
        }

        function checkout() {
            showNotification('Redirection vers la page de paiement');
        }

        function startChat() {
            showNotification('Ouverture du chat en direct...');
            // Simulation d'ouverture de chat
            setTimeout(() => {
                showNotification('Chat connecté ! Un agent va vous répondre dans quelques instants.');
            }, 2000);
        }

        function createTicket() {
            showNotification('Redirection vers le formulaire de création de ticket');
        }

        function contactUs() {
            showNotification('Redirection vers le formulaire de contact');
        }

        function showNotification(message) {
            const notification = document.getElementById('notification');
            const notificationText = document.getElementById('notification-text');
            
            notificationText.textContent = message;
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Simulation d'ajout de produits au panier
        function addToCart() {
            const newItem = {
                id: Date.now(),
                name: "Nouveau Service",
                price: Math.floor(Math.random() * 300) + 50,
                quantity: 1
            };
            
            cartData.push(newItem);
            loadCart();
            updateCounters();
            showNotification('Produit ajouté au panier !');
        }

        // Simulation d'ajout de nouvelles commandes
        function addNewOrder() {
            const statuses = ['pending', 'completed', 'cancelled'];
            const products = ['Site Web', 'Application Mobile', 'Consultation', 'Design Graphique'];
            
            const newOrder = {
                id: `#${Math.floor(Math.random() * 90000) + 10000}`,
                status: statuses[Math.floor(Math.random() * statuses.length)],
                statusText: statuses[Math.floor(Math.random() * statuses.length)] === 'pending' ? 'En cours' : 
                           statuses[Math.floor(Math.random() * statuses.length)] === 'completed' ? 'Complétée' : 'Annulée',
                product: products[Math.floor(Math.random() * products.length)],
                date: new Date().toLocaleDateString('fr-FR'),
                amount: `${Math.floor(Math.random() * 500) + 100}.99€`
            };
            
            ordersData.unshift(newOrder);
            loadOrders();
            updateCounters();
            showNotification('Nouvelle commande ajoutée !');
        }

        // Raccourcis clavier pour la démo
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey && e.key === '1') {
                e.preventDefault();
                addToCart();
            }
            if (e.ctrlKey && e.key === '2') {
                e.preventDefault();
                addNewOrder();
            }
        });

        // Animation au scroll pour les cartes
        function animateOnScroll() {
            const cards = document.querySelectorAll('.info-card, .order-card, .support-card, .contact-card');
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    card.style.animation = 'slideIn 0.6s ease-out';
                }
            });
        }

        window.addEventListener('scroll', animateOnScroll);

        // Mise à jour dynamique des données toutes les 30 secondes (simulation)
        setInterval(() => {
            // Simulation de nouvelles notifications
            const notifications = [
                'Nouvelle mise à jour disponible',
                'Votre commande #12344 a été mise à jour',
                'Promotion spéciale ce week-end !',
                'N\'oubliez pas de compléter votre profil'
            ];
            
            if (Math.random() > 0.7) {
                const randomNotification = notifications[Math.floor(Math.random() * notifications.length)];
                showNotification(randomNotification);
            }
        }, 30000);

        // Sauvegarde automatique des modifications (simulation)
        function autoSave() {
            console.log('Sauvegarde automatique des données...');
            // Ici, vous pourriez envoyer les données à votre serveur
        }

        setInterval(autoSave, 60000); // Sauvegarde toutes les minutes

        // Gestion du mode sombre (bonus)
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            showNotification('Mode sombre ' + (document.body.classList.contains('dark-mode') ? 'activé' : 'désactivé'));
        }

        // Ajout d'un bouton de démonstration flottant
        const demoButton = document.createElement('div');
        demoButton.innerHTML = `
            <div style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">
                <button class="btn btn-primary" onclick="addToCart()" title="Ajouter au panier (Ctrl+1)">
                    <i class="fas fa-plus"></i>
                </button>
                <button class="btn btn-success ms-2" onclick="addNewOrder()" title="Nouvelle commande (Ctrl+2)">
                    <i class="fas fa-shopping-bag"></i>
                </button>
            </div>
        `;
        document.body.appendChild(demoButton);

        // Gestion responsive améliorée
        function handleResize() {
            if (window.innerWidth < 768) {
                document.querySelector('.client-sidebar').style.position = 'relative';
            } else {
                document.querySelector('.client-sidebar').style.position = 'sticky';
            }
        }

        window.addEventListener('resize', handleResize);
        handleResize(); // Appel initial
    </script>
</body>
</html>