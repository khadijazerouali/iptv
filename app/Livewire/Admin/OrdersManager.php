<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Subscription;

class OrdersManager extends Component
{
    public $orders;
    public $selectedOrder = null;

        public function mount()
    {
        $this->orders = Subscription::with([
            'user',
            'product',
            'formiptvs'
        ])->get();
    }

    public function show($id)
    {
        $this->selectedOrder = Subscription::with([
            'user',
            'product',
            'product.devices',
            'product.category',
            'formiptvs',
            'payments'
        ])->findOrFail($id);
    }

    public function closeDetails()
    {
        $this->selectedOrder = null;
    }

    public function render()
    {
        return view('livewire.admin.orders-manager', [
            'selectedOrder' => $this->selectedOrder,
        ]);
    }
}
