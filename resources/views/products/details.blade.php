@extends('layouts.main')

@section('title', $product->title)

@section('content')
<div class="product-details-container">
    <div class="product-header">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a> > 
            <a href="{{ route('dashboard') }}#commandes">Mes Commandes</a> > 
            <span>{{ $product->title }}</span>
        </div>
    </div>

    <div class="product-content">
        <!-- Image et informations principales -->
        <div class="product-main">
            <div class="product-image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->title }}" class="product-img">
                @else
                    <div class="product-placeholder">
                        <span>📺</span>
                    </div>
                @endif
            </div>

            <div class="product-info">
                <h1 class="product-title">{{ $product->title }}</h1>
                
                <div class="product-meta">
                    @if($product->category)
                        <span class="product-category">{{ $product->category->name }}</span>
                    @endif
                    <span class="product-type">{{ ucfirst($product->type) }}</span>
                </div>

                <div class="product-price">
                    @if($product->price_old && $product->price_old > $product->price)
                        <span class="price-old">{{ number_format($product->price_old, 2) }}€</span>
                    @endif
                    <span class="price-current">{{ number_format($product->price, 2) }}€</span>
                </div>

                <div class="product-description">
                    {!! nl2br(e($product->description)) !!}
                </div>

                <div class="product-stats">
                    <div class="stat">
                        <span class="stat-label">Vues:</span>
                        <span class="stat-value">{{ number_format($product->view) }}</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Commandes:</span>
                        <span class="stat-value">{{ number_format($product->orders) }}</span>
                    </div>
                    <div class="stat">
                        <span class="stat-label">Status:</span>
                        <span class="stat-value status-{{ $product->status }}">
                            {{ ucfirst($product->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Options du produit -->
        @if($product->productOptions && $product->productOptions->count() > 0)
        <div class="product-section">
            <h2 class="section-title">Options disponibles</h2>
            <div class="options-grid">
                @foreach($product->productOptions as $option)
                <div class="option-card">
                    <h3 class="option-title">{{ $option->name }}</h3>
                    <div class="option-details">
                        @if($option->price)
                            <div class="option-price">{{ number_format($option->price, 2) }}€</div>
                        @endif
                        @if($option->description)
                            <div class="option-description">{{ $option->description }}</div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Durée -->
        @if($product->durationOption)
        <div class="product-section">
            <h2 class="section-title">Durée</h2>
            <div class="duration-info">
                <div class="duration-card">
                    <h3>{{ $product->durationOption->name }}</h3>
                    @if($product->durationOption->description)
                        <p>{{ $product->durationOption->description }}</p>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Types d'appareils supportés -->
        @if($product->devices && $product->devices->count() > 0)
        <div class="product-section">
            <h2 class="section-title">Appareils supportés</h2>
            <div class="devices-grid">
                @foreach($product->devices as $device)
                <div class="device-card">
                    <div class="device-icon">📱</div>
                    <div class="device-name">{{ $device->name }}</div>
                    @if($device->description)
                        <div class="device-description">{{ $device->description }}</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Avis et commentaires -->
        @if($product->reviews && $product->reviews->count() > 0)
        <div class="product-section">
            <h2 class="section-title">Avis clients</h2>
            <div class="reviews-container">
                @foreach($product->reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div class="reviewer-name">{{ $review->user->name ?? 'Anonyme' }}</div>
                        <div class="review-date">{{ $review->created_at->format('d/m/Y') }}</div>
                    </div>
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">★</span>
                        @endfor
                    </div>
                    <div class="review-comment">{{ $review->comment }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Actions -->
        <div class="product-actions">
            <a href="{{ route('dashboard') }}#commandes" class="btn btn-secondary">
                ← Retour aux commandes
            </a>
            <button class="btn btn-primary" onclick="addToCart('{{ $product->uuid }}')">
                Ajouter au panier
            </button>
        </div>
    </div>
</div>

<script>
function addToCart(productUuid) {
    // Logique pour ajouter au panier
    fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_uuid: productUuid
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Produit ajouté au panier avec succès !');
        } else {
            alert('Erreur lors de l\'ajout au panier');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erreur lors de l\'ajout au panier');
    });
}
</script>

<style>
.product-details-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.product-header {
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

.product-content {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.product-main {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 2rem;
    padding: 2rem;
}

.product-image {
    text-align: center;
}

.product-img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    border-radius: 8px;
}

.product-placeholder {
    width: 100%;
    height: 300px;
    background: #f7fafc;
    border: 2px dashed #cbd5e0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 4rem;
    color: #a0aec0;
}

.product-title {
    font-size: 2rem;
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
    margin-bottom: 1.5rem;
}

.price-old {
    text-decoration: line-through;
    color: #a0aec0;
    font-size: 1.125rem;
    margin-right: 0.5rem;
}

.price-current {
    font-size: 1.5rem;
    font-weight: bold;
    color: #059669;
}

.product-description {
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.product-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.stat {
    text-align: center;
    padding: 1rem;
    background: #f7fafc;
    border-radius: 8px;
}

.stat-label {
    display: block;
    font-size: 0.875rem;
    color: #718096;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-weight: bold;
    color: #2d3748;
}

.status-active {
    color: #059669;
}

.status-inactive {
    color: #dc2626;
}

.product-section {
    padding: 2rem;
    border-top: 1px solid #e2e8f0;
}

.section-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 1.5rem 0;
}

.options-grid, .devices-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1rem;
}

.option-card, .device-card {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.option-title, .device-name {
    font-weight: bold;
    color: #2d3748;
    margin-bottom: 0.5rem;
}

.option-price {
    font-weight: bold;
    color: #059669;
    margin-bottom: 0.5rem;
}

.option-description, .device-description {
    color: #718096;
    font-size: 0.875rem;
}

.device-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.duration-info {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.duration-card h3 {
    margin: 0 0 0.5rem 0;
    color: #2d3748;
}

.duration-card p {
    margin: 0;
    color: #718096;
}

.reviews-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.review-card {
    background: #f7fafc;
    padding: 1rem;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

.review-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.reviewer-name {
    font-weight: bold;
    color: #2d3748;
}

.review-date {
    color: #718096;
    font-size: 0.875rem;
}

.review-rating {
    margin-bottom: 0.5rem;
}

.star {
    color: #cbd5e0;
    font-size: 1.125rem;
}

.star.filled {
    color: #f6ad55;
}

.review-comment {
    color: #4a5568;
    line-height: 1.5;
}

.product-actions {
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

@media (max-width: 768px) {
    .product-main {
        grid-template-columns: 1fr;
    }
    
    .product-stats {
        grid-template-columns: 1fr;
    }
    
    .options-grid, .devices-grid {
        grid-template-columns: 1fr;
    }
    
    .product-actions {
        flex-direction: column;
    }
}
</style>
@endsection 