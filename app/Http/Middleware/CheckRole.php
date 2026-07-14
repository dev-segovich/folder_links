<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role ?? 'dev';

        if (!empty($roles) && !in_array($userRole, $roles)) {
            abort(403, 'No tiene permiso para acceder a esta página.');
        }

        return $next($request);
    }
}
