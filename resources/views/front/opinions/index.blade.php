@extends('front.layouts.app')

@section('title')مقالات الرأي@endsection

@section('content')
<!-- محتوى المقالات -->
<main class="min-h-screen bg-gray-50 dark:bg-slate-900">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-700 to-blue-600 dark:from-slate-800 dark:to-slate-900 text-white py-12 relative">
        <div class="absolute inset-0 bg-blue-900/10"></div>
        <div class="container mx-auto px-4 relative">
            <nav class="mb-4 text-right">
                <ol class="flex items-center text-sm space-x-2 space-x-reverse">
                    <li>
                        <a href="{{ route('front.home') }}" class="text-white/90 hover:text-white transition-colors">
                            <i class="fas fa-home ml-1"></i>
                            الرئيسية
                        </a>
                    </li>
                    <li class="text-white/60">/</li>
                    <li class="text-white">مقالات الرأي</li>
                </ol>
            </nav>
            <div class="text-right">
                <h1 class="text-4xl font-bold text-white">مقالات الرأي</h1>
                <p class="text-lg text-white/90 leading-relaxed">
                    اكتشف أحدث المقالات والآراء من نخبة الكتاب والمفكرين حول أهم القضايا والمواضيع المعاصرة
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto py-12 px-4">
        <div class="flex flex-wrap lg:flex-nowrap gap-8">
            <!-- Articles Grid -->
            <div class="w-full lg:w-8/12">
                @if($opinions->isEmpty())
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-r-4 border-yellow-400 p-6 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-yellow-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-yellow-700 dark:text-yellow-400">لا توجد مقالات متاحة حالياً</p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        @foreach($opinions as $article)
                        <article class="group relative">
                            <div class="relative bg-white dark:bg-slate-800 rounded-[2rem] overflow-hidden transform transition-all duration-500 hover:-translate-y-2">
                                <!-- Decorative Elements -->
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-l from-blue-600 via-purple-600 to-pink-600"></div>
                                <div class="absolute -left-6 top-20 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition-all duration-500"></div>
                                <div class="absolute -right-6 bottom-20 w-24 h-24 bg-purple-600/10 rounded-full blur-2xl group-hover:bg-purple-600/20 transition-all duration-500"></div>

                                <div class="relative p-8">
                                    <!-- Title Section -->
                                    <div class="mb-8">
                                        <div class="flex-1 min-w-0">
                                            <a href="{{ route('front.opinion.show', $article->id) }}" class="block">
                                                <h2 class="text-xl font-bold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors line-clamp-2 leading-8 mb-4">
                                                    {{ $article->title }}
                                                </h2>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Author Section -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <img src="{{ url('storage/' . $article->author->image) }}" 
                                                 alt="{{ $article->author->name }}" 
                                                 class="w-16 h-16 rounded-full object-cover">
                                            <div class="mr-4">
                                                <a href="{{ route('front.author', $article->author->id) }}" 
                                                   class="text-lg font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors block mb-1">
                                                    {{ $article->author->name }}
                                                </a>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $article->created_at->format('Y/m/d') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($opinions->hasPages())
                        <div class="mt-8">
                            {{ $opinions->links() }}
                        </div>
                    @endif
                @endif
            </div>

            <!-- Sidebar -->
            <div class="w-full lg:w-4/12">
                @include('front.includes.sidebar')
            </div>
        </div>
    </div>
</main>
@endsection
