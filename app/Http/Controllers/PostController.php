<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin.or.member')->except(['index', 'show']);
    }

    /**
     * Display a listing of posts
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'media']);

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Filter by status (only for admin/member)
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (Auth::check() && $user && ($user->isAdmin() || $user->isMember())) {
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
        } else {
            // Only show published posts for visitors
            $query->published();
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new post
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created post
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $post = new Post($request->all());
        $post->user_id = Auth::id();
        $post->tags = $request->tags ? explode(',', $request->tags) : [];

        if ($request->status === 'published') {
            $post->published_at = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('posts/featured', $filename, 'public');
            $post->featured_image = $path;
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Article créé avec succès.');
    }

    /**
     * Display the specified post
     */
    public function show(Post $post)
    {
        // Check if user can view this post
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($post->status === 'draft' && (!Auth::check() || !$user || (!$user->isAdmin() && !$user->isMember()))) {
            abort(404);
        }

        $post->load(['user', 'media']);
        
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified post
     */
    public function edit(Post $post)
    {
        // Check if user can edit this post
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($post->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified post
     */
    public function update(Request $request, Post $post)
    {
        // Check if user can edit this post
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($post->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
            'tags' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $post->fill($request->all());
        $post->tags = $request->tags ? explode(',', $request->tags) : [];

        if ($request->status === 'published' && !$post->published_at) {
            $post->published_at = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }

            $image = $request->file('featured_image');
            $filename = time() . '_' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('posts/featured', $filename, 'public');
            $post->featured_image = $path;
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Remove the specified post
     */
    public function destroy(Post $post)
    {
        // Check if user can delete this post
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($post->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        // Delete featured image
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Article supprimé avec succès.');
    }
}
