@extends('layouts.app')

@section('title', $post->title . ' - AEMS')
@section('page-title', 'Article')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="aems-card overflow-hidden">
        @if($post->featured_image)
            <div class="aspect-video overflow-hidden">
                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                     alt="{{ $post->title }}" 
                     class="w-full h-full object-cover">
            </div>
        @endif
        
        <div class="p-8">
            <!-- Meta information -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $post->category === 'actualites' ? 'bg-blue-100 text-blue-800' : 
                           ($post->category === 'social' ? 'bg-green-100 text-green-800' : 
                           ($post->category === 'culture' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ ucfirst($post->category) }}
                    </span>
                    
                    @auth
                        @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $post->status === 'published' ? 'Publié' : 'Brouillon' }}
                            </span>
                        @endif
                    @endauth
                </div>
                
                <div class="text-sm text-gray-500">
                    {{ $post->published_at ? $post->published_at->format('d/m/Y à H:i') : $post->created_at->format('d/m/Y à H:i') }}
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-4xl font-bold aems-text-green mb-4">{{ $post->title }}</h1>

            <!-- Author -->
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                    <span class="text-gray-600 font-semibold">{{ substr($post->user->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Par {{ $post->user->name }}</p>
                    <p class="text-sm text-gray-500">Membre AEMS</p>
                </div>
            </div>

            <!-- Excerpt -->
            @if($post->excerpt)
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-lg text-gray-700 italic">{{ $post->excerpt }}</p>
                </div>
            @endif

            <!-- Content -->
            <div class="prose prose-lg max-w-none mb-8">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Tags -->
            @if($post->tags && count($post->tags) > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold aems-text-green mb-3">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                                #{{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Media Gallery -->
            @if($post->media && $post->media->count() > 0)
                <div class="mb-8">
                    <h3 class="text-lg font-semibold aems-text-green mb-4">Médias associés</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($post->media as $media)
                            <div class="aspect-square overflow-hidden rounded-lg">
                                @if($media->file_type === 'image')
                                    <img src="{{ $media->url }}" 
                                         alt="{{ $media->alt_text }}" 
                                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                                         onclick="openModal('{{ $media->url }}', '{{ $media->caption }}', '{{ $media->created_at->format('d/m/Y') }}')">
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

            <!-- Actions -->
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || (auth()->user()->isMember() && $post->user_id === auth()->id()))
                    <div class="flex items-center justify-between pt-6 border-t">
                        <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← Retour aux articles
                        </a>
                        
                        <div class="flex space-x-3">
                            <a href="{{ route('posts.edit', $post) }}" class="aems-year-button">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" 
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="pt-6 border-t">
                        <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-800">
                            ← Retour aux articles
                        </a>
                    </div>
                @endif
            @else
                <div class="pt-6 border-t">
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-800">
                        ← Retour aux articles
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- Media Modal -->
<div id="mediaModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">Média</h3>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="p-4">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-96 mx-auto">
            <div id="modalCaption" class="mt-4 text-center text-gray-600"></div>
            <div id="modalDate" class="mt-2 text-center text-sm text-gray-500"></div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openModal(imageSrc, caption, date) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalCaption').textContent = caption || '';
    document.getElementById('modalDate').textContent = date;
    document.getElementById('mediaModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('mediaModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('mediaModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush
@endsection
