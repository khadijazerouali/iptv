@extends('layouts.main')

@section('title', $article['title'])

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
                    <li class="breadcrumb-item">
                        <a href="{{ route('support.knowledge-base') }}" class="text-decoration-none">
                            Base de connaissances
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('support.knowledge-base') }}?category={{ $category }}" class="text-decoration-none">
                            {{ ucfirst($category) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $article['title'] }}
                    </li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold text-primary">
                <i class="fas fa-file-alt me-3"></i>
                {{ $article['title'] }}
            </h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('support.knowledge-base') }}?category={{ $category }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>
                Retour aux articles
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-md-8">
            <!-- Article Content -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-primary me-2">{{ ucfirst($category) }}</span>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Dernière mise à jour : {{ now()->format('d/m/Y') }}
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm" onclick="window.print()">
                                <i class="fas fa-print me-1"></i>
                                Imprimer
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="copyToClipboard()">
                                <i class="fas fa-copy me-1"></i>
                                Copier
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="article-content">
                        {!! $article['content'] !!}
                    </div>
                </div>
            </div>

            <!-- Feedback Section -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-thumbs-up me-2"></i>
                        Cet article vous a-t-il aidé ?
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-outline-success btn-lg w-100 mb-2" onclick="submitFeedback('helpful')">
                                <i class="fas fa-thumbs-up me-2"></i>
                                Oui, très utile
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-danger btn-lg w-100 mb-2" onclick="submitFeedback('not-helpful')">
                                <i class="fas fa-thumbs-down me-2"></i>
                                Non, pas utile
                            </button>
                        </div>
                    </div>
                    <small class="text-muted">
                        Votre avis nous aide à améliorer nos articles
                    </small>
                </div>
            </div>

            <!-- Related Articles -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-link me-2"></i>
                        Articles liés
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="d-flex align-items-center p-2 rounded hover-bg-light">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="fas fa-file-alt text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-dark">Article lié 1</h6>
                                        <small class="text-muted">Description courte</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="#" class="text-decoration-none">
                                <div class="d-flex align-items-center p-2 rounded hover-bg-light">
                                    <div class="flex-shrink-0 me-3">
                                        <i class="fas fa-file-alt text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 text-dark">Article lié 2</h6>
                                        <small class="text-muted">Description courte</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('support.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Créer un ticket
                        </a>
                        <a href="{{ route('support.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Mes tickets
                        </a>
                        <a href="{{ route('support.knowledge-base') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-book me-2"></i>
                            Base de connaissances
                        </a>
                    </div>
                </div>
            </div>

            <!-- Table of Contents -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-list me-2"></i>
                        Sommaire
                    </h6>
                </div>
                <div class="card-body">
                    <nav class="nav flex-column">
                        <a class="nav-link" href="#introduction">
                            <i class="fas fa-play me-2"></i>
                            Introduction
                        </a>
                        <a class="nav-link" href="#step1">
                            <i class="fas fa-1 me-2"></i>
                            Étape 1
                        </a>
                        <a class="nav-link" href="#step2">
                            <i class="fas fa-2 me-2"></i>
                            Étape 2
                        </a>
                        <a class="nav-link" href="#step3">
                            <i class="fas fa-3 me-2"></i>
                            Étape 3
                        </a>
                        <a class="nav-link" href="#conclusion">
                            <i class="fas fa-check me-2"></i>
                            Conclusion
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Category Articles -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">
                        <i class="fas fa-folder me-2"></i>
                        Autres articles {{ ucfirst($category) }}
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Article 1</h6>
                                <small class="text-muted">3 min</small>
                            </div>
                            <small class="text-muted">Description courte de l'article</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Article 2</h6>
                                <small class="text-muted">5 min</small>
                            </div>
                            <small class="text-muted">Description courte de l'article</small>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Article 3</h6>
                                <small class="text-muted">2 min</small>
                            </div>
                            <small class="text-muted">Description courte de l'article</small>
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

.breadcrumb-item + .breadcrumb-item::before {
    content: ">";
}

.article-content {
    line-height: 1.8;
}

.article-content h2 {
    color: #0d6efd;
    margin-top: 2rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.article-content h3 {
    color: #495057;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content ul, .article-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}

.article-content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin-bottom: 1rem;
}

.nav-link {
    color: #6c757d;
    border: none;
    padding: 0.5rem 0;
}

.nav-link:hover {
    color: #0d6efd;
    background-color: transparent;
}

.nav-link.active {
    color: #0d6efd;
    font-weight: 600;
}

@media print {
    .card-header, .btn, .sidebar {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>

<script>
// Feedback functionality
function submitFeedback(type) {
    const buttons = document.querySelectorAll('.btn-outline-success, .btn-outline-danger');
    buttons.forEach(btn => btn.disabled = true);
    
    const feedbackBtn = event.target;
    if (type === 'helpful') {
        feedbackBtn.classList.remove('btn-outline-success');
        feedbackBtn.classList.add('btn-success');
        feedbackBtn.innerHTML = '<i class="fas fa-check me-2"></i>Merci !';
    } else {
        feedbackBtn.classList.remove('btn-outline-danger');
        feedbackBtn.classList.add('btn-danger');
        feedbackBtn.innerHTML = '<i class="fas fa-check me-2"></i>Merci !';
    }
    
    // Here you would typically send the feedback to your backend
    console.log('Feedback submitted:', type);
}

// Copy to clipboard functionality
function copyToClipboard() {
    const articleContent = document.querySelector('.article-content').innerText;
    navigator.clipboard.writeText(articleContent).then(() => {
        const btn = event.target;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Copié !';
        btn.classList.remove('btn-outline-success');
        btn.classList.add('btn-success');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-success');
        }, 2000);
    });
}

// Smooth scrolling for table of contents
document.querySelectorAll('.nav-link[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Highlight active section in table of contents
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('h2, h3');
    const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
    
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        if (pageYOffset >= sectionTop - 100) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
        }
    });
});
</script>
@endsection 