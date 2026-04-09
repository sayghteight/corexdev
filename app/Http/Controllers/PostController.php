<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostVisit;
use App\Models\Setting;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'translations'])->published()
            ->where('type', 'news')
            ->latest('published_at')
            ->paginate((int) Setting::get('posts_per_page', 12));

        $locale = app()->getLocale();
        foreach ($posts as $post) {
            $post->applyLocale($locale);
        }

        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function guides(Request $request)
    {
        $posts = Post::with(['category', 'translations'])->published()
            ->where('type', 'guide')
            ->latest('published_at')
            ->paginate((int) Setting::get('posts_per_page', 12));

        $locale = app()->getLocale();
        foreach ($posts as $post) {
            $post->applyLocale($locale);
        }

        $categories = Category::all();

        return view('posts.guides', compact('posts', 'categories'));
    }

    public function show(string $slug)
    {
        $post = Post::with(['category', 'user', 'tags', 'translations'])->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views');

        // Record daily visit for time-series stats (atomic upsert)
        \DB::statement(
            'INSERT INTO post_visits (post_id, visited_on, views, created_at, updated_at)
             VALUES (?, ?, 1, NOW(), NOW())
             ON DUPLICATE KEY UPDATE views = views + 1, updated_at = NOW()',
            [$post->id, now()->toDateString()]
        );

        $locale = app()->getLocale();
        $post->applyLocale($locale);

        $sections = collect();
        if ($post->type === 'guide') {
            $sections = $post->guideSections()->with('translations')->orderBy('sort_order')->get();
            foreach ($sections as $section) {
                $section->applyLocale($locale);
            }
        }

        $related = Post::with('category')->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        // Apply locale overlay to related posts (titles)
        foreach ($related as $r) {
            $r->load('translations');
            $r->applyLocale($locale);
        }

        $comments = Comment::with(['user', 'replies.user'])
            ->where('post_id', $post->id)
            ->approved()
            ->roots()
            ->latest()
            ->paginate(15, ['*'], 'comments');

        return view('posts.show', compact('post', 'related', 'sections', 'comments'));
    }

    public function byCategory(string $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();

        $posts = Post::with('category')->published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate((int) Setting::get('posts_per_page', 12));

        return view('posts.category', compact('category', 'posts'));
    }
}
