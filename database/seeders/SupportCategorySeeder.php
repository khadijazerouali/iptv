<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupportCategory;

class SupportCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Problème de connexion',
                'description' => 'Problèmes liés à la connexion internet, WiFi, ou accès au service',
                'icon' => 'fas fa-wifi',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Problème de chaînes TV',
                'description' => 'Chaînes qui ne fonctionnent pas, qualité d\'image, ou chaînes manquantes',
                'icon' => 'fas fa-tv',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Problème d\'application mobile',
                'description' => 'Application qui ne se lance pas, bugs, ou problèmes de synchronisation',
                'icon' => 'fas fa-mobile-alt',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Problème de paiement',
                'description' => 'Erreurs de paiement, facturation, ou problèmes de renouvellement',
                'icon' => 'fas fa-credit-card',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Problème de compte',
                'description' => 'Connexion au compte, mot de passe, ou informations personnelles',
                'icon' => 'fas fa-user',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Problème de configuration',
                'description' => 'Paramètres, configuration d\'appareils, ou installation',
                'icon' => 'fas fa-cog',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'name' => 'Problème technique',
                'description' => 'Erreurs techniques, bugs, ou dysfonctionnements divers',
                'icon' => 'fas fa-exclamation-triangle',
                'sort_order' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Question générale',
                'description' => 'Questions générales, demandes d\'information, ou assistance',
                'icon' => 'fas fa-question-circle',
                'sort_order' => 8,
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            SupportCategory::create($category);
        }
    }
} 