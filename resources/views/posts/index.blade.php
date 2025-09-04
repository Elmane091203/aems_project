@extends('layouts.app')

@section('title', 'Articles - AEMS')
@section('page-title', 'Articles')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold aems-text-green">📝 Articles</h1>
        @auth
            @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                <a href="{{ route('posts.create') }}" class="aems-year-button">
                    Nouvel Article
                </a>
            @endif
        @endauth
    </div>

    <!-- Filters -->
    <div class="aems-card p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Toutes les catégories</option>
                    <option value="actualites" {{ request('category') == 'actualites' ? 'selected' : '' }}>Actualités</option>
                    <option value="social" {{ request('category') == 'social' ? 'selected' : '' }}>Social</option>
                    <option value="culture" {{ request('category') == 'culture' ? 'selected' : '' }}>Culture</option>
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

            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                        <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">Tous les statuts</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Publié</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                        </select>
                    </div>
                @endif
            @endauth

            <div class="flex items-end">
                <button type="submit" class="aems-year-button w-full">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Posts Grid -->
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <div class="aems-card overflow-hidden">
                    @if($post->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $post->category === 'actualites' ? 'bg-blue-100 text-blue-800' : 
                                   ($post->category === 'social' ? 'bg-green-100 text-green-800' : 
                                   ($post->category === 'culture' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ ucfirst($post->category) }}
                            </span>
                            
                            @auth
                                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $post->status === 'published' ? 'Publié' : 'Brouillon' }}
                                    </span>
                                @endif
                            @endauth
                        </div>

                        <h3 class="text-xl font-semibold aems-text-green mb-3">
                            <a href="{{ route('posts.show', $post) }}" class="hover:text-orange-500">
                                {{ $post->title }}
                            </a>
                        </h3>

                        @if($post->excerpt)
                            <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                        @endif

                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center">
                                <span>Par {{ $post->user->name }}</span>
                            </div>
                            <span>{{ $post->published_at ? $post->published_at->format('d/m/Y') : $post->created_at->format('d/m/Y') }}</span>
                        </div>

                        @auth
                            @if(auth()->check() && (auth()->user()->isAdmin() || (auth()->user()->isMember() && $post->user_id === auth()->id())))
                                <div class="flex items-center justify-between mt-4 pt-4 border-t">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Modifier
                                    </a>
                                    <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
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
            {{ $posts->links() }}
        </div>
    @else
        <div class="aems-card p-12 text-center">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="text-2xl font-bold aems-text-green mb-4">Aucun article trouvé</h3>
            <p class="text-gray-600 mb-6">
                Aucun article ne correspond à vos critères de recherche.
            </p>
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <a href="{{ route('posts.create') }}" class="aems-year-button">
                        Créer le premier article
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>
@endsection
