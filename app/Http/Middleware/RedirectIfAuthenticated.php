<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == 'admin') {
            if (Auth::guard($guard)->check()) {
                return redirect(app()->getLocale() . '/admin/home');
            }
        }
        if ($guard == 'pos') {
            if (Auth::guard($guard)->check()) {
                return redirect(app()->getLocale() . '/pos/home');
            }
        }
        if (Auth::guard($guard)->check()) {
            return redirect(app()->getLocale() . '/home');
        }

        return $next($request);
    }
}
