<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class PermissionsReset extends Command
{
    protected $signature = 'permissions:reset';
    protected $description = 'إعادة تهيئة كل الصلاحيات والأدوار والمستخدم الإداري';

    public function handle()
    {
        $this->info("🚀 بدء إعادة تهيئة الصلاحيات...");

        // تعطيل قيود المفتاح الخارجي مؤقتًا
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // حذف الجداول القديمة إذا وجدت
        $tables = [
            'role_has_permissions',
            'model_has_permissions',
            'model_has_roles',
            'permissions',
            'roles',
            'permission_role',
            'rol_permission',
        ];

        foreach ($tables as $table) {
            if (DB::getSchemaBuilder()->hasTable($table)) {
                DB::statement("DROP TABLE IF EXISTS `$table`");
                $this->info("✅ تم حذف الجدول: $table");
            }
        }

        // إعادة تفعيل قيود المفتاح الخارجي
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // تشغيل المايجريشن الخاصة بالـ Spatie
        $this->call('migrate');

        $this->info("✅ المايجريشن تمت بنجاح");

        // إنشاء الصلاحيات
        $permissions = [
            ['name' => 'customers.view', 'label' => 'عرض العملاء'],
            ['name' => 'customers.create', 'label' => 'إضافة عملاء'],
            ['name' => 'customers.edit', 'label' => 'تعديل العملاء'],
            ['name' => 'customers.delete', 'label' => 'حذف العملاء'],

            ['name' => 'products.view', 'label' => 'عرض المنتجات'],
            ['name' => 'products.create', 'label' => 'إضافة منتجات'],
            ['name' => 'products.edit', 'label' => 'تعديل المنتجات'],
            ['name' => 'products.delete', 'label' => 'حذف المنتجات'],

            ['name' => 'invoices.view', 'label' => 'عرض الفواتير'],
            ['name' => 'invoices.create', 'label' => 'إضافة فواتير'],
            ['name' => 'invoices.edit', 'label' => 'تعديل الفواتير'],
            ['name' => 'invoices.delete', 'label' => 'حذف الفواتير'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                ['label' => $perm['label'], 'guard_name' => 'web']
            );
        }

        $this->info("✅ تم إنشاء الصلاحيات");

        // إنشاء الأدوار
        $rolesList = [
            'admin'      => 'مدير النظام',
            'accountant' => 'محاسب',
            'employee'   => 'موظف',
            'sales'      => 'مبيعات',
        ];

        foreach ($rolesList as $name => $label) {
            $role = Role::firstOrCreate(['name' => $name], ['guard_name' => 'web']);
            $role->syncPermissions(Permission::all());
        }

        $this->info("✅ تم إنشاء الأدوار وربطها بكل الصلاحيات");

        // إنشاء مستخدم إداري
        $adminEmail = 'admin@example.com';
        if (!User::where('email', $adminEmail)->exists()) {
            $admin = User::create([
                'name'     => 'Admin',
                'email'    => $adminEmail,
                'password' => Hash::make('12345678'),
                'is_admin' => 1,
            ]);

            $admin->assignRole('admin');

            $this->info("✅ تم إنشاء المستخدم الإداري بنجاح (Email: $adminEmail / Password: 12345678)");
        }

        $this->info("🎉 تمت إعادة تهيئة الصلاحيات بنجاح!");
    }
}
