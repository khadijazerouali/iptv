@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit me-2"></i>
                        Modifier le code promo : {{ $promoCode->name }}
                    </h3>
                </div>
                
                <form action="{{ route('admin.promo-codes.update', $promoCode) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <!-- Informations de base -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informations de base
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom du code promo *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $promoCode->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="code" class="form-label">Code promo</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                               id="code" name="code" value="{{ old('code', $promoCode->code) }}" 
                                               placeholder="Laissez vide pour générer automatiquement">
                                        <button type="button" class="btn btn-outline-secondary" onclick="generateCode()">
                                            <i class="fas fa-magic"></i> Générer
                                        </button>
                                    </div>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Laissez vide pour générer un code automatiquement</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="3">{{ old('description', $promoCode->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Configuration de la réduction -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-percentage me-2"></i>
                                    Configuration de la réduction
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="discount_type" class="form-label">Type de réduction *</label>
                                    <select class="form-select @error('discount_type') is-invalid @enderror" 
                                            id="discount_type" name="discount_type" required>
                                        <option value="">Sélectionner un type</option>
                                        <option value="percentage" {{ old('discount_type', $promoCode->discount_type) == 'percentage' ? 'selected' : '' }}>
                                            Pourcentage (%)
                                        </option>
                                        <option value="fixed" {{ old('discount_type', $promoCode->discount_type) == 'fixed' ? 'selected' : '' }}>
                                            Montant fixe (€)
                                        </option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="discount_value" class="form-label">Valeur de la réduction *</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('discount_value') is-invalid @enderror" 
                                               id="discount_value" name="discount_value" value="{{ old('discount_value', $promoCode->discount_value) }}" 
                                               step="0.01" min="0" required>
                                        <span class="input-group-text" id="discount_unit">
                                            {{ $promoCode->discount_type === 'percentage' ? '%' : '€' }}
                                        </span>
                                    </div>
                                    @error('discount_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="min_amount" class="form-label">Montant minimum (optionnel)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('min_amount') is-invalid @enderror" 
                                               id="min_amount" name="min_amount" value="{{ old('min_amount', $promoCode->min_amount) }}" 
                                               step="0.01" min="0">
                                        <span class="input-group-text">€</span>
                                    </div>
                                    @error('min_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Montant minimum d'achat pour utiliser le code</small>
                                </div>
                                
                                <div class="mb-3" id="maxDiscountGroup" style="display: {{ $promoCode->discount_type === 'percentage' ? 'block' : 'none' }};">
                                    <label for="max_discount" class="form-label">Réduction maximale (optionnel)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('max_discount') is-invalid @enderror" 
                                               id="max_discount" name="max_discount" value="{{ old('max_discount', $promoCode->max_discount) }}" 
                                               step="0.01" min="0">
                                        <span class="input-group-text">€</span>
                                    </div>
                                    @error('max_discount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Limite la réduction maximale pour les pourcentages</small>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <!-- Limites et validité -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-clock me-2"></i>
                                    Limites et validité
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="usage_limit" class="form-label">Limite d'utilisation *</label>
                                    <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" 
                                           id="usage_limit" name="usage_limit" value="{{ old('usage_limit', $promoCode->usage_limit) }}" 
                                           min="1" required>
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Nombre maximum d'utilisations du code</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="valid_from" class="form-label">Date de début (optionnel)</label>
                                    <input type="datetime-local" class="form-control @error('valid_from') is-invalid @enderror" 
                                           id="valid_from" name="valid_from" 
                                           value="{{ old('valid_from', $promoCode->valid_from ? $promoCode->valid_from->format('Y-m-d\TH:i') : '') }}">
                                    @error('valid_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="valid_until" class="form-label">Date de fin (optionnel)</label>
                                    <input type="datetime-local" class="form-control @error('valid_until') is-invalid @enderror" 
                                           id="valid_until" name="valid_until" 
                                           value="{{ old('valid_until', $promoCode->valid_until ? $promoCode->valid_until->format('Y-m-d\TH:i') : '') }}">
                                    @error('valid_until')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Application et statut -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-tags me-2"></i>
                                    Application et statut
                                </h5>
                                
                                <div class="mb-3">
                                    <label for="applies_to" class="form-label">S'applique à *</label>
                                    <select class="form-select @error('applies_to') is-invalid @enderror" 
                                            id="applies_to" name="applies_to" required>
                                        <option value="">Sélectionner</option>
                                        <option value="all" {{ old('applies_to', $promoCode->applies_to) == 'all' ? 'selected' : '' }}>
                                            Tous les produits
                                        </option>
                                        <option value="specific_products" {{ old('applies_to', $promoCode->applies_to) == 'specific_products' ? 'selected' : '' }}>
                                            Produits spécifiques
                                        </option>
                                        <option value="specific_categories" {{ old('applies_to', $promoCode->applies_to) == 'specific_categories' ? 'selected' : '' }}>
                                            Catégories spécifiques
                                        </option>
                                    </select>
                                    @error('applies_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3" id="specificItemsGroup" style="display: {{ in_array($promoCode->applies_to, ['specific_products', 'specific_categories']) ? 'block' : 'none' }};">
                                    <label class="form-label">Sélectionner les éléments</label>
                                    <div id="specificItemsList" style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                        <!-- Liste chargée dynamiquement -->
                                    </div>
                                    @error('applies_to_ids')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', $promoCode->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Code promo actif
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Statistiques du code promo -->
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-chart-bar me-2"></i>Statistiques</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small>Utilisations : {{ $promoCode->used_count }}/{{ $promoCode->usage_limit }}</small>
                                        </div>
                                        <div class="col-6">
                                            <small>Emails envoyés : {{ $promoCode->email_sent_count }}</small>
                                        </div>
                                    </div>
                                    @if($promoCode->last_sent_at)
                                        <small class="text-muted">Dernier envoi : {{ $promoCode->last_sent_at->format('d/m/Y H:i') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                Retour
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Mettre à jour
                                </button>
                                <a href="{{ route('admin.promo-codes.duplicate', $promoCode) }}" class="btn btn-info">
                                    <i class="fas fa-copy me-2"></i>
                                    Dupliquer
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Génération automatique de code
function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('code').value = code;
}

// Gestion du type de réduction
document.getElementById('discount_type').addEventListener('change', function() {
    const unit = document.getElementById('discount_unit');
    const maxDiscountGroup = document.getElementById('maxDiscountGroup');
    
    if (this.value === 'percentage') {
        unit.textContent = '%';
        maxDiscountGroup.style.display = 'block';
    } else if (this.value === 'fixed') {
        unit.textContent = '€';
        maxDiscountGroup.style.display = 'none';
    }
});

// Gestion de l'application
document.getElementById('applies_to').addEventListener('change', function() {
    const specificItemsGroup = document.getElementById('specificItemsGroup');
    const specificItemsList = document.getElementById('specificItemsList');
    
    if (this.value === 'specific_products') {
        specificItemsGroup.style.display = 'block';
        loadProducts();
    } else if (this.value === 'specific_categories') {
        specificItemsGroup.style.display = 'block';
        loadCategories();
    } else {
        specificItemsGroup.style.display = 'none';
    }
});

function loadProducts() {
    const list = document.getElementById('specificItemsList');
    const currentIds = @json($promoCode->applies_to_ids ?? []);
    
    list.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Chargement...</div>';
    
    // Simuler le chargement des produits
    setTimeout(() => {
        list.innerHTML = `
            @foreach($products as $product)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="applies_to_ids[]" value="{{ $product->id }}" 
                       id="product_{{ $product->id }}" 
                       {{ in_array($product->id, $promoCode->applies_to_ids ?? []) ? 'checked' : '' }}>
                <label class="form-check-label" for="product_{{ $product->id }}">
                    {{ $product->name }}
                </label>
            </div>
            @endforeach
        `;
    }, 500);
}

function loadCategories() {
    const list = document.getElementById('specificItemsList');
    const currentIds = @json($promoCode->applies_to_ids ?? []);
    
    list.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Chargement...</div>';
    
    // Simuler le chargement des catégories
    setTimeout(() => {
        list.innerHTML = `
            @foreach($categories as $category)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="applies_to_ids[]" value="{{ $category->id }}" 
                       id="category_{{ $category->id }}" 
                       {{ in_array($category->id, $promoCode->applies_to_ids ?? []) ? 'checked' : '' }}>
                <label class="form-check-label" for="category_{{ $category->id }}">
                    {{ $category->name }}
                </label>
            </div>
            @endforeach
        `;
    }, 500);
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Déclencher les événements pour initialiser l'affichage
    document.getElementById('discount_type').dispatchEvent(new Event('change'));
    document.getElementById('applies_to').dispatchEvent(new Event('change'));
});
</script>
@endpush 