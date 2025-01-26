@if(isset($news_items) && count($news_items) > 0)
<div class="mx-3 mb-6">
    <!-- Section Header -->
    <div class="bg-gradient-to-l from-blue-600 via-blue-500 to-blue-600 dark:from-blue-700 dark:via-blue-600 dark:to-blue-700 px-5 py-4 flex items-center justify-between relative overflow-hidden">
        <div class="flex items-center gap-4 relative">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/15">
                <i class="fas fa-chart-pie text-white text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-white tracking-wide">
                {{ $section->title }}
            </h3>
        </div>

        @if ($section->category_id)
            <a href="{{ route('front.category', $section->category_id) }}" 
               class="flex items-center gap-2 px-4 py-2 text-sm text-white/90 hover:text-white rounded-lg transition-colors duration-200">
                <span>عرض المزيد</span>
                <i class="fas fa-chevron-left text-xs"></i>
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
        @foreach($news_items->take(3) as $post)
            <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden group hover:shadow-lg dark:hover:shadow-gray-700 transition-all duration-300">
                <a href="{{ route('front.news', $post->id) }}" class="block">
                    <div class="relative overflow-hidden">
                        @if($post->image)
                            <img src="{{ url('storage/' . $post->image) }}" 
                                 class="w-full h-full object-contain transform group-hover:scale-110 transition-transform duration-500" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy">
                            @if($post->category)
                                <span class="absolute top-2 right-2 bg-primary-600 dark:bg-primary-500 text-white text-xs px-2 py-1 rounded">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 line-clamp-2">
                            <a href="{{ route('front.news', $post->id) }}">
                                {{ $post->title }}
                            </a>
                        </h3>

                        @if($post->description)
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-4">
                                {{ Str::limit($post->description, 150) }}
                            </p>
                        @endif

                        @if($post->category)
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <span class="flex items-center">
                                    <i class="fas fa-folder ml-2"></i>
                                    <a href="{{ route('front.category', $post->category->id) }}" 
                                       class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200">
                                        {{ $post->category->name }}
                                    </a>
                                </span>
                            </div>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@else
<div class="alert alert-info text-center p-4 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-lg">
    لا توجد منشورات متاحة حالياً
</div>
@endif
