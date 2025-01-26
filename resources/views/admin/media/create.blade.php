@extends('layouts.admin')

@section('content')
<div class="container-fluid px-6 mx-auto">
    <div class="flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">
                <i class="fas fa-plus ml-2"></i>
                إضافة ملف جديد
            </h2>
            <a href="{{ route('admin.media.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors duration-150">
                <i class="fas fa-arrow-right ml-2"></i>
                رجوع
            </a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('admin.media.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-6"
                  id="uploadForm">
                @csrf
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        العنوان <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="title" 
                           id="title" 
                           value="{{ old('title') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        الوصف
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        الملف <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md dark:border-gray-600">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="file" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">
                                    <span class="px-2">اختر ملف</span>
                                    <input id="file" 
                                           name="file" 
                                           type="file"
                                           accept="image/*,video/*"
                                           class="sr-only"
                                           required>
                                </label>
                                <p class="pr-1">أو اسحب وأفلت</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                الملفات المسموحة: JPG, PNG, GIF, MP4, WebM, OGG
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                الحد الأقصى لحجم الملف: 10 ميجابايت
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400" id="selected-file"></p>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- منطقة المعاينة -->
                <div id="preview-area" class="hidden space-y-4">
                    <!-- معاينة الصورة -->
                    <div id="image-preview" class="hidden">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">معاينة الصورة</h3>
                        <img src="" alt="معاينة" class="max-w-full h-auto rounded-lg shadow-md">
                    </div>

                    <!-- معاينة الفيديو -->
                    <div id="video-preview" class="hidden space-y-2">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">معاينة الفيديو</h3>
                        <video controls class="max-w-full h-auto rounded-lg shadow-md">
                            <source src="" type="">
                        </video>
                        <!-- شريط التقدم -->
                        <div class="relative pt-1">
                            <div class="flex mb-2 items-center justify-between">
                                <div>
                                    <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200">
                                        جارٍ الرفع
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-semibold inline-block text-red-600" id="progress-text">
                                        0%
                                    </span>
                                </div>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-red-200">
                                <div id="progress-bar" 
                                     class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"
                                     style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            id="submitBtn"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors duration-150">
                        <i class="fas fa-save ml-2"></i>
                        <span>حفظ</span>
                    </button>
                </div>
            </form>

            <!-- رسالة الخطأ -->
            <div id="error-message" 
                 class="hidden mt-4 bg-red-100 border-r-4 border-red-500 text-red-700 p-4 rounded-md">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const fileInput = document.querySelector('input[type="file"]');
    const previewArea = document.getElementById('preview-area');
    const imagePreview = document.getElementById('image-preview');
    const videoPreview = document.getElementById('video-preview');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const form = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const errorMessage = document.getElementById('error-message');

    // تحديث اسم الملف المختار وفحص نوعه
    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect(e) {
        const file = e.target.files[0];
        if (file) {
            // التحقق من نوع الملف
            if (!file.type.startsWith('image/') && !file.type.startsWith('video/')) {
                showError('عذراً، يسمح فقط بملفات الصور والفيديو');
                fileInput.value = '';
                document.getElementById('selected-file').textContent = '';
                hidePreview();
                return;
            }

            // التحقق من حجم الملف
            if (file.size > 10 * 1024 * 1024) { // 10MB
                showError('حجم الملف يتجاوز الحد المسموح به (10 ميجابايت)');
                fileInput.value = '';
                document.getElementById('selected-file').textContent = '';
                hidePreview();
                return;
            }

            hideError();
            document.getElementById('selected-file').textContent = file.name;
            showPreview(file);
        }
    }

    function showPreview(file) {
        previewArea.classList.remove('hidden');
        
        if (file.type.startsWith('image/')) {
            // معاينة الصورة
            imagePreview.classList.remove('hidden');
            videoPreview.classList.add('hidden');
            
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.querySelector('img').src = e.target.result;
            }
            reader.readAsDataURL(file);
        } else if (file.type.startsWith('video/')) {
            // معاينة الفيديو
            videoPreview.classList.remove('hidden');
            imagePreview.classList.add('hidden');
            
            const video = videoPreview.querySelector('video');
            const source = video.querySelector('source');
            
            const url = URL.createObjectURL(file);
            source.src = url;
            source.type = file.type;
            video.load();
        }
    }

    function hidePreview() {
        previewArea.classList.add('hidden');
        imagePreview.classList.add('hidden');
        videoPreview.classList.add('hidden');
    }

    function showError(message) {
        errorMessage.textContent = message;
        errorMessage.classList.remove('hidden');
    }

    function hideError() {
        errorMessage.textContent = '';
        errorMessage.classList.add('hidden');
    }

    // معالجة رفع الملف مع إظهار التقدم
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        hideError();

        const formData = new FormData(this);
        const file = fileInput.files[0];
        
        if (!file) {
            showError('الرجاء اختيار ملف');
            return;
        }

        // تعطيل زر الإرسال
        submitBtn.disabled = true;
        submitBtn.querySelector('span').textContent = 'جارٍ الرفع...';

        try {
            const xhr = new XMLHttpRequest();
            
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable && file.type.startsWith('video/')) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressText.textContent = Math.round(percentComplete) + '%';
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        window.location.href = response.redirect;
                    } else {
                        showError(response.error || 'حدث خطأ أثناء رفع الملف');
                        submitBtn.disabled = false;
                        submitBtn.querySelector('span').textContent = 'حفظ';
                    }
                } else {
                    const response = JSON.parse(xhr.responseText);
                    showError(response.error || 'حدث خطأ أثناء رفع الملف');
                    submitBtn.disabled = false;
                    submitBtn.querySelector('span').textContent = 'حفظ';
                }
            });

            xhr.addEventListener('error', function() {
                showError('حدث خطأ في الاتصال بالخادم');
                submitBtn.disabled = false;
                submitBtn.querySelector('span').textContent = 'حفظ';
            });

            xhr.open('POST', form.action, true);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.send(formData);
        } catch (error) {
            showError('حدث خطأ غير متوقع');
            submitBtn.disabled = false;
            submitBtn.querySelector('span').textContent = 'حفظ';
        }
    });

    // دعم السحب والإفلات
    const dropZone = document.querySelector('.border-dashed');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-red-500');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-red-500');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const file = dt.files[0];
        
        if (file) {
            if (!file.type.startsWith('image/') && !file.type.startsWith('video/')) {
                showError('عذراً، يسمح فقط بملفات الصور والفيديو');
                return;
            }

            // التحقق من حجم الملف
            if (file.size > 10 * 1024 * 1024) { // 10MB
                showError('حجم الملف يتجاوز الحد المسموح به (10 ميجابايت)');
                return;
            }

            hideError();
            fileInput.files = dt.files;
            document.getElementById('selected-file').textContent = file.name;
            showPreview(file);
        }
    }
</script>
@endpush

@endsection
