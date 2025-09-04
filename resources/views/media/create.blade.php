@extends('layouts.app')

@section('title', 'Ajouter des Médias - AEMS')
@section('page-title', 'Ajouter des Médias')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="aems-card p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold aems-text-green mb-2">📸 Ajouter des médias</h1>
            <p class="text-gray-600">Partagez vos photos et vidéos avec la communauté AEMS</p>
        </div>

        <form method="POST" action="{{ route('media.store') }}" enctype="multipart/form-data" id="mediaForm">
            @csrf
            
            <!-- File Upload -->
            <div class="mb-6">
                <label for="files" class="block text-sm font-medium text-gray-700 mb-2">
                    Sélectionner des fichiers *
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-orange-500 transition-colors">
                    <input type="file" 
                           id="files" 
                           name="files[]" 
                           multiple
                           accept="image/*,video/*"
                           class="hidden"
                           required>
                    <div id="dropZone" class="cursor-pointer">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <p class="text-lg text-gray-600 mb-2">Glissez-déposez vos fichiers ici</p>
                        <p class="text-sm text-gray-500 mb-4">ou cliquez pour sélectionner</p>
                        <button type="button" onclick="document.getElementById('files').click()" class="aems-year-button">
                            Choisir des fichiers
                        </button>
                        <p class="text-xs text-gray-400 mt-2">
                            Formats acceptés: JPEG, PNG, JPG, GIF, MP4, AVI, MOV (max 10MB par fichier)
                        </p>
                    </div>
                </div>
                @error('files')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('files.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Preview -->
            <div id="filePreview" class="mb-6 hidden">
                <h3 class="text-lg font-semibold aems-text-green mb-4">Aperçu des fichiers</h3>
                <div id="previewGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <!-- File previews will be populated by JavaScript -->
                </div>
            </div>

            <!-- Category -->
            <div class="mb-6">
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                    Catégorie *
                </label>
                <select id="category" 
                        name="category" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('category') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionnez une catégorie</option>
                    <option value="actualites" {{ old('category') == 'actualites' ? 'selected' : '' }}>Actualités</option>
                    <option value="evenements" {{ old('category') == 'evenements' ? 'selected' : '' }}>Événements</option>
                    <option value="culture" {{ old('category') == 'culture' ? 'selected' : '' }}>Culture</option>
                    <option value="social" {{ old('category') == 'social' ? 'selected' : '' }}>Social</option>
                    <option value="academique" {{ old('category') == 'academique' ? 'selected' : '' }}>Académique</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Year -->
            <div class="mb-6">
                <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                    Année *
                </label>
                <select id="year" 
                        name="year" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('year') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionnez une année</option>
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ old('year', date('Y')) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alt Text (for images) -->
            <div class="mb-6">
                <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-2">
                    Texte alternatif (pour les images)
                </label>
                <input type="text" 
                       id="alt_text" 
                       name="alt_text" 
                       value="{{ old('alt_text') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('alt_text') border-red-500 @enderror"
                       placeholder="Description courte pour l'accessibilité">
                <p class="mt-1 text-sm text-gray-500">Description courte pour l'accessibilité (optionnel)</p>
                @error('alt_text')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Caption -->
            <div class="mb-6">
                <label for="caption" class="block text-sm font-medium text-gray-700 mb-2">
                    Légende
                </label>
                <textarea id="caption" 
                          name="caption" 
                          rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('caption') border-red-500 @enderror"
                          placeholder="Légende ou description des médias (optionnel)">{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('media.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
                
                <button type="submit" class="aems-year-button" id="submitBtn" disabled>
                    Ajouter les médias
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let selectedFiles = [];

document.getElementById('files').addEventListener('change', function(e) {
    handleFiles(e.target.files);
});

// Drag and drop functionality
const dropZone = document.getElementById('dropZone');

dropZone.addEventListener('dragover', function(e) {
    e.preventDefault();
    dropZone.classList.add('border-orange-500', 'bg-orange-50');
});

dropZone.addEventListener('dragleave', function(e) {
    e.preventDefault();
    dropZone.classList.remove('border-orange-500', 'bg-orange-50');
});

dropZone.addEventListener('drop', function(e) {
    e.preventDefault();
    dropZone.classList.remove('border-orange-500', 'bg-orange-50');
    handleFiles(e.dataTransfer.files);
});

function handleFiles(files) {
    selectedFiles = Array.from(files);
    updatePreview();
    updateSubmitButton();
}

function updatePreview() {
    const previewContainer = document.getElementById('filePreview');
    const previewGrid = document.getElementById('previewGrid');
    
    if (selectedFiles.length === 0) {
        previewContainer.classList.add('hidden');
        return;
    }
    
    previewContainer.classList.remove('hidden');
    previewGrid.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const previewItem = document.createElement('div');
        previewItem.className = 'relative border rounded-lg overflow-hidden';
        
        if (file.type.startsWith('image/')) {
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.className = 'w-full h-32 object-cover';
            previewItem.appendChild(img);
        } else if (file.type.startsWith('video/')) {
            const video = document.createElement('video');
            video.src = URL.createObjectURL(file);
            video.className = 'w-full h-32 object-cover';
            video.muted = true;
            previewItem.appendChild(video);
        }
        
        const fileInfo = document.createElement('div');
        fileInfo.className = 'p-2 bg-white';
        fileInfo.innerHTML = `
            <p class="text-xs text-gray-600 truncate">${file.name}</p>
            <p class="text-xs text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
        `;
        previewItem.appendChild(fileInfo);
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600';
        removeBtn.innerHTML = '×';
        removeBtn.onclick = () => removeFile(index);
        previewItem.appendChild(removeBtn);
        
        previewGrid.appendChild(previewItem);
    });
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    updatePreview();
    updateSubmitButton();
}

function updateSubmitButton() {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = selectedFiles.length === 0;
}

// Update file input when files are selected
document.getElementById('files').addEventListener('change', function() {
    // The file input is already updated by the browser
});
</script>
@endpush
@endsection
