<div>
    <!-- Message de validation -->
    @if($validation_message)
        <div class="alert alert-{{ $validation_type === 'success' ? 'success' : ($validation_type === 'error' ? 'danger' : 'warning') }} mb-3">
            @if($validation_type === 'success')
                ✅ 
            @elseif($validation_type === 'error')
                ❌ 
            @else
                ⚠️ 
            @endif
            {{ $validation_message }}
        </div>
    @endif

    <!-- Code promo appliqué -->
    @if($applied_coupon)
        <div class="card border-success mb-3">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="fas fa-check-circle me-2"></i>
                    Code promo appliqué
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="text-success">{{ $applied_coupon['name'] }}</h6>
                        <p class="mb-1"><strong>Code :</strong> <span class="badge bg-primary">{{ $applied_coupon['code'] }}</span></p>
                        @if($applied_coupon['description'])
                            <p class="mb-1"><small class="text-muted">{{ $applied_coupon['description'] }}</small></p>
                        @endif
                        <p class="mb-0">
                            <strong>Réduction :</strong> 
                            @if($applied_coupon['discount_type'] === 'percentage')
                                {{ $applied_coupon['discount_value'] }}% 
                            @else
                                {{ number_format($applied_coupon['discount_value'], 2) }}€
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="mb-2">
                            <span class="h5 text-success">-{{ number_format($discount_amount, 2) }}€</span>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm" wire:click="removeCoupon">
                            <i class="fas fa-times me-1"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Formulaire d'application du code promo -->
        <form wire:submit.prevent="applyCoupon">
            <p class="text-muted mb-3">
                <i class="fas fa-info-circle me-1"></i>
                Si vous possédez un code promo, veuillez l'appliquer ci-dessous.
            </p>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="coupon_code" class="form-label">
                            <i class="fas fa-tag me-1"></i>
                            Code promo *
                        </label>
                        <input type="text" 
                               class="form-control @error('coupon_code') is-invalid @enderror" 
                               id="coupon_code" 
                               name="coupon_code" 
                               wire:model="coupon_code" 
                               placeholder="Ex: PROMO2024"
                               maxlength="50"
                               required>
                        @error('coupon_code') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                        <div class="form-text">
                            <i class="fas fa-lightbulb me-1"></i>
                            Saisissez votre code promo en majuscules
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
                            <span wire:loading.remove>
                                <i class="fas fa-check me-1"></i>
                                Appliquer
                            </span>
                            <span wire:loading>
                                <i class="fas fa-spinner fa-spin me-1"></i>
                                Vérification...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Informations sur les codes promo -->
        <div class="alert alert-info mt-3">
            <h6 class="alert-heading">
                <i class="fas fa-question-circle me-2"></i>
                Comment fonctionnent les codes promo ?
            </h6>
            <ul class="mb-0">
                <li>Les codes promo peuvent être des réductions en pourcentage ou en montant fixe</li>
                <li>Certains codes ont un montant minimum d'achat requis</li>
                <li>Les codes ont une date de validité et une limite d'utilisation</li>
                <li>Un seul code promo peut être appliqué par commande</li>
            </ul>
        </div>
    @endif
</div>