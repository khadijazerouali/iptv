<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\SupportTicket;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
    
        $subscriptions = Subscription::with([
            'formiptvs', 
            'deviceType', 
            'applicationType', 
            'productOption',
            'product' // Ajout de la relation avec le produit
        ])->where('user_id', $user->id)->get();
            
        $cartItems = collect(session('cart', []));
    
        $cartTotal = $cartItems->sum(function ($item) {
            return $item['price'] ?? 0;
        });
    
        $supportTickets = SupportTicket::where('user_id', $user->id)->latest()->get();
    
        return view('dashboard', [
            'user' => $user,
            'subscriptions' => $subscriptions,
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'supportTickets' => $supportTickets,
        ]);
    }

    // Nouvelle méthode pour afficher les détails d'un produit
    public function showProduct($productUuid)
    {
        $product = Product::with([
            'category',
            'productOptions',
            'reviews',
            'devices',
            'durationOption'
        ])->where('uuid', $productUuid)->firstOrFail();

        return view('products.details', compact('product'));
    }

    // Nouvelle méthode pour afficher les détails d'une commande
    public function showOrderDetails($subscriptionUuid)
    {
        $user = auth()->user();
        
        $subscription = Subscription::with([
            'product',
            'product.category',
            'formiptvs',
            'deviceType',
            'applicationType',
            'productOption',
            'payments'
        ])->where('uuid', $subscriptionUuid)
          ->where('user_id', $user->id)
          ->firstOrFail();

        return view('orders.details', compact('subscription'));
    }

    public function updateProfile(Request $request)
{
    // dd('Méthode appelée !', $request->all(), $request->method());
    
    $user = Auth::user();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'telephone' => 'nullable|string|max:20',
        'ville' => 'nullable|string|max:255',
    ]);
    


        $user->name = $request->input('name'); 
        $user->telephone = $request->input('telephone'); 
        $user->ville = $request->input('ville'); 

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Vos informations personnelles ont été mises à jour avec succès !');
    }


    public function createSupportTicket(Request $request)
{
    $user = auth()->user();
    
    $request->validate([
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        'subscription_id' => 'nullable|exists:subscriptions,id'
    ]);

    $ticket = SupportTicket::create([
        'user_id' => $user->id,
        'subject' => $request->subject,
        'message' => $request->message,
        'status' => 'open',
        'subscription_id' => $request->subscription_id
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Ticket créé avec succès!',
        'ticket_id' => $ticket->id
    ]);
}

public function downloadInvoice($subscriptionId)
{
    $user = auth()->user();
    $subscription = Subscription::where('user_id', $user->id)
                               ->where('id', $subscriptionId)
                               ->firstOrFail();


    
    // Exemple avec un template Blade pour générer le PDF
    $pdf = PDF::loadView('invoices.template', compact('subscription', 'user'));
    
    return $pdf->download("facture-commande-{$subscription->number_order}.pdf");
}
    
    
}
