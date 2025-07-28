<?php

namespace App\Livewire\Forms;

use App\Models\Vod;
use App\Models\User;
use App\Models\Channel;
use App\Models\Product;
use Livewire\Component;
use App\Models\Devicetype;
use App\Models\Subscription;
use App\Models\ProductOption;
use App\Models\Applicationtype;
use App\Services\PromoCodeService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class Checkout extends Component
{
    public $product;
    public $quantity = 1;
    public $number_order;
    public $product_uuid;
    public $selectedOptionUuid;
    public $selectedOptionName;
    public $total;
    public $subtotal;
    public $discount = 0;
    public $selectedPrice = 0;
    public $countries = [];
    public $productType;
    public $payment_method = 'paypal';
    public $nom;
    public $prenom;
    public $nom_entreprise;
    public $email;
    public $pays;
    public $rue;
    public $code_postal;
    public $ville;
    public $telephone;
    public $commentaire;
    public $cart;
    public $channels = [];
    public $vods = [];
    public $subscription_uuid;
    public $applied_coupon = null;
    protected $promoCodeService;

    protected $listeners = ['coupon-applied', 'coupon-removed'];

    public function boot()
    {
        $this->promoCodeService = app(PromoCodeService::class);
    }

    public function mount()
    {
        $this->cart = session()->get('carts');
        
        // Vérifier si le panier existe et contient les données nécessaires
        if (!$this->cart || !isset($this->cart['product_uuid'])) {
            Session::flash('error', 'Panier invalide. Veuillez ajouter un produit au panier.');
            return redirect()->route('home');
        }
        
        $this->product = Product::whereUuid($this->cart['product_uuid'])->first();
        
        // Vérifier si le produit existe
        if (!$this->product) {
            Session::flash('error', 'Produit introuvable.');
            return redirect()->route('home');
        }
        
        $this->product_uuid = $this->product->uuid;
        
        // Vérifier si une option est sélectionnée
        if (isset($this->cart['selectedOptionUuid']) && $this->cart['selectedOptionUuid']) {
            $option = ProductOption::whereUuid($this->cart['selectedOptionUuid'])->first();
            $this->selectedOptionName = $option ? $option->name : '-';
            $this->selectedPrice = $option ? $option->price : $this->product->price;
        } else {
            $this->selectedOptionName = '-';
            $this->selectedPrice = $this->product->price;
        }
        
        $this->subtotal = $this->selectedPrice * $this->quantity;
        
        // Récupérer le code promo appliqué
        $this->applied_coupon = $this->promoCodeService->getAppliedCode();
        if ($this->applied_coupon) {
            $this->discount = $this->applied_coupon['discount_amount'];
        }
        
        $this->updateTotal();
        $this->productType = $this->product->type;

        // Pré-remplir l'email de l'utilisateur connecté
        if (Auth::check()) {
            $this->email = Auth::user()->email;
        }

        $countriesPath = public_path('country/fr.json');
        if (!file_exists($countriesPath)) {
            Session::flash('error', 'La liste des pays est indisponible.');
            return redirect()->route('home');
        }

        $this->countries = json_decode(file_get_contents($countriesPath))->countries ?? [];
    }

    public function increment()
    {
        if ($this->quantity < 99) {
            $this->quantity++;
            $this->updateTotal();
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
            $this->updateTotal();
        }
    }

    public function updatedPaymentMethod($value)
    {
        $this->payment_method = $value;
    }

    public function updatedSelectedOptionUuid($value)
    {
        $option = ProductOption::find($value);
        $this->selectedPrice = $option ? $option->price : $this->product->price;
        $this->selectedOptionName = $option ? $option->name : null;
        $this->updateTotal();
    }

    public function updateTotal()
    {
        $this->subtotal = $this->selectedPrice * $this->quantity;
        
        // Recalculer la réduction si un code promo est appliqué
        if ($this->applied_coupon) {
            $result = $this->promoCodeService->calculateTotalWithDiscount($this->subtotal);
            $this->discount = $result['discount'];
        }
        
        $this->total = $this->subtotal - $this->discount;
        
        // S'assurer que le total ne soit pas négatif
        if ($this->total < 0) {
            $this->total = 0;
        }
    }

    public function couponApplied($couponData)
    {
        $this->applied_coupon = $couponData;
        $this->discount = $couponData['discount_amount'];
        $this->updateTotal();
    }

    public function couponRemoved()
    {
        $this->applied_coupon = null;
        $this->discount = 0;
        $this->updateTotal();
    }

    public function submit()
    {
        // dd($this->all());
        
        $this->validate([
            'product_uuid' => 'required',
            'payment_method' => 'required|string|in:paypal,card', // Ensure valid payment method
            'nom' => 'required|string',
            'prenom' => 'required|string',
            'email' => 'required|email',
            'pays' => 'required|string',
            'rue' => 'nullable|string',
            'code_postal' => 'nullable|string',
            'ville' => 'nullable|string',
            'telephone' => 'nullable|string',
            'commentaire' => 'nullable|string'
        ]);

        $this->cart = session()->get('carts');
        // dd($this->cart);
        $product = Product::whereUuid($this->cart['product_uuid'])->first();
        // dd($product);
        // $this->product = $product;
        $this->productType = $product->type;
        // dd($this->productType);

        if ($this->productType == 'renouvellement') {
            // dd("gyuu");
            $number_order = $this->cart['number_order'];
            $subscription = Subscription::whereNumberOrder($number_order)->first();
            // dd($subscription);
            if (!$subscription) {
                Session::flash('error', 'Aucune abonnement correspondante trouvée.');
                return redirect()->route('checkout');
            }
            $this->subscription_uuid = $subscription->uuid;
            $formData['subscription_uuid'] = $this->subscription_uuid;
            // dd('jhvjv');
        }
        // dd("gyuu");
        $formData = $this->all();
    
        $user = User::whereEmail($formData['email'])->first();
        if (!$user) {
            $user = User::create([
                'name' => $formData['nom'] . ' ' . $formData['prenom'],
                'email' => $formData['email'],
                'password' => bcrypt('password'),
                // 'nom' => $formData['nom'],
                // 'prenom' => $formData['prenom'],
                // 'pays' => $formData['pays'],
                // 'rue' => $formData['rue'],
                // 'code_postal' => $formData['code_postal'],
                // 'ville' => $formData['ville'],
                // 'telephone' => $formData['telephone'],
                // 'commentaire' => $formData['commentaire'],
            ]);
        }
        
        // Attribution du rôle par défaut (seulement si l'utilisateur n'a pas déjà le rôle)
        if ($user->email === 'admin@admin.com') {
            if (!$user->hasRole('admin')) {
                $user->assignRole('admin');
            }
        } else {
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }
        }
        $formData['user_id'] = $user->id;
        $formData['start_date'] = now();
        $formData['end_date'] = now()->addYear();
        $formData['status'] = 'pending';
        $formData['quantity'] = $this->cart['quantity'];
        $formData['note'] = $formData['commentaire'];
        $formData['product_uuid'] = $this->product_uuid;
        
        // Gestion du code promo
        if ($this->applied_coupon) {
            $formData['promo_code_id'] = $this->applied_coupon['id'];
            $formData['promo_code'] = $this->applied_coupon['code'];
            $formData['discount_amount'] = $this->discount;
            $formData['subtotal'] = $this->subtotal;
            $formData['total'] = $this->total;
            
            // Incrémenter le compteur d'utilisation du code promo
            $this->promoCodeService->incrementUsage($this->applied_coupon['id']);
            
            // Nettoyer le code promo de la session après utilisation
            $this->promoCodeService->removeCode();
            
            Session::flash('success', 'Commande créée avec succès ! Code promo ' . $this->applied_coupon['code'] . ' appliqué (-' . number_format($this->discount, 2) . '€).');
        } else {
            $formData['promo_code_id'] = null;
            $formData['promo_code'] = null;
            $formData['discount_amount'] = 0;
            $formData['subtotal'] = $this->subtotal;
            $formData['total'] = $this->total;
            
            Session::flash('success', 'Commande créée avec succès !');
        }
        
        // dd($this->cart);
        $subscription = Subscription::create($formData);
        // dd($this->productType);
        if ($this->productType == 'abonnement' || $this->productType == 'testiptv') {
            $duration = ProductOption::find($this->cart['selectedOptionUuid']);
            $device = Devicetype::find($this->cart['selectedDevice']);
            $application = Applicationtype::find($this->cart['selectedApplication']);
            foreach($this->cart['channels'] as $channel) {
                $this->channels[] = Channel::where('uuid',$channel)->first()->title;
            }
            foreach($this->cart['vods'] as $vod) {
                $this->vods[] = Vod::where('uuid',$vod)->first()->title;
            }
            $channelsString = implode(', ', $this->channels);
            $vodsString = implode(', ', $this->vods);
            // dd($this->cart);
            $subscription->formiptvs()->create([
                // 'subscription_uuid' => $subscription->uuid,
                'user_id' => $user->id,
                'start_date' => now()->format('Y-m-d'),
                'duration' => $duration->name ?? '-',
                'price' => $duration->price ?? $this->product->price,
                'device' => $device->name ?? '-',
                'application' => $application->name ?? '-',
                'channels' => $channelsString ?? '-',
                'vods' => $vodsString ?? '-',
                'adulte' => $this->cart['adulte'] ?? false,
                // 'product_uuid' => $this->product_uuid,
                'mac_address' => $this->cart['macaddress'] ?? null,
                'device_id' => $this->cart['deviceid'] ?? null,
                'device_key' => $this->cart['devicekey'] ?? null,
                'otp_code' => $this->cart['otpcode'] ?? null,
                'formuler_mac' => $this->cart['formulermac'] ?? null,
                'mag_adresse' => $this->cart['magaddress'] ?? null,
                'note' => $this->cart['smartstbmac'] ?? $formData['commentaire'] ?? null,
            ]);
           
        }elseif ($this->productType == 'renouvellement') {
            $duration = ProductOption::find($this->cart['selectedOptionUuid']);
            // dd($duration);
            $subscription->formRenouvellements()->create([
                'user_id' => $user->id,
                'start_date' => now()->format('Y-m-d'),
                'duration' => $duration->name ?? '-',
                'price' => $duration->price ?? $this->product->price,
                // 'product_uuid' => $this->product_uuid,
                'number' => '#RN'.mt_rand(100000, 999999),
            ]);

            // dd($subscription);
        }elseif ($this->productType == 'revendeur') {
            // dd('ghgj');
            $subscription->formRevendeurs()->create([
                'user_id' => $user->id,
                'start_date' => now()->format('Y-m-d'),
                'name' => $formData['nom'] . ' ' . $formData['prenom'],
                'email' => $formData['email'],
                'quantity' => $formData['quantity'],
                // 'product_uuid' => $this->product_uuid,
                'number' => '#RV'.mt_rand(100000, 999999),
            ]);
            // dd($subscription);
        }else{
            return redirect()->route('home')->with('error', 'Type de produit non reconnu.');
        }
        
        // Store form data in session
        // Session::put('carts', $formData);
        Session::forget('carts');

        // Flash success message
        Session::flash('success', 'Commande effectuée avec succès !');

        // ENVOI EMAIL

        // Récupérer les données formiptv si elles existent
        $formiptv = null;
        if ($this->productType == 'abonnement' || $this->productType == 'testiptv') {
            $formiptv = $subscription->formiptvs()->latest()->first();
        }

        Mail::to(env('ADMIN_EMAIL', 'admin@votresite.com'))->send(new \App\Mail\OrderInfoToAdmin($user, $product, $subscription, $formiptv, $this->cart));
        Mail::to($user->email)->send(new \App\Mail\OrderInfoToClient($user, $product, $subscription, $formiptv, $this->cart));

        // Rediriger vers la page de succès
        return redirect()->route('success');
    }

    public function render()
    {
        return view('livewire.forms.checkout');
    }
}