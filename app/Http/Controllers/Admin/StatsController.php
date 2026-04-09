<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    public function index()
    {
        // ── Last 30 days global visits ──────────────────────────────
        $days = collect(range(29, 0))->map(fn($i) => now()->subDays($i)->toDateString());

        $rawVisits = DB::table('post_visits')
            ->selectRaw('visited_on, SUM(views) as total')
            ->whereBetween('visited_on', [$days->first(), $days->last()])
            ->groupBy('visited_on')
            ->pluck('total', 'visited_on');

        $dailyLabels = $days->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))->values();
        $dailyData   = $days->map(fn($d) => (int) ($rawVisits[$d] ?? 0))->values();

        // ── Top 15 most viewed posts (all time) ─────────────────────
        $topPosts = Post::select('id', 'title', 'slug', 'type', 'views', 'published_at', 'category_id')
            ->with('category')
            ->orderByDesc('views')
            ->take(15)
            ->get();

        // ── Last 30 days per-post top 10 ────────────────────────────
        $topRecent = DB::table('post_visits')
            ->join('posts', 'posts.id', '=', 'post_visits.post_id')
            ->selectRaw('posts.id, posts.title, posts.slug, posts.type, SUM(post_visits.views) as period_views')
            ->whereBetween('post_visits.visited_on', [$days->first(), $days->last()])
            ->groupBy('posts.id', 'posts.title', 'posts.slug', 'posts.type')
            ->orderByDesc('period_views')
            ->take(10)
            ->get();

        // ── Views by category (all time) ────────────────────────────
        $byCategory = DB::table('posts')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->selectRaw('categories.name, categories.color, SUM(posts.views) as total_views')
            ->groupBy('categories.id', 'categories.name', 'categories.color')
            ->orderByDesc('total_views')
            ->get();

        $catLabels = $byCategory->pluck('name');
        $catData   = $byCategory->pluck('total_views')->map(fn($v) => (int) $v);
        $catColors = $byCategory->map(fn($c) => $c->color ?? '#3b9edd');

        // ── Global totals ────────────────────────────────────────────
        $totalViews   = Post::sum('views');
        $viewsToday   = (int) DB::table('post_visits')->where('visited_on', now()->toDateString())->sum('views');
        $viewsThisWeek = (int) DB::table('post_visits')
            ->whereBetween('visited_on', [now()->startOfWeek()->toDateString(), now()->toDateString()])
            ->sum('views');
        $viewsThisMonth = (int) DB::table('post_visits')
            ->whereBetween('visited_on', [now()->startOfMonth()->toDateString(), now()->toDateString()])
            ->sum('views');

        return view('admin.stats.index', compact(
            'dailyLabels', 'dailyData',
            'topPosts', 'topRecent',
            'catLabels', 'catData', 'catColors',
            'totalViews', 'viewsToday', 'viewsThisWeek', 'viewsThisMonth'
        ));
    }
}
