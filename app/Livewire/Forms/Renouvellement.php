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
        try {
            // Validation simplifiée pour test
            if (empty($this->quantity) || $this->quantity < 1) {
                $this->quantity = 1;
            }
            
            if (empty($this->number_order)) {
                session()->flash('error', 'Veuillez saisir le numéro de commande');
                return redirect()->back();
            }

            // Vider l'ancien panier et ajouter le nouveau produit
            Session::forget('carts');
            session()->put('carts', $this->all());

            // Flash success message
            session()->flash('message', 'Produit ajouté au panier avec succès !');

            // Émettre un événement pour mettre à jour le panier dans le header
            $this->dispatch('cartUpdated');

            // Retourner un message de succès pour JavaScript
            $this->dispatch('showCartModal', [
                'productTitle' => $this->product->title,
                'orderNumber' => $this->number_order ?? '',
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
        return view('livewire.forms.renouvellement');
    }
}
