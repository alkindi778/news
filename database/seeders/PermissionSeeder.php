<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // لوحة التحكم
            ['name' => 'view_dashboard', 'display_name' => 'عرض لوحة التحكم', 'group' => 'لوحة التحكم'],
            
            // الأخبار
            ['name' => 'view_posts', 'display_name' => 'عرض الأخبار', 'group' => 'الأخبار'],
            ['name' => 'create_posts', 'display_name' => 'إضافة خبر', 'group' => 'الأخبار'],
            ['name' => 'edit_posts', 'display_name' => 'تعديل خبر', 'group' => 'الأخبار'],
            ['name' => 'delete_posts', 'display_name' => 'حذف خبر', 'group' => 'الأخبار'],
            ['name' => 'publish_posts', 'display_name' => 'نشر الأخبار', 'group' => 'الأخبار'],

            // أغلفة الصحف
            ['name' => 'view_newspaper_covers', 'display_name' => 'عرض أغلفة الصحف', 'group' => 'أغلفة الصحف'],
            ['name' => 'create_newspaper_covers', 'display_name' => 'إضافة غلاف صحيفة', 'group' => 'أغلفة الصحف'],
            ['name' => 'edit_newspaper_covers', 'display_name' => 'تعديل غلاف صحيفة', 'group' => 'أغلفة الصحف'],
            ['name' => 'delete_newspaper_covers', 'display_name' => 'حذف غلاف صحيفة', 'group' => 'أغلفة الصحف'],

            // المقالات
            ['name' => 'view_opinions', 'display_name' => 'عرض المقالات', 'group' => 'المقالات'],
            ['name' => 'create_opinions', 'display_name' => 'إضافة مقال', 'group' => 'المقالات'],
            ['name' => 'edit_opinions', 'display_name' => 'تعديل مقال', 'group' => 'المقالات'],
            ['name' => 'delete_opinions', 'display_name' => 'حذف مقال', 'group' => 'المقالات'],
            ['name' => 'publish_opinions', 'display_name' => 'نشر المقالات', 'group' => 'المقالات'],

            // الكتاب
            ['name' => 'view_writers', 'display_name' => 'عرض الكتاب', 'group' => 'الكتاب'],
            ['name' => 'create_writers', 'display_name' => 'إضافة كاتب', 'group' => 'الكتاب'],
            ['name' => 'edit_writers', 'display_name' => 'تعديل كاتب', 'group' => 'الكتاب'],
            ['name' => 'delete_writers', 'display_name' => 'حذف كاتب', 'group' => 'الكتاب'],

            // الفيديوهات
            ['name' => 'view_videos', 'display_name' => 'عرض الفيديوهات', 'group' => 'الفيديوهات'],
            ['name' => 'create_videos', 'display_name' => 'إضافة فيديو', 'group' => 'الفيديوهات'],
            ['name' => 'edit_videos', 'display_name' => 'تعديل فيديو', 'group' => 'الفيديوهات'],
            ['name' => 'delete_videos', 'display_name' => 'حذف فيديو', 'group' => 'الفيديوهات'],
            ['name' => 'publish_videos', 'display_name' => 'نشر الفيديوهات', 'group' => 'الفيديوهات'],

            // الإعلانات
            ['name' => 'view_advertisements', 'display_name' => 'عرض الإعلانات', 'group' => 'الإعلانات'],
            ['name' => 'create_advertisements', 'display_name' => 'إضافة إعلان', 'group' => 'الإعلانات'],
            ['name' => 'edit_advertisements', 'display_name' => 'تعديل إعلان', 'group' => 'الإعلانات'],
            ['name' => 'delete_advertisements', 'display_name' => 'حذف إعلان', 'group' => 'الإعلانات'],

            // الشريط الجانبي
            ['name' => 'view_sidebars', 'display_name' => 'عرض الشريط الجانبي', 'group' => 'الشريط الجانبي'],
            ['name' => 'create_sidebars', 'display_name' => 'إضافة شريط جانبي', 'group' => 'الشريط الجانبي'],
            ['name' => 'edit_sidebars', 'display_name' => 'تعديل شريط جانبي', 'group' => 'الشريط الجانبي'],
            ['name' => 'delete_sidebars', 'display_name' => 'حذف شريط جانبي', 'group' => 'الشريط الجانبي'],

            // الأقسام
            ['name' => 'view_categories', 'display_name' => 'عرض الأقسام', 'group' => 'الأقسام'],
            ['name' => 'create_categories', 'display_name' => 'إضافة قسم', 'group' => 'الأقسام'],
            ['name' => 'edit_categories', 'display_name' => 'تعديل قسم', 'group' => 'الأقسام'],
            ['name' => 'delete_categories', 'display_name' => 'حذف قسم', 'group' => 'الأقسام'],

            // الوسائط المتعددة
            ['name' => 'view_media', 'display_name' => 'عرض الوسائط', 'group' => 'الوسائط'],
            ['name' => 'upload_media', 'display_name' => 'رفع وسائط', 'group' => 'الوسائط'],
            ['name' => 'delete_media', 'display_name' => 'حذف وسائط', 'group' => 'الوسائط'],

            // أقسام الصفحة الرئيسية
            ['name' => 'view_sections', 'display_name' => 'عرض أقسام الصفحة الرئيسية', 'group' => 'أقسام الصفحة الرئيسية'],
            ['name' => 'create_sections', 'display_name' => 'إضافة قسم للصفحة الرئيسية', 'group' => 'أقسام الصفحة الرئيسية'],
            ['name' => 'edit_sections', 'display_name' => 'تعديل قسم في الصفحة الرئيسية', 'group' => 'أقسام الصفحة الرئيسية'],
            ['name' => 'delete_sections', 'display_name' => 'حذف قسم من الصفحة الرئيسية', 'group' => 'أقسام الصفحة الرئيسية'],

            // المستخدمين
            ['name' => 'view_users', 'display_name' => 'عرض المستخدمين', 'group' => 'المستخدمين'],
            ['name' => 'create_users', 'display_name' => 'إضافة مستخدم', 'group' => 'المستخدمين'],
            ['name' => 'edit_users', 'display_name' => 'تعديل مستخدم', 'group' => 'المستخدمين'],
            ['name' => 'delete_users', 'display_name' => 'حذف مستخدم', 'group' => 'المستخدمين'],

            // الأدوار والصلاحيات
            ['name' => 'view_roles', 'display_name' => 'عرض الأدوار', 'group' => 'الأدوار'],
            ['name' => 'create_roles', 'display_name' => 'إضافة دور', 'group' => 'الأدوار'],
            ['name' => 'edit_roles', 'display_name' => 'تعديل دور', 'group' => 'الأدوار'],
            ['name' => 'delete_roles', 'display_name' => 'حذف دور', 'group' => 'الأدوار'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'],
                    'group' => $permission['group'],
                    'guard_name' => 'web'
                ]
            );
        }
    }
}
