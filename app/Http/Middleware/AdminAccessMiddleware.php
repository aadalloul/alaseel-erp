<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if ($user && $user->hasRole('admin')) {
            // أعط كل الصلاحيات ديناميكيًا للمستخدم الأدمن
            $user->syncPermissions(\Spatie\Permission\Models\Permission::all());
            // امسح الكاش للتأكد
            app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        }

        return $next($request);
    }
}
