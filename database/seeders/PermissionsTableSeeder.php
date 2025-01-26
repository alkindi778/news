<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء الصلاحيات
        foreach (Permission::defaultPermissions() as $permission) {
            Permission::create($permission);
        }

        // إنشاء الأدوار الافتراضية
        $roles = [
            [
                'name' => 'مطور',
                'display_name' => 'مطور النظام',
                'description' => 'لديه كافة الصلاحيات في النظام'
            ],
            [
                'name' => 'أدمن',
                'display_name' => 'مدير النظام',
                'description' => 'يدير محتوى النظام'
            ],
            [
                'name' => 'محرر',
                'display_name' => 'محرر محتوى',
                'description' => 'يحرر المحتوى في النظام'
            ]
        ];

        foreach ($roles as $roleData) {
            $role = Role::create($roleData);

            // إعطاء كافة الصلاحيات للمطور
            if ($roleData['name'] === 'مطور') {
                $role->permissions()->attach(Permission::all());
            }
            // إعطاء صلاحيات محددة للأدمن
            elseif ($roleData['name'] === 'أدمن') {
                $role->permissions()->attach(
                    Permission::whereNotIn('group', ['الأدوار والصلاحيات', 'المستخدمين'])->get()
                );
            }
            // إعطاء صلاحيات محددة للمحرر
            elseif ($roleData['name'] === 'محرر') {
                $role->permissions()->attach(
                    Permission::whereIn('group', ['الأخبار', 'الفيديوهات', 'المقالات'])
                        ->whereIn('name', ['*.view', '*.create', '*.edit', '*.delete'])
                        ->get()
                );
            }
        }

        // إنشاء مستخدم مطور افتراضي
        $admin = User::create([
            'name' => 'مطور النظام',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password123'),
        ]);

        // إعطاء دور المطور للمستخدم
        $admin->roles()->attach(Role::where('name', 'مطور')->first());
    }
}
