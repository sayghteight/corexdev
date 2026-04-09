<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Setting;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['category', 'translations'])->published()
            ->latest('published_at')
            ->paginate((int) Setting::get('reviews_per_page', 12));

        $locale = app()->getLocale();
        foreach ($reviews as $review) {
            $review->applyLocale($locale);
        }

        return view('reviews.index', compact('reviews'));
    }

    public function show(string $slug)
    {
        $review = Review::with(['category', 'user', 'highlights.translations', 'translations'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $review->increment('views');

        $locale = app()->getLocale();
        $review->applyLocale($locale);

        foreach ($review->highlights as $h) {
            $h->applyLocale($locale);
        }

        $related = Review::with(['category', 'translations'])->published()
            ->where('id', '!=', $review->id)
            ->latest('published_at')
            ->take(4)
            ->get();

        foreach ($related as $r) {
            $r->applyLocale($locale);
        }

        return view('reviews.show', compact('review', 'related'));
    }
}
