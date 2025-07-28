<div>
    @if($showModal && $cart && !empty($cartDetails))
    <div class="cart-modal-overlay" wire:click="hideModal">
        <div class="cart-modal" wire:click.stop>
            <div class="cart-modal-header">
                <h5 class="cart-modal-title">
                    <i class="fa-solid fa-shopping-cart me-2"></i>
                    Votre Panier
                </h5>
                <button type="button" class="cart-modal-close" wire:click="hideModal">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>
            
            <div class="cart-modal-body">
                <div class="cart-item">
                    <div class="cart-item-image">
                        @if($cartDetails['image'])
                            <img src="{{ asset('storage/' . $cartDetails['image']) }}" alt="{{ $cartDetails['title'] }}" class="img-fluid">
                        @else
                            <div class="cart-item-placeholder">
                                <i class="fa-solid fa-box"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="cart-item-details">
                        <h6 class="cart-item-title">{{ $cartDetails['title'] }}</h6>
                        
                        @if(isset($cartDetails['device']) && $cartDetails['device'])
                            <div class="cart-item-info">
                                <small class="text-muted">
                                    <i class="fa-solid fa-tv me-1"></i>
                                    Device: {{ $cartDetails['device'] }}
                                </small>
                            </div>
                        @endif
                        
                        @if(isset($cartDetails['application']) && $cartDetails['application'])
                            <div class="cart-item-info">
                                <small class="text-muted">
                                    <i class="fa-solid fa-mobile-screen me-1"></i>
                                    Application: {{ $cartDetails['application'] }}
                                </small>
                            </div>
                        @endif
                        
                        @if(isset($cartDetails['option']))
                            <div class="cart-item-option">
                                <small class="text-muted">
                                    <i class="fa-solid fa-clock me-1"></i>
                                    Durée: {{ $cartDetails['option'] }}
                                </small>
                            </div>
                        @endif
                        
                        <div class="cart-item-meta">
                            <span class="cart-item-quantity">Quantité: {{ $cartDetails['quantity'] }}</span>
                            <span class="cart-item-price">{{ number_format($cartDetails['price'], 2) }} €</span>
                        </div>
                    </div>
                </div>
                
                <div class="cart-total">
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total:</strong>
                        <strong class="cart-total-price">{{ number_format($cartDetails['total'], 2) }} €</strong>
                    </div>
                </div>
            </div>
            
            <div class="cart-modal-footer">
                <button type="button" class="btn btn-outline-danger btn-sm" wire:click="clearCart">
                    <i class="fa-solid fa-trash me-1"></i>
                    Vider le panier
                </button>
                <button type="button" class="btn btn-primary" wire:click="goToCheckout">
                    <i class="fa-solid fa-credit-card me-1"></i>
                    Procéder au paiement
                </button>
            </div>
        </div>
    </div>
    @endif

    <style>
    .cart-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1050;
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        padding: 20px;
    }
    
    .cart-modal {
        background: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        width: 400px;
        max-width: 90vw;
        max-height: 80vh;
        overflow: hidden;
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .cart-modal-header {
        background: #f8f9fa;
        padding: 15px 20px;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .cart-modal-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }
    
    .cart-modal-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        color: #666;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.2s;
    }
    
    .cart-modal-close:hover {
        background-color: #e9ecef;
    }
    
    .cart-modal-body {
        padding: 20px;
        max-height: 400px;
        overflow-y: auto;
    }
    
    .cart-item {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .cart-item-image {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }
    
    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }
    
    .cart-item-placeholder {
        width: 100%;
        height: 100%;
        background: #f8f9fa;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.5rem;
    }
    
    .cart-item-details {
        flex: 1;
    }
    
    .cart-item-title {
        margin: 0 0 5px 0;
        font-size: 1rem;
        font-weight: 600;
        color: #333;
    }
    
    .cart-item-description {
        margin: 0 0 8px 0;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.4;
    }
    
    .cart-item-info {
        margin-bottom: 6px;
    }
    
    .cart-item-option {
        margin-bottom: 8px;
    }
    
    .cart-item-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
    }
    
    .cart-item-quantity {
        color: #666;
    }
    
    .cart-item-price {
        font-weight: 600;
        color: #007bff;
    }
    
    .cart-total {
        margin-top: 15px;
    }
    
    .cart-total-price {
        color: #28a745;
        font-size: 1.1rem;
    }
    
    .cart-modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #dee2e6;
        background: #f8f9fa;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }
    
    .cart-modal-footer .btn {
        padding: 8px 16px;
        font-size: 0.9rem;
    }
    
    @media (max-width: 768px) {
        .cart-modal {
            width: 95vw;
            margin: 10px;
        }
        
        .cart-modal-overlay {
            padding: 10px;
        }
    }
    </style>
</div> 