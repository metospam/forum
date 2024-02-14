<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            return $next($request);
        }

        // User is not authenticated, return a 401 Unauthorized response
        return response()->json('Unauthenticated.', 401);
    }
}
