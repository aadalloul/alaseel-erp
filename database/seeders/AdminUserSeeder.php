<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']); // إنشاء الدور إذا لم يكن موجود

        // تحقق إذا كان المستخدم موجود مسبقًا
        $user = User::where('email', 'admin@example.com')->first();

        if (!$user) {
            $user = User::create([
                'name' => 'دانا احمد عودة كرم',
                'email' => 'dkaram1@smail.ucas.edu.ps',
                'password' => Hash::make('12345678'),
            ]);

            $user->role()->associate($adminRole);
            $user->save();

            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
