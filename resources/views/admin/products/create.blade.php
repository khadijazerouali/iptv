@extends('layouts.admin')

@section('title', 'Ajouter un produit')

@section('content')
<div class="page-header fade-in">
    <h1 class="page-title">
        <i class="fas fa-plus"></i> Ajouter un produit
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
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Nom du produit *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
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
                                    <option value="{{ $cat->uuid }}" {{ old('category_uuid') == $cat->uuid ? 'selected' : '' }}>
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
                                    id="type" name="type" required onchange="showTypeSpecificFields()">
                                <option value="">Choisir un type...</option>
                                <option value="abonnement" {{ old('type') == 'abonnement' ? 'selected' : '' }}>Abonnement</option>
                                <option value="revendeur" {{ old('type') == 'revendeur' ? 'selected' : '' }}>Revendeur</option>
                                <option value="renouvellement" {{ old('type') == 'renouvellement' ? 'selected' : '' }}>Renouvellement</option>
                                <option value="application" {{ old('type') == 'application' ? 'selected' : '' }}>Application</option>
                                <option value="testiptv" {{ old('type') == 'testiptv' ? 'selected' : '' }}>Test IPTV</option>
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
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="paused" {{ old('status') == 'paused' ? 'selected' : '' }}>En pause</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
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
                            <div class="image-placeholder">
                                <i class="fas fa-image"></i>
                                <p>Aucune image sélectionnée</p>
                            </div>
                        </div>
                        <div class="image-upload-controls">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Formats acceptés : JPG, PNG, GIF. Taille max : 2MB
                            </small>
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
                              placeholder="Description détaillée du produit...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Durées et prix du produit -->
                <div class="mb-4">
                    <h5 class="mb-3">Durées et prix</h5>
                    <div id="durationsContainer">
                        <div class="row mb-2 duration-row">
                            <div class="col-md-4">
                                <input type="text" class="form-control" name="duration_names[]" placeholder="Nom de la durée (ex: 1 mois)" required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" class="form-control" name="duration_prices[]" placeholder="Prix (€)" step="0.01" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeDuration(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success btn-sm" id="add-duration">
                        <i class="fas fa-plus"></i> Ajouter une durée
                    </button>
                </div>

                <!-- Champs spécifiques selon le type -->
                <div id="typeSpecificFields" style="display: none;">
                    
                    <!-- Champs pour Abonnement et Test IPTV -->
                    <div id="abonnementFields" class="type-fields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Appareils compatibles</label>
                            <div class="devices-grid">
                                @foreach($deviceTypes as $device)
                                    <div class="device-checkbox">
                                        <input type="checkbox" id="device_{{ $device->uuid }}" 
                                               name="devices[]" value="{{ $device->uuid }}" 
                                               class="form-check-input @error('devices') is-invalid @enderror"
                                               {{ in_array($device->uuid, old('devices', [])) ? 'checked' : '' }}>
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

                        <!-- Bouquets de chaînes -->
                        <div class="mb-3">
                            <label class="form-label">Bouquets de chaînes disponibles :</label>
                            <div class="row">
                                @foreach($channels as $channel)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="channels[]" value="{{ $channel->uuid }}" id="channel_{{ $channel->uuid }}">
                                        <label class="form-check-label" for="channel_{{ $channel->uuid }}">
                                            {{ $channel->title }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- VOD disponibles -->
                        <div class="mb-3">
                            <label class="form-label">Vidéos à la demande disponibles :</label>
                            <div class="row">
                                @foreach($vods as $vod)
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="vods[]" value="{{ $vod->uuid }}" id="vod_{{ $vod->uuid }}">
                                        <label class="form-check-label" for="vod_{{ $vod->uuid }}">
                                            {{ $vod->title }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Champs pour Revendeur -->
                    <div id="revendeurFields" class="type-fields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Informations revendeur</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="revendeur_info" 
                                           placeholder="Informations spécifiques au revendeur" 
                                           value="{{ old('revendeur_info') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Champs pour Renouvellement -->
                    <div id="renouvellementFields" class="type-fields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Informations renouvellement</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="renouvellement_info" 
                                           placeholder="Informations spécifiques au renouvellement" 
                                           value="{{ old('renouvellement_info') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Champs pour Application -->
                    <div id="applicationFields" class="type-fields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label">Informations application</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="application_info" 
                                           placeholder="Informations spécifiques à l'application" 
                                           value="{{ old('application_info') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Créer le produit
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

    // Afficher les champs spécifiques au type sélectionné
    showTypeSpecificFields();
});

// Fonction pour afficher les champs spécifiques selon le type
function showTypeSpecificFields() {
    const type = document.getElementById('type').value;
    const typeSpecificFields = document.getElementById('typeSpecificFields');
    const allTypeFields = document.querySelectorAll('.type-fields');
    
    // Masquer tous les champs spécifiques
    allTypeFields.forEach(field => field.style.display = 'none');
    
    if (type) {
        typeSpecificFields.style.display = 'block';
        
        switch(type) {
            case 'abonnement':
            case 'testiptv':
                document.getElementById('abonnementFields').style.display = 'block';
                break;
            case 'revendeur':
                document.getElementById('revendeurFields').style.display = 'block';
                break;
            case 'renouvellement':
                document.getElementById('renouvellementFields').style.display = 'block';
                break;
            case 'application':
                document.getElementById('applicationFields').style.display = 'block';
                break;
        }
    } else {
        typeSpecificFields.style.display = 'none';
    }
}

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
        preview.innerHTML = `
            <div class="image-placeholder">
                <i class="fas fa-image"></i>
                <p>Aucune image sélectionnée</p>
            </div>
        `;
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

// Fonction pour ajouter une durée
function addDuration() {
    const container = document.getElementById('durationsContainer');
    const newRow = document.createElement('div');
    newRow.className = 'row mb-2 duration-row';
    newRow.innerHTML = `
        <div class="col-md-4">
            <input type="text" class="form-control" name="duration_names[]" placeholder="Nom de la durée (ex: 1 mois)" required>
        </div>
        <div class="col-md-4">
            <input type="number" class="form-control" name="duration_prices[]" placeholder="Prix (€)" step="0.01" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="removeDuration(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(newRow);
}

// Fonction pour supprimer une durée
function removeDuration(button) {
    const row = button.closest('.duration-row');
    if (document.querySelectorAll('.duration-row').length > 1) {
        row.remove();
    } else {
        alert('Vous devez avoir au moins une durée définie.');
    }
}

// Ajouter l'événement pour le bouton d'ajout de durée
document.addEventListener('DOMContentLoaded', function() {
    const addDurationBtn = document.getElementById('add-duration');
    if (addDurationBtn) {
        addDurationBtn.addEventListener('click', addDuration);
    }
});
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