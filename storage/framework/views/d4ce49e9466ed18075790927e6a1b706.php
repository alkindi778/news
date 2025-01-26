<?php $__env->startSection('content'); ?>
<div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white min-h-screen">
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <!-- Header Section -->
        <div class="mb-6 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-2xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700/50 backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="p-3 bg-blue-500/10 dark:bg-blue-500/5 rounded-lg">
                        <i class="fas fa-newspaper text-2xl sm:text-3xl text-blue-500 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">إدارة الأخبار</h1>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">إدارة ونشر المحتوى الإخباري</p>
                    </div>
                </div>
                <a href="<?php echo e(route('admin.news.create')); ?>" 
                   class="w-full sm:w-auto relative inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg transition-all duration-300 ease-out transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fas fa-plus ml-2 text-lg"></i>
                    <span class="font-bold">إضافة خبر جديد</span>
                </a>
            </div>
        </div>
        <?php
            $breakingNews = \App\Models\News::where('is_breaking', true)
                ->where('status', 'published')
                ->latest()
                ->get();
        ?>

        <?php if($breakingNews->count() > 0): ?>
        <!-- Breaking News Section -->
        <div class="mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="bg-red-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-bolt"></i>
                    الأخبار العاجلة
                </h2>
            </div>
            <div class="p-6">
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <?php $__currentLoopData = $breakingNews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 relative">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="font-bold text-gray-900 dark:text-white"><?php echo e($item->title); ?></h3>
                                <form action="<?php echo e(route('admin.news.update', $item->id)); ?>" method="POST" class="flex">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="hidden" name="is_breaking" value="0">
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                                            title="إيقاف الخبر العاجل"
                                            onclick="event.preventDefault(); if(confirm('هل أنت متأكد من إيقاف هذا الخبر العاجل؟')) this.closest('form').submit();">
                                        <i class="fas fa-times-circle text-xl"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                <p><i class="far fa-clock ml-1"></i><?php echo e($item->created_at->diffForHumans()); ?></p>
                                <p><i class="far fa-eye ml-1"></i><?php echo e($item->views_count); ?> مشاهدة</p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Search Bar -->
        <div class="mb-8">
            <div class="relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-white/20 dark:border-gray-700/30">
                <div class="flex items-center p-2">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fas fa-search text-gray-400/80 dark:text-gray-500"></i>
                        </div>
                        <input type="text" 
                               id="searchInput"
                               class="w-full pr-10 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm rounded-xl border-0 ring-1 ring-gray-200/50 dark:ring-gray-700/50 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500 block p-3.5 transition-all duration-200" 
                               placeholder="ابحث في الأخبار...">
                    </div>
                    <div id="searchLoading" class="absolute left-14 flex items-center hidden">
                        <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-500 border-t-transparent"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- News List - Card View for Mobile, Table for Larger Screens -->
        <div class="bg-white dark:bg-gray-800/50 overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 dark:border-gray-700/50">
            <!-- Mobile View (Cards) -->
            <div class="block sm:hidden">
                <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700/50">
                        <div class="flex items-start space-x-4 space-x-reverse">
                            <?php if($newsItem->image): ?>
                                <img class="w-20 h-20 rounded-lg object-cover" 
                                     src="<?php echo e(url('storage/' . $newsItem->image)); ?>" 
                                     alt="<?php echo e($newsItem->title); ?>"
                                     onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.jpg')); ?>';">
                            <?php endif; ?>
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 dark:text-white mb-2"><?php echo e($newsItem->title); ?></div>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <?php if($newsItem->featured): ?>
                                        <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs font-medium px-2 py-0.5 rounded">مميز</span>
                                    <?php endif; ?>
                                    <?php if($newsItem->breaking): ?>
                                        <span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 text-xs font-medium px-2 py-0.5 rounded">عاجل</span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <?php $__currentLoopData = $newsItem->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium px-2 py-0.5 rounded"><?php echo e($category->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <a href="<?php echo e(route('admin.news.edit', $newsItem)); ?>" 
                                       class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.news.destroy', $newsItem)); ?>" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                        لا توجد أخبار حالياً
                    </div>
                <?php endif; ?>
            </div>

            <!-- Desktop View (Table) -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">العنوان</th>
                            <th scope="col" class="px-4 py-3">القسم</th>
                            <th scope="col" class="px-4 py-3">الحالة</th>
                            <th scope="col" class="px-4 py-3">المشاهدات</th>
                            <th scope="col" class="px-4 py-3">تاريخ النشر</th>
                            <th scope="col" class="px-4 py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $newsItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/25">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <?php if($newsItem->image): ?>
                                            <img class="w-10 h-10 rounded-lg object-cover ml-3" 
                                                 src="<?php echo e(url('storage/' . $newsItem->image)); ?>" 
                                                 alt="<?php echo e($newsItem->title); ?>"
                                                 onerror="this.onerror=null; this.src='<?php echo e(asset('images/placeholder.jpg')); ?>';">
                                        <?php endif; ?>
                                        <div>
                                            <div class="font-semibold text-gray-900 dark:text-white"><?php echo e($newsItem->title); ?></div>
                                            <?php if($newsItem->featured): ?>
                                                <span class="bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">مميز</span>
                                            <?php endif; ?>
                                            <?php if($newsItem->breaking): ?>
                                                <span class="bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 text-xs font-medium px-2.5 py-0.5 rounded">عاجل</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <?php $__currentLoopData = $newsItem->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium ml-2 px-2.5 py-0.5 rounded"><?php echo e($category->name); ?></span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if($newsItem->status === 'published'): ?>
                                        <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium px-2.5 py-0.5 rounded">منشور</span>
                                    <?php else: ?>
                                        <span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 text-xs font-medium px-2.5 py-0.5 rounded">مسودة</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3"><?php echo e(number_format($newsItem->views_count)); ?></td>
                                <td class="px-4 py-3"><?php echo e($newsItem->published_at ? $newsItem->published_at->format('Y-m-d H:i') : '-'); ?></td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <a href="<?php echo e(route('admin.news.edit', $newsItem)); ?>" class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.news.destroy', $newsItem)); ?>" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    لا توجد أخبار حالياً
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($news->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const searchLoading = document.getElementById('searchLoading');
    const newsContainer = document.querySelector('.block.sm\\:hidden'); // Mobile container
    const newsTable = document.querySelector('tbody'); // Desktop container

    // Live search functionality
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchLoading.classList.remove('hidden');
            searchTimeout = setTimeout(() => performSearch(query), 300);
        } else if (query.length === 0) {
            window.location.href = '<?php echo e(route("admin.news.index")); ?>';
        }
    });

    async function performSearch(query) {
        try {
            const response = await fetch(`<?php echo e(route('admin.news.search')); ?>?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const data = await response.json();
            updateNewsDisplay(data.news);
        } catch (error) {
            console.error('Error performing search:', error);
        } finally {
            searchLoading.classList.add('hidden');
        }
    }

    function updateNewsDisplay(news) {
        // Update mobile view
        if (newsContainer) {
            newsContainer.innerHTML = news.length ? news.map(item => `
                <div class="p-4 border-b border-gray-200 dark:border-gray-700/50">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">${item.title}</h3>
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-eye ml-1"></i>
                                ${item.views_count || 0}
                            </span>
                            ${item.status === 'published' 
                                ? '<span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium px-2.5 py-0.5 rounded">منشور</span>'
                                : '<span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 text-xs font-medium px-2.5 py-0.5 rounded">مسودة</span>'}
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            ${item.categories.map(cat => 
                                `<span class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">${cat.name}</span>`
                            ).join('')}
                        </div>
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <a href="${item.edit_url}" class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="${item.delete_url}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            `).join('') : '<div class="p-4 text-center text-gray-500 dark:text-gray-400">لا توجد نتائج</div>';
        }

        // Update table view
        if (newsTable) {
            newsTable.innerHTML = news.length ? news.map(item => `
                <tr class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/25">
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">${item.title}</h3>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        ${item.categories.map(cat => 
                            `<span class="bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 text-xs font-medium ml-2 px-2.5 py-0.5 rounded">${cat.name}</span>`
                        ).join('')}
                    </td>
                    <td class="px-4 py-3">
                        ${item.status === 'published' 
                            ? '<span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium px-2.5 py-0.5 rounded">منشور</span>'
                            : '<span class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-400 text-xs font-medium px-2.5 py-0.5 rounded">مسودة</span>'}
                    </td>
                    <td class="px-4 py-3">${item.views_count || 0}</td>
                    <td class="px-4 py-3">${item.published_at || '-'}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <a href="${item.edit_url}" class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="${item.delete_url}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `).join('') : '<tr><td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">لا توجد نتائج</td></tr>';
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/admin/news/index.blade.php ENDPATH**/ ?>