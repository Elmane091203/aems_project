<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin.or.member')->except(['index', 'show']);
    }

    /**
     * Display a listing of events
     */
    public function index(Request $request)
    {
        $query = Event::with('user');

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->byType($request->type);
        }

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        } else {
            // Default to upcoming events
            $query->upcoming();
        }

        $events = $query->orderBy('start_date')->paginate(10);

        $availableYears = Event::selectRaw('EXTRACT(YEAR FROM start_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('events.index', compact('events', 'availableYears'));
    }

    /**
     * Show the form for creating a new event
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created event
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'event_type' => 'required|in:culturelle,sociale,academique',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'max_participants' => 'nullable|integer|min:1',
            'registration_required' => 'boolean',
            'registration_deadline' => 'nullable|date|before:start_date',
        ]);

        $event = new Event($request->all());
        $event->user_id = Auth::id();

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('events/featured', $filename, 'public');
            $event->featured_image = $path;
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Événement créé avec succès.');
    }

    /**
     * Display the specified event
     */
    public function show(Event $event)
    {
        $event->load('user');
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event
     */
    public function edit(Event $event)
    {
        // Check if user can edit this event
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($event->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event
     */
    public function update(Request $request, Event $event)
    {
        // Check if user can edit this event
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($event->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'location' => 'required|string|max:255',
            'event_type' => 'required|in:culturelle,sociale,academique',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'max_participants' => 'nullable|integer|min:1',
            'registration_required' => 'boolean',
            'registration_deadline' => 'nullable|date|before:start_date',
        ]);

        $event->fill($request->all());

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($event->featured_image) {
                Storage::disk('public')->delete($event->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('events/featured', $filename, 'public');
            $event->featured_image = $path;
        }

        $event->save();

        return redirect()->route('events.index')->with('success', 'Événement mis à jour avec succès.');
    }

    /**
     * Remove the specified event
     */
    public function destroy(Event $event)
    {
        // Check if user can delete this event
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($event->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        // Delete featured image
        if ($event->featured_image) {
            Storage::disk('public')->delete($event->featured_image);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Événement supprimé avec succès.');
    }

    /**
     * Display calendar view of events
     */
    public function calendar()
    {
        $events = Event::where('status', 'upcoming')
            ->orderBy('start_date')
            ->get();

        return view('events.calendar', compact('events'));
    }
}
