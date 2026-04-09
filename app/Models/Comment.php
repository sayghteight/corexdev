<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'parent_id', 'body', 'is_approved'];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->where('is_approved', true)->with('user')->latest();
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }
}
