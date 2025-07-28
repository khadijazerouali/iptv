# Système de Panier IPTV

## Vue d'ensemble

Ce système de panier permet d'afficher les produits sélectionnés dans une petite fenêtre modale après avoir cliqué sur l'icône du panier dans le header. Il fonctionne avec les sessions Laravel et utilise Livewire pour une expérience utilisateur fluide.

## Fonctionnalités

### ✅ Fonctionnalités implémentées

1. **Icône du panier avec badge** : Affiche le nombre d'articles dans le panier
2. **Modal du panier** : Petite fenêtre qui s'ouvre en cliquant sur l'icône
3. **Affichage des détails du produit** : Titre, description, image, prix, quantité
4. **Gestion des options** : Affichage des options sélectionnées (durée, etc.)
5. **Calcul automatique du total** : Prix × quantité
6. **Boutons d'action** : Vider le panier et procéder au paiement
7. **Animations fluides** : Transitions et effets visuels
8. **Responsive design** : Compatible mobile et desktop
9. **Notifications toast** : Messages de confirmation
10. **Intégration avec les formulaires existants** : Abonnement, Revendeur, Renouvellement

### 🎯 Fonctionnement

1. **Ajout au panier** : Quand l'utilisateur clique sur "Commander Maintenant"
2. **Stockage en session** : Les données sont sauvegardées dans `session('carts')`
3. **Mise à jour du badge** : Le nombre d'articles s'affiche sur l'icône
4. **Affichage de la modal** : Clic sur l'icône pour voir le contenu
5. **Redirection vers checkout** : Bouton "Procéder au paiement"

## Structure des fichiers

### Composants Livewire
- `app/Livewire/Inc/Header.php` - Gestion du header et de la modal du panier
- `resources/views/livewire/inc/header.blade.php` - Template du header avec modal

### Contrôleurs
- `app/Http/Controllers/Public/CartController.php` - API pour les actions du panier

### JavaScript
- `public/assets/js/cart.js` - Gestionnaire JavaScript pour les interactions

### Routes
- `/cart-count` - Obtenir le nombre d'articles
- `/get-cart` - Obtenir le contenu du panier
- `/add-to-cart` - Ajouter un produit (AJAX)
- `/clear-cart` - Vider le panier
- `/test-cart` - Page de test

## Utilisation

### 1. Ajouter un produit au panier

```php
// Dans un composant Livewire
$cartData = [
    'product_uuid' => $this->product->uuid,
    'quantity' => $this->quantity,
    'selectedOptionUuid' => $this->selectedOptionUuid,
    'price' => $this->selectedPrice,
    // ... autres données
];

Session::put('carts', $cartData);
$this->dispatch('cartUpdated');
```

### 2. Afficher le panier dans le header

Le header se met à jour automatiquement grâce aux événements Livewire :
- `cartUpdated` : Quand un produit est ajouté
- `cartCleared` : Quand le panier est vidé

### 3. Personnaliser l'affichage

Modifiez le template `resources/views/livewire/inc/header.blade.php` pour :
- Changer le style de la modal
- Ajouter des informations supplémentaires
- Modifier les animations

## Styles CSS

Les styles sont inclus dans le template du header et incluent :
- Modal responsive avec animation slide-in
- Badge animé sur l'icône du panier
- Notifications toast
- Design moderne et professionnel

## Test

### Page de test
Accédez à `/test-cart` pour tester toutes les fonctionnalités :
- Ajouter un produit de test
- Vider le panier
- Voir le contenu
- Ouvrir la modal

### Console JavaScript
```javascript
// Accéder au gestionnaire de panier
window.cartManager

// Ajouter un produit
window.cartManager.addToCart({
    product_uuid: 'test-uuid',
    quantity: 1,
    price: 29.99
});

// Vider le panier
window.cartManager.clearCart();
```

## Intégration avec les formulaires existants

Le système s'intègre automatiquement avec :
- `app/Livewire/Forms/Abonnement.php`
- `app/Livewire/Forms/Revendeur.php`
- `app/Livewire/Forms/Renouvellement.php`

Chaque formulaire émet l'événement `cartUpdated` après avoir ajouté un produit au panier.

## Personnalisation

### Modifier l'apparence de la modal

```css
.cart-modal {
    /* Personnalisez la taille, couleur, etc. */
    width: 450px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

### Ajouter des informations supplémentaires

```php
// Dans Header.php
$this->cartDetails['custom_field'] = 'Valeur personnalisée';
```

### Modifier les animations

```css
@keyframes slideInRight {
    /* Personnalisez l'animation */
    from { transform: translateX(100%) rotate(5deg); }
    to { transform: translateX(0) rotate(0deg); }
}
```

## Dépannage

### Problèmes courants

1. **Le badge ne s'affiche pas** : Vérifiez que le JavaScript est chargé
2. **La modal ne s'ouvre pas** : Vérifiez les événements Livewire
3. **Les données ne persistent pas** : Vérifiez la configuration des sessions

### Debug

```php
// Vérifier le contenu du panier
dd(session('carts'));

// Vérifier les événements Livewire
$this->dispatch('cartUpdated');
```

## Compatibilité

- ✅ Laravel 10+
- ✅ Livewire 3
- ✅ PHP 8.1+
- ✅ Bootstrap 5
- ✅ Font Awesome 6

## Support

Pour toute question ou problème, consultez :
1. Les logs Laravel (`storage/logs/laravel.log`)
2. La console du navigateur pour les erreurs JavaScript
3. Les événements Livewire dans les outils de développement 