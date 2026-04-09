<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip for admin panel and all auth routes (login, register, password, email verification…)
        if ($request->is(
            'admin*',
            'login', 'register', 'logout',
            'forgot-password',
            'reset-password', 'reset-password/*',
            'verify-email', 'verify-email/*',
            'email/verification-notification',
            'confirm-password',
            'password',
        )) {
            return $next($request);
        }

        // Skip for logged-in admins
        if ($request->user() && $request->user()->is_admin) {
            return $next($request);
        }

        // Check the DB flag (wrapped in try/catch in case the table doesn't exist yet)
        try {
            if (Setting::maintenanceActive()) {
                return response()->view('maintenance', [], 503);
            }
        } catch (\Throwable) {
            // Table not yet migrated — pass through
        }

        return $next($request);
    }
}
