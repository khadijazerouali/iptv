<div class="row">
    <div class="col-md-3">
        @include('partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <h2>Gestion des types d'appareils</h2>
        @if (session()->has('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <button wire:click="create()" class="btn btn-primary mb-3">Ajouter un type</button>
        @if($isOpen)
            <div class="modal show d-block" tabindex="-1" style="background: rgba(0,0,0,0.3);">
                <div class="modal-dialog">
                    <div class="modal-content p-4">
                        <h5 class="modal-title mb-3">{{ $deviceType_id ? 'Modifier' : 'Ajouter' }} un type d'appareil</h5>
                        <input type="text" wire:model="name" placeholder="Nom du type" class="form-control mb-3">
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        <div class="d-flex justify-content-end">
                            <button wire:click="store" class="btn btn-success me-2">Enregistrer</button>
                            <button wire:click="closeModal" class="btn btn-secondary">Annuler</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($this->deviceTypes) && count($this->deviceTypes) > 0)
                    @foreach($this->deviceTypes as $type)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $type->name }}</td>
                            <td>
                                <button wire:click="edit('{{ $type->uuid }}')" class="btn btn-warning btn-sm">Modifier</button>
                                <button wire:click="delete('{{ $type->uuid }}')" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center text-muted">Aucun type d'appareil trouvé.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
