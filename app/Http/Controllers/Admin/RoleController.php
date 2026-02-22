<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();

        $rolesList = [
            'admin'      => 'مدير النظام',
            'accountant' => 'محاسب',
            'employee'   => 'موظف',
            'sales'      => 'مبيعات',
        ];

        return view('admin.roles.create', compact('permissions', 'rolesList'));
    }




    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);
        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact(
            'role',
            'permissions',
            'rolePermissions'
        ));
    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array'
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'تم تحديث الصلاحيات بنجاح');
    }

    public function destroy(Role $role)
    {
        if($role->users()->count() > 0){
            return redirect()->route('admin.roles.index')->with('error', 'لا يمكن حذف هذا الدور لأنه مرتبط بمستخدمين');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'تم حذف الدور بنجاح');
    }
}
