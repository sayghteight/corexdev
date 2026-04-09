<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name'           => 'required|string|max:120',
            'site_description'    => 'nullable|string|max:300',
            'site_keywords'       => 'nullable|string|max:300',
            'site_default_locale' => 'required|in:es,en',
            'maintenance_mode'    => 'nullable|in:0,1',
            'maintenance_message' => 'nullable|string|max:500',
            'maintenance_eta'     => 'nullable|string|max:100',
            'social_twitter'      => 'nullable|url|max:255',
            'social_discord'      => 'nullable|url|max:255',
            'social_youtube'      => 'nullable|url|max:255',
            'posts_per_page'      => 'required|integer|min:1|max:100',
            'reviews_per_page'    => 'required|integer|min:1|max:100',
        ]);

        // Checkbox: if not present in POST it means unchecked → 0
        $validated['maintenance_mode'] = $request->has('maintenance_mode') ? '1' : '0';

        Setting::setMany($validated);

        return back()->with('success', 'Configuración guardada correctamente.');
    }
}
