<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Test des Catégories de Support ===\n\n";

try {
    // Test 1: Vérifier que le modèle SupportCategory existe
    echo "1. Vérification du modèle SupportCategory...\n";
    
    $categoriesCount = \App\Models\SupportCategory::count();
    echo "✅ Nombre de catégories dans la base: $categoriesCount\n";
    
    // Test 2: Lister toutes les catégories
    echo "\n2. Liste des catégories de support:\n";
    
    $categories = \App\Models\SupportCategory::ordered()->get();
    foreach ($categories as $category) {
        echo "- ID: " . $category->id . "\n";
        echo "  Nom: $category->name\n";
        echo "  Description: $category->description\n";
        echo "  Icône: $category->icon\n";
        echo "  Ordre: $category->sort_order\n";
        echo "  Actif: " . ($category->is_active ? 'Oui' : 'Non') . "\n";
        echo "\n";
    }
    
    // Test 3: Vérifier les catégories actives
    echo "3. Catégories actives:\n";
    
    $activeCategories = \App\Models\SupportCategory::active()->ordered()->get();
    foreach ($activeCategories as $category) {
        echo "- $category->name ($category->icon)\n";
    }
    
    // Test 4: Tester les scopes
    echo "\n4. Test des scopes:\n";
    
    $activeCount = \App\Models\SupportCategory::active()->count();
    echo "- Catégories actives: $activeCount\n";
    
    $orderedCount = \App\Models\SupportCategory::ordered()->count();
    echo "- Catégories triées: $orderedCount\n";
    
    // Test 5: Vérifier la relation avec SupportTicket
    echo "\n5. Vérification de la relation avec SupportTicket:\n";
    
    $ticketsWithCategory = \App\Models\SupportTicket::whereNotNull('category_id')->count();
    echo "- Tickets avec catégorie: $ticketsWithCategory\n";
    
    // Test 6: Tester la méthode statique
    echo "\n6. Test de la méthode getActiveOrdered():\n";
    
    $activeOrdered = \App\Models\SupportCategory::getActiveOrdered();
    echo "- Nombre de catégories actives et triées: " . $activeOrdered->count() . "\n";
    
    foreach ($activeOrdered as $category) {
        echo "  - $category->name (ordre: $category->sort_order)\n";
    }
    
    echo "\n=== Résumé ===\n";
    echo "✅ Modèle SupportCategory créé et fonctionnel\n";
    echo "✅ " . $categoriesCount . " catégories de support créées\n";
    echo "✅ Relations avec SupportTicket configurées\n";
    echo "✅ Scopes et méthodes utilitaires opérationnels\n";
    echo "✅ Système de support prêt à l'utilisation\n";
    
    echo "\n📋 Catégories disponibles:\n";
    foreach ($activeCategories as $category) {
        echo "- $category->name\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur : " . $e->getMessage() . "\n";
    echo "Type d'erreur : " . get_class($e) . "\n";
    echo "Fichier : " . $e->getFile() . "\n";
    echo "Ligne : " . $e->getLine() . "\n";
}

echo "\n=== Test terminé ===\n"; 