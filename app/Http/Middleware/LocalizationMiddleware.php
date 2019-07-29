<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check('admin') || Auth::check('pos')) {
            if (auth()->user()->settings) {
                app()->setLocale(auth()->user()->settings->language);
            } else {
                if (in_array($request->locale, ['en', 'ar'])) {
                    app()->setLocale($request->locale);
                }
            }
        } else {
            if (in_array($request->locale, ['en', 'ar'])) {
                app()->setLocale($request->locale);
            }
        }
        \URL::defaults(['locale' => app()->getLocale()]);
        return $next($request);
    }
}
