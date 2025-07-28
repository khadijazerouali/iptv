<?php

namespace App\Livewire\Forms\Checkout;

use App\Services\PromoCodeService;
use Livewire\Component;

class CouponForm extends Component
{
    public $coupon_code;
    public $validation_message = '';
    public $validation_type = ''; // 'success', 'error', 'warning'
    public $applied_coupon = null;
    public $discount_amount = 0;
    public $subtotal = 0;
    protected $promoCodeService;

    protected $rules = [
        'coupon_code' => 'required|string|max:50',
    ];

    public function mount()
    {
        $this->promoCodeService = app(PromoCodeService::class);
        
        // Récupérer le code promo appliqué depuis la session
        $this->applied_coupon = $this->promoCodeService->getAppliedCode();
        if ($this->applied_coupon) {
            $this->coupon_code = $this->applied_coupon['code'];
            $this->discount_amount = $this->applied_coupon['discount_amount'];
        }
        
        // Calculer le sous-total depuis le panier
        $this->calculateSubtotal();
    }

    public function applyCoupon()
    {
        $this->validate();
        $this->resetValidationMessages();

        // Utiliser le service pour valider et appliquer le code
        $result = $this->promoCodeService->applyCode($this->coupon_code, $this->subtotal);
        
        $this->validation_message = $result['message'];
        $this->validation_type = $result['type'];

        if ($result['valid']) {
            $this->applied_coupon = $result['applied_coupon'];
            $this->discount_amount = $result['discount_amount'];
            
            // Émettre un événement pour informer le composant parent
            $this->dispatch('coupon-applied', $this->applied_coupon);
        }
    }

    public function removeCoupon()
    {
        $result = $this->promoCodeService->removeCode();
        
        $this->applied_coupon = null;
        $this->discount_amount = 0;
        $this->coupon_code = '';
        $this->validation_message = $result['message'];
        $this->validation_type = $result['type'];

        // Émettre un événement pour informer le composant parent
        $this->dispatch('coupon-removed');
    }

    private function resetValidationMessages()
    {
        $this->validation_message = '';
        $this->validation_type = '';
    }

    private function calculateSubtotal()
    {
        $cart = session('carts');
        if ($cart && isset($cart['product_uuid'])) {
            $product = \App\Models\Product::whereUuid($cart['product_uuid'])->first();
            if ($product) {
                $quantity = $cart['quantity'] ?? 1;
                $this->subtotal = $product->price * $quantity;
            }
        }
    }
    
    public function render()
    {
        return view('livewire.forms.checkout.coupon-form');
    }
}
