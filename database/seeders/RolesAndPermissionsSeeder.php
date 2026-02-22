<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // مسح كاش الصلاحيات
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // الصلاحيات الأساسية
        $permissions = [
            'customers.view',
            'customers.create',
            'customers.edit',
            'customers.delete',

            'products.view',
            'products.create',
            'products.edit',
            'products.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate([
                'name' => $perm,
                'guard_name' => 'web',
            ]);
        }

        // دور الأدمن
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // إعطاء كل الصلاحيات للأدمن
        $adminRole->syncPermissions(Permission::all());

        // تعيين أول مستخدم كأدمن
        $user = User::first();
        if ($user && ! $user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
