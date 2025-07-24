<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Session;

class Revendeur extends Component
{
    public $product;
    public $quantity = 1;
    public $first_name;
    public $last_name;
    public $email;
    public $selectedPrice;
    public $selectedOptionUuid;

    public function mount($product)
    {
        $this->product = $product;
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
        // Update selected price based on the selected option
        $option = ProductOption::find($value);
        $this->selectedPrice = $option ? $option->price : $this->product->price;
    }

    public function submitForm()
    {
        
        $this->validate([
            'quantity' => 'required|integer|min:1|max:99',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'selectedOptionUuid' => 'required|string',
            'selectedPrice' => 'required|integer',
        ]);

        $cartData = [
            'product_uuid' => $this->product->uuid,
            'quantity' => $this->quantity,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'selectedOptionUuid' => $this->selectedOptionUuid,
            'selectedPrice' => $this->selectedPrice,
        ];
        // Save data to session
        Session::forget('carts');
        Session::put('carts', $cartData);

        // Flash success message
        session()->flash('message', 'Commande envoyée avec succès.');

        // Redirect to checkout
        return redirect()->route('checkout');
    }


    public function render()
    {
        return view('livewire.forms.revendeur');
    }
}
