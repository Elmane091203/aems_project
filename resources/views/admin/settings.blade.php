@extends('layouts.app')

@section('title', 'Paramètres - AEMS')
@section('page-title', 'Paramètres')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-3xl font-bold aems-text-green">⚙️ Paramètres de la plateforme</h1>
        <p class="text-gray-600">Configurez les paramètres généraux de la plateforme AEMS</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <!-- General Settings -->
        <div class="aems-card p-8 mb-6">
            <h2 class="text-2xl font-bold aems-text-green mb-6">📋 Paramètres généraux</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du site *
                    </label>
                    <input type="text" 
                           id="site_name" 
                           name="site_name" 
                           value="{{ old('site_name', $settings['site_name'] ?? 'AEMS') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('site_name') border-red-500 @enderror"
                           required>
                    @error('site_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description du site
                    </label>
                    <input type="text" 
                           id="site_description" 
                           name="site_description" 
                           value="{{ old('site_description', $settings['site_description'] ?? 'Association des Étudiants de Mitsoudjé au Sénégal') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('site_description') border-red-500 @enderror">
                    @error('site_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email de contact *
                    </label>
                    <input type="email" 
                           id="contact_email" 
                           name="contact_email" 
                           value="{{ old('contact_email', $settings['contact_email'] ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('contact_email') border-red-500 @enderror"
                           required>
                    @error('contact_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone de contact
                    </label>
                    <input type="text" 
                           id="contact_phone" 
                           name="contact_phone" 
                           value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('contact_phone') border-red-500 @enderror">
                    @error('contact_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Registration Settings -->
        <div class="aems-card p-8 mb-6">
            <h2 class="text-2xl font-bold aems-text-green mb-6">👥 Paramètres d'inscription</h2>
            
            <div class="space-y-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="registration_enabled" 
                           name="registration_enabled" 
                           value="1"
                           {{ old('registration_enabled', $settings['registration_enabled'] ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="registration_enabled" class="ml-2 block text-sm text-gray-900">
                        Autoriser les nouvelles inscriptions
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" 
                           id="email_verification_required" 
                           name="email_verification_required" 
                           value="1"
                           {{ old('email_verification_required', $settings['email_verification_required'] ?? true) ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="email_verification_required" class="ml-2 block text-sm text-gray-900">
                        Vérification email requise
                    </label>
                </div>

                <div>
                    <label for="default_user_role" class="block text-sm font-medium text-gray-700 mb-2">
                        Rôle par défaut pour les nouveaux utilisateurs
                    </label>
                    <select id="default_user_role" 
                            name="default_user_role" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('default_user_role') border-red-500 @enderror">
                        <option value="visitor" {{ old('default_user_role', $settings['default_user_role'] ?? 'visitor') == 'visitor' ? 'selected' : '' }}>Visiteur</option>
                        <option value="member" {{ old('default_user_role', $settings['default_user_role'] ?? 'visitor') == 'member' ? 'selected' : '' }}>Membre</option>
                    </select>
                    @error('default_user_role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Content Settings -->
        <div class="aems-card p-8 mb-6">
            <h2 class="text-2xl font-bold aems-text-green mb-6">📰 Paramètres de contenu</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="posts_per_page" class="block text-sm font-medium text-gray-700 mb-2">
                        Articles par page
                    </label>
                    <input type="number" 
                           id="posts_per_page" 
                           name="posts_per_page" 
                           value="{{ old('posts_per_page', $settings['posts_per_page'] ?? 12) }}"
                           min="1"
                           max="50"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('posts_per_page') border-red-500 @enderror">
                    @error('posts_per_page')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="events_per_page" class="block text-sm font-medium text-gray-700 mb-2">
                        Événements par page
                    </label>
                    <input type="number" 
                           id="events_per_page" 
                           name="events_per_page" 
                           value="{{ old('events_per_page', $settings['events_per_page'] ?? 12) }}"
                           min="1"
                           max="50"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('events_per_page') border-red-500 @enderror">
                    @error('events_per_page')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="media_per_page" class="block text-sm font-medium text-gray-700 mb-2">
                        Médias par page
                    </label>
                    <input type="number" 
                           id="media_per_page" 
                           name="media_per_page" 
                           value="{{ old('media_per_page', $settings['media_per_page'] ?? 20) }}"
                           min="1"
                           max="100"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('media_per_page') border-red-500 @enderror">
                    @error('media_per_page')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="max_file_size" class="block text-sm font-medium text-gray-700 mb-2">
                        Taille max des fichiers (MB)
                    </label>
                    <input type="number" 
                           id="max_file_size" 
                           name="max_file_size" 
                           value="{{ old('max_file_size', $settings['max_file_size'] ?? 10) }}"
                           min="1"
                           max="100"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('max_file_size') border-red-500 @enderror">
                    @error('max_file_size')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Maintenance Settings -->
        <div class="aems-card p-8 mb-6">
            <h2 class="text-2xl font-bold aems-text-green mb-6">🔧 Mode maintenance</h2>
            
            <div class="space-y-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="maintenance_mode" 
                           name="maintenance_mode" 
                           value="1"
                           {{ old('maintenance_mode', $settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                           class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                    <label for="maintenance_mode" class="ml-2 block text-sm text-gray-900">
                        Activer le mode maintenance
                    </label>
                </div>

                <div id="maintenance_message_div" style="display: none;">
                    <label for="maintenance_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message de maintenance
                    </label>
                    <textarea id="maintenance_message" 
                              name="maintenance_message" 
                              rows="4"
                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('maintenance_message') border-red-500 @enderror"
                              placeholder="Message affiché aux visiteurs pendant la maintenance">{{ old('maintenance_message', $settings['maintenance_message'] ?? 'Le site est temporairement en maintenance. Nous revenons bientôt !') }}</textarea>
                    @error('maintenance_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-800">
                Retour au tableau de bord
            </a>
            
            <div class="flex space-x-3">
                <button type="button" onclick="resetSettings()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">
                    Réinitialiser
                </button>
                <button type="submit" class="aems-year-button">
                    Sauvegarder les paramètres
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Toggle maintenance message visibility
document.getElementById('maintenance_mode').addEventListener('change', function() {
    const messageDiv = document.getElementById('maintenance_message_div');
    if (this.checked) {
        messageDiv.style.display = 'block';
    } else {
        messageDiv.style.display = 'none';
    }
});

// Show maintenance message if checkbox is checked on page load
if (document.getElementById('maintenance_mode').checked) {
    document.getElementById('maintenance_message_div').style.display = 'block';
}

function resetSettings() {
    if (confirm('Êtes-vous sûr de vouloir réinitialiser tous les paramètres aux valeurs par défaut ?')) {
        // Reset form to default values
        document.getElementById('site_name').value = 'AEMS';
        document.getElementById('site_description').value = 'Association des Étudiants de Mitsoudjé au Sénégal';
        document.getElementById('contact_email').value = '';
        document.getElementById('contact_phone').value = '';
        document.getElementById('registration_enabled').checked = true;
        document.getElementById('email_verification_required').checked = true;
        document.getElementById('default_user_role').value = 'visitor';
        document.getElementById('posts_per_page').value = 12;
        document.getElementById('events_per_page').value = 12;
        document.getElementById('media_per_page').value = 20;
        document.getElementById('max_file_size').value = 10;
        document.getElementById('maintenance_mode').checked = false;
        document.getElementById('maintenance_message').value = 'Le site est temporairement en maintenance. Nous revenons bientôt !';
        document.getElementById('maintenance_message_div').style.display = 'none';
    }
}
</script>
@endpush
@endsection
