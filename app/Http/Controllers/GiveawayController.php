<?php

namespace App\Http\Controllers;

use App\Models\Giveaway;
use Illuminate\Http\Request;

class GiveawayController extends Controller
{
    public function index()
    {
        $activeGiveaways   = Giveaway::where('status', 'active')->latest()->get();
        $upcomingGiveaways = Giveaway::where('status', 'upcoming')->latest()->get();
        $endedGiveaways    = Giveaway::where('status', 'ended')->latest()->paginate(6);
        return view('giveaways.index', compact('activeGiveaways', 'upcomingGiveaways', 'endedGiveaways'));
    }

    public function show(string $slug)
    {
        $giveaway = Giveaway::where('slug', $slug)->firstOrFail();
        return view('giveaways.show', compact('giveaway'));
    }
}
