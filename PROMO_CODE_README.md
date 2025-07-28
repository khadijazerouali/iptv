# Système de Validation des Codes Promo

## Vue d'ensemble

Le système de validation des codes promo a été complètement refactorisé pour offrir une validation robuste et une expérience utilisateur améliorée. Le système vérifie automatiquement :

- ✅ **Existence du code** : Le code promo existe-t-il dans la base de données ?
- ✅ **Statut actif** : Le code promo est-il activé ?
- ✅ **Dates de validité** : Le code est-il dans sa période de validité ?
- ✅ **Limite d'utilisation** : Le code n'a-t-il pas atteint sa limite d'utilisation ?
- ✅ **Montant minimum** : Le montant de la commande respecte-t-il le minimum requis ?
- ✅ **Calcul de réduction** : Calcul automatique de la réduction (pourcentage ou montant fixe)

## Architecture

### 1. Service PromoCodeService

Le service centralisé `PromoCodeService` gère toute la logique de validation :

```php
use App\Services\PromoCodeService;

$promoCodeService = app(PromoCodeService::class);

// Valider un code
$result = $promoCodeService->validateCode('PROMO2024', 100);

// Appliquer un code
$result = $promoCodeService->applyCode('PROMO2024', 100);
```

### 2. Composant Livewire CouponForm

Le composant `CouponForm` utilise le service pour gérer l'interface utilisateur :

- Affichage des messages de validation
- Gestion de l'état du code promo appliqué
- Événements pour communiquer avec les composants parents

### 3. API REST

Endpoints API disponibles pour l'intégration frontend :

```
POST /api/promo-codes/validate
POST /api/promo-codes/apply
DELETE /api/promo-codes/remove
GET /api/promo-codes/applied
POST /api/promo-codes/calculate-total
```

## Fonctionnalités

### Validation en Temps Réel

Le système valide instantanément les codes promo et affiche des messages clairs :

- **Code valide** : ✅ "Code promo appliqué avec succès ! Réduction de X€"
- **Code invalide** : ❌ "Code promo invalide. Veuillez vérifier votre saisie"
- **Code expiré** : ❌ "Ce code promo a expiré le DD/MM/YYYY à HH:MM"
- **Code futur** : ⚠️ "Ce code promo n'est pas encore valide. Il sera actif à partir du DD/MM/YYYY à HH:MM"
- **Limite atteinte** : ❌ "Ce code promo a atteint sa limite d'utilisation (X fois)"
- **Montant insuffisant** : ⚠️ "Ce code promo nécessite un montant minimum de X€"

### Types de Réduction

Le système supporte deux types de réductions :

1. **Pourcentage** : Réduction en pourcentage du montant total
   - Exemple : 20% de réduction
   - Limite maximale configurable

2. **Montant fixe** : Réduction d'un montant fixe
   - Exemple : 10€ de réduction
   - Pas de limite maximale

### Gestion des Limites

- **Limite d'utilisation** : Nombre maximum d'utilisations du code
- **Montant minimum** : Montant minimum requis pour utiliser le code
- **Réduction maximale** : Pour les codes en pourcentage, limite la réduction maximale
- **Protection contre les montants négatifs** : La réduction ne peut pas dépasser le sous-total

## Utilisation

### 1. Interface Utilisateur

L'utilisateur peut :

1. Cliquer sur "Avez-vous un code promo ? Cliquez ici pour saisir votre code"
2. Saisir le code promo dans le champ
3. Cliquer sur "Appliquer"
4. Voir le résultat de la validation
5. Si valide, voir les détails de la réduction appliquée
6. Supprimer le code si nécessaire

### 2. Intégration dans le Checkout

Le code promo appliqué est automatiquement :

- Sauvegardé en session
- Calculé dans le total final
- Affiché dans le récapitulatif de commande

### 3. API Usage

```javascript
// Valider un code promo
fetch('/api/promo-codes/validate', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({
        code: 'PROMO2024',
        subtotal: 100
    })
})
.then(response => response.json())
.then(data => {
    if (data.valid) {
        console.log('Code valide !', data);
    } else {
        console.log('Code invalide :', data.message);
    }
});
```

## Tests

### Exécuter les Tests

```bash
# Tests unitaires pour la validation des codes promo
php artisan test tests/Feature/PromoCodeValidationTest.php

# Tous les tests
php artisan test
```

### Codes de Test

Le seeder `PromoCodeSeeder` crée des codes de test :

**Codes valides :**
- `WELCOME20` : 20% de réduction, minimum 20€
- `SAVE10` : 10€ de réduction, minimum 50€
- `SUMMER25` : 25% de réduction, minimum 30€
- `BIGORDER` : 30% de réduction, minimum 100€

**Codes invalides :**
- `EXPIRED` : Code expiré
- `FUTURE` : Code pas encore valide
- `EXHAUSTED` : Code épuisé
- `INACTIVE` : Code désactivé

### Exécuter le Seeder

```bash
php artisan db:seed --class=PromoCodeSeeder
```

## Configuration

### Modèle PromoCode

Le modèle `PromoCode` contient tous les champs nécessaires :

```php
protected $fillable = [
    'code',              // Code promo unique
    'name',              // Nom du code
    'description',       // Description
    'discount_type',     // 'percentage' ou 'fixed'
    'discount_value',    // Valeur de la réduction
    'min_amount',        // Montant minimum requis
    'max_discount',      // Réduction maximale (pourcentage)
    'usage_limit',       // Limite d'utilisation
    'used_count',        // Nombre d'utilisations
    'valid_from',        // Date de début de validité
    'valid_until',       // Date de fin de validité
    'is_active',         // Statut actif/inactif
    'applies_to',        // 'all', 'specific_products', 'specific_categories'
    'applies_to_ids',    // IDs des produits/catégories concernés
];
```

### Méthodes Utiles

```php
// Vérifier si un code est valide
$promoCode->isValid();

// Calculer la réduction
$discount = $promoCode->calculateDiscount($subtotal);

// Vérifier si le code s'applique à un produit
$applies = $promoCode->appliesToProduct($productId);

// Incrémenter le compteur d'utilisation
$promoCode->incrementUsage();
```

## Sécurité

### Validation des Données

- Tous les codes sont automatiquement convertis en majuscules
- Validation des types de données (pourcentage/fixe)
- Protection contre les montants négatifs
- Vérification des limites d'utilisation

### Gestion des Sessions

- Les codes promo appliqués sont stockés en session
- Nettoyage automatique lors de la suppression
- Persistance entre les pages

## Maintenance

### Monitoring

Le système fournit des statistiques :

```php
$stats = $promoCodeService->getStats();
// Retourne : total, active, expired, expiring_soon, total_usage, total_emails_sent
```

### Logs

Les erreurs sont automatiquement loggées :

```php
Log::error('Erreur lors de l\'incrémentation du compteur d\'utilisation du code promo: ' . $e->getMessage());
```

## Évolutions Futures

### Fonctionnalités Prévues

1. **Codes promo par utilisateur** : Limiter l'utilisation par utilisateur
2. **Codes promo combinables** : Permettre l'utilisation de plusieurs codes
3. **Codes promo temporaires** : Codes à usage unique
4. **Historique des utilisations** : Traçabilité complète
5. **Notifications** : Alertes pour les codes expirant bientôt

### Optimisations

1. **Cache Redis** : Mise en cache des codes promo fréquemment utilisés
2. **Validation asynchrone** : Validation en arrière-plan pour les gros volumes
3. **API GraphQL** : Alternative à l'API REST pour plus de flexibilité 