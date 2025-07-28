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
        try {
            // Validation simplifiée pour test
            if (empty($this->quantity) || $this->quantity < 1) {
                $this->quantity = 1;
            }
            
            if (empty($this->selectedOptionUuid)) {
                session()->flash('error', 'Veuillez sélectionner une option');
                return redirect()->back();
            }

            $cartData = [
                'product_uuid' => $this->product->uuid,
                'quantity' => $this->quantity,
                'first_name' => $this->first_name ?? '',
                'last_name' => $this->last_name ?? '',
                'email' => $this->email ?? '',
                'selectedOptionUuid' => $this->selectedOptionUuid,
                'selectedPrice' => $this->selectedPrice,
            ];
            
            // Vider l'ancien panier et ajouter le nouveau produit
            Session::forget('carts');
            Session::put('carts', $cartData);

            // Flash success message
            session()->flash('message', 'Produit ajouté au panier avec succès !');

            // Retourner un message de succès pour JavaScript
            $this->dispatch('showCartModal', [
                'productTitle' => $this->product->title,
                'firstName' => $this->first_name ?? '',
                'lastName' => $this->last_name ?? '',
                'email' => $this->email ?? '',
                'quantity' => $this->quantity,
                'price' => $this->selectedPrice,
                'total' => $this->selectedPrice * $this->quantity
            ]);

        } catch (\Exception $e) {
            // En cas d'erreur, afficher un message d'erreur
            session()->flash('error', 'Erreur: ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function render()
    {
        return view('livewire.forms.revendeur');
    }
}
