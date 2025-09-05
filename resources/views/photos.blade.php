@extends('layouts.app')

@section('title', 'Photos - AEMS')
@section('page-title', 'Photos')

@section('content')
<div class="w-full">
    <!-- Year Filter -->
    <div class="aems-card p-6 mb-8">
        <h2 class="text-xl md:text-2xl font-bold aems-text-green mb-6">📸 Archives Photos</h2>
        
        <div class="aems-grid aems-grid-7 gap-4">
            @foreach($availableYears as $availableYear)
                <a href="{{ route('photos', ['year' => $availableYear]) }}" 
                   class="aems-year-button text-center {{ $year == $availableYear ? 'bg-orange-500' : '' }}">
                    Année {{ $availableYear }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Photos Grid -->
    @if($photos->count() > 0)
        <div class="aems-grid aems-grid-4 gap-4 md:gap-6">
            @foreach($photos as $photo)
                <div class="aems-card overflow-hidden">
                    <div class="aspect-square overflow-hidden">
                        <img src="{{ $photo->url }}" 
                             alt="{{ $photo->alt_text }}" 
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-300 cursor-pointer"
                             onclick="openModal('{{ $photo->url }}', '{{ $photo->caption }}', '{{ $photo->created_at->format('d/m/Y') }}')">
                    </div>
                    @if($photo->caption)
                        <div class="p-4">
                            <p class="text-sm text-gray-600">{{ $photo->caption }}</p>
                            <div class="flex items-center justify-between mt-2 text-xs text-gray-500">
                                <span>{{ $photo->created_at->format('d/m/Y') }}</span>
                                <span>Par {{ $photo->user->name }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $photos->links() }}
        </div>
    @else
        <div class="aems-card p-12 text-center">
            <div class="text-6xl mb-4">📸</div>
            <h3 class="text-2xl font-bold aems-text-green mb-4">Aucune photo disponible</h3>
            <p class="text-gray-600 mb-6">
                @if($year == date('Y'))
                    Aucune photo n'a été ajoutée pour cette année.
                @else
                    Aucune photo n'est disponible pour l'année {{ $year }}.
                @endif
            </p>
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <a href="{{ route('media.create') }}" class="aems-year-button">
                        Ajouter des photos
                    </a>
                @endif
            @endauth
        </div>
    @endif
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-hidden">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 class="text-lg font-semibold">Photo</h3>
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
    document.getElementById('photoModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('photoModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endpush
@endsection
