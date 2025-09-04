<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Media;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        $featuredPosts = Post::published()
            ->with(['user', 'media'])
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();

        $upcomingEvents = Event::upcoming()
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        $featuredMedia = Media::featured()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        return view('home', compact('featuredPosts', 'upcomingEvents', 'featuredMedia'));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Display the photos page
     */
    public function photos(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $photos = Media::images()
            ->byYear($year)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $availableYears = Media::images()
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('photos', compact('photos', 'availableYears', 'year'));
    }

    /**
     * Display the videos page
     */
    public function videos(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $videos = Media::videos()
            ->byYear($year)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $availableYears = Media::videos()
            ->selectRaw('EXTRACT(YEAR FROM created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('videos', compact('videos', 'availableYears', 'year'));
    }
}
