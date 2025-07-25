@extends('layouts.admin')

@section('title', 'Modifier le produit')

@section('content')
<div class="page-header fade-in">
    <h1 class="page-title">
        <i class="fas fa-edit"></i> Modifier le produit
    </h1>
    <div class="page-actions">
        <a href="{{ route('admin.products') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<div class="admin-container-full">
    <div class="admin-card slide-in">
        <div class="card-header">
            <h5><i class="fas fa-edit"></i> Informations du produit</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->uuid) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Nom du produit *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $product->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_uuid" class="form-label">Catégorie *</label>
                            <select class="form-select @error('category_uuid') is-invalid @enderror" 
                                    id="category_uuid" name="category_uuid" required>
                                <option value="">Choisir une catégorie...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->uuid }}" 
                                            {{ old('category_uuid', $product->category_uuid) == $cat->uuid ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_uuid')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">Type de produit *</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">Choisir un type...</option>
                                <option value="subscription" {{ old('type', $product->type) == 'subscription' ? 'selected' : '' }}>Abonnement</option>
                                <option value="one_time" {{ old('type', $product->type) == 'one_time' ? 'selected' : '' }}>Achat unique</option>
                                <option value="trial" {{ old('type', $product->type) == 'trial' ? 'selected' : '' }}>Essai gratuit</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="paused" {{ old('status', $product->status) == 'paused' ? 'selected' : '' }}>En pause</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image du produit</label>
                    <div class="image-upload-container">
                        <div class="image-preview" id="imagePreview">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Image du produit" class="preview-image">
                                <button type="button" class="btn-remove-image" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            @else
                                <div class="image-placeholder">
                                    <i class="fas fa-image"></i>
                                    <p>Aucune image sélectionnée</p>
                                </div>
                            @endif
                        </div>
                        <div class="image-upload-controls">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Formats acceptés : JPG, PNG, GIF. Taille max : 2MB
                            </small>
                            @if($product->image)
                                <div class="mt-2">
                                    <small class="text-info">
                                        <i class="fas fa-info-circle"></i> 
                                        Image actuelle : {{ basename($product->image) }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="6" 
                              placeholder="Description détaillée du produit...">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Durées & prix *</label>
                    <div id="durations-list">
                        @php $options = old('options', $product->productOptions->toArray() ?? []); @endphp
                        @foreach($options as $i => $option)
                            <div class="row mb-2 duration-row">
                                <div class="col-md-5">
                                    <input type="text" name="options[{{ $i }}][name]" 
                                           value="{{ $option['name'] ?? '' }}" class="form-control" 
                                           placeholder="Durée (ex: 1 mois)" required>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="options[{{ $i }}][price]" 
                                               value="{{ $option['price'] ?? '' }}" class="form-control" 
                                               placeholder="Prix" required>
                                        <span class="input-group-text">€</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-remove-duration">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                        @if(empty($options))
                            <div class="row mb-2 duration-row">
                                <div class="col-md-5">
                                    <input type="text" name="options[0][name]" class="form-control" 
                                           placeholder="Durée (ex: 1 mois)" required>
                                </div>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="options[0][price]" 
                                               class="form-control" placeholder="Prix" required>
                                        <span class="input-group-text">€</span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-remove-duration">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary" id="add-duration">
                        <i class="fas fa-plus"></i> Ajouter une durée
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label">Appareils compatibles</label>
                    <div class="devices-grid">
                        @foreach($deviceTypes as $device)
                            <div class="device-checkbox">
                                <input type="checkbox" id="device_{{ $device->uuid }}" 
                                       name="devices[]" value="{{ $device->uuid }}" 
                                       class="form-check-input @error('devices') is-invalid @enderror"
                                       {{ in_array($device->uuid, old('devices', $product->devices->pluck('uuid')->toArray())) ? 'checked' : '' }}>
                                <label for="device_{{ $device->uuid }}" class="form-check-label">
                                    {{ $device->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('devices')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser TinyMCE
    tinymce.init({
        selector: '#description',
        height: 300,
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
    });

    let durationIndex = document.querySelectorAll('.duration-row').length;
    
    document.getElementById('add-duration').addEventListener('click', function() {
        const list = document.getElementById('durations-list');
        const row = document.createElement('div');
        row.className = 'row mb-2 duration-row';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="options[${durationIndex}][name]" class="form-control" 
                       placeholder="Durée (ex: 1 mois)" required>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <input type="number" step="0.01" name="options[${durationIndex}][price]" 
                           class="form-control" placeholder="Prix" required>
                    <span class="input-group-text">€</span>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-remove-duration">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        list.appendChild(row);
        durationIndex++;
    });
    
    document.getElementById('durations-list').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-duration') || 
            e.target.closest('.btn-remove-duration')) {
            const row = e.target.closest('.duration-row');
            if (document.querySelectorAll('.duration-row').length > 1) {
                row.remove();
            } else {
                showNotification('Au moins une durée est requise', 'warning');
            }
        }
    });
});

// Fonction de prévisualisation d'image
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const file = input.files[0];
    
    if (file) {
        // Vérifier la taille du fichier (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            alert('Le fichier est trop volumineux. Taille maximum : 2MB');
            input.value = '';
            return;
        }
        
        // Vérifier le type de fichier
        if (!file.type.startsWith('image/')) {
            alert('Veuillez sélectionner un fichier image valide');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" alt="Aperçu de l'image" class="preview-image">
                <button type="button" class="btn-remove-image" onclick="removeImage()">
                    <i class="fas fa-times"></i>
                </button>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        // Si aucun fichier sélectionné, afficher l'image existante ou le placeholder
        @if($product->image)
            preview.innerHTML = `
                <img src="{{ asset('storage/' . $product->image) }}" alt="Image du produit" class="preview-image">
                <button type="button" class="btn-remove-image" onclick="removeImage()">
                    <i class="fas fa-times"></i>
                </button>
            `;
        @else
            preview.innerHTML = `
                <div class="image-placeholder">
                    <i class="fas fa-image"></i>
                    <p>Aucune image sélectionnée</p>
                </div>
            `;
        @endif
    }
}

// Fonction pour supprimer l'image
function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').innerHTML = `
        <div class="image-placeholder">
            <i class="fas fa-image"></i>
            <p>Aucune image sélectionnée</p>
        </div>
    `;
}
</script>
@endpush

@push('styles')
<style>
.admin-container-full {
    padding: 20px;
    width: 100%;
}

.form-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
    margin-top: 20px;
}

.duration-row {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.duration-row:hover {
    background: #e9ecef;
    transition: background-color 0.3s ease;
}

#add-duration {
    margin-top: 10px;
}

.btn-remove-duration {
    width: 100%;
}

.devices-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 10px;
}

.device-checkbox {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 6px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.device-checkbox:hover {
    background: #e9ecef;
    border-color: #dee2e6;
}

.device-checkbox input[type="checkbox"] {
    margin: 0;
}

.device-checkbox label {
    margin: 0;
    cursor: pointer;
    font-weight: 500;
}

/* Styles pour l'upload d'image */
.image-upload-container {
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.image-preview {
    width: 200px;
    height: 150px;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

.image-preview:hover {
    border-color: #667eea;
    background: #f0f2ff;
}

.image-placeholder {
    text-align: center;
    color: #6c757d;
}

.image-placeholder i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.image-placeholder p {
    margin: 0;
    font-size: 0.9rem;
}

.preview-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.btn-remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-remove-image:hover {
    background: #dc3545;
    transform: scale(1.1);
}

.image-upload-controls {
    flex: 1;
}

/* TinyMCE custom styles */
.tox-tinymce {
    border-radius: 6px !important;
    border-color: #dee2e6 !important;
}

.tox .tox-toolbar {
    background-color: #f8f9fa !important;
    border-bottom: 1px solid #dee2e6 !important;
}

@media (max-width: 768px) {
    .image-upload-container {
        flex-direction: column;
    }
    
    .image-preview {
        width: 100%;
        height: 200px;
    }
}
</style>
@endpush 