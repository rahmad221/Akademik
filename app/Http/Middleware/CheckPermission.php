<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = auth()->user();

        // Admin bypass semua akses
        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }

        // Cek permission untuk role lain
        if ($user && $user->hasPermission($permission)) {
            return $next($request);
        }

        return abort(403, 'Tidak punya akses');
    }
}
