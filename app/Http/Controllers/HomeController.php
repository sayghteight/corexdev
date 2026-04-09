<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Giveaway;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $sliderPosts  = Post::with(['category', 'translations'])->published()->where('type', 'news')->slider()->latest('published_at')->take(5)->get();
        $featuredPost = Post::with(['category', 'translations'])->published()->where('type', 'news')->featured()->latest('published_at')->first();
        $latestPosts  = Post::with(['category', 'translations'])->published()->where('type', 'news')->latest('published_at')->take(8)->get();
        $latestGuides = Post::with(['category', 'translations'])->published()->where('type', 'guide')->latest('published_at')->take(4)->get();
        $latestReviews = Review::with(['category', 'translations'])->published()->latest('published_at')->take(4)->get();
        $upcomingEvents = Event::where('event_date', '>=', now())->orderBy('event_date')->take(8)->get();
        $activeGiveaways = Giveaway::where('status', 'active')->latest()->take(3)->get();
        $categories = Category::withCount('posts')->get();

        // Apply locale overlays to all translatable collections
        foreach ($sliderPosts as $p)  { $p->applyLocale($locale); }
        if ($featuredPost)            { $featuredPost->applyLocale($locale); }
        foreach ($latestPosts as $p)  { $p->applyLocale($locale); }
        foreach ($latestGuides as $p) { $p->applyLocale($locale); }
        foreach ($latestReviews as $r){ $r->applyLocale($locale); }

        return view('home', compact(
            'sliderPosts', 'featuredPost', 'latestPosts',
            'latestGuides', 'latestReviews', 'upcomingEvents',
            'activeGiveaways', 'categories'
        ));
    }
}
