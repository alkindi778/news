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
        @if ($section->category_id && count($news_items) > 8)
            <a href="{{ route('front.category', $section->category_id) }}" 
               class="flex items-center gap-2 text-white/90 hover:text-white text-sm bg-white/15 hover:bg-white/20 backdrop-blur-sm rounded-lg py-2 px-4 transition-all duration-300 shadow-sm hover:shadow group">
                <span>عرض المزيد</span>
                <i class="fas fa-chevron-left text-[10px] transform group-hover:translate-x-[-3px] transition-transform"></i>
            </a>
        @endif
    </div>

    @if (count($news_items) > 0)
        <div class="bg-white dark:bg-gray-800 p-6 rounded-b-lg shadow-md">
            <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 [&>*:not(:first-child)]:mt-4">
                @foreach($news_items as $news)
                    <div class="break-inside-avoid">
                        <a href="{{ route('front.news', $news->id) }}" class="group block bg-gray-50 dark:bg-gray-700/50 rounded-lg overflow-hidden">
                            <div class="relative aspect-[4/3] overflow-hidden">
                                <img 
                                    src="{{ url('storage/' . $news->image) }}"
                                    alt="{{ $news->title }}"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                                >
                                @if ($news->category)
                                    <span class="absolute top-3 right-3 bg-primary-600 text-white text-xs px-2 py-1 rounded">
                                        {{ $news->category->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 line-clamp-2">
                                    {{ $news->title }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                    {{ $news->subtitle }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // إعادة تنظيم العناصر عند تحميل الصفحة
    const masonryContainer = document.querySelector('.masonry-grid');
    if (masonryContainer) {
        const items = Array.from(masonryContainer.children);
        items.sort((a, b) => {
            const heightA = a.getBoundingClientRect().height;
            const heightB = b.getBoundingClientRect().height;
            return heightA - heightB;
        });
        items.forEach(item => masonryContainer.appendChild(item));
    }
});
</script>
@endpush
