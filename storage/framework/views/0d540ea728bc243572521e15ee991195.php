<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps(['section', 'news_items']) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps(['section', 'news_items']); ?>
<?php foreach (array_filter((['section', 'news_items']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<div class="w-full mb-6">
    <div class="bg-gradient-to-l from-blue-600 via-blue-500 to-blue-600 dark:from-blue-700 dark:via-blue-600 dark:to-blue-700 px-5 py-4 flex items-center justify-between relative overflow-hidden rounded-t-lg">
        <!-- زخرفة الخلفية -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute transform rotate-45 translate-x-[-50%] translate-y-[-50%] left-0 top-0 w-32 h-32 bg-white"></div>
            <div class="absolute transform rotate-45 translate-x-[50%] translate-y-[50%] right-0 bottom-0 w-32 h-32 bg-white"></div>
        </div>
        
        <div class="flex items-center gap-4 relative">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/15">
                <i class="fas fa-newspaper text-white text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-white tracking-wide">
                <?php echo e($section->title); ?>

            </h3>
        </div>

        <?php if($section->category_id): ?>
            <a href="<?php echo e(route('front.category', $section->category_id)); ?>" 
               class="flex items-center gap-2 text-white/90 hover:text-white text-sm bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg py-2 px-4 transition-all duration-300">
                <span>عرض المزيد</span>
                <i class="fas fa-arrow-left text-sm transition-transform group-hover:translate-x-1"></i>
            </a>
        <?php endif; ?>
    </div>

    <?php if(count($news_items) > 0): ?>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 p-3 sm:p-6 bg-white dark:bg-gray-800 rounded-b-lg">
            <?php $__currentLoopData = $news_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl overflow-hidden transform hover:translate-y-[-2px] transition-all duration-300">
                    <a href="<?php echo e(route('front.news', $news->id)); ?>" class="block">
                        <div class="relative aspect-[1/1] sm:aspect-[16/9] overflow-hidden">
                            <img src="<?php echo e(url('storage/' . $news->image)); ?>" 
                                 alt="<?php echo e($news->title); ?>"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <!-- شريط التصنيف -->
                            <?php if($news->category): ?>
                                <div class="absolute bottom-2 sm:bottom-4 right-2 sm:right-4 bg-blue-600/90 text-white text-[10px] sm:text-xs py-1 sm:py-1.5 px-2 sm:px-3 rounded-lg">
                                    <?php echo e($news->category->name); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-3 sm:p-5">
                            <h4 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-gray-100 line-clamp-2">
                                <?php echo e($news->title); ?>

                            </h4>
                            <div class="hidden"><?php echo e($news->views_count); ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-b-lg">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                <i class="far fa-newspaper text-gray-400 dark:text-gray-500 text-2xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400">لا توجد أخبار متاحة حالياً</p>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/front/sections/templates/grid.blade.php ENDPATH**/ ?>