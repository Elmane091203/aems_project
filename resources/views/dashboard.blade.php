@extends('layouts.app')

@section('title', 'Dashboard - AEMS')
@section('page-title', 'Dashboard')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="aems-card p-8">
        <div class="text-center">
            <h1 class="text-3xl font-bold aems-text-green mb-4">🎉 Bienvenue sur votre Dashboard AEMS</h1>
            <p class="text-gray-600 mb-6">Vous êtes connecté avec succès ! Gérez votre contenu et vos activités.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="aems-card p-6 text-center">
                    <div class="text-3xl mb-3">📝</div>
                    <h3 class="text-lg font-semibold aems-text-green mb-2">Articles</h3>
                    <p class="text-gray-600 text-sm">Gérez vos publications</p>
                    <a href="{{ route('posts.index') }}" class="aems-year-button mt-4 inline-block">
                        Voir les articles
                    </a>
                </div>
                
                <div class="aems-card p-6 text-center">
                    <div class="text-3xl mb-3">📅</div>
                    <h3 class="text-lg font-semibold aems-text-green mb-2">Événements</h3>
                    <p class="text-gray-600 text-sm">Planifiez vos activités</p>
                    <a href="{{ route('events.index') }}" class="aems-year-button mt-4 inline-block">
                        Voir les événements
                    </a>
                </div>
                
                <div class="aems-card p-6 text-center">
                    <div class="text-3xl mb-3">🎬</div>
                    <h3 class="text-lg font-semibold aems-text-green mb-2">Médias</h3>
                    <p class="text-gray-600 text-sm">Partagez vos contenus</p>
                    <a href="{{ route('media.index') }}" class="aems-year-button mt-4 inline-block">
                        Voir les médias
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
