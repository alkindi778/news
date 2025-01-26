@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- رأس الصفحة -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">إضافة صفحة جديدة</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-300 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt ml-1"></i> لوحة التحكم
                        </a>
                        <span class="mx-2 text-gray-600">/</span>
                        <a href="{{ route('admin.pages.index') }}" class="hover:text-primary-300 transition-colors duration-200">
                            الصفحات الثابتة
                        </a>
                        <span class="mx-2 text-gray-600">/</span>
                        <span class="text-primary-200">إضافة صفحة</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- نموذج الإضافة -->
        <form action="{{ route('admin.pages.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @csrf

            <!-- العنوان -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">العنوان</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <!-- المحتوى -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المحتوى</label>
                <textarea name="content" id="content" rows="10" required
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('content') }}</textarea>
            </div>

            <!-- وصف ميتا -->
            <div class="mb-6">
                <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">وصف ميتا</label>
                <textarea name="meta_description" id="meta_description" rows="3"
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('meta_description') }}</textarea>
            </div>

            <!-- كلمات ميتا -->
            <div class="mb-6">
                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">كلمات ميتا</label>
                <textarea name="meta_keywords" id="meta_keywords" rows="3"
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('meta_keywords') }}</textarea>
            </div>

            <!-- الحالة -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="mr-2 block text-sm font-medium text-gray-700 dark:text-gray-300">
                        نشط
                    </label>
                </div>
            </div>

            <!-- أزرار الإجراءات -->
            <div class="flex justify-end space-x-3 rtl:space-x-reverse">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save ml-2"></i>
                    حفظ
                </button>
                <a href="{{ route('admin.pages.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            language: 'ar'
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
@endsection
