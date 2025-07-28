<?php

namespace App\Livewire\Forms;

use App\Models\Vod;
use App\Models\Channel;
use Livewire\Component;
use App\Models\Devicetype;
use App\Models\Applicationtype;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Public\SubscriptionController;
use App\Models\Product;


class Abonnement extends Component
{
    public $product;
    public $product_uuid;
    public $quantity = 1;
    public $selectedDevice;
    public $selectedApplication;
    public $device_uuid;
    public $price = 0;
    public $channels = [];
    public $vods = [];
    public $macaddress;
    public $magaddress;
    public $formulermac;
    public $deviceid;
    public $devicekey;
    public $otpcode;
    public $smartstbmac;
    public $selectedOptionUuid;
    public $deviceTypes;
    public $applicationTypes;
    public $deviceSelected;
    public $applicationSelected;
    public $channelList;
    public $vodOptions;
    public $selectedPrice;

    public function mount($product)
{
    $this->product = $product;
    $this->price = $product->price;
    $this->selectedPrice = $product->price; 

    $this->applicationTypes = collect(); 
    $this->channelList = Channel::all(); 
    $this->vodOptions = Vod::all();       

    $this->deviceTypes = $this->product ? $this->product->devices : collect();
}


    public function increment()
    {
        if ($this->quantity < 99) {
            $this->quantity++;
        }
    }

    public function decrement()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function updatedSelectedOptionUuid($value)
    {
        // Update price based on selected option
        $option = $this->product->productOptions()->where('uuid', $value)->first();
        $this->selectedPrice = $option ? $option->price : $this->product->price;
    }

    public function updatedSelectedDevice($value)
    {
        if ($value) {
            $this->applicationTypes = Applicationtype::where('devicetype_uuid', $value)->get();
            $this->deviceSelected = Devicetype::find($value);
        } else {
            $this->applicationTypes = collect(); // Clear application types if no device type is selected
        }
    }

    public function updatedSelectedApplication($value)
    {
        $this->applicationSelected = Applicationtype::find($value);
    }

    public function submitForm()
    {
        // Debug: Log pour voir si la méthode est appelée
        Log::info('submitForm method called');
        
        // Validation simplifiée
        if (empty($this->quantity) || $this->quantity < 1) {
            $this->quantity = 1;
        }
        
        if (empty($this->selectedDevice)) {
            $this->selectedDevice = 'default';
        }

        // Prepare cart data
        $cartData = [
            'product_uuid' => $this->product->uuid,
            'quantity' => $this->quantity,
            'selectedDevice' => $this->selectedDevice,
            'selectedApplication' => $this->selectedApplication ?? null,
            'price' => $this->selectedPrice ?? $this->price,
            'selectedOptionUuid' => $this->selectedOptionUuid ?? null,
            'macaddress' => $this->macaddress ?? null,
            'magaddress' => $this->magaddress ?? null,
            'formulermac' => $this->formulermac ?? null,
            'deviceid' => $this->deviceid ?? null,
            'devicekey' => $this->devicekey ?? null,
            'otpcode' => $this->otpcode ?? null,
            'smartstbmac' => $this->smartstbmac ?? null,
            'channels' => $this->channels ?? [],
            'vods' => $this->vods ?? [],
        ];

        // Vider l'ancien panier et ajouter le nouveau produit
        Session::forget('carts');
        Session::put('carts', $cartData);

        // Flash success message
        session()->flash('message', 'Produit ajouté au panier avec succès !');

        // Émettre un événement pour mettre à jour le panier dans le header
        $this->dispatch('cartUpdated');

        // Debug: Log avant redirection
        Log::info('Redirecting to checkout');
        
        // Rediriger directement vers checkout
        return redirect()->route('checkout');
    }

    public function render()
    {
        return view('livewire.forms.abonnement');
    }
}