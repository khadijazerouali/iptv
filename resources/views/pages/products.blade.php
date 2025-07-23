@extends('layouts.main')

@section('content')

    <style>
        .form-check-input[type="checkbox"] {
            border-color: #006bb3 !important;
        }

        .tab-button.active {
            font-weight: bold;
            border-bottom: 2px solid #007bff;
        }

        .tab-section {
            display: none;
        }

        .tab-section.active {
            display: block;
        }

    </style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            @if($product)
                <img src="{{'/storage/' . $product->image }}" alt="{{ $product->title }}" class="zoom-image w-100">
            @endif
        </div>
        <div class="col-md-9">
            <h3 class="fw-bold fs-2">{{ $product->title }}</h3>
            <br>
            <!-- Star Rating -->
            <div class="star-rating mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $product->rating ? 'text-warning' : 'text-muted' }}"></i>
                @endfor
            </div>
            @if($product->type == "abonnement")
                @livewire('forms.abonnement', ['product' => $product])
            @elseif($product->type == "revendeur")
                @livewire('forms.revendeur', ['product' => $product])
            @elseif($product->type == "renouvellement")
                @livewire('forms.renouvellement', ['product' => $product])
            @elseif($product->type == "application")
                @livewire('forms.application', ['product' => $product])
            @elseif($product->type == "testiptv")
                @livewire('forms.abonnement', ['product' => $product])
            @endif
        </div>
    </div>

    <!-- Product Info -->
    <div class="product-info mt-5">
        <p><strong>Catégorie :</strong> {{ $product->category->name }}</p>
        <p><strong>Tags :</strong> <!-- TODO: Display tags if available --></p>
    </div>

    <button class="tab-button active" data-tab="description">Description</button>
    <button class="tab-button" data-tab="reviews">Reviews</button>

    <!-- Description Section -->
    <div class="tab-section active" id="description">
        <div class="description-section">
            {!! $product->description !!}
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="tab-section" id="reviews">
        <div class="reviews-section">
            <div class="list-review">
                @if($product->reviews->count() > 0)
                    @foreach($product->reviews as $review)
                        <div class="review">
                            <div class="review-header">
                                <div class="reviewer">
                                    <div class="reviewer-info">
                                        <h3 class="reviewer-name">{{ $review->name }}</h3>
                                        <p class="reviewer-date">{{ $review->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    <div class="star-rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <div class="review-content">
                                <p>{{ $review->review }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>Aucun commentaire disponible</p>
                @endif
            </div>
            <div class="write-review">
                <h3 class="extra-bold">Ecrire un commentaire</h3>
                <form action="{{ route('reviews.store', ['product' => $product->uuid]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name">Nom et prénom <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email">E-mail *</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="review">Commentaire</label>
                        <textarea id="review" name="review" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="rating">Note </label>
                        <input type="number" id="rating" name="rating" min="1" max="5" >
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Envoyer</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="row my-5">
        <div class="col-md-12 text-center">
            <h2 class="extra-bold">Produits associés<span class="text-primary">.</span></h2>
        </div>
        <livewire:widget.nos-product />
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabSections = document.querySelectorAll('.tab-section');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons and hide all sections
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabSections.forEach(section => section.classList.remove('active'));

            // Add active class to the clicked button and show the corresponding section
            this.classList.add('active');
            document.getElementById(this.getAttribute('data-tab')).classList.add('active');
        });
    });
});
</script>

@endsection
