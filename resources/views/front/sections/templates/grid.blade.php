@props(['section', 'news_items'])

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
                {{ $section->title }}
            </h3>
        </div>

        @if ($section->category_id)
            <a href="{{ route('front.category', $section->category_id) }}" 
               class="flex items-center gap-2 text-white/90 hover:text-white text-sm bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg py-2 px-4 transition-all duration-300">
                <span>عرض المزيد</span>
                <i class="fas fa-arrow-left text-sm transition-transform group-hover:translate-x-1"></i>
            </a>
        @endif
    </div>

    @if(count($news_items) > 0)
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 p-3 sm:p-6 bg-white dark:bg-gray-800 rounded-b-lg">
            @foreach($news_items as $news)
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl overflow-hidden transform hover:translate-y-[-2px] transition-all duration-300">
                    <a href="{{ route('front.news', $news->id) }}" class="block">
                        <div class="relative aspect-[1/1] sm:aspect-[16/9] overflow-hidden">
                            <img src="{{ url('storage/' . $news->image) }}" 
                                 alt="{{ $news->title }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <!-- شريط التصنيف -->
                            @if($news->category)
                                <div class="absolute bottom-2 sm:bottom-4 right-2 sm:right-4 bg-blue-600/90 text-white text-[10px] sm:text-xs py-1 sm:py-1.5 px-2 sm:px-3 rounded-lg">
                                    {{ $news->category->name }}
                                </div>
                            @endif
                        </div>
                        <div class="p-3 sm:p-5">
                            <h4 class="text-sm sm:text-lg font-bold text-gray-800 dark:text-gray-100 line-clamp-2">
                                {{ $news->title }}
                            </h4>
                            <div class="hidden">{{ $news->views_count }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="p-8 text-center bg-white dark:bg-gray-800 rounded-b-lg">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                <i class="far fa-newspaper text-gray-400 dark:text-gray-500 text-2xl"></i>
            </div>
            <p class="text-gray-500 dark:text-gray-400">لا توجد أخبار متاحة حالياً</p>
        </div>
    @endif
</div>
