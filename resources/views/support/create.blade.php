@extends('layouts.main')

@section('title', 'Nouveau ticket de support')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="display-5 fw-bold text-primary">
                    <i class="fas fa-plus-circle me-3"></i>
                    Nouveau ticket de support
                </h1>
                <p class="lead text-muted">Décrivez votre problème et nous vous répondrons dans les plus brefs délais</p>
            </div>

            <!-- Form Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Informations du ticket
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('support.store') }}" method="POST" id="ticketForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Priorité <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                        <option value="">Sélectionner une priorité</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                            <i class="fas fa-arrow-down"></i> Faible - Question générale
                                        </option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>
                                            <i class="fas fa-info-circle"></i> Moyenne - Problème mineur
                                        </option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                            <i class="fas fa-clock"></i> Élevée - Problème important
                                        </option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                            <i class="fas fa-exclamation-triangle"></i> Urgente - Service interrompu
                                        </option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="subscription_id" class="form-label">
                                        <i class="fas fa-tv me-1"></i>
                                        Abonnement concerné
                                    </label>
                                    <select class="form-select" id="subscription_id" name="subscription_id">
                                        <option value="">Aucun abonnement spécifique</option>
                                        @foreach($subscriptions as $subscription)
                                            <option value="{{ $subscription->id }}" {{ old('subscription_id') == $subscription->id ? 'selected' : '' }}>
                                                {{ $subscription->product->title ?? 'Abonnement #' . $subscription->id }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Sélectionnez votre abonnement si le problème y est lié</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">
                                <i class="fas fa-heading me-1"></i>
                                Sujet <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" 
                                   placeholder="Ex: Problème de connexion, Question sur l'abonnement..." 
                                   value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment me-1"></i>
                                Description détaillée <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="8" 
                                      placeholder="Décrivez votre problème en détail. Plus vous donnez d'informations, plus nous pourrons vous aider rapidement..." 
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-lightbulb me-1"></i>
                                <strong>Conseils :</strong> Incluez des détails comme votre appareil, l'erreur exacte, les étapes pour reproduire le problème...
                            </div>
                        </div>

                        <!-- Priority Guidelines -->
                        <div class="alert alert-info">
                            <h6 class="alert-heading">
                                <i class="fas fa-info-circle me-1"></i>
                                Guide des priorités
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small>
                                        <strong class="text-success">Faible :</strong> Questions générales, demandes d'information<br>
                                        <strong class="text-info">Moyenne :</strong> Problèmes mineurs, améliorations suggérées
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small>
                                        <strong class="text-warning">Élevée :</strong> Problèmes importants affectant l'utilisation<br>
                                        <strong class="text-danger">Urgente :</strong> Service complètement interrompu
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('support.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour aux tickets
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Créer le ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-question-circle me-2"></i>
                        Besoin d'aide ?
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">
                                <i class="fas fa-book me-1"></i>
                                Base de connaissances
                            </h6>
                            <p class="small text-muted">Consultez nos guides et tutoriels avant de créer un ticket.</p>
                            <a href="{{ route('support.knowledge-base') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-search me-1"></i>
                                Parcourir les articles
                            </a>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success">
                                <i class="fas fa-clock me-1"></i>
                                Temps de réponse
                            </h6>
                            <p class="small text-muted">
                                <strong>Urgente :</strong> 2-4 heures<br>
                                <strong>Élevée :</strong> 24 heures<br>
                                <strong>Moyenne/Faible :</strong> 48-72 heures
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.alert {
    border-left: 4px solid #0d6efd;
}
</style>

<script>
// Auto-resize textarea
document.getElementById('message').addEventListener('input', function() {
    this.style.height = 'auto';
    this.style.height = (this.scrollHeight) + 'px';
});

// Form validation
document.getElementById('ticketForm').addEventListener('submit', function(e) {
    const subject = document.getElementById('subject').value.trim();
    const message = document.getElementById('message').value.trim();
    const priority = document.getElementById('priority').value;
    
    if (!subject || !message || !priority) {
        e.preventDefault();
        alert('Veuillez remplir tous les champs obligatoires.');
        return false;
    }
    
    if (message.length < 20) {
        e.preventDefault();
        alert('Veuillez fournir une description plus détaillée (au moins 20 caractères).');
        return false;
    }
});
</script>
@endsection 