/**
 * Gestionnaire du panier pour l'interface utilisateur
 */
class CartManager {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.updateCartBadge();
    }

    bindEvents() {
        // Écouter les événements Livewire
        document.addEventListener('livewire:init', () => {
            Livewire.on('cartUpdated', () => {
                this.updateCartBadge();
                this.showCartNotification();
            });

            Livewire.on('cartCleared', () => {
                this.updateCartBadge();
                this.hideCartModal();
            });
        });

        // Fermer la modal en cliquant à l'extérieur
        document.addEventListener('click', (e) => {
            const cartModal = document.querySelector('.cart-modal-overlay');
            if (cartModal && e.target === cartModal) {
                this.hideCartModal();
            }
        });

        // Fermer la modal avec la touche Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.hideCartModal();
            }
        });
    }

    updateCartBadge() {
        fetch('/cart-count')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const badge = document.querySelector('.cart-badge');
                    if (data.count > 0) {
                        if (badge) {
                            badge.textContent = data.count;
                            badge.style.display = 'flex';
                        } else {
                            this.createCartBadge(data.count);
                        }
                    } else {
                        if (badge) {
                            badge.style.display = 'none';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Erreur lors de la mise à jour du badge:', error);
            });
    }

    createCartBadge(count) {
        const cartIcon = document.querySelector('.cart-icon-link');
        if (cartIcon) {
            const badge = document.createElement('span');
            badge.className = 'cart-badge';
            badge.textContent = count;
            badge.style.display = 'flex';
            cartIcon.appendChild(badge);
        }
    }

    showCartNotification() {
        // Créer une notification toast
        const toast = document.createElement('div');
        toast.className = 'cart-toast';
        toast.innerHTML = `
            <div class="cart-toast-content">
                <i class="fa-solid fa-check-circle text-success me-2"></i>
                <span>Produit ajouté au panier avec succès !</span>
            </div>
        `;

        document.body.appendChild(toast);

        // Animation d'entrée
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);

        // Supprimer après 3 secondes
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

    hideCartModal() {
        const modal = document.querySelector('.cart-modal-overlay');
        if (modal) {
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }
    }

    // Méthode pour ajouter un produit au panier via AJAX
    addToCart(productData) {
        return fetch('/add-to-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(productData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateCartBadge();
                this.showCartNotification();
                return data;
            } else {
                throw new Error(data.message);
            }
        });
    }

    // Méthode pour vider le panier via AJAX
    clearCart() {
        return fetch('/clear-cart', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.updateCartBadge();
                this.hideCartModal();
                return data;
            } else {
                throw new Error(data.message);
            }
        });
    }
}

// Initialiser le gestionnaire de panier
document.addEventListener('DOMContentLoaded', () => {
    window.cartManager = new CartManager();
});

// Styles CSS pour les notifications
const cartStyles = `
    .cart-toast {
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        border: 1px solid #d4edda;
        border-radius: 8px;
        padding: 15px 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
        max-width: 300px;
    }

    .cart-toast.show {
        transform: translateX(0);
    }

    .cart-toast-content {
        display: flex;
        align-items: center;
        font-size: 14px;
        color: #155724;
    }

    .cart-badge {
        animation: pulse 0.6s ease-in-out;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .cart-modal {
        animation: slideInRight 0.3s ease-out;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .cart-modal-overlay {
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
`;

// Ajouter les styles au document
const styleSheet = document.createElement('style');
styleSheet.textContent = cartStyles;
document.head.appendChild(styleSheet); 