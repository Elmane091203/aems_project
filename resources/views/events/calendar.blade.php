@extends('layouts.app')

@section('title', 'Calendrier des Événements - AEMS')
@section('page-title', 'Calendrier')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold aems-text-green">📅 Calendrier des Événements</h1>
        <div class="flex space-x-3">
            <a href="{{ route('events.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Vue Liste
            </a>
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <a href="{{ route('events.create') }}" class="aems-year-button">
                        Nouvel Événement
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Calendar Navigation -->
    <div class="aems-card p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <button id="prevMonth" class="p-2 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h2 id="currentMonth" class="text-2xl font-bold aems-text-green"></h2>
                <button id="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            
            <div class="flex items-center space-x-3">
                <button id="todayBtn" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg">
                    Aujourd'hui
                </button>
                <select id="yearSelect" class="border border-gray-300 rounded-lg px-3 py-2">
                    @for($i = date('Y') - 2; $i <= date('Y') + 2; $i++)
                        <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>

    <!-- Calendar Grid -->
    <div class="aems-card overflow-hidden">
        <div class="grid grid-cols-7 border-b">
            <div class="p-4 text-center font-semibold text-gray-700 bg-gray-50">Lun</div>
            <div class="p-4 text-center font-semibold text-gray-700 bg-gray-50">Mar</div>
            <div class="p-4 text-center font-semibold text-gray-700 bg-gray-50">Mer</div>
            <div class="p-4 text-center font-semibold text-gray-700 bg-gray-50">Jeu</div>
            <div class="p-4 text-center font-semibold text-gray-700 bg-gray-50">Ven</div>
            <div class="p-4 text-center font-semibold text-gray-700 bg-gray-50">Sam</div>
            <div class="p-4 text-center font-semibold text-gray-700 bg-gray-50">Dim</div>
        </div>
        <div id="calendarGrid" class="grid grid-cols-7">
            <!-- Calendar days will be populated by JavaScript -->
        </div>
    </div>

    <!-- Event Details Modal -->
    <div id="eventModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-2xl w-full max-h-full overflow-hidden">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="modalTitle" class="text-lg font-semibold">Détails de l'événement</h3>
                <button onclick="closeEventModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="modalContent" class="p-4 max-h-96 overflow-y-auto">
                <!-- Event details will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentDate = new Date();
let events = @json($events);

const monthNames = [
    'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
    'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
];

function updateCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;
    document.getElementById('yearSelect').value = year;
    
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - (firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1));
    
    const calendarGrid = document.getElementById('calendarGrid');
    calendarGrid.innerHTML = '';
    
    const today = new Date();
    today.setHours(0, 0, 0, 0);
    
    for (let i = 0; i < 42; i++) {
        const cellDate = new Date(startDate);
        cellDate.setDate(startDate.getDate() + i);
        
        const dayElement = document.createElement('div');
        dayElement.className = 'min-h-24 p-2 border-r border-b border-gray-200';
        
        if (cellDate.getMonth() !== month) {
            dayElement.classList.add('bg-gray-50', 'text-gray-400');
        } else if (cellDate.getTime() === today.getTime()) {
            dayElement.classList.add('bg-orange-50', 'border-orange-200');
        }
        
        const dayNumber = document.createElement('div');
        dayNumber.className = 'text-sm font-medium mb-1';
        dayNumber.textContent = cellDate.getDate();
        dayElement.appendChild(dayNumber);
        
        // Add events for this day
        const dayEvents = events.filter(event => {
            const eventDate = new Date(event.start_date);
            return eventDate.toDateString() === cellDate.toDateString();
        });
        
        dayEvents.forEach(event => {
            const eventElement = document.createElement('div');
            eventElement.className = 'text-xs p-1 mb-1 rounded cursor-pointer truncate';
            
            if (event.event_type === 'culturelle') {
                eventElement.classList.add('bg-purple-100', 'text-purple-800');
            } else if (event.event_type === 'sociale') {
                eventElement.classList.add('bg-green-100', 'text-green-800');
            } else {
                eventElement.classList.add('bg-blue-100', 'text-blue-800');
            }
            
            eventElement.textContent = event.title;
            eventElement.onclick = () => showEventModal(event);
            dayElement.appendChild(eventElement);
        });
        
        calendarGrid.appendChild(dayElement);
    }
}

function showEventModal(event) {
    document.getElementById('modalTitle').textContent = event.title;
    
    const content = `
        <div class="space-y-4">
            <div>
                <h4 class="font-semibold text-gray-900">Description</h4>
                <p class="text-gray-600">${event.description}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h4 class="font-semibold text-gray-900">Date</h4>
                    <p class="text-gray-600">${new Date(event.start_date).toLocaleDateString('fr-FR')}</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Heure</h4>
                    <p class="text-gray-600">${new Date(event.start_date).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}</p>
                </div>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-900">Lieu</h4>
                <p class="text-gray-600">${event.location}</p>
            </div>
            
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    ${event.event_type === 'culturelle' ? 'bg-purple-100 text-purple-800' : 
                      (event.event_type === 'sociale' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800')}">
                    ${event.event_type.charAt(0).toUpperCase() + event.event_type.slice(1)}
                </span>
                
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    ${event.status === 'upcoming' ? 'bg-blue-100 text-blue-800' : 
                      (event.status === 'ongoing' ? 'bg-yellow-100 text-yellow-800' : 
                      (event.status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'))}">
                    ${event.status === 'upcoming' ? 'À venir' : 
                      (event.status === 'ongoing' ? 'En cours' : 
                      (event.status === 'completed' ? 'Terminé' : 'Annulé'))}
                </span>
            </div>
            
            @auth
                @if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isMember()))
                    <div class="pt-4 border-t">
                        <a href="/events/${event.id}/edit" class="text-blue-600 hover:text-blue-800 mr-4">Modifier</a>
                        <a href="/events/${event.id}" class="text-green-600 hover:text-green-800">Voir détails</a>
                    </div>
                @endif
            @endauth
        </div>
    `;
    
    document.getElementById('modalContent').innerHTML = content;
    document.getElementById('eventModal').classList.remove('hidden');
}

function closeEventModal() {
    document.getElementById('eventModal').classList.add('hidden');
}

// Event listeners
document.getElementById('prevMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
});

document.getElementById('nextMonth').addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
});

document.getElementById('todayBtn').addEventListener('click', () => {
    currentDate = new Date();
    updateCalendar();
});

document.getElementById('yearSelect').addEventListener('change', (e) => {
    currentDate.setFullYear(parseInt(e.target.value));
    updateCalendar();
});

// Close modal when clicking outside
document.getElementById('eventModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEventModal();
    }
});

// Initialize calendar
updateCalendar();
</script>
@endpush
@endsection
