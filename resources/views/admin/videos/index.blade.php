@extends('layouts.admin')

@section('title', 'إدارة الفيديوهات')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="videosList">
    <!-- رأس الصفحة -->
    <div class="mb-8 bg-gradient-to-l from-white/80 to-blue-50 dark:from-gray-800/80 dark:to-blue-900/20 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-white/20 dark:border-gray-700/30">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4 space-x-reverse">
                <div class="p-3.5 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg shadow-blue-500/20 dark:shadow-blue-500/10">
                    <i class="fas fa-video text-2xl sm:text-3xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-l from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">إدارة الفيديوهات</h1>
                    <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base mt-1">إدارة ونشر محتوى الفيديو</p>
                </div>
            </div>
            <a href="{{ route('admin.videos.create') }}" 
               class="group relative inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:to-blue-500 text-white text-base font-medium rounded-xl shadow-lg shadow-blue-500/20 dark:shadow-blue-500/10 transition-all duration-200 hover:shadow-xl hover:shadow-blue-500/30 dark:hover:shadow-blue-500/20 transform hover:scale-[1.02] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                <span class="relative flex items-center">
                    <i class="fas fa-plus-circle text-lg ml-2"></i>
                    <span class="font-bold">إضافة فيديو جديد</span>
                </span>
            </a>
        </div>
    </div>

    <!-- شريط البحث -->
    <div class="mb-8">
        <div class="relative bg-white dark:bg-gray-800/50 rounded-xl shadow-lg backdrop-blur-xl p-2 border border-white/20 dark:border-gray-700/30">
            <div class="flex items-center">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fas fa-search text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <input type="text" 
                           id="searchInput"
                           class="w-full pr-10 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm rounded-lg border-0 ring-1 ring-gray-200/50 dark:ring-gray-700/50 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500 block p-3.5 transition-all duration-200" 
                           placeholder="ابحث في الفيديوهات...">
                </div>
                <div id="searchLoading" class="absolute left-14 flex items-center hidden">
                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-500 border-t-transparent"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- رسالة النجاح -->
    @if(session('success'))
    <div class="mb-8 rounded-2xl bg-green-50 dark:bg-green-900/30 p-6 border border-green-200 dark:border-green-800/50">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-400 dark:text-green-300 text-xl"></i>
            </div>
            <div class="mr-3">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- قائمة الفيديوهات -->
    <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-white/20 dark:border-gray-700/30">
        <div class="videos-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @forelse($videosData as $video)
            <div class="group bg-white dark:bg-gray-800/80 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-gray-100 dark:border-gray-700/50">
                <div class="relative pb-[56.25%] bg-gray-100 dark:bg-gray-900/50">
                    <img src="https://img.youtube.com/vi/{{$video['youtube_id']}}/maxresdefault.jpg" 
                         alt="{{$video['title']}}"
                         class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="p-5">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{$video['title']}}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">{{$video['description']}}</p>
                    <div class="flex justify-between items-center">
                        <span class="px-3 py-1.5 text-xs font-medium rounded-lg {{
                            $video['status'] === 'published' 
                                ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300'
                                : 'bg-gray-100 dark:bg-gray-700/50 text-gray-800 dark:text-gray-300'
                        }}">{{$video['status']}}</span>
                        <div class="flex space-x-3 space-x-reverse">
                            <a href="{{$video['edit_url']}}" 
                               class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors duration-200">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="deleteVideo({{$video['id']}}, '{{$video['delete_url']}}}')" 
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors duration-200">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="flex flex-col items-center justify-center py-12">
                    <div class="p-4 bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900/50 rounded-2xl shadow-lg mb-6">
                        <i class="fas fa-video text-5xl text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">لا توجد فيديوهات</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">ابدأ بإضافة فيديو جديد</p>
                    <a href="{{ route('admin.videos.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:to-blue-500 text-white font-medium rounded-xl shadow-lg shadow-blue-500/20 dark:shadow-blue-500/10 transition-all duration-200 hover:shadow-xl hover:shadow-blue-500/30 dark:hover:shadow-blue-500/20 transform hover:scale-[1.02]">
                        <i class="fas fa-plus-circle text-lg ml-2"></i>
                        <span class="font-bold">إضافة فيديو جديد</span>
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- الترقيم -->
    @if($videos->hasPages())
    <div class="mt-8">
        <div class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl rounded-xl shadow-lg border border-white/20 dark:border-gray-700/30 p-4">
            {{ $videos->links() }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const searchLoading = document.getElementById('searchLoading');
    const videosContainer = document.querySelector('.videos-grid');

    // Live search functionality
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchLoading.classList.remove('hidden');
            searchTimeout = setTimeout(() => performSearch(query), 300);
        } else if (query.length === 0) {
            window.location.href = '{{ route("admin.videos.index") }}';
        }
    });

    async function performSearch(query) {
        try {
            const response = await fetch(`{{ route('admin.videos.search') }}?q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const data = await response.json();
            updateVideosDisplay(data.data);
        } catch (error) {
            console.error('Error performing search:', error);
        } finally {
            searchLoading.classList.add('hidden');
        }
    }

    function updateVideosDisplay(videos) {
        if (videosContainer) {
            videosContainer.innerHTML = videos.length ? videos.map(video => `
                <div class="group bg-white dark:bg-gray-800/80 rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-gray-100 dark:border-gray-700/50">
                    <div class="relative pb-[56.25%] bg-gray-100 dark:bg-gray-900/50">
                        <img src="https://img.youtube.com/vi/${video['youtube_id']}/maxresdefault.jpg" 
                             alt="${video['title']}"
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">${video['title']}</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">${video['description']}</p>
                        <div class="flex justify-between items-center">
                            <span class="px-3 py-1.5 text-xs font-medium rounded-lg ${
                                video['status'] === 'published' 
                                    ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-300'
                                    : 'bg-gray-100 dark:bg-gray-700/50 text-gray-800 dark:text-gray-300'
                            }">${video['status']}</span>
                            <div class="flex space-x-3 space-x-reverse">
                                <a href="${video['edit_url']}" 
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors duration-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteVideo(${video['id']}, '${video['delete_url']}')" 
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors duration-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('') : '<div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">لا توجد نتائج</div>';
        }
    }
</script>
@endpush
