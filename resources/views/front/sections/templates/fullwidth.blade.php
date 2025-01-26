@props(['section', 'news_items'])

<div class="mb-8">
    <div class="bg-gradient-to-l from-blue-600 via-blue-500 to-blue-600 dark:from-blue-700 dark:via-blue-600 dark:to-blue-700 px-5 py-4 flex items-center justify-between relative overflow-hidden rounded-t-lg">
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
        @if ($section->category_id && count($news_items) > 3)
            <a href="{{ route('front.category', $section->category_id) }}" 
               class="flex items-center gap-2 text-white/90 hover:text-white text-sm bg-white/15 hover:bg-white/20 backdrop-blur-sm rounded-lg py-2 px-4 transition-all duration-300 shadow-sm hover:shadow group">
                <span>عرض المزيد</span>
                <i class="fas fa-chevron-left text-[10px] transform group-hover:translate-x-[-3px] transition-transform"></i>
            </a>
        @endif
    </div>

    @if (count($news_items) > 0)
        <div class="bg-white dark:bg-gray-800 p-6 rounded-b-lg shadow-md">
            @foreach($news_items as $news)
                <a href="{{ route('front.news', $news->id) }}" class="group block mb-6 last:mb-0">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="relative md:w-1/3 aspect-video md:aspect-[16/10] overflow-hidden rounded-lg">
                            <img 
                                src="{{ url('storage/' . $news->image) }}"
                                alt="{{ $news->title }}"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                            >
                            @if ($news->category)
                                <span class="absolute top-4 right-4 bg-primary-600 text-white text-sm px-3 py-1 rounded-full">
                                    {{ $news->category->name }}
                                </span>
                            @endif
                        </div>
                        <div class="md:w-2/3">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-primary-600 transition-colors duration-200">
                                {{ $news->title }}
                            </h2>
                            <p class="mt-3 text-gray-600 dark:text-gray-400 line-clamp-3">
                                {{ $news->excerpt }}
                            </p>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 line-clamp-2">
                                    {{ $news->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                    {{ $news->subtitle }}
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
