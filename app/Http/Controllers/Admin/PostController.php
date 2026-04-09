<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GuideSection;
use App\Models\GuideSectionTranslation;
use App\Models\Post;
use App\Models\PostTranslation;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $isGuide = $request->input('type') === 'guide';

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt'     => 'nullable|string',
            'content'     => $isGuide ? 'nullable|string' : 'required|string',
            'image'       => 'nullable|image|max:2048',
            'type'        => 'required|in:news,guide',
            'is_featured' => 'boolean',
            'is_slider'   => 'boolean',
            'status'      => 'required|in:draft,published',
            'tags'        => 'nullable|array',
            'sections'         => 'nullable|array',
            'sections.*.title'   => 'required_with:sections|string|max:255',
            'sections.*.content' => 'nullable|string',
            // EN translation
            'trans_en.title'              => 'nullable|string|max:255',
            'trans_en.excerpt'            => 'nullable|string',
            'trans_en.content'            => 'nullable|string',
            'trans_en.sections'           => 'nullable|array',
            'trans_en.sections.*.title'   => 'nullable|string|max:255',
            'trans_en.sections.*.content' => 'nullable|string',
        ]);

        $data['slug']    = Str::slug($request->title);
        $data['user_id'] = auth()->id();
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_slider']   = $request->boolean('is_slider');
        $data['content']     = $isGuide ? '' : $this->sanitizeHtml($data['content'] ?? '');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = Post::create($data);

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        $sectionIds = [];
        if ($isGuide) {
            $sectionIds = $this->syncGuideSections($post, $request->input('sections', []));
        }

        // Save EN translation if title provided
        $enData = $request->input('trans_en', []);
        if (!empty(trim($enData['title'] ?? ''))) {
            PostTranslation::updateOrCreate(
                ['post_id' => $post->id, 'locale' => 'en'],
                [
                    'title'   => $enData['title'],
                    'excerpt' => $this->sanitizeHtml($enData['excerpt'] ?? ''),
                    'content' => $isGuide ? '' : $this->sanitizeHtml($enData['content'] ?? ''),
                ]
            );

            if ($isGuide && !empty($sectionIds)) {
                $this->syncGuideSectionTranslations($sectionIds, $request->input('trans_en.sections', []), 'en');
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Artículo creado correctamente.');
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $post->load(['guideSections.translations', 'translations']);
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, Post $post)
    {
        $isGuide = $request->input('type') === 'guide';

        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt'     => 'nullable|string',
            'content'     => $isGuide ? 'nullable|string' : 'required|string',
            'image'       => 'nullable|image|max:2048',
            'type'        => 'required|in:news,guide',
            'is_featured' => 'boolean',
            'is_slider'   => 'boolean',
            'status'      => 'required|in:draft,published',
            'tags'        => 'nullable|array',
            'sections'         => 'nullable|array',
            'sections.*.title'   => 'required_with:sections|string|max:255',
            'sections.*.content' => 'nullable|string',
            // EN translation
            'trans_en.title'              => 'nullable|string|max:255',
            'trans_en.excerpt'            => 'nullable|string',
            'trans_en.content'            => 'nullable|string',
            'trans_en.sections'           => 'nullable|array',
            'trans_en.sections.*.title'   => 'nullable|string|max:255',
            'trans_en.sections.*.content' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('posts', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_slider']   = $request->boolean('is_slider');
        $data['content']     = $isGuide ? '' : $this->sanitizeHtml($data['content'] ?? '');

        if ($data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags ?? []);
        }

        $sectionIds = [];
        if ($isGuide) {
            $sectionIds = $this->syncGuideSections($post, $request->input('sections', []));
        } else {
            $post->guideSections()->delete();
        }

        // Save / wipe EN translation
        $enData = $request->input('trans_en', []);
        if (!empty(trim($enData['title'] ?? ''))) {
            PostTranslation::updateOrCreate(
                ['post_id' => $post->id, 'locale' => 'en'],
                [
                    'title'   => $enData['title'],
                    'excerpt' => $this->sanitizeHtml($enData['excerpt'] ?? ''),
                    'content' => $isGuide ? '' : $this->sanitizeHtml($enData['content'] ?? ''),
                ]
            );

            if ($isGuide && !empty($sectionIds)) {
                $this->syncGuideSectionTranslations($sectionIds, $request->input('trans_en.sections', []), 'en');
            }
        } else {
            // Title cleared → remove EN translation
            $post->translations()->where('locale', 'en')->delete();
        }

        return redirect()->route('admin.posts.index')->with('success', 'Artículo actualizado.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Artículo eliminado.');
    }

    public function show(Post $post)
    {
        return redirect()->route('admin.posts.edit', $post);
    }

    /**
     * Recreate guide sections and return an ordered array of their new IDs.
     */
    private function syncGuideSections(Post $post, array $sections): array
    {
        $post->guideSections()->delete();
        $rows = [];
        foreach (array_values($sections) as $i => $sec) {
            if (empty(trim($sec['title'] ?? ''))) continue;
            $content = $this->sanitizeHtml($sec['content'] ?? '');
            $rows[] = [
                'post_id'    => $post->id,
                'title'      => $sec['title'],
                'content'    => $content,
                'sort_order' => $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        if (!empty($rows)) {
            GuideSection::insert($rows);
        }

        return $post->guideSections()->orderBy('sort_order')->pluck('id')->toArray();
    }

    /**
     * Upsert guide section translations keyed by position index → section ID.
     */
    private function syncGuideSectionTranslations(array $sectionIds, array $enSections, string $locale): void
    {
        foreach ($sectionIds as $i => $sectionId) {
            $enTitle   = $enSections[$i]['title']   ?? '';
            $enContent = $enSections[$i]['content'] ?? '';

            if (empty(trim($enTitle))) {
                GuideSectionTranslation::where('guide_section_id', $sectionId)
                    ->where('locale', $locale)
                    ->delete();
                continue;
            }

            GuideSectionTranslation::updateOrCreate(
                ['guide_section_id' => $sectionId, 'locale' => $locale],
                [
                    'title'   => $enTitle,
                    'content' => $this->sanitizeHtml($enContent),
                ]
            );
        }
    }

    private function sanitizeHtml(string $html): string
    {
        // Remove <script> blocks and inline event handlers
        $html = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*(["\'])[^\1]*?\1/i', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*[^\s>]*/i', '', $html);
        return $html;
    }
}
