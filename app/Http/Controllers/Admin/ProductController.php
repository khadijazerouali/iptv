<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\Devicetype;
use App\Models\ProductOption;
use App\Models\Channel;
use App\Models\Vod;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Statistiques des produits
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'paused_products' => Product::where('status', 'paused')->count(),
            'monthly_sales' => Product::withCount(['subscriptions' => function($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            }])->get()->sum('subscriptions_count'),
        ];

        // Produits avec leurs catégories et options
        $products = Product::with(['category', 'productOptions', 'devices'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Catégories pour le filtre
        $categories = CategoryProduct::all();

        // Types d'appareils pour le filtre
        $deviceTypes = Devicetype::all();

        return view('admin.products', compact('stats', 'products', 'categories', 'deviceTypes'));
    }

    public function create()
    {
        $categories = CategoryProduct::all();
        $deviceTypes = Devicetype::all();
        $channels = Channel::all();
        $vods = Vod::all();
        
        return view('admin.products.create', compact('categories', 'deviceTypes', 'channels', 'vods'));
    }

    public function edit($uuid)
    {
        $product = Product::with(['category', 'productOptions', 'devices'])
            ->where('uuid', $uuid)
            ->firstOrFail();
            
        $categories = CategoryProduct::all();
        $deviceTypes = Devicetype::all();
        $channels = Channel::all();
        $vods = Vod::all();
        
        return view('admin.products.edit', compact('product', 'categories', 'deviceTypes', 'channels', 'vods'));
    }

    public function show($uuid)
    {
        $product = Product::with(['category', 'productOptions', 'devices', 'subscriptions'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        // Statistiques du produit
        $productStats = [
            'total_sales' => $product->subscriptions->count(),
            'monthly_sales' => $product->subscriptions->where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'total_revenue' => $product->subscriptions->sum(function($subscription) {
                return $subscription->payments->where('status', 'completed')->sum('amount');
            }),
            'average_rating' => $product->reviews->avg('rating') ?? 0,
        ];

        return response()->json([
            'product' => $product,
            'stats' => $productStats
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_uuid' => 'required|exists:category_products,uuid',
            'description' => 'nullable|string',
            'status' => 'required|in:active,paused,inactive',
            'type' => 'required|in:abonnement,revendeur,renouvellement,application,testiptv',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devicetypes,uuid',
            'duration_names' => 'required|array',
            'duration_names.*' => 'required|string|max:255',
            'duration_prices' => 'required|array',
            'duration_prices.*' => 'required|numeric|min:0',
            'revendeur_info' => 'nullable|string',
            'renouvellement_info' => 'nullable|string',
            'application_info' => 'nullable|string',
        ]);

        // Gérer l'upload d'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Créer le produit
        $product = Product::create([
            'title' => $validated['title'],
            'category_uuid' => $validated['category_uuid'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'image' => $imagePath,
            'price' => 0, // Prix sera calculé après création des options
        ]);

        // Attacher les appareils compatibles (pour abonnement et testiptv)
        if (in_array($validated['type'], ['abonnement', 'testiptv']) && !empty($validated['devices'])) {
            $product->devices()->attach($validated['devices']);
        }

        // Créer les options de durée (ProductOptions)
        if (!empty($validated['duration_names']) && !empty($validated['duration_prices'])) {
            foreach ($validated['duration_names'] as $index => $name) {
                if (isset($validated['duration_prices'][$index])) {
                    ProductOption::create([
                        'product_uuid' => $product->uuid,
                        'name' => $name,
                        'price' => $validated['duration_prices'][$index],
                    ]);
                }
            }
            
            // Calculer le prix minimum du produit basé sur les options
            $minPrice = $product->productOptions()->min('price') ?? 0;
            $product->update(['price' => $minPrice]);
        }

        return redirect()->route('admin.products')
            ->with('success', 'Produit créé avec succès');
    }

    public function update(Request $request, $uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_uuid' => 'required|exists:category_products,uuid',
            'description' => 'nullable|string',
            'status' => 'required|in:active,paused,inactive',
            'type' => 'required|in:abonnement,revendeur,renouvellement,application,testiptv',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devicetypes,uuid',
            'duration_names' => 'required|array',
            'duration_names.*' => 'required|string|max:255',
            'duration_prices' => 'required|array',
            'duration_prices.*' => 'required|numeric|min:0',
            'revendeur_info' => 'nullable|string',
            'renouvellement_info' => 'nullable|string',
            'application_info' => 'nullable|string',
        ]);

        // Gérer l'upload d'image
        $imagePath = $product->image; // Garder l'image existante par défaut
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Mettre à jour le produit
        $product->update([
            'title' => $validated['title'],
            'category_uuid' => $validated['category_uuid'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'image' => $imagePath,
        ]);

        // Mettre à jour les appareils compatibles (pour abonnement et testiptv)
        if (in_array($validated['type'], ['abonnement', 'testiptv'])) {
            $product->devices()->sync($validated['devices'] ?? []);
        } else {
            // Détacher tous les appareils pour les autres types
            $product->devices()->detach();
        }

        // Mettre à jour les options de durée (ProductOptions)
        // Supprimer toutes les options existantes
        $product->productOptions()->delete();
        
        // Créer les nouvelles options
        if (!empty($validated['duration_names']) && !empty($validated['duration_prices'])) {
            foreach ($validated['duration_names'] as $index => $name) {
                if (isset($validated['duration_prices'][$index])) {
                    ProductOption::create([
                        'product_uuid' => $product->uuid,
                        'name' => $name,
                        'price' => $validated['duration_prices'][$index],
                    ]);
                }
            }
            
            // Calculer le prix minimum du produit basé sur les options
            $minPrice = $product->productOptions()->min('price') ?? 0;
            $product->update(['price' => $minPrice]);
        }

        return redirect()->route('admin.products')
            ->with('success', 'Produit mis à jour avec succès');
    }

    public function destroy($uuid)
    {
        $product = Product::where('uuid', $uuid)->firstOrFail();
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produit supprimé avec succès'
        ]);
    }
} 