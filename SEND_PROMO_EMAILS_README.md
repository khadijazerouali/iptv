# Envoi d'Emails de Codes Promo

## Vue d'ensemble

La fonctionnalité d'envoi d'emails de codes promo permet aux administrateurs d'envoyer des codes promo à tous les utilisateurs actifs ou à des utilisateurs sélectionnés. Cette fonctionnalité est accessible depuis la gestion des codes promo dans l'interface d'administration.

## Fonctionnalités Implémentées

### ✅ **Envoi à Tous les Utilisateurs**
- Bouton "Envoyer à tous les utilisateurs" dans le modal d'envoi
- Envoi automatique à tous les utilisateurs actifs (excluant l'admin)
- Confirmation avant envoi pour éviter les erreurs

### ✅ **Envoi Sélectif**
- Sélection d'utilisateurs spécifiques via checkboxes
- Option "Sélectionner tous les utilisateurs" pour faciliter la sélection
- Envoi uniquement aux utilisateurs sélectionnés

### ✅ **Gestion des Erreurs**
- Rapport détaillé des emails envoyés avec succès
- Liste des erreurs pour les emails non envoyés
- Notification à l'admin avec le rapport complet

### ✅ **Statistiques**
- Compteur d'emails envoyés par code promo
- Statistiques globales dans le dashboard
- Suivi des envois dans l'historique

## Interface Utilisateur

### **Modal d'Envoi d'Emails**

Le modal contient :
- **Titre** : "Envoyer le code promo [Nom du code]"
- **Information** : Instructions pour la sélection des utilisateurs
- **Sélection** : 
  - Checkbox "Sélectionner tous les utilisateurs"
  - Liste des utilisateurs avec checkboxes individuelles
- **Boutons** :
  - "Annuler" : Ferme le modal
  - "Envoyer à tous les utilisateurs" : Envoie à tous les utilisateurs actifs
  - "Envoyer aux sélectionnés" : Envoie aux utilisateurs cochés

### **Boutons d'Action**

Dans la liste des codes promo :
- **📧 Icône d'avion** : Ouvre le modal d'envoi d'emails
- **✏️ Icône d'édition** : Modifier le code promo
- **📋 Icône de copie** : Dupliquer le code promo
- **⏸️/▶️ Icône play/pause** : Activer/désactiver le code
- **🗑️ Icône de suppression** : Supprimer le code promo

## Fonctionnement Technique

### **Routes Ajoutées**

```php
// Envoi à des utilisateurs sélectionnés
Route::post('promo-codes/{promoCode}/send', [PromoCodeController::class, 'sendToUsers']);

// Envoi à tous les utilisateurs actifs
Route::post('promo-codes/{promoCode}/send-all', [PromoCodeController::class, 'sendToAllUsers']);

// Récupération de la liste des utilisateurs
Route::get('promo-codes/users', [PromoCodeController::class, 'getUsersForPromo']);
```

### **Méthodes du Contrôleur**

#### `sendToUsers(Request $request, PromoCode $promoCode)`
- Valide les IDs des utilisateurs sélectionnés
- Envoie les emails aux utilisateurs spécifiés
- Met à jour les statistiques du code promo
- Envoie un rapport à l'admin

#### `sendToAllUsers(Request $request, PromoCode $promoCode)`
- Récupère tous les utilisateurs actifs (excluant l'admin)
- Envoie les emails à tous les utilisateurs
- Met à jour les statistiques du code promo
- Envoie un rapport détaillé à l'admin

### **Template d'Email**

Le template `emails.promo-code.blade.php` contient :
- **En-tête** : Logo et titre de l'offre
- **Salutation** : Nom de l'utilisateur
- **Message** : Description de l'offre spéciale
- **Carte promo** : 
  - Nom et description du code
  - Code promo à utiliser
  - Type et montant de la réduction
  - Conditions d'utilisation

## Utilisation

### **Étapes pour Envoyer un Code Promo**

1. **Accéder à la gestion des codes promo**
   - Admin Panel > Gestion des codes promo

2. **Ouvrir le modal d'envoi**
   - Cliquer sur l'icône d'avion (📧) à côté du code promo

3. **Choisir le type d'envoi**
   - **Option 1** : "Envoyer à tous les utilisateurs"
     - Cliquer sur le bouton orange
     - Confirmer l'action
   - **Option 2** : "Envoyer aux sélectionnés"
     - Cocher les utilisateurs souhaités
     - Cliquer sur "Envoyer aux sélectionnés"

4. **Confirmation**
   - Le système affiche un message de confirmation
   - Les statistiques sont mises à jour
   - Un rapport est envoyé à l'admin

### **Exemple d'Utilisation**

```
1. Code promo "WELCOME20" créé (20% de réduction)
2. Admin clique sur l'icône d'avion
3. Modal s'ouvre avec la liste des utilisateurs
4. Admin clique "Envoyer à tous les utilisateurs"
5. Confirmation : "Êtes-vous sûr de vouloir envoyer ce code promo à TOUS les utilisateurs actifs ?"
6. Admin confirme
7. Système envoie 16 emails (nombre d'utilisateurs actifs)
8. Message : "Code promo envoyé à 16 utilisateur(s) sur 16 avec succès !"
9. Statistiques mises à jour : "Emails envoyés : 16"
```

## Sécurité et Validation

### **Filtres Appliqués**
- Exclusion de l'utilisateur admin (`admin@admin.com`)
- Exclusion des utilisateurs sans email
- Validation des emails avant envoi

### **Gestion des Erreurs**
- Try-catch pour chaque envoi d'email
- Log des erreurs pour le debugging
- Rapport détaillé des échecs

### **Confirmation**
- Double confirmation pour l'envoi à tous les utilisateurs
- Prévention des envois accidentels

## Statistiques et Suivi

### **Compteurs Mis à Jour**
- `email_sent_count` : Nombre total d'emails envoyés
- `last_sent_at` : Date du dernier envoi

### **Rapport Admin**
- Nombre d'emails envoyés avec succès
- Nombre total d'utilisateurs ciblés
- Liste des erreurs détaillées
- Informations sur l'admin qui a effectué l'envoi

## Template d'Email

### **Structure de l'Email**
```html
🎫 Code promo spécial IPTV - [Nom du code]

Bonjour [Nom de l'utilisateur] !

Nous avons une offre spéciale pour vous ! 
Profitez de notre code promo exclusif pour économiser sur votre abonnement IPTV.

[Card avec les détails du code promo]
- Nom du code
- Description
- Code à utiliser
- Type de réduction (pourcentage ou montant fixe)
- Conditions d'utilisation
```

### **Styles CSS**
- Design responsive
- Couleurs cohérentes avec la marque
- Mise en forme professionnelle
- Call-to-action clair

## Évolutions Futures

### **Fonctionnalités Prévues**
1. **Planification** : Envoi programmé d'emails
2. **Segmentation** : Envoi selon des critères spécifiques
3. **A/B Testing** : Différents templates d'emails
4. **Analytics** : Suivi des taux d'ouverture et de clic

### **Optimisations**
1. **Queue** : Envoi en arrière-plan pour les gros volumes
2. **Templates** : Plus de variété dans les designs
3. **Personnalisation** : Variables dynamiques selon l'utilisateur
4. **Rapports** : Dashboard détaillé des performances

## Maintenance

### **Monitoring**
- Vérification régulière des envois d'emails
- Suivi des taux de livraison
- Gestion des bounces et erreurs

### **Logs**
- Traçabilité complète des envois
- Historique des actions admin
- Debugging des erreurs d'envoi 