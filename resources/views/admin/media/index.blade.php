@extends('layouts.admin')

@section('content')
<div class="container-fluid px-6 mx-auto">
    <div class="flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                <i class="fas fa-photo-video ml-2"></i>
                الوسائط المتعددة
            </h2>
            <a href="{{ route('admin.media.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-plus ml-2"></i>
                إضافة ملف جديد
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-r-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm animate-fade-in-down">
                <div class="flex items-center">
                    <i class="fas fa-check-circle ml-2 text-green-500"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($media as $item)
                @php
                    $fileExists = Storage::disk('public')->exists('media/' . $item->file_name);
                @endphp
                @if($fileExists)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden transform hover:scale-[1.02] transition-all duration-300 group">
                    <!-- Media Preview -->
                    <div class="relative aspect-w-16 aspect-h-9">
                        @if($item->type == 'image')
                            <img src="{{ url('storage/media/' . $item->file_name) }}" 
                                 alt="{{ $item->title }}"
                                 class="w-full h-52 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="absolute bottom-4 left-4 right-4 flex justify-center space-x-2 space-x-reverse">
                                    <a href="{{ url('storage/media/' . $item->file_name) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-500/90 hover:bg-blue-600 text-white text-sm rounded-lg backdrop-blur-sm transition-all duration-200">
                                        <i class="fas fa-eye ml-1.5"></i>
                                        عرض
                                    </a>
                                </div>
                            </div>
                        @elseif($item->type == 'video')
                            <video class="w-full h-52 object-cover" controls>
                                <source src="{{ url('storage/media/' . $item->file_name) }}" type="{{ $item->mime_type }}">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                    
                    <!-- Content -->
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs rounded-full">
                                <i class="fas {{ $item->type == 'image' ? 'fa-image' : 'fa-video' }} ml-1"></i>
                                {{ $item->type == 'image' ? 'صورة' : 'فيديو' }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400" dir="ltr">
                                {{ number_format($item->size / 1024, 2) }} KB
                            </span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 truncate" title="{{ $item->title }}">
                            {{ $item->title }}
                        </h3>
                        @if($item->description)
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                                {{ $item->description }}
                            </p>
                        @endif
                        <div class="flex justify-end space-x-2 space-x-reverse border-t dark:border-gray-700 pt-4 mt-4">
                            <a href="{{ route('admin.media.edit', $item->id) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg transition-colors duration-200">
                                <i class="fas fa-edit ml-1.5"></i>
                                تعديل
                            </a>
                            <form action="{{ route('admin.media.destroy', $item->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الملف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm rounded-lg transition-colors duration-200">
                                    <i class="fas fa-trash-alt ml-1.5"></i>
                                    حذف
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <i class="fas fa-photo-video text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400">لا توجد ملفات وسائط حتى الآن</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $media->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (confirm('هل أنت متأكد من حذف هذا الملف؟')) {
                this.submit();
            }
        });
    });
});
</script>
@endsection
