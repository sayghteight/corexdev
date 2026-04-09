<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Review;
use App\Models\ReviewHighlight;
use App\Models\ReviewHighlightTranslation;
use App\Models\ReviewTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('category')->latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.reviews.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'image'        => 'nullable|image|max:2048',
            'game'         => 'required|string|max:255',
            'score'        => 'required|numeric|min:0|max:10',
            'platform'     => 'nullable|string|max:100',
            'developer'    => 'nullable|string|max:255',
            'publisher'    => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'is_featured'  => 'boolean',
            'status'       => 'required|in:draft,published',
            'pros'         => 'nullable|array',
            'pros.*'       => 'nullable|string|max:255',
            'cons'         => 'nullable|array',
            'cons.*'       => 'nullable|string|max:255',
            // EN translation
            'trans_en.title'   => 'nullable|string|max:255',
            'trans_en.excerpt' => 'nullable|string',
            'trans_en.content' => 'nullable|string',
            'trans_en.pros'    => 'nullable|array',
            'trans_en.pros.*'  => 'nullable|string|max:255',
            'trans_en.cons'    => 'nullable|array',
            'trans_en.cons.*'  => 'nullable|string|max:255',
        ]);

        $data['slug']        = Str::slug($request->title);
        $data['user_id']     = auth()->id();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['content']     = $this->sanitizeHtml($data['content']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $review = Review::create($data);

        $highlightIds = $this->syncHighlights(
            $review,
            $request->input('pros', []),
            $request->input('cons', [])
        );

        // EN translation
        $enData = $request->input('trans_en', []);
        if (!empty(trim($enData['title'] ?? ''))) {
            ReviewTranslation::updateOrCreate(
                ['review_id' => $review->id, 'locale' => 'en'],
                [
                    'title'   => $enData['title'],
                    'excerpt' => $this->sanitizeHtml($enData['excerpt'] ?? ''),
                    'content' => $this->sanitizeHtml($enData['content'] ?? ''),
                ]
            );

            $this->syncHighlightTranslations(
                $highlightIds,
                $request->input('trans_en.pros', []),
                $request->input('trans_en.cons', []),
                'en'
            );
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña creada.');
    }

    public function edit(Review $review)
    {
        $categories = Category::all();
        $review->load(['highlights.translations', 'translations']);
        return view('admin.reviews.edit', compact('review', 'categories'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'excerpt'      => 'nullable|string',
            'content'      => 'required|string',
            'image'        => 'nullable|image|max:2048',
            'game'         => 'required|string|max:255',
            'score'        => 'required|numeric|min:0|max:10',
            'platform'     => 'nullable|string|max:100',
            'developer'    => 'nullable|string|max:255',
            'publisher'    => 'nullable|string|max:255',
            'release_date' => 'nullable|date',
            'is_featured'  => 'boolean',
            'status'       => 'required|in:draft,published',
            'pros'         => 'nullable|array',
            'pros.*'       => 'nullable|string|max:255',
            'cons'         => 'nullable|array',
            'cons.*'       => 'nullable|string|max:255',
            // EN translation
            'trans_en.title'   => 'nullable|string|max:255',
            'trans_en.excerpt' => 'nullable|string',
            'trans_en.content' => 'nullable|string',
            'trans_en.pros'    => 'nullable|array',
            'trans_en.pros.*'  => 'nullable|string|max:255',
            'trans_en.cons'    => 'nullable|array',
            'trans_en.cons.*'  => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['content']     = $this->sanitizeHtml($data['content']);

        if ($data['status'] === 'published' && !$review->published_at) {
            $data['published_at'] = now();
        }

        $review->update($data);

        $highlightIds = $this->syncHighlights(
            $review,
            $request->input('pros', []),
            $request->input('cons', [])
        );

        // EN translation
        $enData = $request->input('trans_en', []);
        if (!empty(trim($enData['title'] ?? ''))) {
            ReviewTranslation::updateOrCreate(
                ['review_id' => $review->id, 'locale' => 'en'],
                [
                    'title'   => $enData['title'],
                    'excerpt' => $this->sanitizeHtml($enData['excerpt'] ?? ''),
                    'content' => $this->sanitizeHtml($enData['content'] ?? ''),
                ]
            );

            $this->syncHighlightTranslations(
                $highlightIds,
                $request->input('trans_en.pros', []),
                $request->input('trans_en.cons', []),
                'en'
            );
        } else {
            $review->translations()->where('locale', 'en')->delete();
        }

        return redirect()->route('admin.reviews.index')->with('success', 'Reseña actualizada.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')->with('success', 'Reseña eliminada.');
    }

    public function show(Review $review)
    {
        return redirect()->route('admin.reviews.edit', $review);
    }

    private function sanitizeHtml(string $html): string
    {
        // Remove <script> blocks and inline event handlers
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*(["\'])[^\1]*?\1/i', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*[^\s>]*/i', '', $html);
        return $html;
    }

    /**
     * Recreate highlights and return ['pros' => [ids...], 'cons' => [ids...]].
     */
    private function syncHighlights(Review $review, array $pros, array $cons): array
    {
        $review->highlights()->delete();

        $rows = [];
        foreach (array_filter($pros) as $i => $text) {
            $rows[] = ['review_id' => $review->id, 'type' => 'pro', 'text' => $text, 'sort_order' => $i, 'created_at' => now(), 'updated_at' => now()];
        }
        foreach (array_filter($cons) as $i => $text) {
            $rows[] = ['review_id' => $review->id, 'type' => 'con', 'text' => $text, 'sort_order' => $i, 'created_at' => now(), 'updated_at' => now()];
        }

        if (!empty($rows)) {
            ReviewHighlight::insert($rows);
        }

        $saved = $review->highlights()->orderBy('type')->orderBy('sort_order')->get();
        return [
            'pros' => $saved->where('type', 'pro')->pluck('id')->values()->toArray(),
            'cons' => $saved->where('type', 'con')->pluck('id')->values()->toArray(),
        ];
    }

    private function syncHighlightTranslations(array $highlightIds, array $enPros, array $enCons, string $locale): void
    {
        $enPros = array_values(array_filter($enPros));
        $enCons = array_values(array_filter($enCons));

        foreach ($highlightIds['pros'] as $i => $id) {
            if (!empty($enPros[$i])) {
                ReviewHighlightTranslation::updateOrCreate(
                    ['review_highlight_id' => $id, 'locale' => $locale],
                    ['text' => $enPros[$i]]
                );
            }
        }

        foreach ($highlightIds['cons'] as $i => $id) {
            if (!empty($enCons[$i])) {
                ReviewHighlightTranslation::updateOrCreate(
                    ['review_highlight_id' => $id, 'locale' => $locale],
                    ['text' => $enCons[$i]]
                );
            }
        }
    }
}