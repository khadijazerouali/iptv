<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        // Statistiques des catégories
        $stats = [
            'total_categories' => CategoryProduct::count(),
            'active_categories' => CategoryProduct::count(), // Toutes les catégories sont considérées comme actives
            'categories_with_products' => CategoryProduct::whereHas('products')->count(),
            'total_products' => Product::count(),
        ];

        // Liste des catégories avec leurs produits
        $categories = CategoryProduct::withCount('products')
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->get();

        // Catégories les plus populaires (par nombre de produits)
        $popularCategories = CategoryProduct::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.categories', compact('stats', 'categories', 'popularCategories'));
    }

    public function show($uuid)
    {
        $category = CategoryProduct::with(['products' => function($query) {
            $query->with(['subscriptions', 'productOptions']);
        }])->findOrFail($uuid);

        return response()->json([
            'success' => true,
            'category' => $category,
            'products_count' => $category->products->count(),
            'total_subscriptions' => $category->products->sum(function($product) {
                return $product->subscriptions->count();
            }),
            'total_revenue' => $category->products->sum(function($product) {
                return $product->subscriptions->sum('price');
            })
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:category_products',
            'description' => 'nullable|string',
            'icon_url' => 'nullable|string'
        ]);

        $category = new CategoryProduct();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->icon_url = $request->icon_url;
        $category->slug = Str::slug($request->name);

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Catégorie créée avec succès',
            'category' => $category
        ]);
    }

    public function update(Request $request, $uuid)
    {
        $category = CategoryProduct::findOrFail($uuid);

        $request->validate([
            'name' => 'required|string|max:255|unique:category_products,name,' . $uuid,
            'description' => 'nullable|string',
            'icon_url' => 'nullable|string'
        ]);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->icon_url = $request->icon_url;
        $category->slug = Str::slug($request->name);

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Catégorie mise à jour avec succès',
            'category' => $category
        ]);
    }

    public function destroy($uuid)
    {
        $category = CategoryProduct::findOrFail($uuid);

        // Vérifier si la catégorie a des produits
        if ($category->products()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible de supprimer cette catégorie car elle contient des produits'
            ], 400);
        }



        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catégorie supprimée avec succès'
        ]);
    }
} 