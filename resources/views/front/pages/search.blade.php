@extends('front.layouts.app')

@section('title', 'نتائج البحث: ' . $query)

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 mb-8">
        <h1 class="text-2xl font-bold mb-6">نتائج البحث عن: {{ $query }}</h1>
        
        @if($news->total() > 0)
            <div class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                تم العثور على {{ $news->total() }} نتيجة
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($news as $article)
                    <article class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden">
                        @if($article->getFirstMedia('thumbnail'))
                            <a href="{{ route('front.news', $article->id) }}" class="block aspect-w-16 aspect-h-9">
                                <img src="{{ $article->getFirstMedia('thumbnail')->getUrl('thumb') }}" 
                                     alt="{{ $article->title }}"
                                     class="w-full h-full object-cover">
                            </a>
                        @endif
                        
                        <div class="p-4">
                            @if($article->categories->isNotEmpty())
                                <div class="mb-2">
                                    @foreach($article->categories as $category)
                                        <a href="{{ route('front.category', $category->id) }}" 
                                           class="text-xs text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                                            {{ $category->name }}
                                        </a>
                                        @if(!$loop->last)
                                            <span class="mx-1">•</span>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                            
                            <h2 class="text-lg font-bold mb-2">
                                <a href="{{ route('front.news', $article->id) }}" 
                                   class="hover:text-primary-600 dark:hover:text-primary-400">
                                    {{ $article->title }}
                                </a>
                            </h2>
                            
                            @if($article->subtitle)
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                                    {{ Str::limit($article->subtitle, 120) }}
                                </p>
                            @endif
                            
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <span class="flex items-center">
                                    <i class="fas fa-clock ml-1"></i>
                                    {{ $article->created_at->translatedFormat('d M Y') }}
                                </span>
                                <span class="mx-2">•</span>
                                <span class="flex items-center">
                                    <i class="fas fa-eye ml-1"></i>
                                    {{ $article->views_count }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $news->appends(['q' => $query])->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-xl font-bold mb-2">لم يتم العثور على نتائج</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    جرب البحث باستخدام كلمات مختلفة أو تصفح الأقسام من القائمة الرئيسية
                </p>
            </div>
        @endif
    </div>
</div>
@endsection
