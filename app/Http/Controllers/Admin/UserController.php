<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    // قائمة المستخدمين
    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        return view('admin.users.index', compact('users'));
    }

    // صفحة تعديل الدور والصلاحيات
    public function editRoles(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.editRoles', compact('user', 'roles', 'permissions'));
    }

    // تحديث الدور والصلاحيات
    public function updateRoles(Request $request, User $user)
    {
        // التحقق من المدخلات
        $request->validate([
            'role' => 'nullable|string|exists:roles,name',
            'permissions' => 'nullable|array'
        ]);

        // تعيين الدور
        $user->syncRoles($request->role ? [$request->role] : []);

        // تعيين الصلاحيات الفردية
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث صلاحيات المستخدم بنجاح');
    }
}
