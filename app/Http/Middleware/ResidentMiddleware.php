<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ResidentMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (!auth()->check() || !auth()->user()->isResident()) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}