<!-- 
    في هذا الملف نستخدم مكتبة Quill.js لكتابة المقالات
    نستخدمها لانشاء مقال رأي جديد
-->


@extends('layouts.admin')

@section('title', 'إضافة مقال رأي جديد')

@section('styles')
<style>
    .ql-editor {
        direction: rtl;
        text-align: right;
        min-height: 200px;
    }
    .editor-container {
        min-height: 400px;
    }
    /* تحسين Select2 للوضع الليلي والنهاري */
    .select2-container--default .select2-selection--single {
        height: 46px !important;
        padding: 8px 12px !important;
        background-color: transparent !important;
        border-width: 2px !important;
        border-radius: 0.5rem !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 28px !important;
        text-align: right !important;
        padding-right: 0 !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 44px !important;
        left: 12px !important;
        right: auto !important;
    }

    .select2-dropdown {
        border-width: 2px !important;
        border-radius: 0.5rem !important;
    }

    .select2-search__field {
        direction: rtl !important;
        text-align: right !important;
        padding: 8px 12px !important;
        border-radius: 0.375rem !important;
    }

    .select2-results__option {
        padding: 8px 12px !important;
    }

    /* الوضع النهاري */
    .select2-container--default .select2-selection--single {
        border-color: #e5e7eb !important;
        color: #1f2937 !important;
    }

    .select2-dropdown {
        background-color: #ffffff !important;
        border-color: #e5e7eb !important;
    }

    .select2-search__field {
        background-color: #f9fafb !important;
        border-color: #e5e7eb !important;
        color: #1f2937 !important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #e5e7eb !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
    }

    /* الوضع الليلي */
    .dark .select2-container--default .select2-selection--single {
        border-color: #4b5563 !important;
        color: #ffffff !important;
    }

    .dark .select2-dropdown {
        background-color: #1f2937 !important;
        border-color: #4b5563 !important;
    }

    .dark .select2-search__field {
        background-color: #374151 !important;
        border-color: #4b5563 !important;
        color: #ffffff !important;
    }

    .dark .select2-container--default .select2-results__option[aria-selected=true] {
        background-color: #374151 !important;
    }

    .dark .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #3b82f6 !important;
        color: #ffffff !important;
    }

    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #ffffff !important;
    }

    /* تحسين حدود الخانات */
    input[type="text"],
    textarea,
    select,
    .select2-container--default .select2-selection--single {
        border-width: 2px !important;
        border-color: #e5e7eb !important;
    }
    
    input[type="text"]:focus,
    textarea:focus,
    select:focus,
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1) !important;
    }

    .dark input[type="text"],
    .dark textarea,
    .dark select,
    .dark .select2-container--default .select2-selection--single {
        border-color: #4b5563 !important;
    }

    .dark input[type="text"]:focus,
    .dark textarea:focus,
    .dark select:focus,
    .dark .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #60a5fa !important;
        box-shadow: 0 0 0 2px rgba(96, 165, 250, 0.1) !important;
    }
</style>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="p-2 sm:p-6">
    <div class="max-w-7xl mx-auto p-3 sm:p-6">
        <!-- قسم الرأس -->
        <div class="mb-4 sm:mb-8 bg-white dark:bg-gray-800 rounded-xl shadow-md p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-4 rtl:space-x-reverse">
                    <div class="p-2 sm:p-3 bg-blue-500/10 rounded-lg">
                        <i class="fas fa-pen-fancy text-2xl sm:text-3xl text-blue-500"></i>
                    </div>
                    <div class="text-center sm:text-right">
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">إضافة مقال رأي جديد</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">أضف مقال رأي جديد للموقع</p>
                    </div>
                </div>
                
                <a href="{{ route('admin.opinions.index') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-right ml-2 rtl:rotate-180"></i>
                    عودة للقائمة
                </a>
            </div>
        </div>

        <!-- نموذج إضافة المقال -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <form action="{{ route('admin.opinions.store') }}" method="POST" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                @csrf

                <!-- العنوان -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        عنوان المقال
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           required
                           value="{{ old('title') }}"
                           class="block w-full px-4 py-3 rounded-lg border-2 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition duration-200">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- الكاتب -->
                <div>
                    <label for="author_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        الكاتب
                    </label>
                    <select name="author_id" 
                            id="author_id" 
                            required
                            class="select2 block w-full px-4 py-3 rounded-lg border-2 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition duration-200">
                        <option value="">اختر الكاتب</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- المحتوى -->
                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        محتوى المقال
                    </label>
                    <textarea name="content" 
                              id="content" 
                              rows="10" 
                              required
                              class="block w-full px-4 py-3 rounded-lg border-2 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition duration-200"
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- الحالة -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        حالة المقال
                    </label>
                    <select name="status" 
                            id="status" 
                            required
                            class="block w-full px-4 py-3 rounded-lg border-2 dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-600 focus:border-blue-500 transition duration-200">
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>منشور</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>معلق</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- أزرار التحكم -->
                <div class="flex justify-end space-x-4 rtl:space-x-reverse">
                    <button type="button" 
                            onclick="window.location.href='{{ route('admin.opinions.index') }}'"
                            class="px-6 py-3 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors duration-200">
                        إلغاء
                    </button>
                    <button type="submit"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-save ml-2"></i>
                        حفظ المقال
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dir: "rtl",
            language: "ar",
            placeholder: "اختر الكاتب",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
