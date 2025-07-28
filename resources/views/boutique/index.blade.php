@extends('layouts.main')

@section('title', 'Boutique')

@section('styles')
<link rel="stylesheet" href="{{ asset('/assets/css/boutique.css') }}" />
@endsection

@section('content')
<div class="boutique-page">
    <!-- Sidebar moderne -->
    <aside class="boutique-sidebar">
                <h2 class="sidebar-title">
                    <i class="fas fa-shopping-bag"></i>
                    Boutique
                </h2>
                
                <!-- Section utilisateur -->
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <h6>Bienvenue</h6>
                        <small>Découvrez nos produits</small>
                    </div>
                </div>
                
                <!-- Barre de recherche -->
                <div class="search-container">
                    <form method="GET" action="{{ route('boutique.index') }}">
                        <input type="text" 
                               name="search" 
                               class="search-input" 
                               placeholder="Rechercher un produit..." 
                               value="{{ request('search') }}"
                               autocomplete="off">
                        <button type="submit" class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Navigation des catégories -->
                <ul class="category-nav">
                    <li class="category-item">
                        <a class="category-link{{ !request('category') ? ' active' : '' }}" 
                           href="{{ route('boutique.index', array_filter(['search' => request('search')])) }}">
                            <i class="fas fa-th-large me-2"></i>
                            Tous les produits
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li class="category-item">
                            <a class="category-link{{ request('category') == $category->uuid ? ' active' : '' }}" 
                               href="{{ route('boutique.index', array_filter(['category' => $category->uuid, 'search' => request('search')])) }}">
                                <i class="fas fa-tag me-2"></i>
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </aside>
    
    <!-- Container principal -->
    <div class="boutique-container">
        <!-- Section des produits -->
        <main class="products-section">
                <h1 class="section-title">Nos Produits</h1>
                
                @if($products->count() > 0)
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <div class="product-image-container">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             class="product-image" 
                                             alt="{{ $product->title }}"
                                             loading="lazy">
                                    @else
                                        <div class="product-image-container d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="product-overlay">
                                        <button class="view-button-overlay">
                                            <i class="fas fa-eye me-2"></i>
                                            Voir détails
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="product-content">
                                    <h3 class="product-title">{{ \App\Helpers\HtmlHelper::cleanHtml($product->title) }}</h3>
                                    
                                    @if($product->description)
                                        <div class="product-description">
                                            {{ \App\Helpers\HtmlHelper::cleanHtml($product->description, 100) }}
                                        </div>
                                    @endif
                                    
                                    <div class="product-price">
                                        <span class="price-currency">€</span>
                                        <strong>{{ number_format($product->price, 2) }}</strong>
                                    </div>
                                    
                                    <a href="{{ route('product', $product->slug) }}" 
                                       class="product-button">
                                        <i class="fas fa-eye me-2"></i>
                                        Voir détails
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h3 class="empty-state-title">Aucun produit trouvé</h3>
                        <p class="empty-state-text">
                            @if(request('search') || request('category'))
                                Aucun produit ne correspond à vos critères de recherche.
                                <br>
                                <a href="{{ route('boutique.index') }}" class="text-decoration-none">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Voir tous les produits
                                </a>
                            @else
                                Aucun produit n'est disponible pour le moment.
                                <br>
                                Revenez plus tard pour découvrir nos nouvelles offres !
                            @endif
                        </p>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des cartes au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observer toutes les cartes de produits
    document.querySelectorAll('.product-card').forEach(card => {
        observer.observe(card);
    });

    // Effet de hover amélioré pour les boutons
    document.querySelectorAll('.product-button').forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Animation de la barre de recherche
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }
});
</script>
@endpush