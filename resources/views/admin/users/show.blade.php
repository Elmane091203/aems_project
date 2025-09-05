@extends('layouts.app')

@section('title', 'Détails Utilisateur - AEMS')
@section('page-title', 'Détails Utilisateur')

@section('content')
<div class="w-full">
    <div class="aems-card p-8">
        <!-- User Header -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mr-6">
                    @if($user->profile_photo)
                        <img class="w-20 h-20 rounded-full object-cover" 
                             src="{{ asset('storage/' . $user->profile_photo) }}" 
                             alt="{{ $user->name }}">
                    @else
                        <span class="text-gray-600 text-2xl font-semibold">{{ substr($user->name, 0, 1) }}</span>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold aems-text-green">{{ $user->name }}</h1>
                    <p class="text-gray-600">{{ $user->email }}</p>
                    <div class="flex items-center space-x-3 mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 
                               ($user->role === 'member' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                            {{ $user->role === 'admin' ? 'Administrateur' : 
                               ($user->role === 'member' ? 'Membre' : 'Visiteur') }}
                        </span>
                        
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->status === 'active' ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="aems-year-button">
                    Modifier
                </a>
                @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" 
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">
                            Supprimer
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- User Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div>
                <h2 class="text-xl font-bold aems-text-green mb-4">Informations personnelles</h2>
                <div class="space-y-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <span class="font-semibold text-gray-900">Nom:</span>
                            <span class="ml-2 text-gray-600">{{ $user->name }}</span>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <span class="font-semibold text-gray-900">Email:</span>
                            <span class="ml-2 text-gray-600">{{ $user->email }}</span>
                        </div>
                    </div>

                    @if($user->phone)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Téléphone:</span>
                                <span class="ml-2 text-gray-600">{{ $user->phone }}</span>
                            </div>
                        </div>
                    @endif

                    @if($user->address)
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <span class="font-semibold text-gray-900">Adresse:</span>
                                <span class="ml-2 text-gray-600">{{ $user->address }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <span class="font-semibold text-gray-900">Membre depuis:</span>
                            <span class="ml-2 text-gray-600">{{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold aems-text-green mb-4">Statistiques</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $user->posts()->count() }}</div>
                        <div class="text-sm text-gray-600">Articles</div>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $user->events()->count() }}</div>
                        <div class="text-sm text-gray-600">Événements</div>
                    </div>
                    <div class="bg-purple-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ $user->media()->count() }}</div>
                        <div class="text-sm text-gray-600">Médias</div>
                    </div>
                    <div class="bg-orange-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-orange-600">{{ $user->activityLogs()->count() }}</div>
                        <div class="text-sm text-gray-600">Activités</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bio -->
        @if($user->bio)
            <div class="mb-8">
                <h2 class="text-xl font-bold aems-text-green mb-4">Biographie</h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-700">{{ $user->bio }}</p>
                </div>
            </div>
        @endif

        <!-- Recent Activity -->
        <div class="mb-8">
            <h2 class="text-xl font-bold aems-text-green mb-4">Activité récente</h2>
            <div class="bg-gray-50 p-6 rounded-lg">
                @if($user->activityLogs()->count() > 0)
                    <div class="space-y-3">
                        @foreach($user->activityLogs()->latest()->limit(5)->get() as $log)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-b-0">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $log->activity_type === 'login' ? 'bg-green-100 text-green-800' : 
                                           ($log->activity_type === 'post_created' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $log->activity_type)) }}
                                    </span>
                                    <span class="ml-3 text-sm text-gray-600">{{ $log->description }}</span>
                                </div>
                                <span class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aucune activité récente</p>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6 border-t">
            <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-800">
                ← Retour à la liste des utilisateurs
            </a>
            
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="aems-year-button">
                    Modifier l'utilisateur
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
