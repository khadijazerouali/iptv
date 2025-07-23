<form wire:submit.prevent="submit">
    <div class="mb-3">
        <label for="email">E-mail *</label>
        <input type="email" class="form-control" id="email" name="email" wire:model="email" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <label for="password">Mot de passe *</label>
        <input type="password" class="form-control" id="password" name="password" wire:model="password" required>
        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary w-100 mt-3">Se connecter</button>
    </div>
</form>