<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date')->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'game'        => 'nullable|string|max:255',
            'platform'    => 'nullable|string|max:100',
            'type'        => 'required|in:launch,expansion,demo,update,sale,event',
            'event_date'  => 'required|date',
            'url'         => 'nullable|url',
            'is_featured' => 'boolean',
        ]);

        $data['slug']        = Str::slug($request->name);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Evento creado.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'game'        => 'nullable|string|max:255',
            'platform'    => 'nullable|string|max:100',
            'type'        => 'required|in:launch,expansion,demo,update,sale,event',
            'event_date'  => 'required|date',
            'url'         => 'nullable|url',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Evento actualizado.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Evento eliminado.');
    }

    public function show(Event $event)
    {
        return redirect()->route('admin.events.edit', $event);
    }
}