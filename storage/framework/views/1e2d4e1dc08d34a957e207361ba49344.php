<?php $__env->startSection('title'); ?><?php echo e($article->title); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen py-8">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Main Content -->
            <main class="lg:col-span-8">
                <article class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                    <!-- Article Categories -->
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <div class="flex flex-wrap gap-2 mb-4">
                            <?php $__currentLoopData = $article->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('front.category', $category->id)); ?>" 
                                   class="inline-flex items-center px-3 py-1.5 bg-primary-50 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-medium rounded-full hover:bg-primary-100 dark:hover:bg-primary-900/50 transition-colors">
                                    <i class="fas fa-folder-open ml-1.5"></i>
                                    <?php echo e($category->name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Article Title & Subtitle -->
                        <?php if($article->subtitle): ?>
                            <h2 class="text-xl md:text-2xl leading-relaxed mb-4">
                                <span class="inline-block bg-gradient-to-l from-primary-50 to-primary-100/50 dark:from-primary-900/30 dark:to-primary-800/30 px-4 py-2 rounded-lg border-r-4 border-primary-500">
                                    <?php echo e($article->subtitle); ?>

                                </span>
                            </h2>
                        <?php endif; ?>

                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white leading-tight mb-6">
                            <?php echo e($article->title); ?>

                        </h1>

                        <!-- Article Meta -->
                        <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-center gap-2">
                                <span class="w-8 h-8 rounded-full bg-primary-100 dark:bg-primary-900/50 flex items-center justify-center">
                                    <i class="fas fa-calendar text-primary-600 dark:text-primary-400"></i>
                                </span>
                                <?php echo e($article->created_at->format('Y/m/d')); ?>

                            </div>
                        </div>
                    </div>

                    <!-- Article Image -->
                    <?php if($article->image): ?>
                        <div class="relative">
                            <img src="<?php echo e(url('storage/' . $article->image)); ?>" 
                                 alt="<?php echo e($article->title); ?>" 
                                 class="w-full h-auto">
                            
                            <?php if($article->image_caption): ?>
                                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent backdrop-blur-sm p-4">
                                    <p class="text-sm text-white text-center">
                                        <?php echo e($article->image_caption); ?>

                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="p-8">
                        <?php if($article->source): ?>
                            <div class="mb-8 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl border border-blue-100 dark:border-blue-800/30 shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 flex-shrink-0 rounded-full bg-blue-100 dark:bg-blue-800/50 flex items-center justify-center shadow-inner">
                                        <i class="fas fa-newspaper text-blue-600 dark:text-blue-400 text-xl"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                                            <?php echo e($article->source); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="prose prose-lg max-w-none dark:prose-invert">
                            <style>
                                .article-content {
                                    font-family: 'Noto Kufi Arabic', sans-serif;
                                    line-height: 1.8;
                                    color: #1a1a1a;
                                }
                                .dark .article-content {
                                    color: #e5e7eb;
                                }
                                .article-content p {
                                    margin-bottom: 1.5rem;
                                    text-align: justify;
                                    font-size: 1.125rem;
                                }
                                .article-content h2 {
                                    font-size: 1.5rem;
                                    font-weight: 700;
                                    margin-top: 2rem;
                                    margin-bottom: 1rem;
                                    color: #2563eb;
                                }
                                .dark .article-content h2 {
                                    color: #60a5fa;
                                }
                                .article-content ul, .article-content ol {
                                    margin: 1.5rem 1.5rem;
                                }
                                .article-content li {
                                    margin-bottom: 0.5rem;
                                }
                                .article-content blockquote {
                                    border-right: 4px solid #2563eb;
                                    padding: 1rem 2rem;
                                    margin: 1.5rem 0;
                                    background-color: #f8fafc;
                                    border-radius: 0.5rem;
                                }
                                .dark .article-content blockquote {
                                    background-color: #1e293b;
                                    border-right-color: #60a5fa;
                                }
                                .article-content img {
                                    border-radius: 0.75rem;
                                    margin: 2rem auto;
                                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                                }
                                .dark .article-content img {
                                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.18);
                                }
                                .article-content a {
                                    color: #2563eb;
                                    text-decoration: none;
                                    border-bottom: 1px solid transparent;
                                    transition: border-color 0.2s;
                                }
                                .dark .article-content a {
                                    color: #60a5fa;
                                }
                                .article-content a:hover {
                                    border-bottom-color: currentColor;
                                }
                            </style>
                            <div class="article-content">
                                <?php echo $article->content; ?>

                            </div>
                        </div>
                    </div>

                    <!-- Article Tags -->
                    <?php if($article->tags): ?>
                        <div class="px-6 pb-6">
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = $article->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-full">
                                        <i class="fas fa-tag ml-1.5 text-gray-500 dark:text-gray-400"></i>
                                        <?php echo e($tag); ?>

                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </article>  
                <!-- الكلمات المفتاحية -->
                <?php if(!empty($article->meta_keywords)): ?>
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                        <i class="fas fa-hashtag text-blue-600 dark:text-blue-400"></i>
                        الكلمات المفتاحية
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <?php $__currentLoopData = array_filter(explode(',', str_replace(['، ', ' '], ',', $article->meta_keywords))); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keyword): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('front.search', ['q' => trim($keyword)])); ?>" 
                               class="inline-flex items-center px-3 py-1.5 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-sm rounded-lg hover:bg-blue-200 dark:hover:bg-blue-800 transition-all duration-300">
                                #<?php echo e(trim($keyword)); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
                     <!-- مشاركة المقال -->
                     <div class="mt-12 sm:mt-16 pt-6 sm:pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white mb-4 sm:mb-6 flex items-center gap-3">
                                <i class="fas fa-share-alt text-blue-600 dark:text-blue-400"></i>
                                مشاركة الخبر 
                            </h3>
                            <div class="flex flex-wrap gap-3 sm:gap-4">
                                <button onclick="copyToClipboard('<?php echo e(route('front.news.show', $article->id)); ?>')"
                                        class="flex items-center justify-center px-4 sm:px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition duration-300 group copy-link-button">
                                    <svg class="w-5 h-5 ml-2 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                    </svg>
                                    نسخ الرابط
                                </button>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(route('front.news.show', $article->id))); ?>" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
                                    فيسبوك
                                </a>
                                <a href="https://wa.me/?text=<?php echo e(urlencode($article->title . ' ' . route('front.news.show', $article->id))); ?>" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-green-500 text-white rounded-full hover:bg-green-600 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652c1.746.943 3.71 1.444 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.495-8.411zM12.042 21.762h-.004c-1.771 0-3.507-.471-5.03-1.36l-.358-.214-3.741.981.999-3.648-.235-.374c-.978-1.55-1.495-3.34-1.494-5.154.002-5.366 4.372-9.73 9.742-9.73 2.6.001 5.044 1.014 6.88 2.854 1.836 1.841 2.848 4.286 2.846 6.884-.003 5.366-4.373 9.73-9.74 9.73zm5.972-7.003c-.294-.147-1.735-.853-2.004-.951-.268-.097-.463-.146-.657.148-.195.294-.752.952-.923 1.149-.17.196-.341.22-.635.073-.294-.147-1.24-.456-2.363-1.454-.874-.776-1.463-1.735-1.633-2.029-.171-.294-.019-.452.127-.6.131-.131.294-.342.44-.513.147-.17.196-.294.294-.489.098-.195.049-.366-.024-.513-.074-.147-.657-1.582-.902-2.167-.241-.574-.486-.497-.657-.505-.171-.008-.367-.01-.562-.01-.195 0-.513.073-.781.366-.269.294-1.027.952-1.027 2.324 0 1.372 1.003 2.696 1.149 2.891.146.195 2.026 3.093 4.91 4.349.685.295 1.22.472 1.637.605.688.217 1.314.186 1.809.113.552-.082 1.699-.694 1.94-1.362.241-.668.241-1.239.168-1.361-.073-.121-.268-.195-.562-.342z"/></svg>
                                    واتساب
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?php echo e(urlencode($article->title)); ?>&url=<?php echo e(urlencode(route('front.news.show', $article->id))); ?>" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    منصة x
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo e(urlencode(route('front.news.show', $article->id))); ?>&title=<?php echo e(urlencode($article->title)); ?>" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-blue-700 text-white rounded-full hover:bg-blue-800 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    لينكد إن
                                </a>
                            </div>
                        </div>              
                <!-- Related Articles -->
                <?php if($relatedArticles->count() > 0): ?>
                    <div class="mt-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                            <i class="fas fa-newspaper text-blue-600 dark:text-blue-400"></i>
                            أخبار ذات صلة
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            <?php $__currentLoopData = $relatedArticles->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden group hover:shadow-lg transition-all duration-300">
                                    <a href="<?php echo e(route('front.news', $related->id)); ?>" class="block">
                                        <?php if($related->image): ?>
                                            <div class="relative h-40 overflow-hidden">
                                                <img src="<?php echo e(url('storage/' . $related->image)); ?>" 
                                                     alt="<?php echo e($related->title); ?>" 
                                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                                <?php if($related->categories->isNotEmpty()): ?>
                                                    <span class="absolute top-2 right-2 px-2 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">
                                                        <?php echo e($related->categories->first()->name); ?>

                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-3">
                                            <h3 class="text-base font-bold mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                                <?php echo e($related->title); ?>

                                            </h3>
                                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                                <span><?php echo e($related->created_at->diffForHumans()); ?></span>
                                                <?php if($related->author): ?>
                                                    <span><?php echo e($related->author->name); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </main>

            <!-- Sidebar -->
            <aside class="lg:col-span-4">
                <?php echo $__env->make('front.includes.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </aside>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('front.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/front/pages/news.blade.php ENDPATH**/ ?>