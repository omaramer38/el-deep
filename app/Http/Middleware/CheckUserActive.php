<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserActive
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => __('This account has been deactivated. Please contact an administrator.'),
                ]);
            }

            // Update last login info if needed
            if (! $request->session()->has('logged_login_activity')) {
                $user->updateQuietly([
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ]);
                $request->session()->put('logged_login_activity', true);
            }
        }

        return $next($request);
    }
}
