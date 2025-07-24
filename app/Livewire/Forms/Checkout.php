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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class Checkout extends Component
{
    public $product;
    public $quantity = 1;
    public $number_order;
    public $product_uuid;
    public $selectedOptionUuid;
    public $selectedOptionName;
    public $total;
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

    public function mount()
    {
        $this->cart = session()->get('carts');
        $this->product = Product::whereUuid($this->cart['product_uuid'])->first();
        $this->product_uuid = $this->product->uuid;
        $option = ProductOption::whereUuid($this->cart['selectedOptionUuid'])->first();
        $this->selectedOptionName = $option ? $option->name : '-';
        $this->selectedPrice = $option ? $option->price : $this->product->price;
        $this->total = $this->product->price * $this->quantity;
        $this->productType = $this->product->type;

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
        $this->total = $this->selectedPrice * $this->quantity;
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
            // Attribution du rôle par défaut
            if ($user->email === 'admin@admin.com') {
                $user->assignRole('super-admin');
            } else {
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
                'mac_address' => $this->cart['mac_address'] ?? null,
                'device_id' => $this->cart['device_id'] ?? null,
                'device_key' => $this->cart['device_key'] ?? null,
                'otp_code' => $this->cart['otp_code'] ?? null,
                'formuler_mac' => $this->cart['formuler_mac'] ?? null,
                'mag_adresse' => $this->cart['mag_adresse'] ?? null,
                'note' => $formData['commentaire'] ?? null,
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
        Session::flash('success', 'Commande renouvelée avec succès !');

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