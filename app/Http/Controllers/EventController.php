<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $upcomingEvents = Event::where('event_date', '>=', now())->orderBy('event_date')->paginate(12);
        $pastEvents     = Event::where('event_date', '<', now())->orderBy('event_date', 'desc')->take(6)->get();
        return view('events.index', compact('upcomingEvents', 'pastEvents'));
    }

    public function show(string $slug)
    {
        $event   = Event::where('slug', $slug)->firstOrFail();
        $related = Event::where('id', '!=', $event->id)->where('event_date', '>=', now())->orderBy('event_date')->take(4)->get();
        return view('events.show', compact('event', 'related'));
    }
}
