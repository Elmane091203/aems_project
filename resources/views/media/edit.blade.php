@extends('layouts.app')

@section('title', 'Modifier le Média - AEMS')
@section('page-title', 'Modifier le Média')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="aems-card p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold aems-text-green mb-2">✏️ Modifier le média</h1>
            <p class="text-gray-600">Modifiez les informations de votre média</p>
        </div>

        <form method="POST" action="{{ route('media.update', $media) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Current Media Preview -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Média actuel
                </label>
                <div class="w-full max-w-md mx-auto">
                    @if($media->file_type === 'image')
                        <img src="{{ $media->url }}" 
                             alt="{{ $media->alt_text }}" 
                             class="w-full h-64 object-cover rounded-lg border">
                    @elseif($media->file_type === 'video')
                        <video class="w-full h-64 object-cover rounded-lg border" controls>
                            <source src="{{ $media->url }}" type="{{ $media->mime_type }}">
                        </video>
                    @endif
                </div>
                <p class="mt-2 text-sm text-gray-500 text-center">
                    {{ $media->file_name }} ({{ $media->file_type === 'image' ? '📸 Image' : '🎥 Vidéo' }})
                </p>
            </div>

            <!-- New File (Optional) -->
            <div class="mb-6">
                <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                    Nouveau fichier (optionnel)
                </label>
                <input type="file" 
                       id="file" 
                       name="file" 
                       accept="{{ $media->file_type === 'image' ? 'image/*' : 'video/*' }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('file') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">
                    Laissez vide pour conserver le fichier actuel
                    @if($media->file_type === 'image')
                        <br>Formats acceptés: JPEG, PNG, JPG, GIF (max 2MB)
                    @else
                        <br>Formats acceptés: MP4, AVI, MOV (max 10MB)
                    @endif
                </p>
                @error('file')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
                    <option value="actualites" {{ old('category', $media->category) == 'actualites' ? 'selected' : '' }}>Actualités</option>
                    <option value="evenements" {{ old('category', $media->category) == 'evenements' ? 'selected' : '' }}>Événements</option>
                    <option value="culture" {{ old('category', $media->category) == 'culture' ? 'selected' : '' }}>Culture</option>
                    <option value="social" {{ old('category', $media->category) == 'social' ? 'selected' : '' }}>Social</option>
                    <option value="academique" {{ old('category', $media->category) == 'academique' ? 'selected' : '' }}>Académique</option>
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
                        <option value="{{ $i }}" {{ old('year', $media->year) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                @error('year')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Alt Text -->
            <div class="mb-6">
                <label for="alt_text" class="block text-sm font-medium text-gray-700 mb-2">
                    Texte alternatif
                </label>
                <input type="text" 
                       id="alt_text" 
                       name="alt_text" 
                       value="{{ old('alt_text', $media->alt_text) }}"
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
                          placeholder="Légende ou description du média">{{ old('caption', $media->caption) }}</textarea>
                @error('caption')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- File Info -->
            <div class="mb-8 bg-gray-50 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">Informations du fichier</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Nom du fichier:</span>
                        <span class="text-gray-600">{{ $media->file_name }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Type:</span>
                        <span class="text-gray-600">{{ $media->file_type === 'image' ? 'Image' : 'Vidéo' }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Format:</span>
                        <span class="text-gray-600">{{ $media->mime_type }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Ajouté le:</span>
                        <span class="text-gray-600">{{ $media->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('media.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
                
                <div class="flex space-x-3">
                    <button type="submit" class="aems-year-button">
                        Mettre à jour
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
