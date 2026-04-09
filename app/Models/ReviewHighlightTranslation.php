<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewHighlightTranslation extends Model
{
    protected $fillable = ['review_highlight_id', 'locale', 'text'];
}
