<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Giveaway;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GiveawayController extends Controller
{
    public function index()
    {
        $giveaways = Giveaway::latest()->paginate(15);
        return view('admin.giveaways.index', compact('giveaways'));
    }

    public function create()
    {
        return view('admin.giveaways.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'image'             => 'nullable|image|max:2048',
            'prize'             => 'required|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'participation_url' => 'nullable|url',
            'status'            => 'required|in:upcoming,active,ended',
        ]);

        $data['slug']    = Str::slug($request->title);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('giveaways', 'public');
        }

        Giveaway::create($data);

        return redirect()->route('admin.giveaways.index')->with('success', 'Sorteo creado.');
    }

    public function edit(Giveaway $giveaway)
    {
        return view('admin.giveaways.edit', compact('giveaway'));
    }

    public function update(Request $request, Giveaway $giveaway)
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'image'             => 'nullable|image|max:2048',
            'prize'             => 'required|string|max:255',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after:start_date',
            'participation_url' => 'nullable|url',
            'status'            => 'required|in:upcoming,active,ended',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('giveaways', 'public');
        }

        $giveaway->update($data);

        return redirect()->route('admin.giveaways.index')->with('success', 'Sorteo actualizado.');
    }

    public function destroy(Giveaway $giveaway)
    {
        $giveaway->delete();
        return redirect()->route('admin.giveaways.index')->with('success', 'Sorteo eliminado.');
    }

    public function show(Giveaway $giveaway)
    {
        return redirect()->route('admin.giveaways.edit', $giveaway);
    }
}