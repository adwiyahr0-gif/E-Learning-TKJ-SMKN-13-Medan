<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureGuru
{
    public function handle(Request $request, Closure $next)
    {
        abort_unless($request->user()?->role === 'guru', 403, 'Halaman ini khusus guru.');

        return $next($request);
    }
}