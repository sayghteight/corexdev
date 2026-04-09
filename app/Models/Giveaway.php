<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Giveaway extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'description', 'image',
        'prize', 'start_date', 'end_date', 'participation_url', 'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
