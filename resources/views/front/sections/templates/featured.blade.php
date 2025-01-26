@props(['section', 'news_items'])

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
    <div class="bg-gradient-to-l from-blue-600 via-blue-500 to-blue-600 dark:from-blue-700 dark:via-blue-600 dark:to-blue-700 px-5 py-4 flex items-center justify-between relative overflow-hidden">
        <!-- زخرفة الخلفية -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute transform rotate-45 translate-x-[-50%] translate-y-[-50%] left-0 top-0 w-32 h-32 bg-white"></div>
            <div class="absolute transform rotate-45 translate-x-[50%] translate-y-[50%] right-0 bottom-0 w-32 h-32 bg-white"></div>
        </div>
        
        <div class="flex items-center gap-4 relative">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/15 backdrop-blur-sm shadow-inner">
                <i class="fas fa-newspaper text-white text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-white tracking-wide">
                {{ $section->title }}
            </h3>
        </div>
        @if ($section->category_id && count($news_items) > 4)
            <a href="{{ route('front.category', $section->category_id) }}" 
               class="flex items-center gap-2 text-white/90 hover:text-white text-sm bg-white/15 hover:bg-white/20 backdrop-blur-sm rounded-lg py-2 px-4 transition-all duration-300 shadow-sm hover:shadow group">
                <span>عرض المزيد</span>
                <i class="fas fa-chevron-left text-[10px] transform group-hover:translate-x-[-3px] transition-transform"></i>
            </a>
        @endif
    </div>

    @if (count($news_items) > 0)
        @php
            $main_news = $news_items->shift(); // أخذ أول خبر للعرض الرئيسي
            $side_news = $news_items->take(3); // أخذ 3 أخبار جانبية
        @endphp

        <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Featured News -->
            <div class="lg:col-span-2">
                <a href="{{ route('front.news', $main_news->id) }}" class="group block">
                    <div class="relative aspect-video overflow-hidden rounded-lg">
                        <img 
                            src="{{ url('storage/' . $main_news->image) }}"
                            alt="{{ $main_news->title }}"
                            class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                        >
                        @if ($main_news->category)
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent">
                                <div class="absolute bottom-0 p-6">
                                    <h2 class="text-2xl font-bold text-white mb-2">
                                        {{ $main_news->title }}
                                    </h2>
                                    <p class="text-gray-200 line-clamp-2">
                                        {{ $main_news->subtitle }}
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </a>
            </div>

            <!-- Side News -->
            <div class="space-y-6">
                @foreach($side_news as $news)
                    <a href="{{ route('front.news', $news->id) }}" class="group flex gap-4">
                        <div class="relative w-24 h-24 flex-shrink-0 overflow-hidden rounded">
                            <img 
                                src="{{ url('storage/' . $news->image) }}"
                                alt="{{ $news->title }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                            >
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 line-clamp-2">
                                {{ $news->title }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                {{ $news->subtitle }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
