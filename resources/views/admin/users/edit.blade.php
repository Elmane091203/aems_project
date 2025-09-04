@extends('layouts.app')

@section('title', 'Modifier l\'Utilisateur - AEMS')
@section('page-title', 'Modifier l\'Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="aems-card p-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold aems-text-green mb-2">✏️ Modifier l'utilisateur</h1>
            <p class="text-gray-600">Modifiez les informations de {{ $user->name }}</p>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Personal Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nom complet *
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                           placeholder="Entrez le nom complet"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse email *
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('email') border-red-500 @enderror"
                           placeholder="exemple@email.com"
                           required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password (Optional) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Nouveau mot de passe
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('password') border-red-500 @enderror"
                           placeholder="Laissez vide pour conserver le mot de passe actuel">
                    <p class="mt-1 text-sm text-gray-500">Laissez vide pour conserver le mot de passe actuel</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmer le nouveau mot de passe
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="Confirmez le nouveau mot de passe">
                </div>
            </div>

            <!-- Role and Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Rôle *
                    </label>
                    <select id="role" 
                            name="role" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('role') border-red-500 @enderror"
                            required>
                        <option value="">Sélectionnez un rôle</option>
                        <option value="visitor" {{ old('role', $user->role) == 'visitor' ? 'selected' : '' }}>Visiteur</option>
                        <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Membre</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Statut *
                    </label>
                    <select id="status" 
                            name="status" 
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('status') border-red-500 @enderror"
                            required>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Téléphone
                    </label>
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           value="{{ old('phone', $user->phone) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('phone') border-red-500 @enderror"
                           placeholder="+221 XX XXX XX XX">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Adresse
                    </label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="{{ old('address', $user->address) }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('address') border-red-500 @enderror"
                           placeholder="Adresse complète">
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Current Profile Photo -->
            @if($user->profile_photo)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Photo de profil actuelle
                    </label>
                    <div class="w-24 h-24 overflow-hidden rounded-lg border">
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                             alt="{{ $user->name }}" 
                             class="w-full h-full object-cover">
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Sélectionnez une nouvelle photo pour la remplacer</p>
                </div>
            @endif

            <!-- Profile Photo -->
            <div class="mb-6">
                <label for="profile_photo" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $user->profile_photo ? 'Nouvelle photo de profil' : 'Photo de profil' }}
                </label>
                <input type="file" 
                       id="profile_photo" 
                       name="profile_photo" 
                       accept="image/*"
                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('profile_photo') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Formats acceptés: JPEG, PNG, JPG, GIF (max 2MB)</p>
                @error('profile_photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bio -->
            <div class="mb-8">
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                    Biographie
                </label>
                <textarea id="bio" 
                          name="bio" 
                          rows="4"
                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('bio') border-red-500 @enderror"
                          placeholder="Présentation personnelle...">{{ old('bio', $user->bio) }}</textarea>
                @error('bio')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- User Statistics -->
            <div class="mb-8 bg-gray-50 p-6 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-4">Statistiques de l'utilisateur</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div>
                        <span class="font-medium text-gray-700">Articles:</span>
                        <span class="text-gray-600">{{ $user->posts()->count() }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Événements:</span>
                        <span class="text-gray-600">{{ $user->events()->count() }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Médias:</span>
                        <span class="text-gray-600">{{ $user->media()->count() }}</span>
                    </div>
                    <div>
                        <span class="font-medium text-gray-700">Membre depuis:</span>
                        <span class="text-gray-600">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a href="{{ route('admin.users.show', $user) }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
                
                <div class="flex space-x-3">
                    <button type="submit" class="aems-year-button">
                        Mettre à jour l'utilisateur
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
