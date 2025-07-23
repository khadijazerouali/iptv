@extends('layouts.main')
@section('title', 'Ajouter un produit')
@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <h2>Ajouter un produit</h2>
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Nom du produit</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="category_uuid" class="form-label">Catégorie</label>
                    <select class="form-select" id="category_uuid" name="category_uuid" required>
                        <option value="">Choisir...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->uuid }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Durées & prix</label>
                    <div id="durations-list">
                        @if(old('options'))
                            @foreach(old('options') as $i => $option)
                                <div class="row mb-2 duration-row">
                                    <div class="col">
                                        <input type="text" name="options[{{ $i }}][name]" value="{{ $option['name'] }}" class="form-control" placeholder="Durée (ex: 1 mois)" required>
                                    </div>
                                    <div class="col">
                                        <input type="number" step="0.01" name="options[{{ $i }}][price]" value="{{ $option['price'] }}" class="form-control" placeholder="Prix" required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger btn-remove-duration">Supprimer</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-2 duration-row">
                                <div class="col">
                                    <input type="text" name="options[0][name]" class="form-control" placeholder="Durée (ex: 1 mois)" required>
                                </div>
                                <div class="col">
                                    <input type="number" step="0.01" name="options[0][price]" class="form-control" placeholder="Prix" required>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-danger btn-remove-duration">Supprimer</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-duration">Ajouter une durée</button>
                </div>
                <div class="mb-3">
                    <label for="devices" class="form-label">Appareils compatibles</label>
                    <select class="form-select" id="devices" name="devices[]" multiple>
                        @foreach($devices as $device)
                            <option value="{{ $device->uuid }}">{{ $device->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs appareils.</small>
                </div>
                {{-- Champ prix global supprimé, chaque durée a son propre prix --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="actif">Actif</option>
                        <option value="inactif">Inactif</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let durationIndex = document.querySelectorAll('.duration-row').length;
    document.getElementById('add-duration').addEventListener('click', function() {
        const list = document.getElementById('durations-list');
        const row = document.createElement('div');
        row.className = 'row mb-2 duration-row';
        row.innerHTML = `
            <div class="col">
                <input type="text" name="options[${durationIndex}][name]" class="form-control" placeholder="Durée (ex: 1 mois)" required>
            </div>
            <div class="col">
                <input type="number" step="0.01" name="options[${durationIndex}][price]" class="form-control" placeholder="Prix" required>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-danger btn-remove-duration">Supprimer</button>
            </div>
        `;
        list.appendChild(row);
        durationIndex++;
    });
    document.getElementById('durations-list').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-duration')) {
            e.target.closest('.duration-row').remove();
        }
    });
});
</script>
@endpush 