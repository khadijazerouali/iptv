@extends('layouts.main')

@section('title', 'Test du Panier')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Test du Panier</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Cette page permet de tester le fonctionnement du panier.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Test 1: Ajouter un produit via AJAX</h5>
                                    <p class="card-text">Cliquez sur le bouton pour ajouter un produit de test au panier.</p>
                                    <button type="button" class="btn btn-primary" onclick="testAddToCart()">
                                        <i class="fa-solid fa-cart-plus me-2"></i>
                                        Ajouter au panier (AJAX)
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Test 2: Vider le panier</h5>
                                    <p class="card-text">Cliquez sur le bouton pour vider le panier.</p>
                                    <button type="button" class="btn btn-danger" onclick="testClearCart()">
                                        <i class="fa-solid fa-trash me-2"></i>
                                        Vider le panier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Test 3: Voir le contenu du panier</h5>
                                    <p class="card-text">Cliquez sur le bouton pour voir le contenu actuel du panier.</p>
                                    <button type="button" class="btn btn-info" onclick="testGetCart()">
                                        <i class="fa-solid fa-eye me-2"></i>
                                        Voir le panier
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Test 4: Ouvrir la modal du panier</h5>
                                    <p class="card-text">Cliquez sur le bouton pour ouvrir la modal du panier.</p>
                                    <button type="button" class="btn btn-success" onclick="testOpenCartModal()">
                                        <i class="fa-solid fa-shopping-cart me-2"></i>
                                        Ouvrir la modal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <h6>Instructions :</h6>
                        <ol>
                            <li>Cliquez sur "Ajouter au panier" pour ajouter un produit de test</li>
                            <li>Regardez l'icône du panier dans le header - elle devrait afficher un badge avec le nombre</li>
                            <li>Cliquez sur l'icône du panier pour ouvrir la modal</li>
                            <li>Testez les différentes fonctionnalités</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function testAddToCart() {
    const productData = {
        product_uuid: 'test-uuid-123',
        quantity: 1,
        selectedOptionUuid: 'option-uuid-456',
        price: 29.99
    };
    
    if (window.cartManager) {
        window.cartManager.addToCart(productData)
            .then(data => {
                console.log('Produit ajouté:', data);
                alert('Produit ajouté au panier avec succès !');
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'ajout au panier: ' + error.message);
            });
    } else {
        alert('Le gestionnaire de panier n\'est pas initialisé');
    }
}

function testClearCart() {
    if (window.cartManager) {
        window.cartManager.clearCart()
            .then(data => {
                console.log('Panier vidé:', data);
                alert('Panier vidé avec succès !');
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du vidage du panier: ' + error.message);
            });
    } else {
        alert('Le gestionnaire de panier n\'est pas initialisé');
    }
}

function testGetCart() {
    fetch('/get-cart')
        .then(response => response.json())
        .then(data => {
            console.log('Contenu du panier:', data);
            if (data.cart) {
                alert('Panier contient: ' + JSON.stringify(data.cart, null, 2));
            } else {
                alert('Le panier est vide');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors de la récupération du panier');
        });
}

function testOpenCartModal() {
    // Simuler un clic sur l'icône du panier
    const cartIcon = document.querySelector('.cart-icon-link');
    if (cartIcon) {
        cartIcon.click();
    } else {
        alert('Icône du panier non trouvée');
    }
}
</script>
@endsection 