<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminEmailMiddleware
{
    /**
     * Handle an incoming request.
     * Allow only the admin user with email admin@admin.com to proceed.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (! $user || $user->email !== 'admin@admin.com') {
            // If you prefer a redirect instead of 403, change this to redirect()->route('home')
            abort(403);
        }

        return $next($request);
    }
}
