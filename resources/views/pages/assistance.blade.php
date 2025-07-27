@extends('layouts.main')

@section('title', 'Assistance')

@section('styles')
<link rel="stylesheet" href="{{ asset('/assets/css/support-style.css') }}" />
@endsection

@section('content')
<div class="support-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <div class="mb-5">
                    <i class="fas fa-headset fa-4x text-primary mb-3"></i>
                    <h1 class="display-4 fw-bold text-primary">Assistance</h1>
                    <p class="lead text-muted">Trouvez des solutions à vos problèmes ici.</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="support-card h-100">
                            <div class="support-card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-book fa-3x text-primary"></i>
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
                    
                    <div class="col-md-6">
                        <div class="support-card h-100">
                            <div class="support-card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-ticket-alt fa-3x text-success"></i>
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
                        <div class="support-card">
                            <div class="support-card-body text-center">
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
                        <div class="support-card">
                            <div class="support-card-body">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle fa-2x text-info me-3 mt-1"></i>
                                    <div>
                                        <h6 class="fw-bold mb-2">Besoin d'aide urgente ?</h6>
                                        <p class="mb-0 text-muted">
                                            Si vous rencontrez un problème urgent, n'hésitez pas à créer un ticket avec la priorité "Urgente". 
                                            Notre équipe s'efforcera de vous répondre dans les plus brefs délais.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection