@extends('layouts.app')

@section('title', 'Accueil - AEMS')
@section('page-title', 'Accueil')

@section('content')
<!-- Hero Section -->
<div class="aems-hero rounded-lg mb-8">
    <div class="text-center">
        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-4">Découvrez</h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto px-4">
            nos moments marquants en photos et vidéos, depuis la création de l'association.
        </p>
    </div>
</div>

<!-- Featured Content -->
<div class="aems-grid aems-grid-2 gap-6 md:gap-8 mb-8">
    <!-- Featured Posts -->
    <div class="aems-card p-6">
        <h2 class="text-xl md:text-2xl font-bold aems-text-green mb-4">📰 Derniers Articles</h2>
        @if($featuredPosts->count() > 0)
            <div class="space-y-4">
                @foreach($featuredPosts as $post)
                    <div class="border-l-4 border-orange-400 pl-4">
                        <h3 class="font-semibold text-lg mb-1">
                            <a href="{{ route('posts.show', $post) }}" class="aems-hover-orange">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $post->excerpt }}</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>Par {{ $post->user->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $post->published_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Aucun article disponible pour le moment.</p>
        @endif
    </div>

    <!-- Upcoming Events -->
    <div class="aems-card p-6">
        <h2 class="text-xl md:text-2xl font-bold aems-text-green mb-4">📅 Prochains Événements</h2>
        @if($upcomingEvents->count() > 0)
            <div class="space-y-4">
                @foreach($upcomingEvents as $event)
                    <div class="border-l-4 border-green-400 pl-4">
                        <h3 class="font-semibold text-lg mb-1">
                            <a href="{{ route('events.show', $event) }}" class="aems-hover-orange">
                                {{ $event->title }}
                            </a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-2">{{ Str::limit($event->description, 100) }}</p>
                        <div class="flex items-center text-xs text-gray-500">
                            <span>📅 {{ $event->start_date->format('d/m/Y H:i') }}</span>
                            <span class="mx-2">•</span>
                            <span>📍 {{ $event->location }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Aucun événement à venir pour le moment.</p>
        @endif
    </div>
</div>

<!-- Featured Media Gallery -->
@if($featuredMedia->count() > 0)
    <div class="aems-card p-6">
        <h2 class="text-xl md:text-2xl font-bold aems-text-green mb-6">📸 Galerie en vedette</h2>
        <div class="aems-grid aems-grid-6 gap-4">
            @foreach($featuredMedia as $media)
                <div class="aspect-square overflow-hidden rounded-lg">
                    @if($media->file_type === 'image')
                        <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    @elseif($media->file_type === 'video')
                        <video class="w-full h-full object-cover" controls>
                            <source src="{{ $media->url }}" type="{{ $media->mime_type }}">
                        </video>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- Quick Access -->
<div class="aems-grid aems-grid-3 gap-4 md:gap-6 mt-8">
    <a href="{{ route('photos') }}" class="aems-card p-6 text-center hover:shadow-lg transition-shadow">
        <div class="text-4xl mb-3">📸</div>
        <h3 class="text-xl font-semibold aems-text-green mb-2">Photos</h3>
        <p class="text-gray-600">Découvrez nos archives photos par année</p>
    </a>
    
    <a href="{{ route('videos') }}" class="aems-card p-6 text-center hover:shadow-lg transition-shadow">
        <div class="text-4xl mb-3">🎥</div>
        <h3 class="text-xl font-semibold aems-text-green mb-2">Vidéos</h3>
        <p class="text-gray-600">Regardez nos vidéos et moments marquants</p>
    </a>
    
    <a href="{{ route('about') }}" class="aems-card p-6 text-center hover:shadow-lg transition-shadow">
        <div class="text-4xl mb-3">ℹ️</div>
        <h3 class="text-xl font-semibold aems-text-green mb-2">À propos</h3>
        <p class="text-gray-600">En savoir plus sur notre association</p>
    </a>
</div>
@endsection
