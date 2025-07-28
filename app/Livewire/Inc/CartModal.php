<?php

namespace App\Livewire\Inc;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Session;

class CartModal extends Component
{
    public $showModal = false;
    public $cart = null;
    public $cartProduct = null;
    public $cartDetails = [];

    protected $listeners = ['cartUpdated' => 'loadCart', 'showCartModal' => 'showModal'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = Session::get('carts');
        $this->cartDetails = [];
        
        if ($this->cart && isset($this->cart['product_uuid'])) {
            $cartProduct = Product::where('uuid', $this->cart['product_uuid'])->first();
            
            if ($cartProduct) {
                $this->cartDetails = [
                    'title' => $cartProduct->title ?? 'Produit',
                    'description' => $cartProduct->description ?? 'Aucune description',
                    'image' => $cartProduct->image ?? null,
                    'quantity' => $this->cart['quantity'] ?? 1,
                    'price' => $this->cart['price'] ?? ($cartProduct->price ?? 0),
                    'total' => ($this->cart['price'] ?? ($cartProduct->price ?? 0)) * ($this->cart['quantity'] ?? 1),
                    'type' => $cartProduct->type ?? 'default',
                    'device' => null,
                    'application' => null
                ];

                // Ajouter les informations du device et de l'application
                if (isset($this->cart['selectedDevice'])) {
                    $device = \App\Models\Devicetype::where('uuid', $this->cart['selectedDevice'])->first();
                    if ($device) {
                        $this->cartDetails['device'] = $device->name;
                    }
                }

                if (isset($this->cart['selectedApplication'])) {
                    $application = \App\Models\Applicationtype::where('uuid', $this->cart['selectedApplication'])->first();
                    if ($application) {
                        $this->cartDetails['application'] = $application->name;
                    }
                }

                // Ajouter les détails de l'option si elle existe
                if (isset($this->cart['selectedOptionUuid'])) {
                    $option = ProductOption::where('uuid', $this->cart['selectedOptionUuid'])->first();
                    if ($option) {
                        $this->cartDetails['option'] = $option->name;
                        $this->cartDetails['price'] = $option->price;
                        $this->cartDetails['total'] = $option->price * ($this->cart['quantity'] ?? 1);
                    }
                }
            }
        }
    }

    public function showModal()
    {
        if ($this->cart && !empty($this->cartDetails)) {
            $this->showModal = true;
        }
    }

    public function hideModal()
    {
        $this->showModal = false;
    }

    public function goToCheckout()
    {
        if ($this->cart) {
            return redirect()->route('checkout');
        }
    }

    public function clearCart()
    {
        Session::forget('carts');
        $this->cart = null;
        $this->cartDetails = [];
        $this->showModal = false;
        
        $this->dispatch('cartCleared');
    }

    public function render()
    {
        return view('livewire.inc.cart-modal');
    }
} 