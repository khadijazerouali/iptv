@extends('layouts.dashboard')

@section('title', 'Support - Nouveau Ticket')

@section('content')
<div class="dashboard-content">
<div class="support-container">
    <!-- Header -->
    <div class="support-header">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="support-title">
                    <i class="fas fa-plus me-3"></i>
                    Nouveau Ticket de Support
            </h1>
                <p class="support-subtitle">Décrivez votre problème pour que nous puissions vous aider</p>
            </div>
            <a href="{{ route('support.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>
                Retour aux tickets
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="support-card">
                    <div class="support-card-header">
            <h5><i class="fas fa-edit me-2"></i> Informations du Ticket</h5>
                    </div>
                    <div class="support-card-body">
            <form action="{{ route('support.store') }}" method="POST" class="support-form">
                            @csrf
                            
                            <div class="row">
                    <div class="col-md-8">
                        <!-- Subject -->
                        <div class="form-group mb-4">
                            <label for="subject" class="form-label">
                                <i class="fas fa-tag me-2"></i>Sujet du ticket
                            </label>
                            <input type="text" 
                                   class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}"
                                   placeholder="Ex: Problème de connexion à l'application"
                                   required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="form-group mb-4">
                            <label for="message" class="form-label">
                                <i class="fas fa-comment me-2"></i>Description détaillée
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" 
                                      name="message" 
                                      rows="8"
                                      placeholder="Décrivez votre problème en détail. Plus vous donnez d'informations, plus nous pourrons vous aider rapidement."
                                      required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Minimum 10 caractères. Soyez le plus précis possible.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Category -->
                        <div class="form-group mb-4">
                            <label for="category" class="form-label">
                                <i class="fas fa-folder me-2"></i>Catégorie
                                        </label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" 
                                    name="category" 
                                    required>
                                <option value="">Sélectionner une catégorie</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                            @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                        <!-- Priority -->
                        <div class="form-group mb-4">
                                        <label for="priority" class="form-label">
                                <i class="fas fa-exclamation-triangle me-2"></i>Priorité
                                        </label>
                            <select class="form-select @error('priority') is-invalid @enderror" 
                                    id="priority" 
                                    name="priority" 
                                    required>
                                            <option value="">Sélectionner une priorité</option>
                                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                    <i class="fas fa-arrow-down"></i> Faible
                                            </option>
                                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>
                                    <i class="fas fa-minus"></i> Moyenne
                                            </option>
                                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                    <i class="fas fa-arrow-up"></i> Élevée
                                            </option>
                                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                    <i class="fas fa-exclamation"></i> Urgente
                                            </option>
                                        </select>
                                        @error('priority')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                        <!-- Priority Guide -->
                        <div class="priority-guide">
                            <h6><i class="fas fa-info-circle me-2"></i>Guide des priorités</h6>
                            <div class="priority-item">
                                <span class="badge bg-secondary">Faible</span>
                                <small>Question générale, suggestion</small>
                            </div>
                            <div class="priority-item">
                                <span class="badge bg-info">Moyenne</span>
                                <small>Problème non bloquant</small>
                            </div>
                            <div class="priority-item">
                                <span class="badge bg-warning">Élevée</span>
                                <small>Problème important</small>
                                </div>
                            <div class="priority-item">
                                <span class="badge bg-danger">Urgente</span>
                                <small>Service complètement bloqué</small>
                            </div>
                        </div>
                    </div>
                            </div>

                <!-- Submit Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>
                        Envoyer le ticket
                                </button>
                    <a href="{{ route('support.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
                        <i class="fas fa-times me-2"></i>
                        Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<style>
.support-container {
    padding: 2rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
}

.support-header {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.support-title {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.support-subtitle {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin: 0.5rem 0 0 0;
}

.support-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.support-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.5rem 2rem;
    border-bottom: none;
}

.support-card-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.2rem;
}

.support-card-body {
    padding: 2rem;
}

.support-form .form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.support-form .form-control,
.support-form .form-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.support-form .form-control:focus,
.support-form .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.priority-guide {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    border: 1px solid #e9ecef;
}

.priority-guide h6 {
    color: #495057;
    margin-bottom: 1rem;
    font-weight: 600;
}

.priority-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    padding: 0.5rem;
    border-radius: 5px;
    transition: background-color 0.2s ease;
}

.priority-item:hover {
    background: white;
}

.priority-item .badge {
    margin-right: 0.75rem;
    min-width: 60px;
}

.priority-item small {
    color: #6c757d;
    font-size: 0.85rem;
}

.form-actions {
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
    margin-top: 2rem;
}

.btn-lg {
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .support-container {
        padding: 1rem;
    }
    
    .support-title {
        font-size: 2rem;
    }
    
    .support-card-body {
        padding: 1rem;
    }
    
    .form-actions {
        text-align: center;
    }
    
    .form-actions .btn {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection 