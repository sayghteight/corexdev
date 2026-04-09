<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostVisit extends Model
{
    protected $fillable = ['post_id', 'visited_on', 'views'];

    protected $casts = [
        'visited_on' => 'date',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
