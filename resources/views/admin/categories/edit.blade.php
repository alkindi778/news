@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 py-6 sm:py-12">
        <!-- رأس الصفحة -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                <i class="fas fa-edit ml-2 text-blue-600 dark:text-blue-500"></i>
                تعديل القسم
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-500 transition-colors duration-200">
                    <i class="fas fa-tachometer-alt ml-1"></i> لوحة التحكم
                </a>
                <span class="mx-1 text-gray-400 dark:text-gray-600">/</span>
                <a href="{{ route('admin.categories.index') }}" class="hover:text-blue-600 dark:hover:text-blue-500 transition-colors duration-200">الأقسام</a>
                <span class="mx-1 text-gray-400 dark:text-gray-600">/</span>
                <span class="text-gray-600 dark:text-gray-400">تعديل القسم</span>
            </p>
        </div>

        <!-- رسائل الخطأ -->
        @if ($errors->any())
            <div class="mb-6 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative" role="alert">
                <strong class="font-bold">تنبيه!</strong>
                <span class="block sm:inline">يرجى تصحيح الأخطاء التالية:</span>
                <ul class="list-disc list-inside mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- نموذج تعديل القسم -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                    معلومات القسم
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-400">
                    قم بتعديل معلومات القسم من خلال النموذج التالي.
                </p>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- اسم القسم -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            اسم القسم <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-folder text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <input type="text" name="name" id="name"
                                   class="block w-full pr-12 sm:text-sm bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-3"
                                   placeholder="اسم القسم"
                                   value="{{ old('name', $category->name) }}"
                                   required>
                        </div>
                    </div>

                    <!-- الرابط المختصر (Slug) -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            الرابط المختصر <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-link text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <input type="text" name="slug" id="slug"
                                   class="block w-full pr-12 sm:text-sm bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 py-3"
                                   placeholder="الرابط-المختصر"
                                   value="{{ old('slug', $category->slug) }}"
                                   required>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            سيتم استخدام هذا في رابط URL للقسم
                        </p>
                    </div>

                    <!-- القسم الأب -->
                    <div>
                        <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            القسم الأب
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="fas fa-sitemap text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <select id="parent_id" name="parent_id" 
                                    class="block w-full pr-12 py-2 px-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">بدون قسم أب</option>
                                @foreach($categories as $parentCategory)
                                    @if($parentCategory->id != $category->id)
                                        <option value="{{ $parentCategory->id }}" 
                                            {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                            {{ $parentCategory->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            يمكنك تحديد قسم أب إذا كان هذا القسم فرعياً
                        </p>
                    </div>

                    <!-- الوصف -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            الوصف
                        </label>
                        <div class="mt-1">
                            <textarea id="description" name="description" rows="3"
                                      class="block w-full sm:text-sm bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                      placeholder="وصف القسم">{{ old('description', $category->description) }}</textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            وصف موجز لهذا القسم
                        </p>
                    </div>

                    <!-- حالة القسم -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">حالة القسم</label>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- نشط -->
                            <div class="relative flex items-start p-4 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-600 hover:border-blue-500 transition-colors duration-200">
                                <div class="flex items-center h-5">
                                    <input id="status_active" name="status" value="active" type="radio" 
                                           class="focus:ring-blue-500 h-5 w-5 text-blue-600 border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 cursor-pointer"
                                           {{ old('status', $category->status) == 'active' ? 'checked' : '' }}>
                                </div>
                                <div class="mr-3 flex items-center">
                                    <div>
                                        <label for="status_active" class="font-medium text-gray-900 dark:text-white text-lg cursor-pointer">نشط</label>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">سيكون القسم مرئياً للزوار في الموقع</p>
                                    </div>
                                </div>
                            </div>

                            <!-- غير نشط -->
                            <div class="relative flex items-start p-4 bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-600 hover:border-blue-500 transition-colors duration-200">
                                <div class="flex items-center h-5">
                                    <input id="status_inactive" name="status" value="inactive" type="radio" 
                                           class="focus:ring-blue-500 h-5 w-5 text-blue-600 border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-800 cursor-pointer"
                                           {{ old('status', $category->status) == 'inactive' ? 'checked' : '' }}>
                                </div>
                                <div class="mr-3 flex items-center">
                                    <div>
                                        <label for="status_inactive" class="font-medium text-gray-900 dark:text-white text-lg cursor-pointer">غير نشط</label>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">لن يظهر القسم للزوار في الموقع</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="flex justify-end space-x-2 space-x-reverse pt-4">
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-sm font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <i class="fas fa-save ml-2"></i>
                            حفظ التغييرات
                        </button>
                        <a href="{{ route('admin.categories.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
