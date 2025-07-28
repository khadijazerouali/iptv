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
        
        if (!$cart) {
            return response()->json([
                'success' => true,
                'cart' => null,
                'message' => 'Panier vide'
            ]);
        }

        // Récupérer les détails du produit
        $product = Product::where('uuid', $cart['product_uuid'])->first();
        $cartDetails = null;

        if ($product) {
            $cartDetails = [
                'title' => $product->title,
                'description' => $product->description,
                'image' => $product->image,
                'quantity' => $cart['quantity'] ?? 1,
                'price' => $cart['price'] ?? $product->price,
                'total' => ($cart['price'] ?? $product->price) * ($cart['quantity'] ?? 1),
                'type' => $product->type
            ];

            // Ajouter les détails de l'option si elle existe
            if (isset($cart['selectedOptionUuid'])) {
                $option = ProductOption::where('uuid', $cart['selectedOptionUuid'])->first();
                if ($option) {
                    $cartDetails['option'] = $option->name;
                    $cartDetails['price'] = $option->price;
                    $cartDetails['total'] = $option->price * ($cart['quantity'] ?? 1);
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'cart' => $cart,
            'cartDetails' => $cartDetails
        ]);
    }

    /**
     * Obtenir le nombre d'articles dans le panier
     */
    public function getCartCount()
    {
        $cart = Session::get('carts');
        $count = $cart ? ($cart['quantity'] ?? 1) : 0;
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
} 