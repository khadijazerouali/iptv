<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Abonnement iptv Premium</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('/assets/css/Style.css') }}" />
    @yield('styles')
    <style>
        .whatsapp-button {
            background-color: #25d366;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .whatsapp-button:hover {
            background-color: #1da851;
        }

        .fab {
            font-size: 24px;
        }
    </style>
    @livewireStyles
</head>

<body>
    @stack('scripts')
    
    <!--whatsapp Button-->
    <a href="https://api.whatsapp.com/message/5LUH3NO6QLG5N1?autoload=1&app_absent=0" target="_blank">
        <button class="Btn">
            <div class="sign">
                <svg class="socialSvg whatsappSvg" viewBox="0 0 16 16">
                    <path
                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z">
                    </path>
                </svg>
            </div>
            <div class="text">Whatsapp</div>
        </button>
    </a>
    <!-- End whatsapp Button-->
    <livewire:inc.header />



    <!-- Contenu de la page -->
    <div class="container mt-4">
      @yield('content')  <!-- C'est ici que le contenu des pages sera inséré -->
  </div>

  <!-- <button id="whatsapp-button" class="whatsapp-button">
        <i class="fab fa-whatsapp"></i>
        Contacter Nous !
    </button>

    <script>
        document.getElementById('whatsapp-button').addEventListener('click', function() {
            var phone = '+1234567890'; // Replace with your WhatsApp number
            var message = 'Bonjour, je voudrais plus d\'informations sur vos produits.'; // Optional: Pre-filled message

            var url = 'https://wa.me/' + phone;
            if (message) {
                url += '?text=' + encodeURIComponent(message);
            }

            window.open(url, '_blank');
        });
    </script> -->


    <!--Footer-->

    <livewire:inc.footer />

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex align-items-center">
                        <img src="/assets/images/product-box.svg" alt="Product" style="width: 40px; height: 40px; margin-right: 15px;">
                        <h5 class="modal-title" id="cartModalLabel" id="modalProductTitle">Produit ajouté au panier</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="modalProductDetails">
                        <!-- Les détails du produit seront insérés ici -->
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold">Sous-Total :</span>
                            <span class="fw-bold fs-5" id="modalTotal">0.00 €</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="viewCart()">
                        <i class="fas fa-shopping-cart me-2"></i>
                        Voir Le Panier
                    </button>
                    <button type="button" class="btn btn-dark" onclick="goToCheckout()">
                        <i class="fas fa-credit-card me-2"></i>
                        Commander
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('livewire:init', () => {
        console.log('Livewire initialized');
        
        Livewire.on('showCartModal', (data) => {
            console.log('showCartModal event received:', data);
            showCartModal(data);
        });
    });

    function showCartModal(data) {
        // Mettre à jour le titre
        document.getElementById('modalProductTitle').textContent = data.productTitle;
        
        // Construire les détails du produit
        let details = '';
        
        // Pour Abonnement
        if (data.device) {
            details += `
                <div class="mb-2">
                    <strong>Dispositif d'abonnement IPTV :</strong> ${data.device}
                </div>
            `;
        }
        
        if (data.magAddress) {
            details += `
                <div class="mb-2">
                    <strong>Mag Adresse :</strong> ${data.magAddress}
                </div>
            `;
        }
        
        if (data.channels && data.channels.length > 0) {
            details += `
                <div class="mb-2">
                    <strong>Sélectionnez vos bouquets de chaines :</strong> ${data.channels.join(', ')}
                </div>
            `;
        }
        
        if (data.vods && data.vods.length > 0) {
            details += `
                <div class="mb-2">
                    <strong>Vidéos à la demande :</strong> ${data.vods.join(', ')}
                </div>
            `;
        }
        
        // Pour Revendeur
        if (data.firstName && data.lastName) {
            details += `
                <div class="mb-2">
                    <strong>Nom :</strong> ${data.firstName} ${data.lastName}
                </div>
            `;
        }
        
        if (data.email) {
            details += `
                <div class="mb-2">
                    <strong>Email :</strong> ${data.email}
                </div>
            `;
        }
        
        // Pour Renouvellement
        if (data.orderNumber) {
            details += `
                <div class="mb-2">
                    <strong>N° de la commande à renouveler :</strong> ${data.orderNumber}
                </div>
            `;
        }
        
        details += `
            <div class="mb-2">
                <strong>Quantité :</strong> ${data.quantity} x ${data.price.toFixed(2)} €
            </div>
        `;
        
        // Mettre à jour les détails et le total
        document.getElementById('modalProductDetails').innerHTML = details;
        document.getElementById('modalTotal').textContent = data.total.toFixed(2) + ' €';
        
        // Afficher la modal
        const modal = new bootstrap.Modal(document.getElementById('cartModal'));
        modal.show();
    }

    function viewCart() {
        // Fermer la modal et rediriger vers le panier
        const modal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
        modal.hide();
        window.location.href = '{{ route("checkout") }}';
    }

    function goToCheckout() {
        // Fermer la modal et rediriger vers le checkout
        const modal = bootstrap.Modal.getInstance(document.getElementById('cartModal'));
        modal.hide();
        window.location.href = '{{ route("checkout") }}';
    }
    </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
@livewireScripts
</html>