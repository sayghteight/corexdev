<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GuideSection;
use App\Models\PostTranslation;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'excerpt', 'content',
        'image', 'type', 'is_featured', 'is_slider', 'status', 'views', 'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_slider'   => 'boolean',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function guideSections()
    {
        return $this->hasMany(GuideSection::class)->orderBy('sort_order');
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class);
    }

    /**
     * Overlay translatable fields from the given locale onto this model instance.
     * Falls back to the base (es) fields when no translation exists.
     */
    public function applyLocale(string $locale): static
    {
        if ($locale === 'es') {
            return $this;
        }

        $trans = $this->translations->firstWhere('locale', $locale);
        if ($trans) {
            if ($trans->title)   $this->title   = $trans->title;
            if ($trans->excerpt) $this->excerpt = $trans->excerpt;
            if ($trans->content) $this->content = $trans->content;
        }

        return $this;
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSlider($query)
    {
        return $query->where('is_slider', true);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function visits()
    {
        return $this->hasMany(PostVisit::class);
    }
}
