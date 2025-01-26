<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // إنشاء دور المدير
        $adminRole = \Spatie\Permission\Models\Role::firstOrCreate([
            'name' => 'مدير النظام',
            'guard_name' => 'web'
        ]);

        // إعطاء دور المدير جميع الصلاحيات
        $permissions = \Spatie\Permission\Models\Permission::all();
        $adminRole->syncPermissions($permissions);

        // إنشاء حساب المدير
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'المدير',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // إعطاء المدير دور مدير النظام
        $admin->assignRole($adminRole);
    }
}
