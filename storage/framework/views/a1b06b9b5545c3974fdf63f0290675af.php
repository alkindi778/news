
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

<div class="w-full bg-gray-900 rounded-lg shadow-xl overflow-hidden">
    <?php if(isset($section)): ?>
        <div class="bg-gradient-to-r from-red-600 to-red-800 px-6 py-5 flex items-center justify-between relative overflow-hidden rounded-t-lg">
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-14 h-14 flex items-center justify-center rounded-full bg-white shadow-lg">
                    <i class="fas fa-play text-red-600 text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-white tracking-wide">
                    <?php echo e($section->title ?? 'الفيديوهات'); ?>

                </h3>
            </div>
            
            <a href="<?php echo e(url('/videos')); ?>" 
               class="flex items-center gap-2 text-white hover:text-red-200 text-sm bg-white/10 hover:bg-white/20 rounded-full py-2.5 px-5 transition-all duration-300 group">
                <span>عرض الكل</span>
                <i class="fas fa-arrow-left text-sm transition-transform group-hover:translate-x-1"></i>
            </a>

            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20 z-0"></div>
        </div>
    <?php endif; ?>

    <?php if((isset($videos) && $videos->count() > 0) || (isset($news_items) && $news_items->count() > 0)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6 bg-gray-900 max-w-5xl mx-auto">
            <?php $__currentLoopData = (isset($videos) ? $videos : $news_items); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="video-card bg-gray-800 rounded-xl overflow-hidden shadow-lg transition-all duration-300 hover:shadow-2xl hover:scale-105 group">
                    <div class="relative aspect-video">
                        <div class="video-thumbnail cursor-pointer" 
                             onclick="playVideo(this, '<?php echo e($item->video_url); ?>', <?php echo e($item->id); ?>)">
                            <img src="<?php echo e($item->getThumbnailUrl()); ?>"
                                 alt="<?php echo e($item->title); ?>"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="bg-red-600 text-white p-4 rounded-full transform scale-0 group-hover:scale-100 transition-transform duration-300">
                                    <i class="fas fa-play text-xl"></i>
                                </span>
                            </div>
                        </div>
                        <div class="video-frame hidden absolute inset-0">
                            <iframe class="w-full h-full" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="text-lg font-semibold text-white mb-2 line-clamp-2"><?php echo e($item->title); ?></h4>
                        <p class="text-gray-400 text-sm line-clamp-3"><?php echo e($item->description); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-16 bg-gray-900">
            <div class="bg-gray-800 rounded-2xl p-8 inline-block shadow-lg">
                <i class="fas fa-video text-5xl text-red-600 mb-4"></i>
                <p class="text-gray-400 text-lg">لا توجد فيديوهات متاحة حالياً</p>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function playVideo(element, videoUrl, videoId) {
    const card = element.closest('.video-card');
    const thumbnail = card.querySelector('.video-thumbnail');
    const videoFrame = card.querySelector('.video-frame');
    const iframe = videoFrame.querySelector('iframe');
    
    let embedUrl = videoUrl;
    if (videoUrl.includes('youtube.com/watch?v=')) {
        const videoId = videoUrl.split('v=')[1].split('&')[0];
        embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
    } else if (videoUrl.includes('youtu.be/')) {
        const videoId = videoUrl.split('youtu.be/')[1];
        embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
    }
    
    iframe.src = embedUrl;
    thumbnail.classList.add('hidden');
    videoFrame.classList.remove('hidden');
    
    fetch(`/videos/${videoId}/view`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
}
</script>
<?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/front/sections/templates/videos.blade.php ENDPATH**/ ?>