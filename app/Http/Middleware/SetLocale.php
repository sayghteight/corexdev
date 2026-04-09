<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const ALLOWED = ['es', 'en'];

    public function handle(Request $request, Closure $next): Response
    {
        // 1. User's explicit session preference takes priority
        $locale = Session::get('locale');

        // 2. Fall back to site's configured default
        if (!$locale || !in_array($locale, self::ALLOWED)) {
            try {
                $locale = Setting::get('site_default_locale', 'es');
            } catch (\Throwable) {
                $locale = 'es';
            }
        }

        // 3. Final safety check
        if (!in_array($locale, self::ALLOWED)) {
            $locale = 'es';
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
