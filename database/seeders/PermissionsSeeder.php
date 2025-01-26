<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء الصلاحيات الأساسية
        $permissions = [
            // إدارة المستخدمين
            ['name' => 'manage_users', 'display_name' => 'إدارة المستخدمين', 'module' => 'users'],
            ['name' => 'view_users', 'display_name' => 'عرض المستخدمين', 'module' => 'users'],
            ['name' => 'create_users', 'display_name' => 'إضافة مستخدمين', 'module' => 'users'],
            ['name' => 'edit_users', 'display_name' => 'تعديل المستخدمين', 'module' => 'users'],
            ['name' => 'delete_users', 'display_name' => 'حذف المستخدمين', 'module' => 'users'],

            // إدارة الأدوار
            ['name' => 'manage_roles', 'display_name' => 'إدارة الأدوار', 'module' => 'roles'],
            ['name' => 'view_roles', 'display_name' => 'عرض الأدوار', 'module' => 'roles'],
            ['name' => 'create_roles', 'display_name' => 'إضافة أدوار', 'module' => 'roles'],
            ['name' => 'edit_roles', 'display_name' => 'تعديل الأدوار', 'module' => 'roles'],
            ['name' => 'delete_roles', 'display_name' => 'حذف الأدوار', 'module' => 'roles'],

            // إدارة مقالات الرأي
            ['name' => 'manage_opinions', 'display_name' => 'إدارة مقالات الرأي', 'module' => 'opinions'],
            ['name' => 'view_opinions', 'display_name' => 'عرض مقالات الرأي', 'module' => 'opinions'],
            ['name' => 'create_opinions', 'display_name' => 'إضافة مقالات رأي', 'module' => 'opinions'],
            ['name' => 'edit_opinions', 'display_name' => 'تعديل مقالات الرأي', 'module' => 'opinions'],
            ['name' => 'delete_opinions', 'display_name' => 'حذف مقالات الرأي', 'module' => 'opinions'],
            ['name' => 'publish_opinions', 'display_name' => 'نشر مقالات الرأي', 'module' => 'opinions'],

            // إدارة الكتاب
            ['name' => 'manage_authors', 'display_name' => 'إدارة الكتاب', 'module' => 'authors'],
            ['name' => 'view_authors', 'display_name' => 'عرض الكتاب', 'module' => 'authors'],
            ['name' => 'create_authors', 'display_name' => 'إضافة كتاب', 'module' => 'authors'],
            ['name' => 'edit_authors', 'display_name' => 'تعديل الكتاب', 'module' => 'authors'],
            ['name' => 'delete_authors', 'display_name' => 'حذف الكتاب', 'module' => 'authors'],
        ];

        // إنشاء الصلاحيات
        foreach ($permissions as $permission) {
            Permission::findOrCreate(
                $permission['name'],
                $permission['display_name'],
                $permission['module']
            );
        }

        // إنشاء الأدوار الأساسية
        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'description' => 'مدير النظام',
                'is_system' => true
            ]
        );

        $editorRole = Role::firstOrCreate(
            ['name' => 'editor'],
            [
                'description' => 'محرر',
                'is_system' => true
            ]
        );

        $authorRole = Role::firstOrCreate(
            ['name' => 'author'],
            [
                'description' => 'كاتب',
                'is_system' => true
            ]
        );

        // إسناد جميع الصلاحيات لمدير النظام
        $adminRole->syncPermissions(Permission::all());

        // إسناد صلاحيات المحرر
        $editorRole->syncPermissions(
            Permission::whereIn('name', [
                'view_opinions',
                'edit_opinions',
                'publish_opinions',
                'view_authors',
                'edit_authors'
            ])->get()
        );

        // إسناد صلاحيات الكاتب
        $authorRole->syncPermissions(
            Permission::whereIn('name', [
                'view_opinions',
                'create_opinions',
                'edit_opinions'
            ])->get()
        );
    }
}
