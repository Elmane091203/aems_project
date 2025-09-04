@extends('layouts.app')

@section('title', 'Tableau de bord Admin - AEMS')
@section('page-title', 'Administration')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="aems-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
                </div>
            </div>
        </div>

        <div class="aems-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Articles Publiés</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['published_posts'] }}</p>
                </div>
            </div>
        </div>

        <div class="aems-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Médias</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_media'] }}</p>
                </div>
            </div>
        </div>

        <div class="aems-card p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Événements à Venir</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['upcoming_events'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Posts -->
        <div class="aems-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold aems-text-green">📝 Articles Récents</h3>
                <a href="{{ route('posts.index') }}" class="text-sm text-orange-500 hover:text-orange-600">Voir tout</a>
            </div>
            @if($recentPosts->count() > 0)
                <div class="space-y-3">
                    @foreach($recentPosts as $post)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="w-12 h-12 object-cover rounded">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $post->title }}</p>
                                <p class="text-xs text-gray-500">Par {{ $post->user->name }} • {{ $post->created_at->format('d/m/Y') }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $post->status === 'published' ? 'Publié' : 'Brouillon' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Aucun article récent</p>
            @endif
        </div>

        <!-- Recent Events -->
        <div class="aems-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold aems-text-green">📅 Événements Récents</h3>
                <a href="{{ route('events.index') }}" class="text-sm text-orange-500 hover:text-orange-600">Voir tout</a>
            </div>
            @if($recentEvents->count() > 0)
                <div class="space-y-3">
                    @foreach($recentEvents as $event)
                        <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-orange-100 rounded flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $event->title }}</p>
                                <p class="text-xs text-gray-500">{{ $event->start_date->format('d/m/Y H:i') }} • {{ $event->location }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $event->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $event->status === 'upcoming' ? 'À venir' : ucfirst($event->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Aucun événement récent</p>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="aems-card p-6 mt-8">
        <h3 class="text-lg font-semibold aems-text-green mb-4">📊 Activité Récente</h3>
        @if($recentActivity->count() > 0)
            <div class="space-y-3">
                @foreach($recentActivity as $activity)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                            <p class="text-xs text-gray-500">
                                @if($activity->user)
                                    Par {{ $activity->user->name }}
                                @endif
                                • {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Aucune activité récente</p>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <a href="{{ route('posts.create') }}" class="aems-card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-3">📝</div>
            <h3 class="text-lg font-semibold aems-text-green mb-2">Nouvel Article</h3>
            <p class="text-gray-600 text-sm">Créer un nouvel article</p>
        </a>
        
        <a href="{{ route('events.create') }}" class="aems-card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-3">📅</div>
            <h3 class="text-lg font-semibold aems-text-green mb-2">Nouvel Événement</h3>
            <p class="text-gray-600 text-sm">Planifier un événement</p>
        </a>
        
        <a href="{{ route('media.create') }}" class="aems-card p-6 text-center hover:shadow-lg transition-shadow">
            <div class="text-3xl mb-3">🎬</div>
            <h3 class="text-lg font-semibold aems-text-green mb-2">Ajouter Médias</h3>
            <p class="text-gray-600 text-sm">Uploader photos/vidéos</p>
        </a>
    </div>
</div>
@endsection
