<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission; // <--- استيراد Spatie Permission

class PermissionSeeder extends Seeder
{
    public function run()
    {
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

            ['name' => 'purchases.view', 'label' => 'عرض المشتريات'],
            ['name' => 'purchases.create', 'label' => 'إضافة مشتريات'],
            ['name' => 'purchases.edit', 'label' => 'تعديل مشتريات'],
            ['name' => 'purchases.delete', 'label' => 'حذف مشتريات'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm['name']],
                ['label' => $perm['label'], 'guard_name' => 'web']
            );

        }
    }
}
