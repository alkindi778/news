<header class="w-full">
    <div class="bg-gradient-to-r from-primary-600 to-primary-800 dark:from-slate-800 dark:to-slate-900 text-white py-2">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between gap-2">
               <div class="flex items-center space-x-3 rtl:space-x-reverse">
                    <?php if($site_settings->facebook_url || $site_settings->twitter_url || $site_settings->instagram_url || $site_settings->youtube_url): ?>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <?php if($site_settings->facebook_url): ?>
                                <a href="<?php echo e($site_settings->facebook_url); ?>" target="_blank" class="text-white hover:text-primary-200 transition-colors duration-300">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            <?php endif; ?>
                            <?php if($site_settings->twitter_url): ?>
                                <a href="<?php echo e($site_settings->twitter_url); ?>" target="_blank" class="text-white hover:text-primary-200 transition-colors duration-300">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            <?php endif; ?>
                            <?php if($site_settings->instagram_url): ?>
                                <a href="<?php echo e($site_settings->instagram_url); ?>" target="_blank" class="text-white hover:text-primary-200 transition-colors duration-300">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                            <?php if($site_settings->youtube_url): ?>
                                <a href="<?php echo e($site_settings->youtube_url); ?>" target="_blank" class="text-white hover:text-primary-200 transition-colors duration-300">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-white text-sm">ليس هناك روابط لمواقع التواصل الاجتماعي حالياً</p>
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center gap-4">
                    <form action="<?php echo e(route('front.search')); ?>" method="GET" class="relative">
                        <input type="text" name="q" placeholder="ابحث هنا..."
                            class="search-input w-64 px-4 py-2 rounded-lg border-0 bg-gray-100 dark:bg-slate-700
                                   text-gray-900 dark:text-gray-100 placeholder-gray-500
                                   focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400"
                        value="<?php echo e(request('q')); ?>" minlength="2" required>
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary-500 dark:hover:text-primary-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
    
                    <button id="darkModeToggle"
                        class="relative inline-flex items-center h-7 w-12 rounded-full bg-gray-200 dark:bg-slate-700
                               transition-all duration-300 focus:outline-none">
                        <span class="absolute inset-0 rounded-full transition-colors duration-300 ease-in-out"></span>
                        <span class="absolute left-0.5 inline-block h-6 w-6 rounded-full
                                   transform transition-transform duration-300 ease-in-out
                                   translate-x-0 dark:translate-x-5
                                   bg-white dark:bg-primary-500
                                   shadow-md">
                            <svg class="absolute inset-0 h-6 w-6 p-1 text-gray-400 dark:hidden"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                            </svg>
                            <svg class="absolute inset-0 h-6 w-6 p-1 text-yellow-300 hidden dark:block"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 shadow-sm">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between gap-8">
                <a href="<?php echo e(route('front.home')); ?>" class="flex-shrink-0">
                    <?php if($site_settings && $site_settings->site_logo): ?>
                        <img src="<?php echo e(url('storage/' . $site_settings->site_logo)); ?>"
                            alt="<?php echo e($site_settings->site_name); ?>" 
                            class="h-auto" 
                            style="max-height: <?php echo e($site_settings->logo_height ?? '64'); ?>px; max-width: <?php echo e($site_settings->logo_width ?? '200'); ?>px;">
                    <?php else: ?>
                        <span class="text-2xl font-bold text-primary-600"><?php echo e($site_settings->site_name ?? config('app.name')); ?></span>
                    <?php endif; ?>
                </a>

                <?php
                    $headerAd = App\Models\Advertisement::where('position', 'header')
                        ->where('active', true)
                        ->latest()
                        ->first();
                ?>

                <?php if($headerAd && $headerAd->image_url): ?>
                    <div class="hidden md:block flex-grow">
                        <div class="flex justify-center items-center h-full">
                            <a href="<?php echo e($headerAd->link); ?>" target="_blank" class="block hover:opacity-95 transition-opacity" title="<?php echo e($headerAd->title); ?>">
                                <img src="<?php echo e($headerAd->image_url); ?>" 
                                     alt="<?php echo e($headerAd->title); ?>" 
                                     class="h-24 w-auto object-contain">
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- شريط الأخبار مع الشعار -->
    <div class="bg-primary-600 dark:bg-primary-700 text-white overflow-hidden py-2">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 bg-white text-primary-600 px-3 py-1 rounded-lg font-bold flex items-center">
                    <i class="fas fa-newspaper ml-2"></i>
                    آخر الأخبار
                </div>
                <div class="flex-1 overflow-hidden relative" x-data="{ play: true }"
                     x-init="$el.addEventListener('mouseover', () => play = false); $el.addEventListener('mouseout', () => play = true)">
                    <div class="whitespace-nowrap animate-marquee" x-bind:class="{ 'animate-play': play }">
                        <?php $__currentLoopData = $latestNews->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="inline-flex items-center">
                                <a href="<?php echo e(route('front.news', $news->id)); ?>" class="hover:text-primary-200">
                                    <?php echo e($news->title); ?>

                                </a>
                                <?php if(!$loop->last): ?>
                                    <i class="fas fa-circle text-xs mx-4 text-primary-400"></i>
                                <?php endif; ?>
                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

 <!-- Include Navigation -->
 <?php echo $__env->make('front.includes.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <!-- Below Navbar Advertisements -->
 <?php
 $below_navbar_ads = \App\Models\Advertisement::where('position', 'below_navbar')
                     ->where('active', true)
                     ->latest()
                     ->get();
 ?>
 
 <?php if($below_navbar_ads->count() > 0): ?>
 <div class="container mx-auto px-4 py-4">
     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
         <?php $__currentLoopData = $below_navbar_ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <div class="relative overflow-hidden rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                 <?php if($ad->link): ?>
                     <a href="<?php echo e($ad->link); ?>" target="_blank" class="block">
                 <?php endif; ?>
                     <img src="<?php echo e($ad->image_url); ?>" 
                          alt="<?php echo e($ad->title); ?>" 
                          class="w-full h-auto object-cover"
                          style="max-height: 90px;">
                 <?php if($ad->link): ?>
                     </a>
                 <?php endif; ?>
             </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     </div>
 </div>
 <?php endif; ?>
</header>
<style>
@keyframes marquee {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

.animate-marquee {
    animation: marquee 30s linear infinite;
}

.animate-play {
    animation-play-state: running;
}

.animate-pause {
    animation-play-state: paused;
}
</style><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/front/includes/header.blade.php ENDPATH**/ ?>