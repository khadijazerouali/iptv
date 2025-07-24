@extends('layouts.main')

@section('content')

<style>
    .form-check-input[type="checkbox"] {
        border-color: #006bb3 !important;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            @if($product)
                <img src="{{'/storage/' . $product->image }}" alt="{{ $product->title }}" class="zoom-image w-100">
            @endif
        </div>

        @livewire('forms.abonnement', ['product' => $product])
    </div>

    <!-- Product Info -->
    <div class="product-info mt-5">
        <p><strong>Catégorie :</strong> {{ $product->category->name }}</p>
        <p><strong>Tags :</strong> <!-- TODO: Display tags if available --></p>
    </div>

    <!-- Description -->
    <button class="tab-button active mt-4">Description</button>
    <div class="description-section">
        {!! $product->description !!}
    </div>

    <!-- Related Products -->
    <div class="row my-5">
        <div class="col-md-12 text-center">
            <h2 class="extra-bold">Produits associés<span class="text-primary">.</span></h2>
        </div>
        <livewire:widget.nos-product />
    </div>
</div>

@endsection
