<form wire:submit.prevent="applyCoupon">
    <p>Si vous possédez un code promo, veuillez l’appliquer ci-dessous.</p>
    <div class="mb-3">
        <label for="coupon_code">Code promo *</label>
        <input type="text" class="form-control" id="coupon_code" name="coupon_code" wire:model="coupon_code" required>
        @error('coupon_code') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100 mt-3">Appliquer le code promo</button>
    </div>
</form>