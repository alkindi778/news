@extends('front.layouts.app')

@section('title'){{ $category->name }}@endsection

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-700 to-blue-600 dark:from-blue-800 dark:to-blue-700 text-white py-12 relative">
    <div class="absolute inset-0 bg-blue-900/10"></div>
    <div class="container mx-auto px-4 relative">
        <nav class="mb-4 text-right">
            <ol class="flex items-center text-sm space-x-2 space-x-reverse">
                <li>
                    <a href="{{ route('front.home') }}" class="text-white/80 hover:text-white">الرئيسية</a>
                </li>
                <li>
                    <i class="fas fa-chevron-left mx-2 text-white/60"></i>
                </li>
                <li>
                    <a href="{{ route('front.category', $category->id) }}" class="text-white">{{ $category->name }}</a>
                </li>
            </ol>
        </nav>
        <div class="text-right">
            <h1 class="text-4xl font-bold mb-4 text-white">{{ $category->name }}</h1>
            <p class="text-lg text-white/90 leading-relaxed">{{ $category->description }}</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mx-auto py-12 px-4">
    <div class="flex flex-wrap lg:flex-nowrap gap-8">
        <!-- Articles Grid -->
        <div class="w-full lg:w-8/12">
            @if($posts->count() > 0)
                <div class="grid gap-8">
                    @foreach($posts as $post)
                        <article class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm overflow-hidden transform transition-all duration-500 hover:shadow-lg hover:-translate-y-1">
                            <div class="flex flex-col md:flex-row">
                                @if($post->image)
                                    <div class="md:w-1/3">
                                        <a href="{{ route('front.news', $post->id) }}" class="block relative h-48 md:h-full overflow-hidden">
                                            <img src="{{ url('storage/' . $post->image) }}" 
                                                 alt="{{ $post->title }}" 
                                                 class="w-full h-full object-cover transform transition-transform duration-500 hover:scale-110">
                                        </a>
                                    </div>
                                @endif
                                <div class="p-6 flex-1">
                                    <header>
                                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                                            <time datetime="{{ $post->created_at }}">{{ $post->created_at->format('Y/m/d') }}</time>
                                            @if($post->author)
                                                <span class="mx-2">•</span>
                                                <a href="{{ route('front.author', $post->author->id) }}" class="hover:text-primary-500">
                                                    {{ $post->author->name }}
                                                </a>
                                            @endif
                                        </div>
                                        <h2 class="text-xl font-bold mb-3">
                                            <a href="{{ route('front.news', $post->id) }}" class="hover:text-primary-500">
                                                {{ $post->title }}
                                            </a>
                                        </h2>
                                    </header>
                                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                        {{ Str::limit(strip_tags($post->content), 150) }}
                                    </p>
                                    <footer>
                                        <a href="{{ route('front.news', $post->id) }}" 
                                           class="inline-flex items-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300">
                                            اقرأ المزيد
                                            <i class="fas fa-arrow-left mr-2"></i>
                                        </a>
                                    </footer>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $posts->links('front.includes.pagination') }}
                </div>
            @else
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-r-4 border-yellow-400 p-6 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-yellow-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="font-bold text-yellow-800 dark:text-yellow-200">لا توجد مقالات</p>
                            <p class="text-yellow-700 dark:text-yellow-300">لم يتم نشر أي مقالات في هذا القسم بعد.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-4/12">
            @include('front.includes.sidebar')
        </div>
    </div>
</div>
@endsection
