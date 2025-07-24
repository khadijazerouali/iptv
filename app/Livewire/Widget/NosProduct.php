<?php

namespace App\Livewire\Widget;

use App\Models\Product;
use Livewire\Component;

class NosProduct extends Component
{
    public function render()
    {
        // dd(Product::all());
        return view('livewire.widget.nos-product',[
            'products' => Product::all()
        ]);
    }
}
