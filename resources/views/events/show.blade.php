@extends('layouts.app')

@section('title', $event->title . ' - AEMS')
@section('page-title', 'Événement')

@section('content')
<div class="max-w-4xl mx-auto">
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
                    <div class="text-6xl mb-4">📅</div>
                    <div class="text-2xl font-bold">{{ $event->event_type }}</div>
                </div>
            </div>
        @endif
        
        <div class="p-8">
            <!-- Meta information -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $event->event_type === 'culturelle' ? 'bg-purple-100 text-purple-800' : 
                           ($event->event_type === 'sociale' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800')) }}">
                        {{ ucfirst($event->event_type) }}
                    </span>
                    
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 
                           ($event->status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 
                           ($event->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                        {{ $event->status === 'upcoming' ? 'À venir' : 
                           ($event->status === 'ongoing' ? 'En cours' : 
                           ($event->status === 'completed' ? 'Terminé' : 'Annulé')) }}
                    </span>
                </div>
                
                <div class="text-sm text-gray-500">
                    Créé le {{ $event->created_at->format('d/m/Y') }}
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl font-bold aems-text-green mb-4">{{ $event->title }}</h1>

            <!-- Event Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-orange-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Date et heure</h3>
                            <p class="text-gray-600">
                                {{ $event->start_date->format('d/m/Y à H:i') }}
                                @if($event->end_date && $event->end_date != $event->start_date)
                                    <br>au {{ $event->end_date->format('d/m/Y à H:i') }}
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-orange-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Lieu</h3>
                            <p class="text-gray-600">{{ $event->location }}</p>
                        </div>
                    </div>

                    @if($event->max_participants)
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-orange-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Participants</h3>
                                <p class="text-gray-600">Maximum {{ $event->max_participants }} personnes</p>
                            </div>
                        </div>
                    @endif

                    @if($event->registration_required)
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-orange-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900">Inscription</h3>
                                <p class="text-gray-600">
                                    Inscription requise
                                    @if($event->registration_deadline)
                                        <br>Date limite: {{ $event->registration_deadline->format('d/m/Y à H:i') }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    <h3 class="font-semibold text-gray-900 mb-3">Organisateur</h3>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-gray-600 font-semibold">{{ substr($event->user->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $event->user->name }}</p>
                            <p class="text-sm text-gray-500">Membre AEMS</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold aems-text-green mb-4">Description</h3>
                <div class="prose prose-lg max-w-none">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            <!-- Event Status Info -->
            @if($event->isUpcoming())
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-blue-900">Événement à venir</h4>
                            <p class="text-blue-700">
                                Cet événement aura lieu dans {{ $event->start_date->diffForHumans() }}
                                @if($event->registration_required)
                                    <br>N'oubliez pas de vous inscrire !
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($event->isPast())
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-8">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-900">Événement terminé</h4>
                            <p class="text-green-700">
                                Cet événement s'est terminé {{ $event->end_date->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || (auth()->user()->isMember() && $event->user_id === auth()->id()))
                    <div class="flex items-center justify-between pt-6 border-t">
                        <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← Retour aux événements
                        </a>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('events.edit', $event) }}" class="aems-year-button">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="pt-6 border-t">
                        <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← Retour aux événements
                        </a>
                    </div>
                @endif
            @else
                <div class="pt-6 border-t">
                    <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-800">
                        ← Retour aux événements
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
