@extends('layouts.app')

@section('title', 'Nouvel Article - AEMS')
@section('page-title', 'Nouvel Article')

@section('content')
<div class="w-full">
    <div class="aems-card p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold aems-text-green mb-2">📝 Créer un nouvel article</h1>
            <p class="text-gray-600">Partagez vos idées et actualités avec la communauté AEMS</p>
        </div>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre de l'article *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('title') border-red-500 @enderror"
                       placeholder="Entrez le titre de votre article"
                       required>
                @error('title')
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
                    <option value="actualites" {{ old('category') == 'actualites' ? 'selected' : '' }}>Actualités</option>
                    <option value="social" {{ old('category') == 'social' ? 'selected' : '' }}>Social</option>
                    <option value="culture" {{ old('category') == 'culture' ? 'selected' : '' }}>Culture</option>
                    <option value="academique" {{ old('category') == 'academique' ? 'selected' : '' }}>Académique</option>
                </select>
                @error('category')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div class="mb-6">
                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">
                    Résumé
                </label>
                <textarea id="excerpt" 
                          name="excerpt" 
                          rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('excerpt') border-red-500 @enderror"
                          placeholder="Résumé court de l'article (optionnel)">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                    Contenu de l'article *
                </label>
                <textarea id="content" 
                          name="content" 
                          rows="12"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('content') border-red-500 @enderror"
                          placeholder="Rédigez le contenu de votre article..."
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags -->
            <div class="mb-6">
                <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">
                    Tags
                </label>
                <input type="text" 
                       id="tags" 
                       name="tags" 
                       value="{{ old('tags') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('tags') border-red-500 @enderror"
                       placeholder="Séparez les tags par des virgules (ex: aems, culture, événement)">
                <p class="mt-1 text-sm text-gray-500">Séparez les tags par des virgules</p>
                @error('tags')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image -->
            <div class="mb-6">
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Image de couverture
                </label>
                <input type="file" 
                       id="featured_image" 
                       name="featured_image" 
                       accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('featured_image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Formats acceptés: JPEG, PNG, JPG, GIF (max 2MB)</p>
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="mb-8">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Statut de publication *
                </label>
                <select id="status" 
                        name="status" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('status') border-red-500 @enderror"
                        required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publier immédiatement</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
                
                <div class="flex space-x-3">
                    <button type="submit" name="status" value="draft" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">
                        Enregistrer comme brouillon
                    </button>
                    <button type="submit" name="status" value="published" class="aems-year-button">
                        Publier l'article
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
