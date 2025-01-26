<!-- Sidebar -->
<aside class="fixed right-0 w-64 h-screen bg-white dark:bg-gray-800 shadow-lg overflow-y-auto z-30 sidebar lg:translate-x-0"
       :class="{'translate-x-0': sidebarOpen, 'translate-x-full': !sidebarOpen}">
    <!-- Header -->
    <div class="p-4 flex justify-between items-center border-b dark:border-gray-700">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">لوحة التحكم</h1>
        <!-- Close button for mobile -->
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
    
    <nav class="mt-4">
        <div class="space-y-1 px-2">
            <!-- القسم الرئيسي -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_dashboard')): ?>
            <a href="<?php echo e(route('admin.dashboard')); ?>" 
                class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.dashboard') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                <i class="fas fa-tachometer-alt w-5 h-5 ml-3"></i>
                <span class="flex-1">لوحة التحكم</span>
            </a>
            <?php endif; ?>

            <!-- الأخبار -->
            <?php if(auth()->user()->can('view_posts') || auth()->user()->can('view_newspaper_covers')): ?>
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">الأخبار</p>
                <div class="space-y-1">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_posts')): ?>
                    <a href="<?php echo e(route('admin.news.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.news.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-newspaper w-5 h-5 ml-3"></i>
                        <span class="flex-1">الأخبار</span>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_newspaper_covers')): ?>
                    <a href="<?php echo e(route('admin.newspaper-covers.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.newspaper-covers.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-file-alt w-5 h-5 ml-3"></i>
                        <span class="flex-1">أغلفة الصحف</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- المقالات والكتاب -->
            <?php if(auth()->user()->can('view_opinions') || auth()->user()->can('view_writers')): ?>
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">المقالات والكتاب</p>
                <div class="space-y-1">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_writers')): ?>
                    <a href="<?php echo e(route('admin.writers.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.writers.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-users w-5 h-5 ml-3"></i>
                        <span class="flex-1">الكتاب</span>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_opinions')): ?>
                    <a href="<?php echo e(route('admin.opinions.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.opinions.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-pen w-5 h-5 ml-3"></i>
                        <span class="flex-1">المقالات</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- تنظيم الموقع -->
            <?php if(auth()->user()->can('view_videos') || 
                auth()->user()->can('view_categories') || 
                auth()->user()->can('view_advertisements') || 
                auth()->user()->can('view_sidebars') || 
                auth()->user()->can('view_sections') || 
                auth()->user()->can('view_media')): ?>
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">تنظيم الموقع</p>
                <div class="space-y-1">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_videos')): ?>
                    <a href="<?php echo e(route('admin.videos.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.videos.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-video w-5 h-5 ml-3"></i>
                        <span class="flex-1">الفيديوهات</span>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_advertisements')): ?>
                    <a href="<?php echo e(route('admin.advertisements.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.advertisements.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-ad w-5 h-5 ml-3"></i>
                        <span class="flex-1">الإعلانات</span>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_sidebars')): ?>
                    <a href="<?php echo e(route('admin.sidebars.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.sidebars.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-columns w-5 h-5 ml-3"></i>
                        <span class="flex-1">الشريط الجانبي</span>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_categories')): ?>
                    <a href="<?php echo e(route('admin.categories.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.categories.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-th w-5 h-5 ml-3"></i>
                        <span class="flex-1">الأقسام</span>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_media')): ?>
                    <a href="<?php echo e(route('admin.media.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.media.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-photo-video w-5 h-5 ml-3"></i>
                        <span class="flex-1">الوسائط المتعددة</span>
                    </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_sections')): ?>
                    <a href="<?php echo e(route('admin.sections.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.sections.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-layer-group w-5 h-5 ml-3"></i>
                        <span class="flex-1">أقسام الصفحة الرئيسية</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- المستخدمين -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_users')): ?>
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">المستخدمين</p>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.users.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.users.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-user w-5 h-5 ml-3"></i>
                        <span class="flex-1">المستخدمين</span>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- إدارة الأدوار والصلاحيات -->
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_roles')): ?>
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">إدارة الأدوار والصلاحيات</p>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.roles.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.roles.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-user-tag w-5 h-5 ml-3"></i>
                        <span class="flex-1">الأدوار والصلاحيات</span>
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <!-- النظام -->
            <div class="mt-4">
                <p class="px-3 mb-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">النظام</p>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.statistics')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.statistics') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-chart-bar w-5 h-5 ml-3"></i>
                        <span class="flex-1">الإحصائيات</span>
                    </a>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" 
                        class="flex items-center px-4 py-2.5 text-sm font-medium transition-colors duration-200 rounded-lg group <?php echo e(request()->routeIs('admin.settings.*') ? 'text-white bg-red-600' : 'text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-gray-700'); ?>">
                        <i class="fas fa-cog w-5 h-5 ml-3"></i>
                        <span class="flex-1">الإعدادات</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
</aside>
<?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/admin/sidebar/sidebar.blade.php ENDPATH**/ ?>