<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $table = 'spatie_permissions';

    protected $fillable = [
        'name',
        'guard_name',
        'display_name',
        'group'
    ]

    public static function defaultPermissions()
    {
        return [
            // الأخبار
            ['name' => 'news.view', 'display_name' => 'عرض الأخبار', 'group' => 'الأخبار'],
            ['name' => 'news.create', 'display_name' => 'إضافة خبر', 'group' => 'الأخبار'],
            ['name' => 'news.edit', 'display_name' => 'تعديل خبر', 'group' => 'الأخبار'],
            ['name' => 'news.delete', 'display_name' => 'حذف خبر', 'group' => 'الأخبار'],

            // الفيديوهات
            ['name' => 'videos.view', 'display_name' => 'عرض الفيديوهات', 'group' => 'الفيديوهات'],
            ['name' => 'videos.create', 'display_name' => 'إضافة فيديو', 'group' => 'الفيديوهات'],
            ['name' => 'videos.edit', 'display_name' => 'تعديل فيديو', 'group' => 'الفيديوهات'],
            ['name' => 'videos.delete', 'display_name' => 'حذف فيديو', 'group' => 'الفيديوهات'],

            // المقالات
            ['name' => 'opinions.view', 'display_name' => 'عرض المقالات', 'group' => 'المقالات'],
            ['name' => 'opinions.create', 'display_name' => 'إضافة مقال', 'group' => 'المقالات'],
            ['name' => 'opinions.edit', 'display_name' => 'تعديل مقال', 'group' => 'المقالات'],
            ['name' => 'opinions.delete', 'display_name' => 'حذف مقال', 'group' => 'المقالات'],

            // الأقسام
            ['name' => 'categories.view', 'display_name' => 'عرض الأقسام', 'group' => 'الأقسام'],
            ['name' => 'categories.create', 'display_name' => 'إضافة قسم', 'group' => 'الأقسام'],
            ['name' => 'categories.edit', 'display_name' => 'تعديل قسم', 'group' => 'الأقسام'],
            ['name' => 'categories.delete', 'display_name' => 'حذف قسم', 'group' => 'الأقسام'],

            // الكتاب
            ['name' => 'writers.view', 'display_name' => 'عرض الكتاب', 'group' => 'الكتاب'],
            ['name' => 'writers.create', 'display_name' => 'إضافة كاتب', 'group' => 'الكتاب'],
            ['name' => 'writers.edit', 'display_name' => 'تعديل كاتب', 'group' => 'الكتاب'],
            ['name' => 'writers.delete', 'display_name' => 'حذف كاتب', 'group' => 'الكتاب'],

            // الإعدادات
            ['name' => 'settings.view', 'display_name' => 'عرض الإعدادات', 'group' => 'الإعدادات'],
            ['name' => 'settings.edit', 'display_name' => 'تعديل الإعدادات', 'group' => 'الإعدادات'],

            // المستخدمين
            ['name' => 'users.view', 'display_name' => 'عرض المستخدمين', 'group' => 'المستخدمين'],
            ['name' => 'users.create', 'display_name' => 'إضافة مستخدم', 'group' => 'المستخدمين'],
            ['name' => 'users.edit', 'display_name' => 'تعديل مستخدم', 'group' => 'المستخدمين'],
            ['name' => 'users.delete', 'display_name' => 'حذف مستخدم', 'group' => 'المستخدمين'],

            // الأدوار والصلاحيات
            ['name' => 'roles.view', 'display_name' => 'عرض الأدوار', 'group' => 'الأدوار والصلاحيات'],
            ['name' => 'roles.create', 'display_name' => 'إضافة دور', 'group' => 'الأدوار والصلاحيات'],
            ['name' => 'roles.edit', 'display_name' => 'تعديل دور', 'group' => 'الأدوار والصلاحيات'],
            ['name' => 'roles.delete', 'display_name' => 'حذف دور', 'group' => 'الأدوار والصلاحيات'],
        ];
    }
}
