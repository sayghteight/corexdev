<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GuideSectionTranslation;

class GuideSection extends Model
{
    protected $fillable = ['post_id', 'title', 'content', 'sort_order'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function translations()
    {
        return $this->hasMany(GuideSectionTranslation::class);
    }

    public function applyLocale(string $locale): static
    {
        if ($locale === 'es') {
            return $this;
        }

        $trans = $this->translations->firstWhere('locale', $locale);
        if ($trans) {
            if ($trans->title)   $this->title   = $trans->title;
            if ($trans->content) $this->content = $trans->content;
        }

        return $this;
    }
}
