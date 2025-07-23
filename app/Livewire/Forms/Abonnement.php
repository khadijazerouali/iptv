<?php

namespace App\Livewire\Forms;

use App\Models\Vod;
use App\Models\Channel;
use Livewire\Component;
use App\Models\Devicetype;
use App\Models\Applicationtype;
use Illuminate\Support\Facades\Session;
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
        // dd($this->all());
        Session::forget('carts');
        // Validate input
        $this->validate([
            'quantity' => 'required|integer|min:1|max:99',
            'selectedDevice' => 'required|string',
            'selectedApplication' => 'nullable|string',
            'selectedOptionUuid' => 'nullable|string',
            'macaddress' => 'nullable|string',
            'magaddress' => 'nullable|string',
            'formulermac' => 'nullable|string',
            'deviceid' => 'nullable|string',
            'devicekey' => 'nullable|string',
            'otpcode' => 'nullable|string',
            'smartstbmac' => 'nullable|string',
        ]);

        // dd($this->all());
        // Prepare cart data
        $cartData = [
            'product_uuid' => $this->product->uuid,
            'quantity' => $this->quantity,
            'selectedDevice' => $this->selectedDevice,
            'selectedApplication' => $this->selectedApplication,
            'price' => $this->selectedPrice ?? $this->price,
            'selectedOptionUuid' => $this->selectedOptionUuid,
            'macaddress' => $this->macaddress,
            'magaddress' => $this->magaddress,
            'formulermac' => $this->formulermac,
            'deviceid' => $this->deviceid,
            'devicekey' => $this->devicekey,
            'otpcode' => $this->otpcode,
            'smartstbmac' => $this->smartstbmac,
            'channels' => $this->channels,
            'vods' => $this->vods,
        ];

        $controller = new SubscriptionController();
        return $controller->store($cartData);

        // dd($cartData);

        
    }

    public function render()
    {
        return view('livewire.forms.abonnement');
    }
}