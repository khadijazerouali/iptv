<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\Devicetype;
use App\Models\ProductOption;
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
        
        return view('admin.products.create', compact('categories', 'deviceTypes'));
    }

    public function edit($uuid)
    {
        $product = Product::with(['category', 'productOptions', 'devices'])
            ->where('uuid', $uuid)
            ->firstOrFail();
            
        $categories = CategoryProduct::all();
        $deviceTypes = Devicetype::all();
        
        return view('admin.products.edit', compact('product', 'categories', 'deviceTypes'));
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
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required|array|min:1',
            'options.*.name' => 'required|string',
            'options.*.price' => 'required|numeric|min:0',
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devicetypes,uuid',
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
            'price' => $validated['options'][0]['price'], // Prix principal = première option
        ]);

        // Créer les options de produit
        foreach ($validated['options'] as $option) {
            ProductOption::create([
                'product_uuid' => $product->uuid,
                'name' => $option['name'],
                'price' => $option['price'],
            ]);
        }

        // Attacher les appareils compatibles
        if (!empty($validated['devices'])) {
            $product->devices()->attach($validated['devices']);
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
            'type' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required|array|min:1',
            'options.*.name' => 'required|string',
            'options.*.price' => 'required|numeric|min:0',
            'devices' => 'nullable|array',
            'devices.*' => 'exists:devicetypes,uuid',
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
            'price' => $validated['options'][0]['price'], // Prix principal = première option
        ]);

        // Supprimer les anciennes options
        $product->productOptions()->delete();

        // Créer les nouvelles options
        foreach ($validated['options'] as $option) {
            ProductOption::create([
                'product_uuid' => $product->uuid,
                'name' => $option['name'],
                'price' => $option['price'],
            ]);
        }

        // Mettre à jour les appareils compatibles
        $product->devices()->sync($validated['devices'] ?? []);

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