@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
            <i class="fas fa-pen-fancy text-blue-600 ml-2"></i>
            كتاب الرأي
        </h1>
        <p class="text-gray-600 dark:text-gray-400">إدارة كتاب الرأي والمقالات</p>
    </div>

    <!-- زر إضافة كاتب جديد -->
    <div class="mb-6">
        <a href="{{ route('admin.writers.create') }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            <i class="fas fa-plus ml-2"></i>
            إضافة كاتب جديد
        </a>
    </div>

    <!-- قائمة الكتاب -->
    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($writers as $writer)
            <li>
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center">
                            <!-- صورة الكاتب -->
                            <div class="flex-shrink-0 h-12 w-12">
                                <img class="h-12 w-12 rounded-full object-cover" 
                                     src="{{ $writer->image_path }}" 
                                     alt="{{ $writer->name }}">
                            </div>
                            <!-- معلومات الكاتب -->
                            <div class="mr-4">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $writer->name }}
                                </h2>
                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-envelope ml-1"></i>
                                        {{ $writer->email }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-newspaper ml-1"></i>
                                        {{ $writer->articles_count }} مقال
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- الوصف المختصر - يظهر فقط على الشاشات الكبيرة -->
                        <div class="hidden sm:block mt-4 flex-shrink-0 sm:mt-0 sm:mr-6">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ Str::limit($writer->bio, 100) }}
                            </p>
                        </div>
                    </div>

                    <!-- الوصف المختصر - يظهر فقط على الموبايل -->
                    <div class="sm:hidden mt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ Str::limit($writer->bio, 100) }}
                        </p>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="mt-4 sm:mt-0 flex justify-start sm:justify-end gap-2">
                        <a href="{{ route('admin.writers.articles.index', $writer) }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                           title="عرض المقالات">
                            <i class="fas fa-newspaper"></i>
                            <span class="mr-1 sm:hidden">عرض المقالات</span>
                        </a>
                        <a href="{{ route('admin.writers.edit', $writer) }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                           title="تعديل">
                            <i class="fas fa-edit"></i>
                            <span class="mr-1 sm:hidden">تعديل</span>
                        </a>
                        <form action="{{ route('admin.writers.destroy', $writer) }}" 
                              method="POST" 
                              class="flex-1 sm:flex-none">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('هل أنت متأكد من حذف هذا الكاتب؟')"
                                    class="w-full inline-flex items-center justify-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    title="حذف">
                                <i class="fas fa-trash"></i>
                                <span class="mr-1 sm:hidden">حذف</span>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-4 py-8 text-center">
                <div class="text-gray-500 dark:text-gray-400">
                    <i class="fas fa-users text-4xl mb-4"></i>
                    <p>لا يوجد كتاب حالياً</p>
                    <p class="mt-1 text-sm">قم بإضافة كتاب جدد للبدء</p>
                </div>
            </li>
            @endforelse
        </ul>
    </div>

    <!-- ترقيم الصفحات -->
    @if($writers->hasPages())
    <div class="mt-6">
        {{ $writers->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // تفعيل tooltips
    $('[title]').tooltip();
});
</script>
@endsection
