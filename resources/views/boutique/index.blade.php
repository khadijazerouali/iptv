@extends('layouts.main')

@section('title', 'Boutique')

@push('styles')
<style>
    aside.bg-light {
        background: #194058 !important;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }
    .nav.flex-column .nav-link {
        color: #222;
        font-weight: 500;
        border-radius: 6px;
        margin-bottom: 4px;
        transition: background 0.2s, color 0.2s;
    }
    .nav.flex-column .nav-link.active,
    .nav.flex-column .nav-link:hover {
        background: #0099ff;
        color: #fff !important;
    }
    .nav.flex-column .nav-link {
        padding-left: 18px;
    }
    .nav.flex-column .nav-link.active {
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(0,153,255,0.08);
    }
    .input-group .form-control {
        border-radius: 6px 0 0 6px;
        border: 1px solid #e5e7eb;
    }
    .input-group .btn {
        border-radius: 0 6px 6px 0;
        background: #fff;
        color: #ffffff;
        border: 1px solid #fbfdff;
    }
    .input-group .btn:hover {
        background: #f0f8ff;
        color: #007acc;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <aside class="col-md-3 p-3" style="min-height: 100vh; background-color:#007acc;">
            <h4>Boutique</h4>
            <form method="GET" action="{{ route('boutique.index') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Rechercher un produit..." value="{{ request('search') }}">
                    <button class="btn" type="submit">Rechercher</button>
                </div>
            </form>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link{{ !request('category') ? ' active' : '' }}" href="{{ route('boutique.index', array_filter(['search' => request('search')])) }}">Tous les produits</a>
                </li>
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link{{ request('category') == $category->uuid ? ' active' : '' }}" href="{{ route('boutique.index', array_filter(['category' => $category->uuid, 'search' => request('search')])) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <!-- Produits -->
        <main class="col-md-9 p-4">
            <h2>Nos produits</h2>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            {{-- Image du produit si tu as un champ image --}}
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                {{-- <p class="card-text">{{ $product->description }}</p> --}}
                                <p class="card-text"><strong>{{ $product->price }} €</strong></p>
                                <a href="{{ route('product', $product->slug) }}" class="btn btn-primary">Voir</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Aucun produit disponible.</p>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection