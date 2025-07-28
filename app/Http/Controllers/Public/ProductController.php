<?php

namespace App\Http\Controllers\Public;

use App\Models\Vod;
use App\Models\Channel;
use App\Models\Product;
use App\Models\Devicetype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;

class ProductController extends Controller
{
    //
    public function show($slug){
        try {
            $product = Product::whereSlug($slug)->first();
            if (!$product) {
                abort(404, 'Produit non trouvé');
            }
            return view('pages.products',compact("product"));
        } catch (\Exception $e) {
            abort(404, 'Erreur lors du chargement du produit');
        }
    }

    /**
     * Affiche la page boutique avec catégories et produits.
     */
    public function boutique(Request $request)
    {
        $categories = CategoryProduct::all();
        $categoryId = $request->query('category');
        $search = $request->query('search');
        
        $products = Product::query()
            ->when($categoryId, function ($query, $categoryId) {
                return $query->where('category_uuid', $categoryId);
            })
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%');
            })
            ->whereIn('status', ['active', 'actif'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('boutique.index', compact('categories', 'products', 'categoryId', 'search'));
    }
}
