@extends('layouts.admin')

@section('title', 'تعديل الفيديو')

@section('content')
<div class="container-fluid py-6">
    <!-- رأس الصفحة -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl sm:tracking-tight">
                    تعديل الفيديو
                </h2>
                <nav class="flex mt-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 space-x-reverse">
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary-600 dark:text-gray-400">
                                <i class="fas fa-tachometer-alt ml-2"></i>
                                لوحة التحكم
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="fas fa-chevron-left mx-2 text-gray-400"></i>
                                <a href="{{ route('admin.videos.index') }}" class="text-sm font-medium text-gray-500 hover:text-primary-600 dark:text-gray-400">
                                    الفيديوهات
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <i class="fas fa-chevron-left mx-2 text-gray-400"></i>
                                <span class="text-sm font-medium text-gray-500 dark:text-gray-400">تعديل الفيديو</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- نموذج تعديل الفيديو -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <form method="POST" action="{{ route('admin.videos.update', $video) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-900/5 rounded-xl overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- القسم الأيمن - معلومات الفيديو -->
                        <div class="lg:col-span-2 space-y-6">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">
                                    معلومات الفيديو
                                </h3>
                                <!-- عنوان الفيديو -->
                                <div class="space-y-6">
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                                            عنوان الفيديو <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="title" name="title" 
                                               class="block w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 dark:focus:border-primary-400 dark:focus:ring-primary-400 sm:text-sm transition-all duration-200"
                                               value="{{ old('title', $video->title) }}" required>
                                        @error('title')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- رابط الفيديو -->
                                    <div>
                                        <label for="video_url" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                                            رابط الفيديو (YouTube) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="mt-1 flex rounded-lg shadow-sm">
                                            <span class="inline-flex items-center px-4 rounded-r-lg border-2 border-l-0 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-300 sm:text-sm">
                                                <i class="fab fa-youtube text-red-500 text-lg"></i>
                                            </span>
                                            <input type="url" id="video_url" name="video_url" 
                                                   class="block w-full rounded-none rounded-l-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-primary-500 focus:ring-2 focus:ring-primary-500 dark:focus:border-primary-400 dark:focus:ring-primary-400 sm:text-sm transition-all duration-200"
                                                   value="{{ old('video_url', $video->video_url) }}" required 
                                                   placeholder="https://www.youtube.com/watch?v=...">
                                        </div>
                                        @error('video_url')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- وصف الفيديو -->
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                                            وصف الفيديو
                                        </label>
                                        <textarea id="description" name="description" rows="4" 
                                                  class="block w-full rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-500 dark:focus:border-primary-400 dark:focus:ring-primary-400 sm:text-sm transition-all duration-200"
                                                  placeholder="اكتب وصفاً مختصراً للفيديو...">{{ old('description', $video->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- القسم الأيسر - المعاينة والإعدادات -->
                        <div class="space-y-6">
                            <!-- معاينة الفيديو -->
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    معاينة الفيديو
                                </h3>
                                <div id="video-preview" class="w-full bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-xl shadow-md overflow-hidden">
                                    <div class="aspect-w-16 aspect-h-9">
                                        <div class="flex items-center justify-center h-full">
                                            <div class="text-center p-6">
                                                <i class="fas fa-film text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                                    سيظهر الفيديو هنا بعد إدخال الرابط
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- إعدادات النشر -->
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-4">إعدادات النشر</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-700 dark:text-gray-300">نشر الفيديو</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="hidden" name="status" value="0">
                                        <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $video->status) ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                        <span class="mr-3 text-sm font-medium text-gray-900 dark:text-gray-300">تفعيل</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- أزرار التحكم -->
                <div class="bg-gray-50 dark:bg-gray-800/50 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('admin.videos.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                            إلغاء
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-700 focus:bg-blue-700 dark:focus:bg-blue-700 active:bg-blue-900 dark:active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            حفظ التغييرات
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // استخراج معرف الفيديو من رابط YouTube
    function getYouTubeVideoId(url) {
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
        const match = url.match(regExp);
        return (match && match[2].length === 11) ? match[2] : null;
    }

    // جلب معلومات الفيديو من YouTube API
    async function fetchVideoInfo(videoId) {
        try {
            const response = await fetch(`{{ route('admin.videos.get-info') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ url: `https://www.youtube.com/watch?v=${videoId}` })
            });

            const data = await response.json();
            
            if (!data.error) {
                document.getElementById('title').value = data.title;
                document.getElementById('description').value = data.description;
            }
            
            // تحديث معاينة الفيديو
            const previewContainer = document.getElementById('video-preview');
            if (previewContainer) {
                previewContainer.innerHTML = `
                    <div class="relative" style="padding-bottom: 56.25%;">
                        <iframe 
                            src="https://www.youtube.com/embed/${videoId}"
                            class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe>
                    </div>`;
            }
        } catch (error) {
            console.error('Error fetching video info:', error);
        }
    }

    // إضافة مستمع لحدث تغيير رابط الفيديو
    document.addEventListener('DOMContentLoaded', function() {
        const videoUrl = document.getElementById('video_url').value;
        const videoId = getYouTubeVideoId(videoUrl);
        if (videoId) {
            fetchVideoInfo(videoId);
        }

        document.getElementById('video_url').addEventListener('input', function(e) {
            const videoId = getYouTubeVideoId(e.target.value);
            if (videoId) {
                fetchVideoInfo(videoId);
            }
        });
    });
</script>
@endpush
@endsection
