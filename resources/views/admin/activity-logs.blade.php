@extends('layouts.app')

@section('title', 'Logs d\'Activité - AEMS')
@section('page-title', 'Logs d\'Activité')

@section('content')
<div class="w-full">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold aems-text-green">📊 Logs d'Activité</h1>
        <div class="flex space-x-3">
            <button onclick="exportLogs()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                Exporter
            </button>
            <button onclick="clearOldLogs()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                Nettoyer
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="aems-card p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type d'activité</label>
                <select name="activity_type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous les types</option>
                    <option value="login" {{ request('activity_type') == 'login' ? 'selected' : '' }}>Connexion</option>
                    <option value="logout" {{ request('activity_type') == 'logout' ? 'selected' : '' }}>Déconnexion</option>
                    <option value="post_created" {{ request('activity_type') == 'post_created' ? 'selected' : '' }}>Article créé</option>
                    <option value="post_updated" {{ request('activity_type') == 'post_updated' ? 'selected' : '' }}>Article modifié</option>
                    <option value="post_deleted" {{ request('activity_type') == 'post_deleted' ? 'selected' : '' }}>Article supprimé</option>
                    <option value="event_created" {{ request('activity_type') == 'event_created' ? 'selected' : '' }}>Événement créé</option>
                    <option value="media_uploaded" {{ request('activity_type') == 'media_uploaded' ? 'selected' : '' }}>Média uploadé</option>
                    <option value="user_created" {{ request('activity_type') == 'user_created' ? 'selected' : '' }}>Utilisateur créé</option>
                    <option value="user_updated" {{ request('activity_type') == 'user_updated' ? 'selected' : '' }}>Utilisateur modifié</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Utilisateur</label>
                <select name="user_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tous les utilisateurs</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                <input type="date" 
                       name="start_date" 
                       value="{{ request('start_date') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                <input type="date" 
                       name="end_date" 
                       value="{{ request('end_date') }}"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2">
            </div>

            <div class="flex items-end">
                <button type="submit" class="aems-year-button w-full">
                    Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Activity Logs Table -->
    <div class="aems-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date/Heure
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Utilisateur
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            IP
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <div>{{ $log->created_at->format('d/m/Y') }}</div>
                                <div class="text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8">
                                        @if($log->user && $log->user->profile_photo)
                                            <img class="h-8 w-8 rounded-full object-cover" 
                                                 src="{{ asset('storage/' . $log->user->profile_photo) }}" 
                                                 alt="{{ $log->user->name }}">
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-600 text-xs font-semibold">
                                                    {{ $log->user ? substr($log->user->name, 0, 1) : '?' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $log->user ? $log->user->name : 'Utilisateur supprimé' }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $log->user ? $log->user->email : 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $log->activity_type === 'login' ? 'bg-green-100 text-green-800' : 
                                       ($log->activity_type === 'logout' ? 'bg-gray-100 text-gray-800' : 
                                       ($log->activity_type === 'post_created' ? 'bg-blue-100 text-blue-800' : 
                                       ($log->activity_type === 'event_created' ? 'bg-purple-100 text-purple-800' : 
                                       ($log->activity_type === 'media_uploaded' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $log->activity_type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->ip_address }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-6xl mb-4">📊</div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun log trouvé</h3>
                                <p class="text-gray-500">Aucun log d'activité ne correspond à vos critères de recherche.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
        <div class="aems-card p-6 text-center">
            <div class="text-3xl font-bold aems-text-green">{{ $stats['total'] }}</div>
            <div class="text-sm text-gray-600">Total logs</div>
        </div>
        <div class="aems-card p-6 text-center">
            <div class="text-3xl font-bold text-blue-600">{{ $stats['today'] }}</div>
            <div class="text-sm text-gray-600">Aujourd'hui</div>
        </div>
        <div class="aems-card p-6 text-center">
            <div class="text-3xl font-bold text-green-600">{{ $stats['logins'] }}</div>
            <div class="text-sm text-gray-600">Connexions</div>
        </div>
        <div class="aems-card p-6 text-center">
            <div class="text-3xl font-bold text-purple-600">{{ $stats['posts'] }}</div>
            <div class="text-sm text-gray-600">Articles créés</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportLogs() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');
    window.location.href = '{{ route("admin.activity-logs") }}?' + params.toString();
}

function clearOldLogs() {
    if (confirm('Êtes-vous sûr de vouloir supprimer les logs de plus de 6 mois ? Cette action est irréversible.')) {
        fetch('{{ route("admin.activity-logs.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Logs supprimés avec succès !');
                location.reload();
            } else {
                alert('Erreur lors de la suppression des logs.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erreur lors de la suppression des logs.');
        });
    }
}
</script>
@endpush
@endsection
