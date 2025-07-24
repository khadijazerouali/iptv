<div class="container-fluid">
    <style>
        .img-fluid{
            width: 300px !important;
            height: 300px !important;
            object-fit: cover;
        }
    </style>
        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($products->chunk(4) as $chunk) <!-- Regroupe les produits par 4 -->
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <div class="row justify-content-center flex-nowrap">
                            @foreach($chunk as $product)
                                <div class="col-md-3">
                                    <div class="card product-card">
                                        <a href="{{ route('product', $product->slug) }}" target="_self">
                                            <img src="{{'/storage/' . $product->image }}" class="img-fluid">
                                            <div class="product-title">{{ $product->title }}</div>
                                            <div class="product-price text-primary">{{ $product->price }}€</div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
    
            <!-- Boutons de contrôle du carrousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>