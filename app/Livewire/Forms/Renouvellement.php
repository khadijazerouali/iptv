<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Session;

class Renouvellement extends Component
{
    public $product;
    public $quantity = 1;
    public $number_order;
    public $product_uuid;
    public $selectedOptionUuid;
    public $selectedPrice = 0;

    public function mount($product)
    {
        $this->product = $product;
        $this->product_uuid = $product->uuid;
        $this->selectedPrice = $product->price; // Default to base product price
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

    public function submit()
    {
        Session::forget('carts');
        // dd(session()->get('carts'));
        // dd($this->all());
        // Validate input
        $this->validate([
            'number_order' => 'required|string',
            'quantity' => 'required|integer|min:1|max:99',
            'selectedOptionUuid' => 'nullable', // Optional if no options are available
            'product_uuid' => 'required',
        ]);

        

        session()->put('carts', $this->all());

        // Handle form submission (e.g., save to database, redirect, etc.)
        session()->flash('success', 'Commande renouvelée avec succès !');

        // Redirect to checkout
        return redirect()->route('checkout');
    }

    public function render()
    {
        return view('livewire.forms.renouvellement');
    }
}
