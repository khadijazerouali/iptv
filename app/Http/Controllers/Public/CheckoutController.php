<?php

namespace App\Http\Controllers\Public;

use App\Models\Product;

use Illuminate\Http\Request;
use App\Models\ProductOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = session()->get('carts');
        
        // Vérifier si le panier existe et contient les données nécessaires
        if (!$cart || !isset($cart['product_uuid'])) {
            return redirect()->route('home')->with('error', 'Votre panier est vide ou invalide.');
        }

        $product = Product::where('uuid', $cart['product_uuid'])->first();
        if (!$product) {
            return redirect()->route('home')->with('error', 'Produit non trouvé.');
        }

        // Common variables
        $quantity = $cart['quantity'] ?? 1;
        $total = $product->price * $quantity;
        $productType = $product->type;
        $selectedOptionUuid = $cart['selectedOptionUuid'] ?? null;
        $selectedOption = ProductOption::where('uuid', $selectedOptionUuid)->first();
        $selectedOptionName = $selectedOption?->name ?? '';
        $selectedOptionPrice = $selectedOption?->price ?? 0;

        // Product-specific variables - initialiser à null par défaut
        $device_id = $device_key = $macaddress = $magaddress = $formulermac = $smartstbmac = '';
        $first_name = $last_name = $phone = $email = $number_order = '';

        if ($productType === 'abonnement' || $productType === 'testiptv' || $productType === 'application') {
            $device_id = $cart['device_id'] ?? '';
            $device_key = $cart['device_key'] ?? '';
            $macaddress = $cart['macaddress'] ?? '';
            $magaddress = $cart['magaddress'] ?? '';
            $formulermac = $cart['formulermac'] ?? '';
            $smartstbmac = $cart['smartstbmac'] ?? '';
        } elseif ($productType === 'revendeur') {
            $first_name = $cart['first_name'] ?? '';
            $last_name = $cart['last_name'] ?? '';
            $phone = $cart['phone'] ?? '';
            $email = $cart['email'] ?? '';
        } elseif ($productType === 'renouvellement') {
            $number_order = $cart['number_order'] ?? '';
        }

        // Load countries from JSON file
        $countriesPath = public_path('country/fr.json');
        if (!file_exists($countriesPath)) {
            return redirect()->route('home')->with('error', 'La liste des pays est indisponible.');
        }
        $countries = json_decode(file_get_contents($countriesPath))->countries ?? [];

        // Préparer l'utilisateur pour l'email client
        $user = (object)[
            'name' => trim(($first_name ?? '') . ' ' . ($last_name ?? '')),
            'email' => $email ?? '-',
        ];
        
        // Envoi de l'email au client - Gestion sécurisée des erreurs SMTP
        try {
            if (!empty($user->email) && filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($user->email)->send(new \App\Mail\OrderInfoToClient($user, $product, null, null, $cart));
            }
        } catch (\Exception $e) {
            // Log l'erreur mais ne pas faire échouer la page
            Log::error('Erreur lors de l\'envoi de l\'email client: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }

        return view('pages.checkout', compact(
            'countries',
            'product',
            'quantity',
            'total',
            'first_name',
            'last_name',
            'phone',
            'email',
            'number_order',
            'selectedOptionName',
            'selectedOptionPrice',
            'productType'
        ));
    }
}
