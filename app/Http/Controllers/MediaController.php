<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin.or.member')->except(['index', 'show']);
    }

    /**
     * Display a listing of media
     */
    public function index(Request $request)
    {
        $query = Media::with(['user', 'post']);

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('file_type', $request->type);
        }

        // Filter by year
        if ($request->has('year') && $request->year) {
            $query->byYear($request->year);
        }

        // Filter by category
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $media = $query->orderBy('created_at', 'desc')->paginate(20);

        $availableYears = Media::selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('media.index', compact('media', 'availableYears'));
    }

    /**
     * Show the form for creating new media
     */
    public function create()
    {
        $posts = Post::where('user_id', Auth::id())->get();
        return view('media.create', compact('posts'));
    }

    /**
     * Store newly uploaded media
     */
    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov,wmv|max:10240',
            'post_id' => 'nullable|exists:posts,id',
            'category' => 'required|string|max:100',
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $fileType = $this->getFileType($file->getMimeType());
            $year = date('Y');

            // Store file
            $path = $file->storeAs('media/' . $fileType . '/' . $year, $filename, 'public');

            // Create media record
            $media = new Media([
                'filename' => $filename,
                'original_name' => $originalName,
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'file_type' => $fileType,
                'alt_text' => $request->alt_text,
                'caption' => $request->caption,
                'post_id' => $request->post_id,
                'user_id' => Auth::id(),
                'year' => $year,
                'category' => $request->category,
            ]);

            $media->save();
            $uploadedFiles[] = $media;
        }

        return redirect()->route('media.index')->with('success', count($uploadedFiles) . ' fichier(s) uploadé(s) avec succès.');
    }

    /**
     * Display the specified media
     */
    public function show(Media $media)
    {
        $media->load(['user', 'post']);
        return view('media.show', compact('media'));
    }

    /**
     * Show the form for editing the specified media
     */
    public function edit(Media $media)
    {
        // Check if user can edit this media
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($media->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        $posts = Post::where('user_id', Auth::id())->get();
        return view('media.edit', compact('media', 'posts'));
    }

    /**
     * Update the specified media
     */
    public function update(Request $request, Media $media)
    {
        // Check if user can edit this media
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($media->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'caption' => 'nullable|string|max:500',
            'category' => 'required|string|max:100',
            'post_id' => 'nullable|exists:posts,id',
            'is_featured' => 'boolean',
        ]);

        $media->update($request->all());

        return redirect()->route('media.index')->with('success', 'Média mis à jour avec succès.');
    }

    /**
     * Remove the specified media
     */
    public function destroy(Media $media)
    {
        // Check if user can delete this media
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if ($media->user_id !== Auth::id() && (!$user || !$user->isAdmin())) {
            abort(403);
        }

        // Delete file from storage
        Storage::disk('public')->delete($media->file_path);

        $media->delete();

        return redirect()->route('media.index')->with('success', 'Média supprimé avec succès.');
    }

    /**
     * Get file type from mime type
     */
    private function getFileType($mimeType)
    {
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } elseif (str_starts_with($mimeType, 'video/')) {
            return 'video';
        } else {
            return 'document';
        }
    }
}
