@extends('front.layouts.app')

@section('title', $video->title)

@section('content')
<div class="video-details-page py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- الفيديو الرئيسي -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                    <!-- مشغل الفيديو -->
                    <div class="relative pb-[56.25%] bg-black">
                        <iframe 
                            src="{{ $video->getYoutubeEmbedUrlAttribute() }}" 
                            class="absolute inset-0 w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                    
                    <!-- تفاصيل الفيديو -->
                    <div class="p-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $video->title }}</h1>
                        
                        @if($video->section)
                            <div class="mb-4">
                                <a href="{{ route('front.videos.index', ['section' => $video->section->id]) }}" 
                                   class="inline-block bg-primary-50 dark:bg-gray-700 text-primary-600 dark:text-primary-400 text-sm px-3 py-1 rounded-full hover:bg-primary-100 dark:hover:bg-gray-600 transition-colors duration-200">
                                    {{ $video->section->name }}
                                </a>
                            </div>
                        @endif

                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ $video->description }}</p>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                            <span class="flex items-center">
                                <i class="far fa-calendar-alt ml-1"></i>
                                {{ $video->created_at->format('Y/m/d') }}
                            </span>
                            <span class="mx-3">•</span>
                            <span class="flex items-center">
                                <i class="far fa-eye ml-1"></i>
                                {{ $video->views_count ?? 0 }} مشاهدة
                            </span>
                        </div>
                        
                        <!-- أزرار المشاركة -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-4">
                                <span class="text-gray-600 dark:text-gray-400">مشاركة:</span>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($video->title) }}" 
                                   target="_blank"
                                   class="text-blue-400 hover:text-blue-500 dark:text-blue-300 dark:hover:text-blue-200">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($video->title . ' ' . request()->url()) }}" 
                                   target="_blank"
                                   class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- الفيديوهات ذات الصلة -->
            <div class="lg:col-span-1">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">فيديوهات ذات صلة</h3>
                <div class="space-y-4">
                    @foreach($relatedVideos as $relatedVideo)
                    <a href="{{ route('front.videos.show', $relatedVideo) }}" 
                       class="block group bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="flex">
                            <div class="relative w-40 h-24">
                                <img src="{{ $relatedVideo->getThumbnailUrl() }}" 
                                     alt="{{ $relatedVideo->title }}" 
                                     class="absolute inset-0 w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <i class="fas fa-play text-white"></i>
                                </div>
                            </div>
                            <div class="flex-1 p-3">
                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                    {{ $relatedVideo->title }}
                                </h4>
                                <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                    {{ $relatedVideo->created_at->format('Y/m/d') }}
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
