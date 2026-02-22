<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
        ]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index')->with('success', 'تم إنشاء الدور بنجاح');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
        ]);
        $role->permissions()->sync($request->permissions);
        return redirect()->route('roles.index')->with('success', 'تم تحديث الدور بنجاح');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'تم حذف الدور بنجاح');
    }
}
