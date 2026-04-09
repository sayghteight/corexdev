<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ReviewHighlightTranslation;

class ReviewHighlight extends Model
{
    protected $fillable = ['review_id', 'type', 'text', 'sort_order'];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function translations()
    {
        return $this->hasMany(ReviewHighlightTranslation::class);
    }

    public function applyLocale(string $locale): static
    {
        if ($locale === 'es') {
            return $this;
        }

        $trans = $this->translations->firstWhere('locale', $locale);
        if ($trans && $trans->text) {
            $this->text = $trans->text;
        }

        return $this;
    }
}
