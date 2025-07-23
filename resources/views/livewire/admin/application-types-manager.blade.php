<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <h2>Gestion des types d'applications</h2>
            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            <button wire:click="create()" class="btn btn-primary mb-3">Ajouter un type</button>
            @if($isOpen)
                <div class="modal show d-block" tabindex="-1" style="background: rgba(0,0,0,0.3);">
                    <div class="modal-dialog">
                        <div class="modal-content p-4">
                            <h5 class="modal-title mb-3">{{ $applicationType_id ? 'Modifier' : 'Ajouter' }} un type d'application</h5>
                            <input type="text" wire:model="name" placeholder="Nom du type" class="form-control mb-3">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            <select wire:model="devicetype_uuid" class="form-control mb-3">
                                <option value="">-- Choisir un type d'appareil --</option>
                                @foreach($this->devices as $device)
                                    <option value="{{ $device->uuid }}">{{ $device->name }}</option>
                                @endforeach
                            </select>
                            @error('devicetype_uuid') <span class="text-danger">{{ $message }}</span> @enderror
                            @foreach(['deviceid', 'devicekey', 'otpcode', 'smartstbmac'] as $field)
                                <div class="form-check form-switch mb-2">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           id="{{ $field }}"
                                           wire:model="{{ $field }}">
                                    <label class="form-check-label" for="{{ $field }}">
                                        {{ ucfirst($field) }}
                                    </label>
                                </div>
                            @endforeach
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
                        <th>Appareil</th>
                        <th>deviceid</th>
                        <th>devicekey</th>
                        <th>otpcode</th>
                        <th>smartstbmac</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applicationTypes as $type)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ optional($type->devicetype)->name ?? $type->devicetype_uuid }}</td>
                            @foreach(['deviceid', 'devicekey', 'otpcode', 'smartstbmac'] as $field)
                                <td>
                                    @if($type->$field)
                                        <span class="badge bg-success">True</span>
                                    @else
                                        <span class="badge bg-secondary">False</span>
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                <button wire:click="edit('{{ $type->uuid }}')" class="btn btn-warning btn-sm">Modifier</button>
                                <button wire:click="delete('{{ $type->uuid }}')" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>