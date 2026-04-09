<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'image', 'game',
        'platform', 'type', 'event_date', 'url', 'is_featured',
    ];

    protected $casts = [
        'event_date'  => 'datetime',
        'is_featured' => 'boolean',
    ];
}
