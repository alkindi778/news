@extends('front.layouts.app')

@section('title'){{ $author->name }}@endsection

@section('content')
<!-- Breadcrumb -->
<div class="bg-gray-100 py-3 border-b dark:bg-slate-800">
    <div class="container mx-auto px-4">
        <div class="flex items-center text-sm text-gray-600 dark:text-gray-300">
            <a href="{{ route('front.home') }}" class="hover:text-blue-600 dark:hover:text-blue-400">الرئيسية</a>
            <svg class="mx-2 h-4 w-4 text-gray-400 dark:text-gray-300 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <a href="{{ route('front.opinions') }}" class="hover:text-blue-600 dark:hover:text-blue-400">مقالات الرأي</a>
            <svg class="mx-2 h-4 w-4 text-gray-400 dark:text-gray-300 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-blue-600 dark:text-blue-400">{{ $author->name }}</span>
        </div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-8">
            <!-- Author Profile -->
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm overflow-hidden mb-8">
                <div class="relative h-48 bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700">
                    <div class="absolute inset-0 flex flex-col justify-center px-8 text-white">
                        @if($author->bio)
                        <div class="bg-black/30 rounded-lg px-4 py-2 mb-4 text-base font-medium text-white/90 line-clamp-2">
                            {{ $author->bio }}
                        </div>
                        @endif
                        <h1 class="text-4xl font-bold mb-2">{{ $author->name }}</h1>
                        <p class="text-lg text-white/80">
                            <span class="inline-flex items-center">
                                <svg class="w-5 h-5 ml-1 opacity-80" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M18 2H8a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2zM9 4h2v6H9V4zm8 8h-2v2h-2v-2h-2v-2h2V8h2v2h2v2z"></path>
                                </svg>
                                كاتب رأي
                            </span>
                        </p>
                        
                        <!-- Social Media Links -->
                        @if($author->twitter_url || $author->facebook_url || $author->instagram_url || $author->linkedin_url)
                            <div class="flex items-center gap-4 mt-4">
                                @if($author->twitter_url)
                                    <a href="{{ $author->twitter_url }}" target="_blank" class="text-white hover:text-blue-200 transition-colors">
                                        <i class="fab fa-twitter fa-lg"></i>
                                    </a>
                                @endif
                                
                                @if($author->facebook_url)
                                    <a href="{{ $author->facebook_url }}" target="_blank" class="text-white hover:text-blue-200 transition-colors">
                                        <i class="fab fa-facebook-f fa-lg"></i>
                                    </a>
                                @endif
                                
                                @if($author->instagram_url)
                                    <a href="{{ $author->instagram_url }}" target="_blank" class="text-white hover:text-blue-200 transition-colors">
                                        <i class="fab fa-instagram fa-lg"></i>
                                    </a>
                                @endif
                                
                                @if($author->linkedin_url)
                                    <a href="{{ $author->linkedin_url }}" target="_blank" class="text-white hover:text-blue-200 transition-colors">
                                        <i class="fab fa-linkedin-in fa-lg"></i>
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-16 left-8">
                        @if($author->image)
                            <img src="{{ url('storage/' . $author->image) }}" 
                                 alt="{{ $author->name }}" 
                                 class="w-32 h-32 rounded-full border-4 border-white dark:border-slate-800 shadow-lg object-cover">
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-white dark:border-slate-800 shadow-lg bg-blue-600 flex items-center justify-center">
                                <span class="text-4xl font-bold text-white">{{ substr($author->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="pt-20 pb-8 px-8">
                </div>
            </div>

            <!-- Author's Articles -->
            <div class="space-y-8" 
                 x-data="{ 
                    articles: {{ Js::from($articles->map(function($article) {
                        return [
                            'id' => $article->id,
                            'title' => $article->title,
                            'url' => route('front.opinion.show', $article->id),
                            'created_at' => $article->created_at->format('Y/m/d')
                        ];
                    })) }},
                    currentPage: 1,
                    perPage: 10,
                    get paginatedArticles() {
                        const start = (this.currentPage - 1) * this.perPage;
                        const end = start + this.perPage;
                        return this.articles.slice(start, end);
                    },
                    get totalPages() {
                        return Math.ceil(this.articles.length / this.perPage);
                    },
                    nextPage() {
                        if (this.currentPage < this.totalPages) {
                            this.currentPage++;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    },
                    prevPage() {
                        if (this.currentPage > 1) {
                            this.currentPage--;
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                    }
                 }">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3 border-r-4 border-blue-600 dark:border-blue-400 pr-4">
                    <i class="fas fa-newspaper text-blue-600 dark:text-blue-400"></i>
                    مقالات الكاتب
                </h2>

                <template x-if="articles.length > 0">
                    <div>
                        <div class="grid gap-6">
                            <template x-for="article in paginatedArticles" :key="article.id">
                                <article class="group relative">
                                    <div class="relative bg-white dark:bg-slate-800 rounded-2xl overflow-hidden transform transition-all duration-500 hover:-translate-y-2 hover:shadow-xl border border-gray-100 dark:border-slate-700">
                                        <!-- Decorative Elements -->
                                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-l from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700"></div>
                                        <div class="absolute -left-6 top-20 w-24 h-24 bg-blue-600/10 rounded-full blur-2xl group-hover:bg-blue-600/20 transition-all duration-500"></div>
                                        <div class="absolute -right-6 bottom-20 w-24 h-24 bg-purple-600/10 rounded-full blur-2xl group-hover:bg-purple-600/20 transition-all duration-500"></div>
                                        
                                        <div class="relative p-8">
                                            <!-- Title Section -->
                                            <div class="flex-1 min-w-0">
                                                <a :href="article.url" class="block">
                                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-500 line-clamp-2 mb-4 leading-tight transition duration-200"
                                                        x-text="article.title"></h3>
                                                </a>
                                                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="flex items-center">
                                                        <i class="fas fa-calendar-alt ml-1"></i>
                                                        <span x-text="article.created_at"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </template>
                        </div>

                        <!-- Pagination -->
                        <template x-if="totalPages > 1">
                            <div class="mt-8 flex justify-center gap-4 items-center">
                                <button @click="prevPage" 
                                        :disabled="currentPage === 1"
                                        :class="{ 'opacity-50 cursor-not-allowed': currentPage === 1 }"
                                        class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                    <i class="fas fa-chevron-right"></i>
                                    السابق
                                </button>

                                <span class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                                    <span x-text="currentPage"></span> من <span x-text="totalPages"></span>
                                </span>

                                <button @click="nextPage" 
                                        :disabled="currentPage === totalPages"
                                        :class="{ 'opacity-50 cursor-not-allowed': currentPage === totalPages }"
                                        class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300">
                                    التالي
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="articles.length === 0">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-r-4 border-yellow-400 p-6 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-yellow-400 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-yellow-700 dark:text-yellow-400">لا توجد مقالات متاحة حالياً</p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4">
            @include('front.includes.sidebar')
        </div>
    </div>
</div>
@endsection
