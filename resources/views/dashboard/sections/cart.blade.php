<div class="section-header">
    <h1 class="section-title">Mon Panier</h1>
    <p class="section-subtitle">Articles en attente d'achat</p>
</div>

@if($cartItems->count() > 0)
    <div class="grid">
        @foreach($cartItems as $id => $cartItem)
            <div class="card">
                <h3 class="card-title">{{ $cartItem['title'] }}</h3>
                <div class="card-meta">
                    Prix: <span class="price">{{ number_format($cartItem['price'], 2) }}€</span> • 
                    Durée: {{ $cartItem['duration_hours'] ?? '?' }}h • 
                    Niveau: {{ ucfirst($cartItem['level'] ?? 'N/A') }}
                </div>
                <p class="card-description">{{ $cartItem['description'] ?? 'Aucune description.' }}</p>
                <div style="margin-top: 1rem;">
                    <a href="#" class="btn">Acheter maintenant</a>
                    <form method="POST" action="{{ route('cart.remove', $id) }}" style="display: inline-block; margin-left: 0.5rem;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Cart Total -->
        <div class="card" style="border-color: rgb(0, 107, 179); background-color: #f8fafc;">
            <h3 class="card-title" style="color: rgb(0, 107, 179);">Total du panier</h3>
            <div class="card-meta">
                {{ $cartItems->count() }} article{{ $cartItems->count() > 1 ? 's' : '' }} • 
                Total: <span class="price" style="font-size: 1.5rem;">{{ number_format($cartTotal, 2) }}€</span>
            </div>
            <div style="margin-top: 1rem;">
                <a href="#" class="btn" style="font-size: 1rem; padding: 0.75rem 1.5rem;">
                    Procéder au paiement
                </a>
            </div>
        </div>
    </div>
@else
    <div class="empty-state">
        <div class="empty-state-icon">🛒</div>
        <h3>Votre panier est vide</h3>
        <p>Ajoutez des formations à votre panier pour les acheter.</p>
    </div>
@endif 