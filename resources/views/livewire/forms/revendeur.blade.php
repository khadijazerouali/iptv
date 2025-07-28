<form wire:submit.prevent="submitForm">
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
            <select class="form-select" wire:model="selectedOptionUuid" name="selectedOptionUuid" wire:model.live="selectedOptionUuid" required>
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
    <!-- Name Fields -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nom :</label>
            <input type="text" class="form-control" name="first_name" wire:model="first_name" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Prénom :</label>
            <input type="text" class="form-control" name="last_name" wire:model="last_name" required>
        </div>
    </div>

    <!-- Email Field -->
    <div class="mb-3">
        <label class="form-label">Email :</label>
        <input type="email" class="form-control" name="email" wire:model="email" required>
    </div>

    <!-- Hidden Product UUID -->
    <input type="hidden" name="product_uuid" value="{{ $product->uuid }}">

    <!-- Quantity Selector -->
    <div class="d-flex align-items-center mb-3">
        <div class="counter">
            <button type="button" class="counter-btn" wire:click="increment">&#x25B2;</button>
            <input type="number" class="counter-input" name="quantity" id="quantity" wire:model="quantity" value="1" min="1" max="99" readonly>
            <button type="button" class="counter-btn" wire:click="decrement">&#x25BC;</button>
        </div>

        <button type="button" wire:click="submitForm" class="btn btn-primary btn-lg d-flex align-items-center ms-4 rounded-pill">
            COMMANDER MAINTENANT
            <span class="ms-2"><i class="bi bi-plus-circle"></i></span>
        </button>
    </div>
</form>