<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReviewTranslation;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'excerpt', 'content',
        'image', 'game', 'score', 'platform', 'developer', 'publisher',
        'release_date', 'is_featured', 'status', 'views', 'published_at',
    ];

    protected $casts = [
        'is_featured'   => 'boolean',
        'published_at'  => 'datetime',
        'release_date'  => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function highlights()
    {
        return $this->hasMany(ReviewHighlight::class)->orderBy('sort_order');
    }

    public function pros()
    {
        return $this->hasMany(ReviewHighlight::class)->where('type', 'pro')->orderBy('sort_order');
    }

    public function cons()
    {
        return $this->hasMany(ReviewHighlight::class)->where('type', 'con')->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function translations()
    {
        return $this->hasMany(ReviewTranslation::class);
    }

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
}
