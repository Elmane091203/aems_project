@extends('layouts.app')

@section('title', 'Événements - AEMS')
@section('page-title', 'Événements')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold aems-text-green">📅 Événements</h1>
        @auth
            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                <a href="{{ route('events.create') }}" class="aems-year-button">
                    Nouvel Événement
                </a>
            @endif
        @endauth
    </div>

    <!-- Filters -->
    <div class="aems-card p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type d'événement</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous les types</option>
                    <option value="culturelle" {{ request('type') == 'culturelle' ? 'selected' : '' }}>Culturelle</option>
                    <option value="sociale" {{ request('type') == 'sociale' ? 'selected' : '' }}>Sociale</option>
                    <option value="academique" {{ request('type') == 'academique' ? 'selected' : '' }}>Académique</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Année</label>
                <select name="year" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Toutes les années</option>
                    @for($i = date('Y'); $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="upcoming" {{ request('status', 'upcoming') == 'upcoming' ? 'selected' : '' }}>À venir</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>En cours</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminés</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulés</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="aems-year-button w-full">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Events Grid -->
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="aems-card overflow-hidden">
                    @if($event->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset('storage/' . $event->featured_image) }}" 
                                 alt="{{ $event->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="aspect-video bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center">
                            <div class="text-white text-center">
                                <div class="text-4xl mb-2">📅</div>
                                <div class="text-sm font-semibold">{{ $event->event_type }}</div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $event->event_type === 'culturelle' ? 'bg-purple-100 text-purple-800' : 
                                   ($event->event_type === 'sociale' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                {{ ucfirst($event->event_type) }}
                            </span>
                            
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 
                                   ($event->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($event->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $event->status === 'upcoming' ? 'À venir' : 
                                   ($event->status === 'ongoing' ? 'En cours' : 
                                   ($event->status === 'completed' ? 'Terminé' : 'Annulé')) }}
                            </span>
                        </div>

                        <h3 class="text-xl font-semibold aems-text-green mb-3">
                            <a href="{{ route('events.show', $event) }}" class="hover:text-orange-500">
                                {{ $event->title }}
                            </a>
                        </h3>

                        <p class="text-gray-600 mb-4">{{ Str::limit($event->description, 120) }}</p>

                        <div class="space-y-2 text-sm text-gray-500 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $event->start_date->format('d/m/Y à H:i') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $event->location }}
                            </div>
                            @if($event->max_participants)
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    Max {{ $event->max_participants }} participants
                                </div>
                            @endif
                        </div>

                        @auth
                            @if(auth()->check() && (auth()->user()->isAdmin() || (auth()->user()->isMember() && $event->user_id === auth()->id())))
                                <div class="flex items-center justify-between pt-4 border-t">
                                    <a href="{{ route('events.edit', $event) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @else
        <div class="aems-card p-12 text-center">
            <div class="text-6xl mb-4">📅</div>
            <h3 class="text-2xl font-bold aems-text-green mb-4">Aucun événement trouvé</h3>
            <p class="text-gray-600 mb-6">
                Aucun événement ne correspond à vos critères de recherche.
            </p>
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <a href="{{ route('events.create') }}" class="aems-year-button">
                        Créer le premier événement
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>
@endsection
