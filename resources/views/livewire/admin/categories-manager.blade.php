<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            @include('partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            <h2>Gestion des catégories</h2>
            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form wire:submit.prevent="save" class="mb-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" wire:model.defer="name" placeholder="Nom de la catégorie" required>
                    <button class="btn btn-primary" type="submit">Ajouter</button>
                </div>
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
            </form>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cat->name }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger" wire:click="delete('{{ $cat->uuid }}')" onclick="return confirm('Supprimer cette catégorie ?')">Supprimer</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> 