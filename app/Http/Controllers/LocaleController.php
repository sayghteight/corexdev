<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    private const ALLOWED = ['es', 'en'];

    public function switch(Request $request, string $lang): RedirectResponse
    {
        if (in_array($lang, self::ALLOWED, true)) {
            session(['locale' => $lang]);
        }

        return redirect()->back(fallback: route('home'));
    }
}
