@php
$sidebars = \App\Models\Sidebar::where('active', true)
    ->orderBy('order')
    ->get();
@endphp

@foreach($sidebars as $sidebar)
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 pb-3 border-b-2 border-gray-200 dark:border-gray-700 flex items-center">
            <i class="fas {{ $sidebar->type == 'popular' || $sidebar->title == 'الاكثر قراءة' ? 'fa-chart-line' : 'fa-newspaper' }} ml-3 text-primary-600"></i>
            <span>{{ $sidebar->title }}</span>
        </h3>

        @if($sidebar->type == 'category')
            <div class="space-y-6">
                @php
                    if ($sidebar->category_id) {
                        $news = \App\Models\News::whereHas('categories', function($query) use ($sidebar) {
                                $query->where('categories.id', $sidebar->category_id);
                            });
                    } else {
                        $news = \App\Models\News::query();
                    }
                    
                    $news = $news->where('status', 'published')
                        ->latest()
                        ->take($sidebar->posts_count ?? 6)
                        ->get();
                @endphp
                
                @if($news->isNotEmpty())
                    @if($sidebar->layout_type == 'grid')
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($news as $item)
                                <div class="group">
                                    <a href="{{ route('front.news', $item->id) }}" class="block aspect-w-16 aspect-h-9 mb-3">
                                        @if($item->image)
                                            <img src="{{ url('storage/' . $item->image) }}" 
                                                 alt="{{ $item->title }}" 
                                                 class="w-full h-full object-cover rounded-lg shadow-sm transition-all duration-500 group-hover:scale-110 group-hover:shadow-md">
                                        @endif
                                    </a>
                                    <h4>
                                        <a href="{{ route('front.news', $item->id) }}"
                                           class="text-base font-bold text-gray-900 dark:text-white hover:text-primary-600 line-clamp-2">
                                            {{ $item->title }}
                                        </a>
                                    </h4>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($news as $item)
                                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden group">
                                    <a href="{{ route('front.news', $item->id) }}" class="block">
                                        @if($item->image)
                                            <img src="{{ url('storage/' . $item->image) }}" 
                                                 alt="{{ $item->title }}" 
                                                 class="w-full aspect-video object-cover transition-transform duration-500 group-hover:scale-110">
                                        @endif
                                    </a>
                                    <div class="p-4">
                                        <h4>
                                            <a href="{{ route('front.news', $item->id) }}"
                                               class="text-lg font-bold text-gray-900 dark:text-white hover:text-primary-600 line-clamp-2">
                                                {{ $item->title }}
                                            </a>
                                        </h4>
                                        <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-clock ml-1"></i>
                                            {{ $item->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @else
                    <p class="text-gray-500 dark:text-gray-400">لا توجد أخبار في هذا القسم</p>
                @endif
            </div>

        @elseif($sidebar->type == 'popular' || $sidebar->title == 'الاكثر قراءة')
            <div class="space-y-4">
                @php
                    $popularNews = \App\Models\News::where('status', 'published')
                        ->orderBy('views_count', 'desc')
                        ->take($sidebar->posts_count ?? 5)
                        ->get();
                @endphp

                @foreach($popularNews as $news)
                    <div class="flex items-start gap-4 group">
                        <a href="{{ route('front.news', $news->id) }}" class="shrink-0 relative w-20 aspect-[4/3] overflow-hidden rounded-lg">
                            @if($news->image)
                                <img src="{{ url('storage/' . $news->image) }}" 
                                     alt="{{ $news->title }}" 
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-gray-400 dark:text-gray-500 text-xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        <div class="flex-1 min-w-0">
                            <h4 class="mb-2">
                                <a href="{{ route('front.news', $news->id) }}" 
                                   class="text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-500 font-bold line-clamp-2 leading-tight">
                                    {{ $news->title }}
                                </a>
                            </h4>
                            <time class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $news->created_at->diffForHumans() }}
                            </time>
                        </div>
                    </div>
                @endforeach
            </div>

        @elseif($sidebar->type == 'ads')
            @php
                $ad = null;
                if ($sidebar->ad_id) {
                    $ad = \App\Models\Advertisement::where('id', $sidebar->ad_id)
                        ->where('position', 'sidebar')
                        ->where('active', true)
                        ->first();
                } else {
                    $ad = \App\Models\Advertisement::where('position', 'sidebar')
                        ->where('active', true)
                        ->latest()
                        ->first();
                }
            @endphp
            
            @if($ad)
                <div class="text-center">
                    @if($ad->link)
                        <a href="{{ $ad->link }}" target="_blank" rel="nofollow">
                    @endif
                    
                    @if($ad->image)
                        <img src="{{ url('storage/' . $ad->image) }}" 
                             alt="{{ $ad->title }}" 
                             class="mx-auto rounded-lg">
                    @else
                        {!! $ad->code !!}
                    @endif
                    
                    @if($ad->link)
                        </a>
                    @endif
                </div>
            @endif
        
        @elseif($sidebar->type == 'opinions')
            @php
                $opinions = \App\Models\Opinion::where('status', 'published')
                    ->latest()
                    ->take($sidebar->posts_count ?? 5)
                    ->get();
            @endphp

            <div class="space-y-4">
                @foreach($opinions as $opinion)
                    <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-md p-4 transition-all duration-300">
                        <div class="flex gap-4">
                            <div class="shrink-0 relative w-16 h-16 rounded-full overflow-hidden border-2 border-primary-100 dark:border-primary-900 group-hover:border-primary-500 dark:group-hover:border-primary-400 transition-colors duration-300">
                                @if($opinion->author && $opinion->author->image)
                                    <img src="{{ url('storage/' . $opinion->author->image) }}" 
                                         alt="{{ $opinion->author->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center">
                                        <i class="fas fa-user-pen text-primary-600 dark:text-primary-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="mb-2">
                                    <a href="{{ route('front.opinion.show', $opinion->id) }}" 
                                       class="block text-base font-bold text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400 line-clamp-2 leading-snug transition-colors duration-300">
                                        {{ $opinion->title }}
                                    </a>
                                </h4>
                                @if($opinion->author)
                                    <div class="flex items-center text-sm">
                                        <a href="{{ route('front.author', $opinion->author->id) }}" 
                                           class="flex items-center text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-300">
                                            <i class="fas fa-user-pen ml-1.5 text-xs opacity-80"></i>
                                            <span class="truncate">{{ $opinion->author->name }}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endforeach