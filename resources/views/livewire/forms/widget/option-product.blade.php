<div class="my-3">
Durée Abonnement :
    @if($selectedPrice)
        <p class="fw-semibold text-primary fs-4">  {{ $selectedPrice }} €</p>
        <input type="hidden" wire:model="selectedPrice" value="{{ $selectedPrice }}">
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