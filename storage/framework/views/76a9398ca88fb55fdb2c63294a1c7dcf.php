<?php if($latestCover): ?>
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden mb-6">
    <div class="flex items-center justify-between px-4 py-3 bg-gradient-to-l from-red-600 to-red-700">
        <h3 class="text-lg font-bold text-white">
            غلاف الصحيفة
        </h3>
        <a href="<?php echo e(route('front.newspaper.archive')); ?>" 
           class="text-sm text-white/90 hover:text-white flex items-center gap-1 transition-colors duration-200">
            <span>الأرشيف</span>
            <i class="fas fa-archive"></i>
        </a>
    </div>
    
    <div class="p-4">
        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-md relative group">
            <a href="<?php echo e($latestCover->pdf_link ?? '#'); ?>" 
               target="_blank" 
               class="block relative group cursor-pointer">
                <img src="<?php echo e(url('storage/' . $latestCover->cover_image)); ?>"
                     alt="<?php echo e($latestCover->title); ?>"
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110 object-fill">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <span class="text-white text-lg font-medium opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                        <i class="fas fa-external-link-alt ml-2"></i>
                        عرض العدد
                    </span>
                </div>
            </a>
        </div>
        
        <div class="mt-4">
            <div class="text-center mb-4">
                <h4 class="font-bold text-xl mb-2 text-gray-800 dark:text-white"><?php echo e($latestCover->newspaper_name); ?></h4>
                <p class="text-gray-600 dark:text-gray-400"><?php echo e($latestCover->title); ?></p>
            </div>

            <div class="space-y-2">
                <?php if($latestCover->pdf_link): ?>
                    <a href="<?php echo e($latestCover->pdf_link); ?>" 
                       target="_blank"
                       class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 font-medium">
                        <i class="fas fa-external-link-alt"></i>
                        عرض العدد
                    </a>
                <?php endif; ?>
                <?php if($latestCover->pdf_file): ?>
                    <a href="<?php echo e(url('storage/' . $latestCover->pdf_file)); ?>" 
                       target="_blank"
                       class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 font-medium">
                        <i class="fas fa-file-pdf"></i>
                        تحميل PDF
                    </a>
                <?php endif; ?>
                
                <a href="<?php echo e(route('front.newspaper.archive')); ?>" 
                   class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg transition-colors duration-200 font-medium">
                    <i class="fas fa-archive"></i>
                    الأرشيف
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/front/includes/sidebar_cover.blade.php ENDPATH**/ ?>