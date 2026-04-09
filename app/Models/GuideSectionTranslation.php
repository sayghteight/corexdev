<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuideSectionTranslation extends Model
{
    protected $fillable = ['guide_section_id', 'locale', 'title', 'content'];
}
