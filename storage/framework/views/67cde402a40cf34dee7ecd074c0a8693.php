<?php $__env->startSection('title'); ?>الرئيسية<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <?php
        $betweenSectionsAds = App\Models\Advertisement::where('position', 'between_sections')
            ->where('active', true)
            ->latest()
            ->get();
        $adIndex = 0;
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-8">
            <?php echo $__env->make('front.includes.slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
            <!-- Newspaper Cover for Mobile -->
            <div class="lg:hidden mb-8">
                <?php echo $__env->make('front.includes.sidebar_cover', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            
            <!-- All Sections -->
            <div id="sortable-sections" class="flex flex-wrap -mx-3">
                <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($section->template === 'featured_with_list'): ?>
                        <?php echo $__env->make('front.sections.templates.featured_with_list', [
                            'section' => $section,
                            'news_items' => $section->getContent()
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php else: ?>
                        <div class="w-full px-3 mb-6">
                            <?php echo $__env->make('front.sections.templates.' . $section->template, [
                                'section' => $section,
                                'news_items' => $section->getContent()
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($index < count($sections) - 1 && isset($betweenSectionsAds[$adIndex])): ?>
                        <div class="w-full px-3 mb-6">
                            <?php if($betweenSectionsAds[$adIndex]->code): ?>
                                <?php echo $betweenSectionsAds[$adIndex]->code; ?>

                            <?php elseif($betweenSectionsAds[$adIndex]->image): ?>
                                <a href="<?php echo e($betweenSectionsAds[$adIndex]->url); ?>" target="_blank" class="block">
                                    <img src="<?php echo e(url('storage/' . $betweenSectionsAds[$adIndex]->image)); ?>" 
                                         alt="<?php echo e($betweenSectionsAds[$adIndex]->title); ?>"
                                         class="w-full h-auto rounded-lg">
                                </a>
                            <?php endif; ?>
                        </div>
                        <?php $adIndex++; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Desktop Sidebar -->
            <div class="hidden lg:block">
                <?php echo $__env->make('front.includes.sidebar_cover', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            
            <!-- Sidebar Content (Visible on all devices) -->
            <?php echo $__env->make('front.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if(auth()->guard()->check()): ?>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortableList = document.getElementById('sortable-sections');
            if (sortableList) {
                new Sortable(sortableList, {
                    animation: 150,
                    ghostClass: 'bg-blue-100',
                    handle: '.section-handle',
                    onEnd: function(evt) {
                        const items = [...evt.to.children].map((el, index) => ({
                            id: el.dataset.id,
                            order: index
                        }));

                        fetch('/admin/sections/reorder', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ items })
                        });
                    }
                });
            }
        });
    </script>
<?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/front/pages/home.blade.php ENDPATH**/ ?>