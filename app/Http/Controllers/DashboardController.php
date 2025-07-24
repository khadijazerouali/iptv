<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;
use App\Models\SupportTicket;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
    
        $subscriptions = Subscription::with([
            'vods', 
            'deviceType', 
            'applicationType', 
            'productOption'
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
    
    
}
