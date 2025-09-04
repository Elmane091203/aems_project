@extends('layouts.app')

@section('title', 'Médias - AEMS')
@section('page-title', 'Médias')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold aems-text-green">📸 Médias</h1>
        @auth
            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                <a href="{{ route('media.create') }}" class="aems-year-button">
                    Ajouter des Médias
                </a>
            @endif
        @endauth
    </div>

    <!-- Filters -->
    <div class="aems-card p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type de média</label>
                <select name="file_type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous les types</option>
                    <option value="image" {{ request('file_type') == 'image' ? 'selected' : '' }}>Images</option>
                    <option value="video" {{ request('file_type') == 'video' ? 'selected' : '' }}>Vidéos</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Toutes les catégories</option>
                    <option value="actualites" {{ request('category') == 'actualites' ? 'selected' : '' }}>Actualités</option>
                    <option value="evenements" {{ request('category') == 'evenements' ? 'selected' : '' }}>Événements</option>
                    <option value="culture" {{ request('category') == 'culture' ? 'selected' : '' }}>Culture</option>
                    <option value="social" {{ request('category') == 'social' ? 'selected' : '' }}>Social</option>
                    <option value="academique" {{ request('category') == 'academique' ? 'selected' : '' }}>Académique</option>
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

            <div class="flex items-end">
                <button type="submit" class="aems-year-button w-full">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Media Grid -->
    @if($media->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
            @foreach($media as $item)
                <div class="aems-card overflow-hidden group cursor-pointer" onclick="openMediaModal('{{ $item->id }}')">
                    @if($item->file_type === 'image')
                        <div class="aspect-square overflow-hidden">
                            <img src="{{ $item->url }}" 
                                 alt="{{ $item->alt_text }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                    @elseif($item->file_type === 'video')
                        <div class="aspect-square overflow-hidden relative">
                            <video class="w-full h-full object-cover" muted>
                                <source src="{{ $item->url }}" type="{{ $item->mime_type }}">
                            </video>
                            <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                            </div>
                        </div>
                    @endif
                    
                    <div class="p-3">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                {{ $item->file_type === 'image' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $item->file_type === 'image' ? '📸' : '🎥' }} {{ ucfirst($item->file_type) }}
                            </span>
                            
                            <span class="text-xs text-gray-500">{{ $item->year }}</span>
                        </div>

                        @if($item->caption)
                            <p class="text-sm text-gray-600 truncate">{{ $item->caption }}</p>
                        @endif

                        @if($item->category)
                            <p class="text-xs text-gray-500 mt-1">{{ ucfirst($item->category) }}</p>
                        @endif

                        @auth
                            @if(auth()->check() && (auth()->user()->isAdmin() || (auth()->user()->isMember() && $item->user_id === auth()->id()))
                                <div class="flex items-center justify-between mt-3 pt-2 border-t">
                                    <a href="{{ route('media.edit', $item) }}" class="text-xs text-blue-600 hover:text-blue-800">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('media.destroy', $item) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?')">
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
            {{ $media->links() }}
        </div>
    @else
        <div class="aems-card p-12 text-center">
            <div class="text-6xl mb-4">📸</div>
            <h3 class="text-2xl font-bold aems-text-green mb-4">Aucun média trouvé</h3>
            <p class="text-gray-600 mb-6">
                Aucun média ne correspond à vos critères de recherche.
            </p>
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <a href="{{ route('media.create') }}" class="aems-year-button">
                        Ajouter le premier média
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>

<!-- Media Modal -->
<div id="mediaModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="modalTitle" class="text-lg font-semibold">Média</h3>
            <button onclick="closeMediaModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div id="modalContent" class="p-4">
            <!-- Media content will be populated by JavaScript -->
        </div>
    </div>
</div>

@push('scripts')
<script>
const mediaData = @json($media->items());

function openMediaModal(mediaId) {
    const media = mediaData.find(m => m.id == mediaId);
    if (!media) return;

    document.getElementById('modalTitle').textContent = media.caption || 'Média';
    
    let content = '';
    
    if (media.file_type === 'image') {
        content = `
            <div class="text-center">
                <img src="${media.url}" alt="${media.alt_text}" class="max-w-full max-h-96 mx-auto rounded-lg">
                <div class="mt-4 space-y-2">
                    ${media.caption ? `<p class="text-gray-700">${media.caption}</p>` : ''}
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                        <span>📸 Image</span>
                        <span>•</span>
                        <span>${media.year}</span>
                        ${media.category ? `<span>•</span><span>${media.category}</span>` : ''}
                    </div>
                </div>
            </div>
        `;
    } else if (media.file_type === 'video') {
        content = `
            <div class="text-center">
                <video class="max-w-full max-h-96 mx-auto rounded-lg" controls>
                    <source src="${media.url}" type="${media.mime_type}">
                </video>
                <div class="mt-4 space-y-2">
                    ${media.caption ? `<p class="text-gray-700">${media.caption}</p>` : ''}
                    <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                        <span>🎥 Vidéo</span>
                        <span>•</span>
                        <span>${media.year}</span>
                        ${media.category ? `<span>•</span><span>${media.category}</span>` : ''}
                    </div>
                </div>
            </div>
        `;
    }
    
    document.getElementById('modalContent').innerHTML = content;
    document.getElementById('mediaModal').classList.remove('hidden');
}

function closeMediaModal() {
    document.getElementById('mediaModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('mediaModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMediaModal();
    }
});
</script>
@endpush
@endsection
