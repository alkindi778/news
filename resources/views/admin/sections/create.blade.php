@extends('layouts.admin')

@section('title', 'إضافة قسم جديد')

@section('content')
<div class="container-fluid py-6">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
            <div>
                <h2 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 drop-shadow-sm">
                    <i class="fas fa-plus-circle mr-2 animate-pulse"></i>إضافة قسم جديد
                </h2>
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400">
                    <i class="fas fa-info-circle ml-1"></i>
                    قم بإضافة قسم جديد لموقعك وتخصيص إعداداته بكل سهولة
                </p>
            </div>
            <a href="{{ route('admin.sections.index') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white text-sm font-medium rounded-lg hover:from-gray-700 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-arrow-right ml-2"></i>
                عودة للأقسام
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
        <form action="{{ route('admin.sections.store') }}" method="POST">
            @csrf
            
            <div class="p-8 space-y-6">
                <!-- Title -->
                <div class="relative group">
                    <label for="title" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-heading ml-1"></i>العنوان
                    </label>
                    <input type="text" name="title" id="title" 
                           class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-200 @error('title') border-red-500 @enderror" 
                           value="{{ old('title') }}" required>
                    @error('title')
                        <p class="mt-2 text-sm text-red-500 flex items-center">
                            <i class="fas fa-exclamation-circle ml-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Type -->
                <div class="relative group">
                    <label for="type" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-layer-group ml-1"></i>نوع القسم
                    </label>
                    <select name="type" id="type" 
                            class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-200 @error('type') border-red-500 @enderror">
                        <option value="">-- اختر نوع القسم --</option>
                        <optgroup label="أقسام عامة">
                            <option value="latest" {{ old('type') == 'latest' ? 'selected' : '' }}>آخر الأخبار</option>
                            <option value="popular" {{ old('type') == 'popular' ? 'selected' : '' }}>الأكثر قراءة</option>
                            <option value="featured" {{ old('type') == 'featured' ? 'selected' : '' }}>الأخبار المميزة</option>
                            <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>محتوى مخصص</option>
                            <option value="videos" {{ old('type') == 'videos' ? 'selected' : '' }}>قسم الفيديوهات</option>
                        </optgroup>
                        <optgroup label="التصنيفات">
                            @foreach($categories as $category)
                                <option value="category_{{ $category->id }}" {{ old('type') == 'category_'.$category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Template -->
                <div id="templateGroup" class="relative group">
                    <label for="template" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-paint-brush ml-1"></i>قالب العرض
                    </label>
                    <select name="template" id="template" 
                            class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-200 @error('template') border-red-500 @enderror">
                        <option value="">-- اختر قالب العرض --</option>
                        @foreach($templates as $value => $label)
                            <option value="{{ $value }}" {{ old('template') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('template')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- محتوى مخصص -->
                <div id="contentGroup" class="hidden relative group">
                    <label for="content" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-edit ml-1"></i>المحتوى المخصص
                    </label>
                    <textarea name="content" id="content" rows="4"
                              class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-200 @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Items Count -->
                <div class="relative group">
                    <label for="items_count" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-list-ol ml-1"></i>عدد العناصر
                    </label>
                    <input type="number" name="items_count" id="items_count" 
                           class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-200 @error('items_count') border-red-500 @enderror" 
                           value="{{ old('items_count', 6) }}" min="1" max="20" required>
                    @error('items_count')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Style Options -->
                <div class="relative group">
                    <label class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">
                        <i class="fas fa-paint-brush ml-1"></i>خيارات التصميم
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Background Color -->
                        <div>
                            <label for="style[background_color]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                لون الخلفية
                            </label>
                            <input type="color" name="style[background_color]" id="style[background_color]" 
                                   class="block w-full h-10 rounded-lg border-2 border-gray-200 dark:border-gray-600 cursor-pointer"
                                   value="{{ old('style.background_color', '#ffffff') }}">
                        </div>

                        <!-- Title Color -->
                        <div>
                            <label for="style[title_color]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                لون العنوان
                            </label>
                            <input type="color" name="style[title_color]" id="style[title_color]" 
                                   class="block w-full h-10 rounded-lg border-2 border-gray-200 dark:border-gray-600 cursor-pointer"
                                   value="{{ old('style.title_color', '#000000') }}">
                        </div>

                        <!-- Border Color -->
                        <div>
                            <label for="style[border_color]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                لون الحدود
                            </label>
                            <input type="color" name="style[border_color]" id="style[border_color]" 
                                   class="block w-full h-10 rounded-lg border-2 border-gray-200 dark:border-gray-600 cursor-pointer"
                                   value="{{ old('style.border_color', '#e5e7eb') }}">
                        </div>
                    </div>
                </div>

                <!-- Order -->
                <div class="relative group">
                    <label for="order" class="block text-base font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-sort-numeric-down ml-1"></i>الترتيب
                    </label>
                    <input type="number" name="order" id="order" 
                           class="block w-full px-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-colors duration-200 @error('order') border-red-500 @enderror" 
                           value="{{ old('order', 0) }}" min="0">
                    @error('order')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Toggles -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Is Active -->
                    <div class="relative group">
                        <label for="is_active" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="mr-2 text-base font-semibold text-gray-700 dark:text-gray-300">تفعيل القسم</span>
                        </label>
                    </div>

                    <!-- Show Title -->
                    <div class="relative group">
                        <label for="show_title" class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_title" id="show_title" value="1" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                   {{ old('show_title', true) ? 'checked' : '' }}>
                            <span class="mr-2 text-base font-semibold text-gray-700 dark:text-gray-300">إظهار العنوان</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-8 py-5 bg-gray-50 dark:bg-gray-700 border-t border-gray-100 dark:border-gray-600">
                <button type="submit" 
                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-save ml-2"></i>
                    حفظ القسم
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const categoryGroup = document.getElementById('categoryGroup');
        const contentGroup = document.getElementById('contentGroup');
        const categoryInput = document.getElementById('category_id');
        const contentInput = document.getElementById('content');
        const templateSelect = document.getElementById('template');

        function toggleFields() {
            if (typeSelect.value.startsWith('category_')) {
                categoryGroup.classList.remove('hidden');
                contentGroup.classList.add('hidden');
                categoryInput.required = true;
                contentInput.required = false;
            } else if (typeSelect.value === 'custom') {
                categoryGroup.classList.add('hidden');
                contentGroup.classList.remove('hidden');
                categoryInput.required = false;
                contentInput.required = true;
            } else {
                categoryGroup.classList.add('hidden');
                contentGroup.classList.add('hidden');
                categoryInput.required = false;
                contentInput.required = false;
            }

            // Handle video section type
            if (typeSelect.value === 'videos') {
                templateSelect.value = 'videos';
            }
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields(); // Run on initial load
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // تحديث قيم الألوان المعروضة
        function updateColorHex(inputId, spanId) {
            const input = document.getElementById(inputId);
            const span = document.getElementById(spanId);
            if (input && span) {
                input.addEventListener('input', function() {
                    span.textContent = input.value.toUpperCase();
                });
                // تحديث القيمة الأولية
                span.textContent = input.value.toUpperCase();
            }
        }

        // تحديث جميع حقول الألوان
        updateColorHex('style_background_color', 'background_color_hex');
        updateColorHex('style_title_color', 'title_color_hex');
        updateColorHex('style_border_color', 'border_color_hex');

        // معاينة القالب
        const templateSelect = document.getElementById('template');
        const templatePreview = document.getElementById('templatePreview');
        const previewImages = {
            'grid': '/previews/templates/grid.png',
            'featured': '/previews/templates/featured.png',
            'featured_with_list': '/previews/templates/featured_with_list.png',
            'fullwidth': '/previews/templates/fullwidth.png',
            'masonry': '/previews/templates/masonry.png',
            'news_grid': '/previews/templates/news_grid.png',
            'videos': '/previews/templates/videos.png'
        };

        function updateTemplatePreview() {
            const selectedTemplate = templateSelect.value;
            const previewImage = previewImages[selectedTemplate];
            
            if (previewImage) {
                templatePreview.innerHTML = `
                    <img src="${previewImage}" alt="${selectedTemplate} preview" 
                         class="w-full h-auto rounded shadow-sm">
                `;
            } else {
                templatePreview.innerHTML = `
                    <div class="flex items-center justify-center h-full text-gray-400">
                        <p><i class="fas fa-exclamation-circle ml-2"></i>لا تتوفر معاينة لهذا القالب</p>
                    </div>
                `;
            }
        }

        if (templateSelect && templatePreview) {
            templateSelect.addEventListener('change', updateTemplatePreview);
            // تحديث المعاينة عند تحميل الصفحة
            updateTemplatePreview();
        }
    });
</script>
@endpush
