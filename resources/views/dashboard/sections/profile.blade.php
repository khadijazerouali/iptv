<div class="section-header">
    <h2 class="section-title">Mes Informations Personnelles</h2>
    <p class="section-subtitle">Mettez à jour vos données de profil (Email non modifiable)</p>
</div>

<div class="info-card">
    <form action="{{ route('dashboard.updateProfile') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" readonly>
            <small class="form-text text-muted">L'adresse e-mail ne peut pas être modifiée.</small>
        </div>

        <div class="form-group">
            <label for="phone">Téléphone :</label>
            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <label for="ville">Ville :</label>
            <input type="text" id="ville" name="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville', $user->ville) }}">
            @error('ville')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-actions" style="margin-top: 1.5rem; text-align: right;">
            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
    </form>
</div> 