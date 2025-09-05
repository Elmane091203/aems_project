@extends('layouts.app')

@section('title', 'Vidéos - AEMS')
@section('page-title', 'Vidéos')

@section('content')
<div class="w-full">
    <!-- Year Filter -->
    <div class="aems-card p-6 mb-8">
        <h2 class="text-xl md:text-2xl font-bold aems-text-green mb-6">🎥 Archives Vidéos</h2>
        
        <div class="aems-grid aems-grid-7 gap-4">
            @foreach($availableYears as $availableYear)
                <a href="{{ route('videos', ['year' => $availableYear]) }}" 
                   class="aems-year-button text-center {{ $year == $availableYear ? 'bg-orange-500' : '' }}">
                    Année {{ $availableYear }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Videos Grid -->
    @if($videos->count() > 0)
        <div class="aems-grid aems-grid-3 gap-4 md:gap-6">
            @foreach($videos as $video)
                <div class="aems-card overflow-hidden">
                    <div class="aspect-video overflow-hidden">
                        <video class="w-full h-full object-cover" controls preload="metadata">
                            <source src="{{ $video->url }}" type="{{ $video->mime_type }}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    </div>
                    <div class="p-4">
                        @if($video->caption)
                            <p class="text-sm text-gray-600 mb-2">{{ $video->caption }}</p>
                        @endif
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>{{ $video->created_at->format('d/m/Y') }}</span>
                            <span>Par {{ $video->user->name }}</span>
                        </div>
                        <div class="mt-2 text-xs text-gray-500">
                            <span>📁 {{ number_format($video->file_size / 1024 / 1024, 1) }} MB</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $videos->links() }}
        </div>
    @else
        <div class="aems-card p-12 text-center">
            <div class="text-6xl mb-4">🎥</div>
            <h3 class="text-2xl font-bold aems-text-green mb-4">Aucune vidéo disponible</h3>
            <p class="text-gray-600 mb-6">
                @if($year == date('Y'))
                    Aucune vidéo n'a été ajoutée pour cette année.
                @else
                    Aucune vidéo n'est disponible pour l'année {{ $year }}.
                @endif
            </p>
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <a href="{{ route('media.create') }}" class="aems-year-button">
                        Ajouter des vidéos
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>
@endsection
