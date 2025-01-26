@props(['section', 'news_items'])

<div class="w-full mb-4">
    <div class="bg-gradient-to-l from-blue-600 via-blue-500 to-blue-600 dark:from-blue-700 dark:via-blue-600 dark:to-blue-700 px-5 py-4 flex items-center justify-between relative overflow-hidden rounded-t-lg">
        <!-- زخرفة الخلفية -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute transform rotate-45 translate-x-[-50%] translate-y-[-50%] left-0 top-0 w-32 h-32 bg-white dark:bg-gray-200"></div>
            <div class="absolute transform rotate-45 translate-x-[50%] translate-y-[50%] right-0 bottom-0 w-32 h-32 bg-white dark:bg-gray-200"></div>
        </div>
        
        <div class="flex items-center gap-4 relative">
            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-white/15 backdrop-blur-sm shadow-inner">
                <i class="fas fa-newspaper text-white text-lg"></i>
            </div>
            <h3 class="text-lg font-bold text-white tracking-wide">
                {{ $section->title }}
            </h3>
        </div>
        @if ($section->category_id && count($news_items) > 6)
            <a href="{{ route('front.category', $section->category_id) }}" 
               class="flex items-center gap-2 text-white/90 hover:text-white text-sm bg-white/15 hover:bg-white/20 backdrop-blur-sm rounded-lg py-2 px-4 transition-all duration-300 shadow-sm hover:shadow group">
                <span>عرض المزيد</span>
                <i class="fas fa-chevron-left text-[10px] transform group-hover:translate-x-[-3px] transition-transform"></i>
            </a>
        @endif
    </div>

    @if (count($news_items) > 0)
        @if(auth()->check() && auth()->user()->is_admin)
            <div class="section-handle cursor-move bg-blue-500 text-white px-2 py-1 rounded-t-lg text-sm flex items-center justify-between">
                <span>{{ $section->title }}</span>
                <i class="fas fa-grip-vertical"></i>
            </div>
        @endif
        <div class="bg-white dark:bg-gray-800 p-4 lg:p-6 rounded-b-lg shadow-md">
            <div class="news-grid-mixed">
                <div class="news-grid-top">
                    @if($news_items->first())
                    <div class="news-item news-item-large">
                        <a href="{{ route('front.news', $news_items->first()->id) }}" class="block">
                            <div class="news-image-container">
                                <img src="{{ url('storage/' . $news_items->first()->image) }}"
                                     alt="{{ $news_items->first()->title }}"
                                     class="news-image"
                                     loading="lazy">
                                @if($news_items->first()->category)
                                    <span class="category-label">{{ $news_items->first()->category->name }}</span>
                                @endif
                            </div>
                            <div class="news-content p-4">
                                <h3 class="news-title text-gray-900 dark:text-gray-100">{{ $news_items->first()->title }}</h3>
                                <div class="news-excerpt text-gray-600 dark:text-gray-400">{{ Str::limit(strip_tags($news_items->first()->content), 200) }}</div>
                            </div>
                        </a>
                    </div>
                    @endif

                    <div class="news-grid-top-small">
                        @foreach($news_items->slice(1, 2) as $news)
                        <div class="news-item news-item-small-top">
                            <a href="{{ route('front.news', $news->id) }}" class="block">
                                <div class="news-image-container">
                                    <img src="{{ url('storage/' . $news->image) }}"
                                         alt="{{ $news->title }}"
                                         class="news-image"
                                         loading="lazy">
                                    @if($news->category)
                                        <span class="category-label">{{ $news->category->name }}</span>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <h3 class="news-title text-gray-900 dark:text-gray-100">{{ $news->title }}</h3>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="news-grid-bottom">
                    @foreach($news_items->slice(3, 4) as $news)
                    <div class="news-item news-item-small">
                        <a href="{{ route('front.news', $news->id) }}" class="block">
                            <div class="news-image-container">
                                <img src="{{ url('storage/' . $news->image) }}"
                                     alt="{{ $news->title }}"
                                     class="news-image"
                                     loading="lazy">
                                @if($news->category)
                                    <span class="category-label">{{ $news->category->name }}</span>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="news-title text-gray-900 dark:text-gray-100">{{ $news->title }}</h3>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.news-grid-mixed {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
}

.news-grid-top {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 1rem;
    width: 100%;
}

@media (min-width: 768px) {
    .news-grid-top {
        grid-template-columns: 1.6fr 1fr;
    }
}

.news-grid-top-small {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

@media (max-width: 767px) {
    .news-grid-top {
        grid-template-columns: 1fr;
    }
    
    .news-grid-top-small {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }
}

.news-grid-bottom {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

@media (min-width: 640px) {
    .news-grid-bottom {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .news-grid-bottom {
        grid-template-columns: repeat(4, 1fr);
    }
}

.news-item {
    background: #fff;
    border-radius: 0.5rem;
    overflow: hidden;
    position: relative;
    transition: all 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.dark .news-item {
    background: #374151;
    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.news-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.news-image-container {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.news-item-large .news-image-container {
    padding-top: 56%;
}

.news-item-small-top .news-image-container,
.news-item-small .news-image-container {
    padding-top: 65%;
}

.news-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-item:hover .news-image {
    transform: scale(1.03);
}

.category-label {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: #e31b1b;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
    z-index: 1;
}

.news-title {
    font-weight: 600;
    line-height: 1.5;
    margin: 0;
}

.news-item-large .news-title {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.news-item-small .news-title,
.news-item-small-top .news-title {
    font-size: 0.875rem;
}

.news-excerpt {
    font-size: 0.875rem;
    line-height: 1.6;
    margin-top: 0.5rem;
}

@media (max-width: 767px) {
    .news-grid-top {
        gap: 1rem;
    }
    
    .news-item-large .news-title {
        font-size: 1.125rem;
    }
    
    .news-excerpt {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
}
</style>
