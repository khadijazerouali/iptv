<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <h2>Gestion des produits</h2>
            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($showForm)
                <form wire:submit.prevent="save" class="mb-4" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nom du produit</label>
                        <input type="text" class="form-control" wire:model.defer="title" required>
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catégorie</label>
                        <select class="form-select" wire:model.defer="category_uuid" required>
                            <option value="">Choisir...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->uuid }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_uuid') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image du produit</label>
                        <input type="file" class="form-control" wire:model="image" accept="image/*">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                        @if ($image)
                            <div class="mt-2">
                                <img src="{{ $image->temporaryUrl() }}" alt="Aperçu" style="max-width: 150px; max-height: 150px;">
                            </div>
                        @elseif($editMode && isset($products) && $productId)
                            @php
                                $prod = $products->firstWhere('uuid', $productId);
                            @endphp
                            @if($prod && $prod->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $prod->image) }}" alt="Image actuelle" style="max-width: 150px; max-height: 150px;">
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Durées & prix</label>
                        @foreach($options as $i => $option)
                            <div class="row mb-2 align-items-center">
                                <div class="col">
                                    <input type="text" class="form-control" wire:model.defer="options.{{ $i }}.name" placeholder="Durée (ex: 1 mois)" required>
                                </div>
                                <div class="col">
                                    <input type="number" step="0.01" class="form-control" wire:model.defer="options.{{ $i }}.price" placeholder="Prix" required>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-danger" wire:click="removeOption({{ $i }})">Supprimer</button>
                                </div>
                            </div>
                        @endforeach
                        <button type="button" class="btn btn-secondary" wire:click="addOption">Ajouter une durée</button>
                        @error('options') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prix barré (optionnel)</label>
                        <input type="number" step="0.01" class="form-control" wire:model.defer="price_old">
                        @error('price_old') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="description" class="form-control" wire:model.defer="description"></textarea>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type de produit</label>
                        <select class="form-select" wire:model.defer="type" required>
                            <option value="">Choisir...</option>
                            <option value="abonnement">Abonnement</option>
                            <option value="application">Application</option>
                            <option value="renouvellement">Renouvellement</option>
                            <option value="revendeur">Revendeur</option>
                            <option value="testiptv">Test IPTV</option>
                        </select>
                        @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label">Options spécifiques</label>
                        @foreach(['deviceid', 'devicekey', 'otpcode', 'smartstbmac'] as $field)
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input"
                                       type="checkbox"
                                       id="{{ $field }}"
                                       wire:model.defer="{{ $field }}">
                                <label class="form-check-label" for="{{ $field }}">
                                    {{ ucfirst($field) }}
                                </label>
                            </div>
                        @endforeach
                    </div> --}}
                    <div class="mb-3">
                        <label class="form-label">Appareils compatibles</label>
                        <select class="form-select" wire:model.defer="selectedDevices" multiple>
                            @foreach($devices as $device)
                                <option value="{{ $device->uuid }}">{{ $device->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Maintenez Ctrl (Windows) ou Cmd (Mac) pour sélectionner plusieurs appareils.</small>
                        @error('selectedDevices') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Statut</label>
                        <select class="form-select" wire:model.defer="status">
                            <option value="actif">Actif</option>
                            <option value="inactif">Inactif</option>
                        </select>
                        @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">{{ $editMode ? 'Modifier' : 'Ajouter' }}</button>
                    <button type="button" class="btn btn-secondary" wire:click="cancel">Annuler</button>
                </form>
            @else
                <div class="d-flex justify-content-end mb-3">
                    <button class="btn btn-success" wire:click="showCreateForm">+ Ajouter un produit</button>
                </div>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prix min</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->title }}</td>
                                <td>
                                    @php
                                        $minPrice = $product->productOptions && count($product->productOptions) ? collect($product->productOptions)->min('price') : null;
                                    @endphp
                                    {{ $minPrice ? number_format($minPrice, 2) . ' €' : '-' }}
                                </td>
                                <td>{{ $product->status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" wire:click="showEditForm('{{ $product->uuid }}')">Editer</button>
                                    <button class="btn btn-sm btn-danger" wire:click="delete('{{ $product->uuid }}')" onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener('livewire:load', function () {
        tinymce.init({
            selector: '#description',
            setup: function (editor) {
                editor.on('Change KeyUp', function () {
                    @this.set('description', editor.getContent());
                });
                Livewire.hook('message.processed', (message, component) => {
                    if (editor.getContent() !== @this.get('description')) {
                        editor.setContent(@this.get('description') || '');
                    }
                });
            }
        });
    });
</script>
@endpush 