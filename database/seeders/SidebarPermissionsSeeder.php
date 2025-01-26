<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class SidebarPermissionsSeeder extends Seeder
{
    public function run()
    {
        // تعريف الصلاحيات للقائمة الجانبية
        $permissions = [
            // لوحة التحكم
            [
                'name' => 'عرض لوحة التحكم',
                'guard_name' => 'web'
            ],

            // الأقسام
            [
                'name' => 'عرض الأقسام',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة الأقسام',
                'guard_name' => 'web'
            ],

            // الأخبار
            [
                'name' => 'عرض الأخبار',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة الأخبار',
                'guard_name' => 'web'
            ],

            // الفيديوهات
            [
                'name' => 'عرض الفيديوهات',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة الفيديوهات',
                'guard_name' => 'web'
            ],

            // المقالات
            [
                'name' => 'عرض المقالات',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة المقالات',
                'guard_name' => 'web'
            ],

            // الكتاب
            [
                'name' => 'عرض الكتاب',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة الكتاب',
                'guard_name' => 'web'
            ],

            // أغلفة الصحف
            [
                'name' => 'عرض أغلفة الصحف',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة أغلفة الصحف',
                'guard_name' => 'web'
            ],

            // المستخدمين
            [
                'name' => 'عرض المستخدمين',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة المستخدمين',
                'guard_name' => 'web'
            ],

            // الأدوار والصلاحيات
            [
                'name' => 'عرض الأدوار',
                'guard_name' => 'web'
            ],
            [
                'name' => 'إدارة الأدوار والصلاحيات',
                'guard_name' => 'web'
            ],
        ];

        // إنشاء الصلاحيات
        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }

        // إعطاء جميع الصلاحيات لدور المطور
        $adminRole = Role::where('name', 'مدير النظام')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }

        // إعطاء صلاحيات محددة لدور المحرر
        $editorRole = Role::where('name', 'محرر')->first();
        if ($editorRole) {
            $editorPermissions = Permission::whereIn('name', [
                'عرض لوحة التحكم',
                'عرض الأقسام',
                'عرض الأخبار',
                'إدارة الأخبار',
                'عرض الفيديوهات',
                'إدارة الفيديوهات',
                'عرض المقالات',
                'إدارة المقالات',
                'عرض الكتاب',
            ])->get();
            
            $editorRole->syncPermissions($editorPermissions);
        }
    }
}
