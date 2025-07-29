<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST DES STATUTS DES CODES PROMO ===\n";

try {
    // Récupérer tous les codes promo
    $promoCodes = \App\Models\PromoCode::all();
    
    echo "✅ Codes promo trouvés: " . $promoCodes->count() . "\n\n";
    
    foreach ($promoCodes as $promoCode) {
        echo "🎫 Code: " . $promoCode->code . "\n";
        echo "📝 Nom: " . $promoCode->name . "\n";
        echo "🎯 Statut: " . $promoCode->status . "\n";
        echo "📋 Texte statut: " . $promoCode->status_text . "\n";
        echo "🎨 Couleur statut: " . $promoCode->status_color . "\n";
        echo "✅ Actif: " . ($promoCode->is_active ? 'OUI' : 'NON') . "\n";
        echo "📅 Validité: ";
        
        if ($promoCode->valid_from && $promoCode->valid_until) {
            echo "Du " . $promoCode->valid_from->format('d/m/Y') . " au " . $promoCode->valid_until->format('d/m/Y');
        } else {
            echo "Illimitée";
        }
        
        echo "\n";
        echo "📊 Utilisation: " . $promoCode->used_count . " / " . $promoCode->usage_limit . "\n";
        
        // Test de la configuration des statuts
        $statusConfig = [
            'inactive' => ['class' => 'secondary', 'icon' => 'times-circle', 'label' => 'Inactif'],
            'pending' => ['class' => 'warning', 'icon' => 'clock', 'label' => 'En attente'],
            'active' => ['class' => 'success', 'icon' => 'check-circle', 'label' => 'Actif'],
            'expired' => ['class' => 'danger', 'icon' => 'calendar-times', 'label' => 'Expiré'],
            'exhausted' => ['class' => 'danger', 'icon' => 'exclamation-triangle', 'label' => 'Épuisé']
        ];
        
        $status = $promoCode->status;
        $config = $statusConfig[$status] ?? $statusConfig['inactive'];
        
        echo "🎨 Classe CSS: bg-" . $config['class'] . "\n";
        echo "🔍 Icône: fas fa-" . $config['icon'] . "\n";
        echo "🏷️ Label: " . $config['label'] . "\n";
        
        echo "---\n";
    }
    
    // Test des statistiques
    echo "\n=== STATISTIQUES ===\n";
    echo "Total codes: " . \App\Models\PromoCode::count() . "\n";
    echo "Codes actifs: " . \App\Models\PromoCode::where('is_active', true)->count() . "\n";
    echo "Codes expirés: " . \App\Models\PromoCode::where('valid_until', '<', now())->count() . "\n";
    echo "Codes épuisés: " . \App\Models\PromoCode::whereRaw('used_count >= usage_limit')->count() . "\n";
    
    echo "\n✅ Test des statuts terminé !\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Fichier: " . $e->getFile() . "\n";
    echo "Ligne: " . $e->getLine() . "\n";
} 