<?php

namespace Rinjax\LaraImpersonator\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ImpersonateMiddleware
{
    /**
     * Check if user is impersonating and set the auth user id if so.
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(session()->has('impersonate')){
            Auth::onceUsingID(session('impersonate'));
        }

        return $next($request);
    }
}