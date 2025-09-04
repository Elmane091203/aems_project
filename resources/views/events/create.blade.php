@extends('layouts.app')

@section('title', 'Nouvel Événement - AEMS')
@section('page-title', 'Nouvel Événement')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="aems-card p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold aems-text-green mb-2">📅 Créer un nouvel événement</h1>
            <p class="text-gray-600">Organisez et planifiez vos événements pour la communauté AEMS</p>
        </div>

        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
            @csrf
            
            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre de l'événement *
                </label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('title') border-red-500 @enderror"
                       placeholder="Entrez le titre de votre événement"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Event Type -->
            <div class="mb-6">
                <label for="event_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Type d'événement *
                </label>
                <select id="event_type" 
                        name="event_type" 
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('event_type') border-red-500 @enderror"
                        required>
                    <option value="">Sélectionnez un type</option>
                    <option value="culturelle" {{ old('event_type') == 'culturelle' ? 'selected' : '' }}>Culturelle</option>
                    <option value="sociale" {{ old('event_type') == 'sociale' ? 'selected' : '' }}>Sociale</option>
                    <option value="academique" {{ old('event_type') == 'academique' ? 'selected' : '' }}>Académique</option>
                </select>
                @error('event_type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description de l'événement *
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="6"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror"
                          placeholder="Décrivez votre événement en détail..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date and Time -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Date et heure de début *
                    </label>
                    <input type="datetime-local" 
                           id="start_date" 
                           name="start_date" 
                           value="{{ old('start_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('start_date') border-red-500 @enderror"
                           required>
                    @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Date et heure de fin *
                    </label>
                    <input type="datetime-local" 
                           id="end_date" 
                           name="end_date" 
                           value="{{ old('end_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('end_date') border-red-500 @enderror"
                           required>
                    @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Location -->
            <div class="mb-6">
                <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                    Lieu de l'événement *
                </label>
                <input type="text" 
                       id="location" 
                       name="location" 
                       value="{{ old('location') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('location') border-red-500 @enderror"
                       placeholder="Ex: Centre Culturel de Dakar"
                       required>
                @error('location')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image -->
            <div class="mb-6">
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Image de couverture
                </label>
                <input type="file" 
                       id="featured_image" 
                       name="featured_image" 
                       accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('featured_image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Formats acceptés: JPEG, PNG, JPG, GIF (max 2MB)</p>
                @error('featured_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Registration Settings -->
            <div class="mb-6">
                <div class="flex items-center mb-4">
                    <input type="checkbox" 
                           id="registration_required" 
                           name="registration_required" 
                           value="1"
                           {{ old('registration_required') ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="registration_required" class="ml-2 block text-sm text-gray-900">
                        Inscription requise pour cet événement
                    </label>
                </div>

                <div id="registration_settings" class="grid grid-cols-1 md:grid-cols-2 gap-6" style="display: none;">
                    <div>
                        <label for="max_participants" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre maximum de participants
                        </label>
                        <input type="number" 
                               id="max_participants" 
                               name="max_participants" 
                               value="{{ old('max_participants') }}"
                               min="1"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('max_participants') border-red-500 @enderror"
                               placeholder="Ex: 100">
                        @error('max_participants')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="registration_deadline" class="block text-sm font-medium text-gray-700 mb-2">
                            Date limite d'inscription
                        </label>
                        <input type="datetime-local" 
                               id="registration_deadline" 
                               name="registration_deadline" 
                               value="{{ old('registration_deadline') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('registration_deadline') border-red-500 @enderror">
                        @error('registration_deadline')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
                
                <button type="submit" class="aems-year-button">
                    Créer l'événement
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('registration_required').addEventListener('change', function() {
    const settings = document.getElementById('registration_settings');
    if (this.checked) {
        settings.style.display = 'grid';
    } else {
        settings.style.display = 'none';
    }
});

// Show registration settings if checkbox was checked on form error
if (document.getElementById('registration_required').checked) {
    document.getElementById('registration_settings').style.display = 'grid';
}
</script>
@endpush
@endsection
