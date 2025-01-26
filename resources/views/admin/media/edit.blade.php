@extends('layouts.admin')

@section('content')
<div class="container-fluid px-6 mx-auto">
    <div class="flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                <i class="fas fa-edit ml-2"></i>
                تعديل الوسائط
            </h2>
            <a href="{{ route('admin.media.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle ml-2 text-red-500"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="mb-6">
                    <div class="relative mb-4">
                        @if($medium->type == 'image')
                            <div class="relative group">
                                <img src="{{ url('storage/media/' . $medium->file_name) }}" 
                                     alt="{{ $medium->title }}"
                                     class="rounded-lg w-full h-auto max-h-96 object-contain shadow-lg transition-transform duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <a href="{{ url('storage/media/' . $medium->file_name) }}" target="_blank" class="text-white text-lg bg-blue-600 hover:bg-blue-700 p-3 rounded-full transition-colors duration-200">
                                        <i class="fas fa-expand-arrows-alt"></i>
                                    </a>
                                </div>
                            </div>
                        @elseif($medium->type == 'video')
                            <div class="relative rounded-lg overflow-hidden shadow-lg">
                                <video class="w-full h-auto max-h-96 object-contain" controls>
                                    <source src="{{ url('storage/media/' . $medium->file_name) }}" type="{{ $medium->mime_type }}">
                                    Your browser does not support the video tag.
                                </video>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
                                    <p class="text-white text-sm">{{ $medium->title }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <form action="{{ route('admin.media.update', $medium) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            العنوان
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $medium->title) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               required>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            الوصف
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('description', $medium->description) }}</textarea>
                    </div>
                    <!-- القسم -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            القسم
                        </label>
                        <select name="category_id" 
                                id="category_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('category_id') border-red-500 @enderror">
                            <option value="">اختر القسم</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $medium->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                            <i class="fas fa-save ml-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
