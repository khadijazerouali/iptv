<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class KnowledgeBaseController extends Controller
{
    public function articles($category)
    {
        // Simulation des articles par catégorie
        $articles = [
            'installation' => [
                ['id' => 1, 'title' => 'Installation sur Android', 'content' => 'Guide complet...'],
                ['id' => 2, 'title' => 'Installation sur iOS', 'content' => 'Guide complet...'],
                ['id' => 3, 'title' => 'Installation sur Smart TV', 'content' => 'Guide complet...'],
                ['id' => 4, 'title' => 'Installation sur PC', 'content' => 'Guide complet...'],
                ['id' => 5, 'title' => 'Installation sur MAC', 'content' => 'Guide complet...'],
            ],
            'configuration' => [
                ['id' => 6, 'title' => 'Configuration des paramètres', 'content' => 'Guide complet...'],
                ['id' => 7, 'title' => 'Configuration du réseau', 'content' => 'Guide complet...'],
                ['id' => 8, 'title' => 'Configuration avancée', 'content' => 'Guide complet...'],
            ],
            'depannage' => [
                ['id' => 9, 'title' => 'Problèmes de connexion', 'content' => 'Guide complet...'],
                ['id' => 10, 'title' => 'Problèmes de qualité vidéo', 'content' => 'Guide complet...'],
                ['id' => 11, 'title' => 'Problèmes de son', 'content' => 'Guide complet...'],
                ['id' => 12, 'title' => 'Problèmes de décalage', 'content' => 'Guide complet...'],
            ]
        ];

        $categoryArticles = $articles[$category] ?? [];

        return response()->json([
            'success' => true,
            'message' => 'Articles récupérés avec succès',
            'articles' => $categoryArticles,
            'category' => $category
        ]);
    }

    public function create()
    {
        return response()->json([
            'success' => true,
            'message' => 'Redirection vers la création d\'article',
            'redirect_url' => '/admin/knowledge-base/articles/create'
        ]);
    }
}
