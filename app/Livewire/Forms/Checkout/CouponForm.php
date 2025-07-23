<?php

namespace App\Livewire\Forms\Checkout;

use Livewire\Component;

class CouponForm extends Component
{
    public $coupon_code;

    protected $rules = [
        'coupon_code' => 'required',
    ];

    public function applyCoupon()
    {
        $this->validate();

        // Handle coupon application logic here

        session()->flash('success', 'Code promo appliqué avec succès.');
    }
    
    public function render()
    {
        return view('livewire.forms.checkout.coupon-form');
    }
}
