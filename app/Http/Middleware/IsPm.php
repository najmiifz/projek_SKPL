<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPm
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || $user->role !== 'pm') {
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
