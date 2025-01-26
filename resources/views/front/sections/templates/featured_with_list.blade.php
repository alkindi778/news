@props(['section', 'news_items'])

<div class="inline-block w-full md:w-[calc(50%-1.5rem)] mx-3 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl overflow-hidden transform hover:translate-y-[-2px] transition-all duration-300 h-full">
        <!-- رأس القسم -->
        <div class="bg-gradient-to-l from-blue-600 via-blue-500 to-blue-600 dark:from-blue-700 dark:via-blue-600 dark:to-blue-700 px-5 py-4 flex items-center justify-between relative">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/15">
                    <i class="fas fa-newspaper text-white text-lg"></i>
                </div>
                <h3 class="text-lg font-bold text-white tracking-wide">
                    {{ $section->title }}
                </h3>
            </div>

            <a href="{{ route('front.category', $section->category_id) }}" 
               class="flex items-center gap-2 text-white/90 hover:text-white text-sm bg-white/10 hover:bg-white/20 backdrop-blur-sm rounded-lg py-2 px-4 transition-all duration-300">
                <span>عرض المزيد</span>
                <i class="fas fa-arrow-left text-sm transition-transform group-hover:translate-x-1"></i>
            </a>
        </div>

        @if (count($news_items) > 0)
            <!-- الخبر الرئيسي مع الصورة الكبيرة -->
            <div class="p-5">
                <div class="bg-gray-50 dark:bg-gray-700 rounded overflow-hidden">
                    <a href="{{ route('front.news', $news_items[0]->id) }}" class="block">
                        <div class="relative aspect-[16/9] overflow-hidden">
                            <img src="{{ url('storage/' . $news_items[0]->image) }}" 
                                 alt="{{ $news_items[0]->title }}"
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            <!-- شريط التصنيف -->
                            @if($news_items[0]->category)
                                <div class="absolute bottom-4 right-4 bg-blue-600/90 text-white text-xs py-1.5 px-3 rounded-lg">
                                    {{ $news_items[0]->category->name }}
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h4 class="text-lg font-bold text-gray-800 dark:text-gray-100 line-clamp-2">
                                {{ $news_items[0]->title }}
                            </h4>
                            @if($news_items[0]->excerpt)
                                <p class="mt-2 text-gray-600 dark:text-gray-400 line-clamp-2">
                                    {{ $news_items[0]->excerpt }}
                                </p>
                            @endif
                        </div>
                    </a>
                </div>
            </div>

            <!-- قائمة الأخبار الأخرى -->
            <div class="divide-y dark:divide-gray-700">
                @foreach($news_items->slice(1) as $news)
                    <div>
                        <a href="{{ route('front.news', $news->id) }}" 
                           class="flex items-center gap-5 p-5">
                            <div class="relative w-28 aspect-[4/3] overflow-hidden rounded-xl">
                                <img src="{{ url('storage/' . $news->image) }}" 
                                     alt="{{ $news->title }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-black/20 to-transparent"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h5 class="text-base font-bold text-gray-800 dark:text-gray-100 line-clamp-2">
                                    {{ $news->title }}
                                </h5>
                                <time class="block mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $news->created_at->format('Y-m-d') }}
                                </time>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                    <i class="far fa-newspaper text-gray-400 dark:text-gray-500 text-2xl"></i>
                </div>
                <p class="text-gray-500 dark:text-gray-400">لا توجد أخبار متاحة حالياً</p>
            </div>
        @endif
    </div>
</div>
