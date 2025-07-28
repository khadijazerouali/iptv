<?php

namespace App\Livewire\Inc;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Session;

class Header extends Component
{
    public $cart = null;
    public $cartDetails = [];

    protected $listeners = ['cartUpdated' => 'loadCart'];

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = Session::get('carts');
        
        if ($this->cart && isset($this->cart['product_uuid'])) {
            $cartProduct = Product::where('uuid', $this->cart['product_uuid'])->first();
            
            if ($cartProduct) {
                $this->cartDetails = [
                    'title' => $cartProduct->title,
                    'description' => $cartProduct->description,
                    'image' => $cartProduct->image,
                    'quantity' => $this->cart['quantity'] ?? 1,
                    'price' => $this->cart['price'] ?? $cartProduct->price,
                    'total' => ($this->cart['price'] ?? $cartProduct->price) * ($this->cart['quantity'] ?? 1),
                    'type' => $cartProduct->type
                ];

                // Ajouter les détails spécifiques selon le type de produit
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

    public function toggleCartModal()
    {
        if ($this->cart) {
            $this->dispatch('showCartModal');
        }
    }

    public function render()
    {
        return view('livewire.inc.header');
    }
}
