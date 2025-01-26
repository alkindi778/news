@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- رأس الصفحة -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">تعديل {{ $title }}</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-300 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt ml-1"></i> لوحة التحكم
                        </a>
                        <span class="mx-2 text-gray-600">/</span>
                        <a href="{{ route('admin.settings.index') }}" class="hover:text-primary-300 transition-colors duration-200">
                            الإعدادات
                        </a>
                        <span class="mx-2 text-gray-600">/</span>
                        <span class="text-primary-200">{{ $title }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- نموذج التعديل -->
        <form action="{{ route('admin.pages.update', $page) }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            @csrf
            @method('PUT')

            <!-- المحتوى -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">المحتوى</label>
                <textarea name="content" id="content" rows="20" required
                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('content', $content) }}</textarea>
            </div>

            <!-- أزرار التحكم -->
            <div class="flex items-center justify-end space-x-3 rtl:space-x-reverse">
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:bg-gray-600">
                    إلغاء
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            language: 'ar',
            removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload'],
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
