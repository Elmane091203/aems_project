<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/photos', [HomeController::class, 'photos'])->name('photos');
Route::get('/videos', [HomeController::class, 'videos'])->name('videos');

// Posts Routes (Public viewing)
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Events Routes (Public viewing)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events-calendar', [EventController::class, 'calendar'])->name('events.calendar');

// Media Routes (Public viewing)
Route::get('/media', [MediaController::class, 'index'])->name('media.index');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin/Member Routes
    Route::middleware('admin.or.member')->group(function () {
        // Posts Management
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        
        // Posts Show (after specific routes to avoid conflicts)
        Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

        // Events Management
        Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
        Route::post('/events', [EventController::class, 'store'])->name('events.store');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
        
        // Events Show (after specific routes to avoid conflicts)
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

        // Media Management
        Route::get('/media/create', [MediaController::class, 'create'])->name('media.create');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::get('/media/{media}/edit', [MediaController::class, 'edit'])->name('media.edit');
        Route::put('/media/{media}', [MediaController::class, 'update'])->name('media.update');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
        
        // Media Show (after specific routes to avoid conflicts)
        Route::get('/media/{media}', [MediaController::class, 'show'])->name('media.show');
    });

    // Admin Only Routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
        Route::patch('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('users.update-status');
        
        // Activity Logs
        Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('activity-logs');
        Route::get('/activity-logs/export', [AdminController::class, 'exportActivityLogs'])->name('activity-logs.export');
        Route::post('/activity-logs/clear', [AdminController::class, 'clearActivityLogs'])->name('activity-logs.clear');
        
        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });
});

require __DIR__.'/auth.php';
