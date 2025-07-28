<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\ProductOption;

class CartController extends Controller
{
    /**
     * Ajouter un produit au panier
     */
    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'product_uuid' => 'required|string',
                'quantity' => 'required|integer|min:1|max:99',
                'selectedOptionUuid' => 'nullable|string',
                'price' => 'required|numeric|min:0'
            ]);

            // Récupérer le produit
            $product = Product::where('uuid', $request->product_uuid)->first();
            
            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produit non trouvé'
                ], 404);
            }

            // Préparer les données du panier
            $cartData = [
                'product_uuid' => $request->product_uuid,
                'quantity' => $request->quantity,
                'selectedOptionUuid' => $request->selectedOptionUuid,
                'price' => $request->price,
                'product_title' => $product->title,
                'product_description' => $product->description,
                'product_image' => $product->image
            ];

            // Vider l'ancien panier et ajouter le nouveau produit
            Session::forget('carts');
            Session::put('carts', $cartData);

            return response()->json([
                'success' => true,
                'message' => 'Produit ajouté au panier avec succès',
                'cart' => $cartData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'ajout au panier: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vider le panier
     */
    public function clearCart()
    {
        Session::forget('carts');
        
        return response()->json([
            'success' => true,
            'message' => 'Panier vidé avec succès'
        ]);
    }

    /**
     * Obtenir le contenu du panier
     */
    public function getCart()
    {
        $cart = Session::get('carts');
        
        return response()->json([
            'success' => true,
            'cart' => $cart
        ]);
    }
} 