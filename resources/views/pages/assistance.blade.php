@extends('layouts.main')

@section('title', 'Assistance')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="mb-4">
                <i class="fas fa-headset fa-4x text-primary mb-3"></i>
                <h1 class="display-4 fw-bold text-primary">Assistance</h1>
                <p class="lead text-muted">Trouvez des solutions à vos problèmes ici.</p>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="display-6 text-primary mb-3">
                                <i class="fas fa-book"></i>
                            </div>
                            <h5 class="card-title">Base de connaissances</h5>
                            <p class="card-text text-muted">Consultez nos guides et tutoriels pour résoudre vos problèmes rapidement.</p>
                            <a href="{{ route('support.knowledge-base') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>
                                Parcourir les articles
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="display-6 text-success mb-3">
                                <i class="fas fa-ticket-alt"></i>
                            </div>
                            <h5 class="card-title">Créer un ticket</h5>
                            <p class="card-text text-muted">Contactez notre équipe de support pour une assistance personnalisée.</p>
                            @auth
                                <a href="{{ route('support.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>
                                    Nouveau ticket
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success">
                                    <i class="fas fa-sign-in-alt me-2"></i>
                                    Se connecter
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            @auth
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <i class="fas fa-list me-2"></i>
                                Mes tickets de support
                            </h5>
                            <p class="card-text text-muted">Consultez l'historique de vos demandes d'assistance.</p>
                            <a href="{{ route('support.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-eye me-2"></i>
                                Voir mes tickets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="row mt-5">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">
                            <i class="fas fa-info-circle me-2"></i>
                            Besoin d'aide urgente ?
                        </h6>
                        <p class="mb-0">
                            Si vous rencontrez un problème urgent, n'hésitez pas à créer un ticket avec la priorité "Urgente". 
                            Notre équipe s'efforcera de vous répondre dans les plus brefs délais.
                        </p>
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

.display-6 {
    font-size: 2.5rem;
}
</style>
@endsection