<?php

namespace App\Livewire\Forms\Widget;

use App\Models\Vod;
use App\Models\Channel;
use App\Models\Product;
use Livewire\Component;
use App\Models\Devicetype;
use App\Models\ProductOption;
use App\Models\Applicationtype;

class CheckoutForm extends Component
{
    public $cart;
    public $countries, $product, $quantity, $total, $first_name, $last_name, $phone, $email, $number_order;
    public $selectedOptionName, $selectedOptionPrice, $productType, $device, $application, $selectedOption, $selectedDevice, $selectedApplication, $selectedOptionUuid;
    public $device_id, $device_key, $macaddress, $magaddress, $formulermac, $smartstbmac, $commentaire;
    public $prenom, $nom, $nom_entreprise, $pays, $rue, $code_postal, $ville, $telephone;
    public $channel_lists = [], $vod_lists = [], $channels = [], $vods = [];
    public function mount()
    {
        $countriesPath = public_path('country/fr.json');
        if (!file_exists($countriesPath)) {
            return redirect()->route('home')->with('error', 'La liste des pays est indisponible.');
        }
        $this->countries = json_decode(file_get_contents($countriesPath))->countries ?? [];
        
        $this->cart = session()->get('carts');
        
        // Vérifier si le panier existe et contient les données nécessaires
        if (!$this->cart || !isset($this->cart['product_uuid'])) {
            return redirect()->route('home')->with('error', 'Panier invalide. Veuillez ajouter un produit au panier.');
        }
        
        $this->product = Product::where('uuid', $this->cart['product_uuid'])->first();
        if (!$this->product) {
            return redirect()->route('home')->with('error', 'Produit non trouvé.');
        }
        
        $this->quantity = $this->cart['quantity'] ?? 1;
        $this->selectedDevice = $this->cart['selectedDevice'] ?? null;
        $this->selectedApplication = $this->cart['selectedApplication'] ?? null;
        $this->selectedOptionUuid = $this->cart['selectedOptionUuid'] ?? null;
        
        if ($this->selectedOptionUuid) {
            $this->selectedOption = ProductOption::where('uuid', $this->selectedOptionUuid)->first();
        }

        // Calculer le total
        if ($this->selectedOption) {
            $this->total = $this->quantity * $this->selectedOption->price;
        } else {
            $this->total = $this->product->price * $this->quantity;
        }
    }

    public function submitForm()
    {
        if($this->product->type == 'abonnement' || $this->product->type == 'testiptv')
        {
            dd($this->cart);
            
        }elseif($this->product->type == 'revendeur')
        {
            $this->validate([
                'nom' => 'required|string',
                'prenom' => 'required|string',
                'email' => 'required|email',
                'nom_entreprise' => 'nullable|string',
                'pays' => 'required|string',
                'rue' => 'nullable|string',
                'code_postal' => 'nullable|string',
                'ville' => 'nullable|string',
                'telephone' => 'required|string',
                'commentaire' => 'nullable|string',
            ]);
            
            dd($this->all());

        }elseif($this->product->type == 'renouvellement')
        {
            dd($this->cart);
            
        }elseif($this->product->type == 'application')
        {
            dd($this->cart);
        }else{
            return redirect()->route('home')->with('error', 'Type de produit non reconnu.');
        }
        // Handle form submission
    }

    public function render()
    {
        // Load countries from JSON file
        $countriesPath = public_path('country/fr.json');
        if (!file_exists($countriesPath)) {
            return redirect()->route('home')->with('error', 'La liste des pays est indisponible.');
        }
        $countries = json_decode(file_get_contents($countriesPath))->countries ?? [];
        return view('livewire.forms.widget.checkout-form', compact('countries'));
    }
}
