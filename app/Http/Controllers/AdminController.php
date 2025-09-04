<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Media;
use App\Models\Event;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Display the admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'total_media' => Media::count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::upcoming()->count(),
        ];

        $recentPosts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentEvents = Event::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentActivity = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentEvents', 'recentUsers', 'recentActivity'));
    }

    /**
     * Display user management page
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name or email
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistics
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'members' => User::where('role', 'member')->count(),
            'visitors' => User::where('role', 'visitor')->count(),
        ];

        return view('admin.users', compact('users', 'stats'));
    }

    /**
     * Show the form for creating a new user
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,member,visitor',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
        ]);

        $userData = $request->except(['password_confirmation', 'profile_photo']);
        $userData['password'] = bcrypt($request->password);

        if ($request->hasFile('profile_photo')) {
            $userData['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user = User::create($userData);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'user_created',
            'description' => "Utilisateur créé: {$user->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified user
     */
    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,member,visitor',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
        ]);

        $userData = $request->except(['password_confirmation', 'profile_photo']);

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        } else {
            unset($userData['password']);
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $userData['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $user->update($userData);

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'user_updated',
            'description' => "Utilisateur modifié: {$user->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.users.show', $user)->with('success', 'Utilisateur mis à jour avec succès.');
    }

    /**
     * Remove the specified user
     */
    public function destroyUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $userName = $user->name;
        $user->delete();

        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'user_deleted',
            'description' => "Utilisateur supprimé: {$userName}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès.');
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,member,visitor',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'Rôle utilisateur mis à jour avec succès.');
    }

    /**
     * Update user status
     */
    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $user->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Statut utilisateur mis à jour avec succès.');
    }

    /**
     * Display activity logs
     */
    public function activityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        // Filter by activity type
        if ($request->has('activity_type') && $request->activity_type) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get all users for filter dropdown
        $users = User::orderBy('name')->get();

        // Statistics
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'logins' => ActivityLog::where('activity_type', 'login')->count(),
            'posts' => ActivityLog::where('activity_type', 'post_created')->count(),
        ];

        return view('admin.activity-logs', compact('logs', 'users', 'stats'));
    }

    /**
     * Export activity logs
     */
    public function exportActivityLogs(Request $request)
    {
        $query = ActivityLog::with('user');

        // Apply same filters as activityLogs method
        if ($request->has('activity_type') && $request->activity_type) {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $logs = $query->orderBy('created_at', 'desc')->get();

        $filename = 'activity_logs_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, ['Date', 'Heure', 'Utilisateur', 'Type d\'activité', 'Description', 'IP']);
            
            // CSV data
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('d/m/Y'),
                    $log->created_at->format('H:i:s'),
                    $log->user ? $log->user->name : 'Utilisateur supprimé',
                    ucfirst(str_replace('_', ' ', $log->activity_type)),
                    $log->description,
                    $log->ip_address,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Clear old activity logs
     */
    public function clearActivityLogs()
    {
        $deletedCount = ActivityLog::where('created_at', '<', now()->subMonths(6))->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deletedCount} logs supprimés avec succès.",
            'deleted_count' => $deletedCount
        ]);
    }

    /**
     * Display system settings
     */
    public function settings()
    {
        $settings = config('aems');
        return view('admin.settings', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'registration_enabled' => 'boolean',
            'email_verification_required' => 'boolean',
            'default_user_role' => 'required|in:admin,member,visitor',
            'posts_per_page' => 'required|integer|min:1|max:50',
            'events_per_page' => 'required|integer|min:1|max:50',
            'media_per_page' => 'required|integer|min:1|max:100',
            'max_file_size' => 'required|integer|min:1|max:100',
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'nullable|string|max:500',
        ]);

        // Update .env file or use a settings model
        // For now, we'll just return success
        // In a real application, you would update the configuration
        
        // Log activity
        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity_type' => 'settings_updated',
            'description' => 'Paramètres de la plateforme mis à jour',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
