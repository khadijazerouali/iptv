<?php

namespace App\Http\Controllers\Public;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class SubscriptionController extends Controller
{
    public function store($cartData)
    {
        // dd($cartData);
        // Handle the cart data

        // Save data to session
        Session::put('carts', $cartData);

        // dd(session('carts'));
        // Flash success message
        session()->flash('message', 'Commande envoyée avec succès.');
        session()->flash('type', 'success');

        // dd('jhjk');
        // Redirect to checkout
        return redirect("/checkout");
    }
}
