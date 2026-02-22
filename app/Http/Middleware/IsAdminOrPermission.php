<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdminOrPermission
{
    public function handle($request, Closure $next, $permission = null)
    {
        $user = Auth::user();

        if ($user && $user->is_admin) {
            return $next($request);
        }

        if ($permission && $user && $user->can($permission)) {
            return $next($request);
        }

        abort(403, 'ليس لديك صلاحية.');
    }
}
