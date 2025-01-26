@extends('front.layouts.app')

@section('title'){{ $opinion->title }}@endsection

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white dark:from-slate-900 dark:to-slate-800 min-h-screen">
    <div class="container mx-auto px-4 py-12 lg:py-20">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 bg-white/80 dark:bg-slate-800/80 p-4 rounded-xl shadow-sm backdrop-blur-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="{{ route('front.home') }}" class="inline-flex items-center text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                        <svg class="me-2.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        الرئيسية
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="mx-2 h-5 w-5 text-gray-400 dark:text-gray-500 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        <a href="{{ route('front.opinions') }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">مقالات الرأي</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="mx-2 h-5 w-5 text-gray-400 dark:text-gray-500 rtl:rotate-180" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        <span class="text-sm font-medium text-blue-600 dark:text-blue-400">{{ $opinion->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-8">
                <article class="bg-white dark:bg-slate-800 rounded-3xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <!-- صورة المقال -->
                    @if($opinion->image)
                    <div class="relative h-[300px] sm:h-[400px] lg:h-[500px] group">
                        <img src="{{ url('storage/' . $opinion->image) }}" 
                             alt="{{ $opinion->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/70"></div>
                    </div>
                    @endif

                    <!-- محتوى المقال -->
                    <div class="p-6 sm:p-8 lg:p-10">
                        <!-- معلومات الكاتب -->
                        @if($opinion->author)
                        <div class="relative mb-10 max-w-3xl mx-auto">
                            <div class="bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-700 dark:to-purple-700 rounded-xl p-8 shadow-xl transition-all duration-300 hover:shadow-2xl">
                                <div class="flex flex-col sm:flex-row items-center gap-8">
                                    <a href="{{ route('front.author', ['id' => $opinion->author->id]) }}" class="group shrink-0">
                                        @if($opinion->author->image)
                                            <img src="{{ url('storage/' . $opinion->author->image) }}" 
                                                 alt="{{ $opinion->author->name }}" 
                                                 class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-4 border-white/90 dark:border-slate-800 shadow-lg object-cover transition-all duration-300 group-hover:scale-105 group-hover:border-blue-200">
                                        @else
                                            <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-4 border-white/90 dark:border-slate-800 shadow-lg bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center transition-all duration-300 group-hover:scale-105 group-hover:border-blue-200">
                                                <span class="text-3xl sm:text-4xl font-bold text-white">{{ substr($opinion->author->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="flex-1 text-center sm:text-right space-y-4">
                                        <div>
                                            <a href="{{ route('front.author', ['id' => $opinion->author->id]) }}" class="group inline-block">
                                                <h3 class="text-2xl sm:text-3xl font-bold text-white group-hover:text-blue-200 transition-colors duration-200">{{ $opinion->author->name }}</h3>
                                            </a>
                                        </div>
                                        
                                        @if($opinion->author->bio)
                                        <p class="text-base text-blue-50/90 leading-relaxed">
                                            {{ Str::limit($opinion->author->bio, 200) }}
                                        </p>
                                        @endif

                                        <div class="flex items-center justify-center sm:justify-end gap-5 mt-4">
                                            @if($opinion->author->twitter_url)
                                                <a href="{{ $opinion->author->twitter_url }}" target="_blank" class="text-blue-100 hover:text-white transition-all duration-200 hover:scale-110">
                                                    <i class="fab fa-twitter text-xl"></i>
                                                </a>
                                            @endif
                                            @if($opinion->author->facebook_url)
                                                <a href="{{ $opinion->author->facebook_url }}" target="_blank" class="text-blue-100 hover:text-white transition-all duration-200 hover:scale-110">
                                                    <i class="fab fa-facebook text-xl"></i>
                                                </a>
                                            @endif
                                            @if($opinion->author->instagram_url)
                                                <a href="{{ $opinion->author->instagram_url }}" target="_blank" class="text-blue-100 hover:text-white transition-all duration-200 hover:scale-110">
                                                    <i class="fab fa-instagram text-xl"></i>
                                                </a>
                                            @endif
                                            @if($opinion->author->linkedin_url)
                                                <a href="{{ $opinion->author->linkedin_url }}" target="_blank" class="text-blue-100 hover:text-white transition-all duration-200 hover:scale-110">
                                                    <i class="fab fa-linkedin text-xl"></i>
                                                </a>
                                            @endif
                                        </div>

                                        <div class="flex items-center justify-center sm:justify-end gap-6 mt-4 pt-4 border-t border-white/10">
                                            <div class="flex items-center gap-2">
                                                <span class="text-sm text-blue-100/80">{{ $opinion->views }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fas fa-calendar-alt text-lg text-blue-100/80"></i>
                                                <span class="text-sm text-blue-100/80">{{ $opinion->created_at->format('Y/m/d') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- عنوان المقال -->
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-8 leading-tight">
                            {{ $opinion->title }}
                        </h1>

                        <!-- نص المقال -->
                        <div class="prose prose-lg dark:prose-invert max-w-none">
                            <div class="leading-relaxed space-y-6 text-gray-700 dark:text-gray-300 text-justify article-content">
                                {!! nl2br(e($opinion->content)) !!}
                            </div>
                        </div>

                        <!-- مشاركة المقال -->
                        <div class="mt-12 sm:mt-16 pt-6 sm:pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white mb-4 sm:mb-6 flex items-center gap-3">
                                <i class="fas fa-share-alt text-blue-600 dark:text-blue-400"></i>
                                مشاركة المقال
                            </h3>
                            <div class="flex flex-wrap gap-3 sm:gap-4">
                                <button onclick="copyToClipboard('{{ route('front.opinion.show', $opinion->id) }}')"
                                        class="flex items-center justify-center px-4 sm:px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 transition duration-300 group copy-link-button">
                                    <svg class="w-5 h-5 ml-2 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                                    </svg>
                                    نسخ الرابط
                                </button>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('front.opinion.show', $opinion->id)) }}" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/></svg>
                                    فيسبوك
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($opinion->title . ' ' . route('front.opinion.show', $opinion->id)) }}" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-green-500 text-white rounded-full hover:bg-green-600 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652c1.746.943 3.71 1.444 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.495-8.411zM12.042 21.762h-.004c-1.771 0-3.507-.471-5.03-1.36l-.358-.214-3.741.981.999-3.648-.235-.374c-.978-1.55-1.495-3.34-1.494-5.154.002-5.366 4.372-9.73 9.742-9.73 2.6.001 5.044 1.014 6.88 2.854 1.836 1.841 2.848 4.286 2.846 6.884-.003 5.366-4.373 9.73-9.74 9.73zm5.972-7.003c-.294-.147-1.735-.853-2.004-.951-.268-.097-.463-.146-.657.148-.195.294-.752.952-.923 1.149-.17.196-.341.22-.635.073-.294-.147-1.24-.456-2.363-1.454-.874-.776-1.463-1.735-1.633-2.029-.171-.294-.019-.452.127-.6.131-.131.294-.342.44-.513.147-.17.196-.294.294-.489.098-.195.049-.366-.024-.513-.074-.147-.657-1.582-.902-2.167-.241-.574-.486-.497-.657-.505-.171-.008-.367-.01-.562-.01-.195 0-.513.073-.781.366-.269.294-1.027.952-1.027 2.324 0 1.372 1.003 2.696 1.149 2.891.146.195 2.026 3.093 4.91 4.349.685.295 1.22.472 1.637.605.688.217 1.314.186 1.809.113.552-.082 1.699-.694 1.94-1.362.241-.668.241-1.239.168-1.361-.073-.121-.268-.195-.562-.342z"/></svg>
                                    واتساب
                                </a>
                                <a href="https://twitter.com/intent/tweet?text={{ urlencode($opinion->title) }}&url={{ urlencode(route('front.opinion.show', $opinion->id)) }}" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-black text-white rounded-full hover:bg-gray-800 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    منصة x
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('front.opinion.show', $opinion->id)) }}&title={{ urlencode($opinion->title) }}" 
                                   target="_blank" 
                                   class="flex items-center justify-center px-4 sm:px-6 py-3 bg-blue-700 text-white rounded-full hover:bg-blue-800 transition duration-300">
                                    <svg class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    لينكد إن
                                </a>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Related Articles -->
                @if($opinion->author && $opinion->author->opinions->count() > 1)
                <div class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">مقالات أخرى للكاتب</h2>
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach($opinion->author->opinions->where('id', '!=', $opinion->id)->take(3) as $relatedOpinion)
                            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition duration-300">
                                <a href="{{ route('front.opinion.show', $relatedOpinion->id) }}" class="block p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                        {{ $relatedOpinion->title }}
                                    </h3>
                                    <time class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $relatedOpinion->created_at->format('d/m/Y') }}
                                    </time>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-4 mt-8 lg:mt-0">
                @include('front.includes.sidebar')
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .article-content {
        font-size: 1.125rem;
        line-height: 1.85;
        color: #374151;
    }
    
    .article-content p {
        margin-bottom: 1.5rem;
    }
    
    .article-content p:first-of-type::first-letter {
        font-size: 3.5rem;
        font-weight: bold;
        float: right;
        margin: 0 0 0.5rem 1rem;
        color: #2563eb;
        line-height: 1;
        padding: 0.5rem;
        background-color: #eff6ff;
        border-radius: 0.5rem;
    }

    .article-content p:first-of-type {
        font-size: 1.25rem;
        color: #1f2937;
        font-weight: 500;
    }

    .article-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 2rem 0 1rem;
        color: #1f2937;
    }

    .article-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 1.5rem 0 1rem;
        color: #1f2937;
    }

    .article-content ul, .article-content ol {
        margin: 1rem 0;
        padding-right: 1.5rem;
    }

    .article-content li {
        margin-bottom: 0.5rem;
    }

    .article-content blockquote {
        border-right: 4px solid #3b82f6;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        font-style: italic;
    }

    @media (prefers-color-scheme: dark) {
        .article-content {
            color: #e5e7eb;
        }
        
        .article-content p:first-of-type::first-letter {
            color: #60a5fa;
            background-color: #1e3a8a;
        }
        
        .article-content p:first-of-type {
            color: #f3f4f6;
        }

        .article-content h2, .article-content h3 {
            color: #f3f4f6;
        }

        .article-content blockquote {
            background-color: #1f2937;
            border-color: #60a5fa;
        }
    }
</style>
@endpush

@push('scripts')
<script>
function copyToClipboard(text) {
    // Create a temporary input element
    const input = document.createElement('input');
    input.setAttribute('value', text);
    document.body.appendChild(input);
    
    // Select the text
    input.select();
    input.setSelectionRange(0, 99999); // For mobile devices
    
    // Copy the text
    document.execCommand('copy');
    
    // Remove the temporary input
    document.body.removeChild(input);
    
    // Show feedback
    const button = document.querySelector('.copy-link-button');
    const originalText = button.textContent;
    button.textContent = 'تم النسخ!';
    
    // Reset button text after 2 seconds
    setTimeout(() => {
        button.textContent = originalText;
    }, 2000);
}
</script>
@endpush
@endsection
