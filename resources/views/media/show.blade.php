@extends('layouts.app')

@section('title', 'Média - AEMS')
@section('page-title', 'Média')

@section('content')
<div class="w-full">
    <div class="aems-card overflow-hidden">
        <div class="p-8">
            <!-- Media Display -->
            <div class="text-center mb-8">
                @if($media->file_type === 'image')
                    <img src="{{ $media->url }}" 
                         alt="{{ $media->alt_text }}" 
                         class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg">
                @elseif($media->file_type === 'video')
                    <video class="max-w-full max-h-96 mx-auto rounded-lg shadow-lg" controls>
                        <source src="{{ $media->url }}" type="{{ $media->mime_type }}">
                        Votre navigateur ne supporte pas la lecture vidéo.
                    </video>
                @endif
            </div>

            <!-- Media Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h1 class="text-3xl font-bold aems-text-green mb-4">
                        {{ $media->caption ?: 'Média sans titre' }}
                    </h1>

                    @if($media->caption)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-700">{{ $media->caption }}</p>
                        </div>
                    @endif

                    <!-- Media Details -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011 1v18a1 1 0 01-1 1H6a1 1 0 01-1-1V2a1 1 0 011-1h8v2z"></path>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Type:</span>
                                <span class="ml-2 text-gray-600">
                                    {{ $media->file_type === 'image' ? '📸 Image' : '🎥 Vidéo' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2m0 0V1a1 1 0 011 1v18a1 1 0 01-1 1H6a1 1 0 01-1-1V2a1 1 0 011-1h8v2z"></path>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Format:</span>
                                <span class="ml-2 text-gray-600">{{ $media->mime_type }}</span>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Année:</span>
                                <span class="ml-2 text-gray-600">{{ $media->year }}</span>
                            </div>
                        </div>

                        @if($media->category)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <div>
                                    <span class="font-semibold text-gray-900">Catégorie:</span>
                                    <span class="ml-2 text-gray-600">{{ ucfirst($media->category) }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Ajouté le:</span>
                                <span class="ml-2 text-gray-600">{{ $media->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <!-- Uploader Information -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ajouté par</h3>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-4">
                                <span class="text-gray-600 font-semibold">{{ substr($media->user->name, 0, 1) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $media->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $media->user->email }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $media->user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                                       ($media->user->role === 'member' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $media->user->role === 'admin' ? 'Administrateur' : 
                                       ($media->user->role === 'member' ? 'Membre' : 'Visiteur') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- File Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informations du fichier</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nom du fichier:</span>
                                <span class="font-medium">{{ $media->file_name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Taille:</span>
                                <span class="font-medium">{{ number_format($media->file_size / 1024 / 1024, 2) }} MB</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dimensions:</span>
                                <span class="font-medium">
                                    @if($media->file_type === 'image' && $media->width && $media->height)
                                        {{ $media->width }} × {{ $media->height }} px
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || (auth()->user()->isMember() && $media->user_id === auth()->id()))
                    <div class="flex items-center justify-between pt-6 border-t mt-8">
                        <a href="{{ route('media.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← Retour aux médias
                        </a>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('media.edit', $media) }}" class="aems-year-button">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('media.destroy', $media) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="pt-6 border-t mt-8">
                        <a href="{{ route('media.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← Retour aux médias
                        </a>
                    </div>
                @endif
            @else
                <div class="pt-6 border-t mt-8">
                    <a href="{{ route('media.index') }}" class="text-gray-600 hover:text-gray-800">
                        ← Retour aux médias
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
