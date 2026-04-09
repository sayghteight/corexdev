<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Giveaway;
use App\Models\Post;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'posts'      => Post::count(),
            'reviews'    => Review::count(),
            'events'     => Event::count(),
            'giveaways'  => Giveaway::count(),
            'users'      => User::count(),
            'views'      => Post::sum('views'),
            'viewsToday' => (int) DB::table('post_visits')->where('visited_on', now()->toDateString())->sum('views'),
        ];

        $latestPosts   = Post::with('category')->latest()->take(5)->get();
        $latestReviews = Review::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestPosts', 'latestReviews'));
    }
}
