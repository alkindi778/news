<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware for checking if the user is an admin.
 *
 * This middleware checks if the user is authenticated and if they have the 'is_admin' flag set to true.
 * If either of these conditions is not met, it redirects the user to the login page with an error message.
 */
class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and an admin
        if (!Auth::check() || !Auth::user()->is_admin) {
            // If not, redirect to the login page with an error message
            return redirect()->route('login')
                ->with('error', 'غير مصرح لك بالدخول إلى لوحة التحكم');
        }

        // If the user is authenticated and an admin, allow the request to proceed
        return $next($request);
    }
}
