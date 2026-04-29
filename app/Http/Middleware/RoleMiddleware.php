<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * @param  array<int, string>  $roles
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = $request->user();
        $role = data_get($user, 'role');

        if (!is_string($role) || !in_array($role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}

