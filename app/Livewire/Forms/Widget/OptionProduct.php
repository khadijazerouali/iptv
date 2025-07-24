<?php

namespace App\Livewire\Forms\Widget;

use Livewire\Component;
use App\Models\ProductOption;

class OptionProduct extends Component
{
    public $product;
    public $selectedOptionUuid;
    public $selectedPrice = 0;

    public function mount($product)
    {
        $this->product = $product;
        $this->selectedPrice = $product->price;
    }

    public function updatedSelectedOptionUuid($value)
    {
        $option = ProductOption::find($value);
        $this->selectedPrice = $option ? $option->price : $this->product->price;

    }


    public function render()
    {
        return view('livewire.forms.widget.option-product');
    }
}