@extends('front.layouts.app')

@section('title', 'الفيديوهات')

@section('content')
<div class="videos-page py-8">
    <div class="container mx-auto px-4">
        <!-- رأس الصفحة -->
        <div class="page-header mb-8">
            <div class="flex items-center gap-4 mb-6">
                <div class="relative">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        الفيديوهات
                    </h2>
                    <div class="absolute w-full h-1 bg-primary-600 bottom-0 right-0 rounded-full transform -translate-y-2"></div>
                </div>
                <div class="flex-grow">
                    <div class="h-px bg-gray-300 dark:bg-gray-700"></div>
                </div>
                <div class="w-full md:w-1/3">
                    <form action="{{ route('front.videos.index') }}" method="GET" class="relative">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="ابحث عن فيديو..."
                               class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2">
                            <i class="fas fa-search text-gray-400"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- شبكة الفيديوهات -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($videos as $video)
            <div class="video-card bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transition-transform duration-300 hover:transform hover:scale-105">
                <a href="{{ route('front.videos.show', $video) }}" class="block relative pb-[56.25%] bg-gray-200 dark:bg-gray-700">
                    <img src="{{ $video->getThumbnailUrl() }}" 
                         alt="{{ $video->title }}" 
                         class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-20 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="w-16 h-16 rounded-full bg-white bg-opacity-80 flex items-center justify-center">
                            <i class="fas fa-play text-2xl text-blue-600"></i>
                        </span>
                    </div>
                </a>
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                        <a href="{{ route('front.videos.show', $video) }}" class="hover:text-blue-600 dark:hover:text-blue-400">
                            {{ $video->title }}
                        </a>
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                        {{ $video->description }}
                    </p>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center">
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $video->created_at->format('Y/m/d') }}
                        </span>
                        <span class="mx-3">•</span>
                        <span class="flex items-center">
                            <i class="far fa-eye mr-1"></i>
                            {{ $video->views_count ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full flex flex-col items-center justify-center py-12 text-center">
                <div class="w-20 h-20 mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <i class="fas fa-video text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">لا توجد فيديوهات</h3>
                <p class="text-gray-600 dark:text-gray-400">لم يتم العثور على أي فيديوهات. حاول البحث بكلمات مختلفة.</p>
            </div>
            @endforelse
        </div>

        <!-- الترقيم -->
        @if($videos->hasPages())
        <div class="mt-8">
            {{ $videos->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
.video-card {
    backface-visibility: hidden;
}
</style>
@endpush
