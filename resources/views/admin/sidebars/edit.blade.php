@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-4xl mx-auto">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-t-3xl shadow-2xl p-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-extrabold text-white leading-tight">تعديل قسم السايدبار</h1>
                    <p class="mt-2 text-indigo-100 text-lg">قم بتحديث إعدادات القسم بسهولة</p>
                </div>
                <a href="{{ route('admin.sidebars.index') }}" 
                   class="group flex items-center px-6 py-3 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full text-white text-lg font-semibold transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-lg">
                    <svg class="ml-3 w-6 h-6 transition-transform duration-300 ease-in-out transform group-hover:-translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    عودة
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-b-3xl shadow-2xl p-10">
            @if($errors->any())
                <div class="mb-8 animate-pulse">
                    <div class="bg-red-100 dark:bg-red-900 border-l-4 border-red-500 text-red-700 dark:text-red-200 p-5 rounded-xl" role="alert">
                        <p class="font-bold text-lg mb-2">يرجى تصحيح الأخطاء التالية:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.sidebars.update', $sidebar) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-8">
                        <div class="relative">
                            <input type="text" name="title" id="title" value="{{ old('title', $sidebar->title) }}" required
                                   class="peer block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 placeholder-transparent transition-colors duration-300"
                                   placeholder="عنوان القسم">
                            <label for="title" class="absolute left-4 -top-5 text-sm text-gray-600 dark:text-gray-400 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-5 peer-focus:text-indigo-500 peer-focus:text-sm">
                                عنوان القسم
                            </label>
                        </div>

                        <div class="relative">
                            <select name="type" id="type" 
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 transition-colors duration-300 appearance-none">
                                <option value="">اختر نوع القسم</option>
                                <option value="category" {{ old('type', $sidebar->type) == 'category' ? 'selected' : '' }}>قسم من الأقسام</option>
                                <option value="ads" {{ old('type', $sidebar->type) == 'ads' ? 'selected' : '' }}>إعلانات</option>
                                <option value="popular" {{ old('type', $sidebar->type) == 'popular' ? 'selected' : '' }}>الأكثر قراءة</option>
                                <option value="opinions" {{ old('type', $sidebar->type) == 'opinions' ? 'selected' : '' }}>مقالات الرأي</option>
                                <option value="custom" {{ old('type', $sidebar->type) == 'custom' ? 'selected' : '' }}>مخصص</option>
                            </select>
                            <label for="type" class="absolute -top-6 right-0 text-sm font-medium text-gray-600 dark:text-gray-300">
                                نوع القسم <span class="text-red-500">*</span>
                            </label>
                        </div>

                        <div id="posts-count-field" class="relative hidden">
                            <input type="number" name="posts_count" id="posts_count" 
                                   value="{{ old('posts_count', $sidebar->posts_count ?? 5) }}"
                                   min="1" max="20"
                                   class="block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 transition-colors duration-300">
                            <label for="posts_count" class="absolute -top-6 right-0 text-sm font-medium text-gray-600 dark:text-gray-300">
                                عدد المنشورات المعروضة
                            </label>
                        </div>

                        <div id="category-fields" class="relative hidden">
                            <select name="category_id" 
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 transition-colors duration-300 appearance-none">
                                <option value="">اختر القسم</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $sidebar->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="absolute left-4 -top-5 text-sm text-gray-600 dark:text-gray-400">
                                اختر القسم
                            </label>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-600">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="relative">
                            <input type="number" name="posts_count" id="posts_count" value="{{ $sidebar->posts_count ?? 6 }}" min="1" max="20"
                                   class="peer block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 placeholder-transparent transition-colors duration-300">
                            <label for="posts_count" class="absolute left-4 -top-5 text-sm text-gray-600 dark:text-gray-400 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-5 peer-focus:text-indigo-500 peer-focus:text-sm">
                                عدد المواد الصحفية
                            </label>
                        </div>

                        <div class="relative">
                            <select name="layout_type" 
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 transition-colors duration-300 appearance-none">
                                <option value="grid" {{ $sidebar->layout_type == 'grid' ? 'selected' : '' }}>شبكة</option>
                                <option value="list" {{ $sidebar->layout_type == 'list' ? 'selected' : '' }}>قائمة</option>
                            </select>
                            <label class="absolute left-4 -top-5 text-sm text-gray-600 dark:text-gray-400">
                                نوع العرض
                            </label>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-600">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div id="ad-fields" class="space-y-8 {{ $sidebar->type == 'ads' ? '' : 'hidden' }}">
                        <div class="relative">
                            <select name="ad_id" 
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 transition-colors duration-300 appearance-none">
                                <option value="">اختر الإعلان</option>
                                @foreach($advertisements as $ad)
                                    <option value="{{ $ad->id }}" {{ $sidebar->ad_id == $ad->id ? 'selected' : '' }}>
                                        {{ $ad->title }}
                                    </option>
                                @endforeach
                            </select>
                            <label class="absolute left-4 -top-5 text-sm text-gray-600 dark:text-gray-400">
                                اختر الإعلان
                            </label>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-600">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div id="custom-fields" class="space-y-8 {{ $sidebar->type == 'custom' ? '' : 'hidden' }}">
                        <div class="relative">
                            @if($sidebar->image)
                                <div class="mb-4">
                                    <img src="{{ Storage::url($sidebar->image) }}" alt="{{ $sidebar->title }}" class="h-32 w-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors duration-300">
                            <label for="image" class="absolute left-4 -top-5 text-sm text-gray-600 dark:text-gray-400">
                                الصورة
                            </label>
                        </div>

                        <div class="relative">
                            <input type="url" name="link" id="link" value="{{ old('link', $sidebar->link) }}"
                                   class="peer block w-full px-4 py-3 border-2 border-gray-300 rounded-xl dark:border-gray-600 dark:bg-gray-700 dark:text-white text-gray-900 focus:outline-none focus:border-indigo-500 placeholder-transparent transition-colors duration-300"
                                   placeholder="الرابط">
                            <label for="link" class="absolute left-4 -top-5 text-sm text-gray-600 dark:text-gray-400 transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-400 peer-placeholder-shown:top-3 peer-focus:-top-5 peer-focus:text-indigo-500 peer-focus:text-sm">
                                الرابط
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4 space-x-reverse">
                    <input type="checkbox" name="active" id="active" value="1" {{ old('active', $sidebar->active) ? 'checked' : '' }}
                           class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-colors duration-300">
                    <label for="active" class="text-lg font-medium text-gray-700 dark:text-gray-300">تفعيل القسم</label>
                </div>

                <div class="flex justify-end pt-8">
                    <button type="submit" 
                            class="flex items-center px-8 py-3 text-lg font-medium text-white transition-all duration-300 ease-in-out transform bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:scale-105 hover:from-purple-600 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg hover:shadow-2xl">
                        <svg class="inline-block w-6 h-6 ml-2 -mr-1 transition-transform duration-300 ease-in-out group-hover:rotate-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const categoryFields = document.getElementById('category-fields');
    const adFields = document.getElementById('ad-fields');
    const postsCountField = document.getElementById('posts-count-field');
    const customFields = document.getElementById('custom-fields');

    function updateFields() {
        const selectedType = typeSelect.value;
        
        // Hide all fields first
        categoryFields.classList.add('hidden');
        adFields.classList.add('hidden');
        customFields.classList.add('hidden');
        postsCountField.classList.add('hidden');

        // Show relevant fields based on type
        switch(selectedType) {
            case 'category':
                categoryFields.classList.remove('hidden');
                postsCountField.classList.remove('hidden');
                break;
            case 'ads':
                adFields.classList.remove('hidden');
                break;
            case 'popular':
                postsCountField.classList.remove('hidden');
                break;
            case 'opinions':
                postsCountField.classList.remove('hidden');
                break;
            case 'custom':
                customFields.classList.remove('hidden');
                break;
        }
    }

    typeSelect.addEventListener('change', updateFields);
    updateFields(); // Run on initial load
});
</script>
@endpush
@endsection
