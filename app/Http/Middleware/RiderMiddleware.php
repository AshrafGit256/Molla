<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RiderMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!empty(Auth::check() && Auth::user()->is_delivery == 1)) {
            return $next($request);
        }

        Auth::logout();
        return redirect(url(''));
    }
}
