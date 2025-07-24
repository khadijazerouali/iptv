@extends('layouts.main')

@section('title', 'Détails de la commande #' . $subscription->number_order)

@section('content')
<div class="order-details-container">
    <div class="order-header">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a> > 
            <a href="{{ route('dashboard') }}#commandes">Mes Commandes</a> > 
            <span>Commande #{{ $subscription->number_order }}</span>
        </div>
    </div>

    <div class="order-content">
        <!-- En-tête de la commande -->
        <div class="order-main-header">
            <div class="order-title-section">
                <h1 class="order-title">Commande #{{ $subscription->number_order }}</h1>
                <div class="order-status status-{{ $subscription->status }}">
                    {{ ucfirst($subscription->status) }}
                </div>
            </div>
            <div class="order-meta">
                <div class="order-date">
                    <strong>Date de commande:</strong> {{ $subscription->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="order-quantity">
                    <strong>Quantité:</strong> {{ $subscription->quantity }}
                </div>
            </div>
        </div>

        <!-- Informations du produit -->
        @if($subscription->product)
        <div class="order-section">
            <h2 class="section-title">Formation commandée</h2>
            <div class="product-details">
                <div class="product-info">
                    <h3 class="product-title">{{ $subscription->product->title }}</h3>
                    <div class="product-meta">
                        @if($subscription->product->category)
                            <span class="product-category">{{ $subscription->product->category->name }}</span>
                        @endif
                        <span class="product-type">{{ ucfirst($subscription->product->type) }}</span>
                    </div>
                    <div class="product-price">
                        <span class="price">{{ number_format($subscription->product->price, 2) }}€</span>
                    </div>
                    <div class="product-description">
                        {{ $subscription->product->description }}
                    </div>
                </div>
                <div class="product-actions">
                    <a href="{{ route('product.details', $subscription->product->uuid) }}" class="btn btn-primary">
                        Voir la formation
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Dates de validité -->
        <div class="order-section">
            <h2 class="section-title">Période de validité</h2>
            <div class="validity-details">
                <div class="validity-item">
                    <div class="validity-label">Date de début</div>
                    <div class="validity-value">{{ $subscription->start_date->format('d/m/Y') }}</div>
                </div>
                <div class="validity-item">
                    <div class="validity-label">Date de fin</div>
                    <div class="validity-value">
                        @if($subscription->end_date)
                            {{ $subscription->end_date->format('d/m/Y') }}
                        @else
                            <span class="text-muted">Non définie</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Options et configurations -->
        <div class="order-section">
            <h2 class="section-title">Configuration</h2>
            <div class="config-grid">
                @if($subscription->productOption)
                <div class="config-item">
                    <div class="config-label">Option produit</div>
                    <div class="config-value">{{ $subscription->productOption->name }}</div>
                </div>
                @endif

                @if($subscription->applicationType)
                <div class="config-item">
                    <div class="config-label">Type d'application</div>
                    <div class="config-value">{{ $subscription->applicationType->name }}</div>
                </div>
                @endif

                @if($subscription->deviceType)
                <div class="config-item">
                    <div class="config-label">Type d'appareil</div>
                    <div class="config-value">{{ $subscription->deviceType->name }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- VODs associées -->
        @if($subscription->formiptvs && $subscription->formiptvs->count() > 0)
        <div class="order-section">
            <h2 class="section-title">VODs incluses</h2>
            <div class="vods-list">
                @foreach($subscription->formiptvs as $formiptv)
                    @if($formiptv->vods)
                        <div class="vod-item">
                            <div class="vod-content">{{ $formiptv->vods }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Informations techniques -->
        @if($subscription->formiptvs && $subscription->formiptvs->count() > 0)
        <div class="order-section">
            <h2 class="section-title">Informations techniques</h2>
            <div class="tech-grid">
                @foreach($subscription->formiptvs as $formiptv)
                    @if($formiptv->mac_address)
                    <div class="tech-item">
                        <div class="tech-label">Adresse MAC</div>
                        <div class="tech-value">{{ $formiptv->mac_address }}</div>
                    </div>
                    @endif

                    @if($formiptv->device_id)
                    <div class="tech-item">
                        <div class="tech-label">ID Appareil</div>
                        <div class="tech-value">{{ $formiptv->device_id }}</div>
                    </div>
                    @endif

                    @if($formiptv->device_key)
                    <div class="tech-item">
                        <div class="tech-label">Clé Appareil</div>
                        <div class="tech-value">{{ $formiptv->device_key }}</div>
                    </div>
                    @endif

                    @if($formiptv->otp_code)
                    <div class="tech-item">
                        <div class="tech-label">Code OTP</div>
                        <div class="tech-value">{{ $formiptv->otp_code }}</div>
                    </div>
                    @endif

                    @if($formiptv->formuler_mac)
                    <div class="tech-item">
                        <div class="tech-label">Formuler MAC</div>
                        <div class="tech-value">{{ $formiptv->formuler_mac }}</div>
                    </div>
                    @endif

                    @if($formiptv->mag_adresse)
                    <div class="tech-item">
                        <div class="tech-label">Adresse MAG</div>
                        <div class="tech-value">{{ $formiptv->mag_adresse }}</div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($subscription->note)
        <div class="order-section">
            <h2 class="section-title">Notes</h2>
            <div class="notes-content">
                {{ $subscription->note }}
            </div>
        </div>
        @endif

        <!-- Paiements -->
        @if($subscription->payments && $subscription->payments->count() > 0)
        <div class="order-section">
            <h2 class="section-title">Historique des paiements</h2>
            <div class="payments-list">
                @foreach($subscription->payments as $payment)
                <div class="payment-item">
                    <div class="payment-header">
                        <div class="payment-amount">{{ number_format($payment->amount, 2) }}€</div>
                        <div class="payment-status status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </div>
                    </div>
                    <div class="payment-meta">
                        <div class="payment-date">{{ $payment->created_at->format('d/m/Y H:i') }}</div>
                        @if($payment->payment_method)
                            <div class="payment-method">{{ $payment->payment_method }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="order-actions">
            <a href="{{ route('dashboard') }}#commandes" class="btn btn-secondary">
                ← Retour aux commandes
            </a>
            <button onclick="downloadInvoice('{{ $subscription->uuid }}')" class="btn btn-primary">
                📄 Télécharger la facture
            </button>
            <button onclick="contactSupport('{{ $subscription->uuid }}')" class="btn btn-secondary">
                💬 Contacter le support
            </button>
        </div>
    </div>
</div>

<script>
function downloadInvoice(subscriptionUuid) {
    // Afficher un message de chargement
    const loadingToast = showToast('Génération de la facture en cours...', 'info');
    
    // Simuler le téléchargement (remplacez par votre logique réelle)
    setTimeout(() => {
        loadingToast.remove();
        showToast('Facture téléchargée avec succès !', 'success');
    }, 2000);
}

function contactSupport(subscriptionUuid) {
    // Rediriger vers la page de support avec l'ID de la commande
    window.location.href = '{{ route("dashboard") }}#support';
}

// Utilitaires pour les toasts
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    
    // Ajouter au DOM
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.appendChild(toast);
    
    // Auto-suppression après 5 secondes
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
    
    return toast;
}
</script>

<style>
.order-details-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.order-header {
    margin-bottom: 2rem;
}

.breadcrumb {
    color: #718096;
    font-size: 0.9rem;
}

.breadcrumb a {
    color: #667eea;
    text-decoration: none;
}

.breadcrumb a:hover {
    text-decoration: underline;
}

.order-content {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.order-main-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.order-title-section {
    flex: 1;
}

.order-title {
    font-size: 2rem;
    font-weight: bold;
    margin: 0 0 0.5rem 0;
}

.order-status {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-active {
    background: rgba(5, 150, 105, 0.2);
    color: #10b981;
}

.status-inactive {
    background: rgba(239, 68, 68, 0.2);
    color: #f87171;
}

.status-pending {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
}

.order-meta {
    text-align: right;
}

.order-date, .order-quantity {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.order-section {
    padding: 2rem;
    border-bottom: 1px solid #e2e8f0;
}

.order-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 1.5rem 0;
}

.product-details {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 2rem;
    align-items: start;
}

.product-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 1rem 0;
}

.product-meta {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.product-category, .product-type {
    background: #e2e8f0;
    color: #4a5568;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
}

.product-price {
    margin-bottom: 1rem;
}

.price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #059669;
}

.product-description {
    color: #4a5568;
    line-height: 1.6;
}

.validity-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.validity-item {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.validity-label {
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.validity-value {
    font-weight: bold;
    color: #2d3748;
}

.config-grid, .tech-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.config-item, .tech-item {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.config-label, .tech-label {
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 0.5rem;
}

.config-value, .tech-value {
    font-weight: bold;
    color: #2d3748;
    word-break: break-all;
}

.vods-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.vod-item {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.vod-content {
    color: #4a5568;
}

.notes-content {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    color: #4a5568;
    line-height: 1.6;
}

.payments-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.payment-item {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.payment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.payment-amount {
    font-weight: bold;
    color: #2d3748;
    font-size: 1.125rem;
}

.payment-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #718096;
}

.order-actions {
    padding: 2rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #667eea;
    color: white;
}

.btn-primary:hover {
    background: #5a6fd8;
}

.btn-secondary {
    background: #718096;
    color: white;
}

.btn-secondary:hover {
    background: #4a5568;
}

/* Styles pour les toasts */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 3000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    min-width: 300px;
    animation: slideIn 0.3s ease;
}

.toast-info {
    background-color: #dbeafe;
    color: #1e40af;
    border-left: 4px solid #3b82f6;
}

.toast-success {
    background-color: #d1fae5;
    color: #065f46;
    border-left: 4px solid #059669;
}

.toast button {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: 1rem;
    opacity: 0.7;
}

.toast button:hover {
    opacity: 1;
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

@media (max-width: 768px) {
    .order-main-header {
        flex-direction: column;
        gap: 1rem;
    }
    
    .order-meta {
        text-align: left;
    }
    
    .product-details {
        grid-template-columns: 1fr;
    }
    
    .order-actions {
        flex-direction: column;
    }
    
    .validity-details,
    .config-grid,
    .tech-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection 