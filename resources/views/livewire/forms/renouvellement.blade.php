<div>
    <form wire:submit.prevent="submit">
        @csrf

        <!-- Option Selector -->
        <div class="my-3">
            Durée Abonnement :
            @if($selectedPrice)
                <p class="fw-semibold text-primary fs-4">{{ $selectedPrice }} €</p>
            @else
                @if($product->old_price)
                    <p class="fw-semibold text-primary fs-4"><del>{{ $product->old_price }} €</del></p>
                @endif
                <p class="fw-semibold text-primary fs-4">{{ $product->price }} €</p>
            @endif

            @if($product->productOptions->isNotEmpty())
                <select class="form-select" wire:model="selectedOptionUuid" name="selectedOptionUuid"  wire:model.live="selectedOptionUuid" required>
                    <option value="">Choisir une option</option>
                    @foreach ($product->productOptions as $option)
                        <option value="{{ $option->uuid }}">
                            {{ $option->name }} - {{ $option->price }} €
                        </option>
                    @endforeach
                </select>
            @endif
        </div>
        <br>
        <!-- Command Number Field -->
        <div class="mb-3">
            <label class="form-label">N° de la commande à renouveler :</label>
            <input type="text" class="form-control" wire:model="number_order" required>
            @error('number_order')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <p class="text-muted">Veuillez entrer le numéro de la commande à renouveler.</p>
        </div>

        <!-- Hidden Product UUID -->
        <input type="hidden" wire:model="product_uuid" value="{{ $product_uuid }}">

        

        <!-- Quantity Selector -->
        <div class="d-flex align-items-center mb-3">
            <div class="counter">
                <button type="button" class="counter-btn" wire:click="increment">&#x25B2;</button>
                <input type="number" class="counter-input" wire:model="quantity" min="1" max="99">
                <button type="button" class="counter-btn" wire:click="decrement">&#x25BC;</button>
            </div>

            <button type="button" wire:click="submit" class="btn btn-primary btn-lg d-flex align-items-center ms-4 rounded-pill">
                COMMANDER MAINTENANT
                <span class="ms-2"><i class="bi bi-plus-circle"></i></span>
            </button>
        </div>
    </form>
</div>