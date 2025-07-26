@extends('layouts.main')

@section('title', 'Base de connaissances')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('support.index') }}" class="text-decoration-none">
                            <i class="fas fa-headset me-1"></i>
                            Support
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Base de connaissances
                    </li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold text-primary">
                <i class="fas fa-book me-3"></i>
                Base de connaissances
            </h1>
            <p class="lead text-muted">Trouvez rapidement des solutions à vos problèmes</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('support.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Nouveau ticket
            </a>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" 
                               id="searchInput" 
                               placeholder="Rechercher dans la base de connaissances...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="row">
        @foreach($categories as $categoryKey => $category)
        <div class="col-md-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white text-center">
                    <div class="display-6 text-primary mb-2">
                        <i class="{{ $category['icon'] }}"></i>
                    </div>
                    <h5 class="card-title mb-0">{{ $category['title'] }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text text-muted text-center mb-4">
                        {{ $category['description'] }}
                    </p>
                    
                    <div class="articles-list">
                        @foreach($category['articles'] as $article)
                        <div class="article-item mb-3" data-search="{{ strtolower($article['title']) }}">
                            <a href="{{ route('support.article', [$categoryKey, $article['id']]) }}" 
                               class="text-decoration-none">
                                <div class="d-flex align-items-center p-2 rounded hover-bg-light">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="fas fa-file-alt text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-dark">{{ $article['title'] }}</h6>
                                        <small class="text-muted">Article d'aide</small>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('support.knowledge-base') }}?category={{ $categoryKey }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-2"></i>
                        Voir tous les articles
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Popular Articles -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>
                        Articles populaires
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="popular-article mb-3">
                                <a href="#" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 rounded hover-bg-light">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-tools text-warning"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">Comment résoudre les problèmes de connexion</h6>
                                            <small class="text-muted">Guide complet pour diagnostiquer et résoudre les problèmes de connexion</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="popular-article mb-3">
                                <a href="#" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 rounded hover-bg-light">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-download text-success"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">Installation sur Smart TV</h6>
                                            <small class="text-muted">Guide étape par étape pour installer l'application sur votre Smart TV</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="popular-article mb-3">
                                <a href="#" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 rounded hover-bg-light">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-cog text-info"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">Configuration des paramètres avancés</h6>
                                            <small class="text-muted">Optimisez votre expérience avec les paramètres avancés</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="popular-article mb-3">
                                <a href="#" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 rounded hover-bg-light">
                                        <div class="flex-shrink-0 me-3">
                                            <i class="fas fa-question-circle text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">FAQ - Questions fréquentes</h6>
                                            <small class="text-muted">Réponses aux questions les plus courantes</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Support -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body text-center py-5">
                    <div class="display-4 mb-3">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="mb-3">Vous n'avez pas trouvé ce que vous cherchiez ?</h3>
                    <p class="lead mb-4">Notre équipe de support est là pour vous aider</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('support.create') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-plus me-2"></i>
                            Créer un ticket
                        </a>
                        <a href="{{ route('support.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Mes tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.hover-bg-light:hover {
    background-color: rgba(0, 123, 255, 0.05) !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
}

.article-item {
    transition: all 0.2s ease-in-out;
}

.article-item:hover {
    transform: translateX(5px);
}

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}

.display-6 {
    font-size: 2.5rem;
}
</style>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const articles = document.querySelectorAll('.article-item');
    
    articles.forEach(article => {
        const searchText = article.getAttribute('data-search');
        if (searchText.includes(searchTerm)) {
            article.style.display = '';
        } else {
            article.style.display = 'none';
        }
    });
    
    // Show/hide category cards based on visible articles
    const categoryCards = document.querySelectorAll('.col-md-4');
    categoryCards.forEach(card => {
        const visibleArticles = card.querySelectorAll('.article-item[style=""]').length;
        const totalArticles = card.querySelectorAll('.article-item').length;
        
        if (visibleArticles === 0 && searchTerm !== '') {
            card.style.display = 'none';
        } else {
            card.style.display = '';
        }
    });
});

// Filter by category if URL parameter is present
const urlParams = new URLSearchParams(window.location.search);
const category = urlParams.get('category');
if (category) {
    const categoryCards = document.querySelectorAll('.col-md-4');
    categoryCards.forEach((card, index) => {
        const categoryKeys = ['installation', 'configuration', 'depannage'];
        if (categoryKeys[index] !== category) {
            card.style.display = 'none';
        }
    });
}
</script>
@endsection 