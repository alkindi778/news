@extends('layouts.admin')

@section('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<style>
    /* جميع تنسيقات CSS الأصلية هنا */
    /* ... نفس محتوى قسم ال styles السابق ... */

    /* تنسيقات عامة للمحرر */
    .ql-editor {
        direction: rtl;
        text-align: right;
        min-height: 300px;
        font-family: 'Cairo', sans-serif;
        font-size: 16px;
        line-height: 1.8;
        padding: 1rem;
    }

    /* تنسيقات النص */
    .ql-editor h1, .ql-editor h2, .ql-editor h3 {
        font-weight: bold;
        margin: 20px 0;
    }
    .ql-editor p {
        margin-bottom: 15px;
    }

    /* تنسيقات شريط الأدوات */
    .ql-toolbar.ql-snow {
        direction: rtl;
        border-radius: 8px 8px 0 0;
        padding: 0.75rem;
        border-color: #e5e7eb;
    }

    /* تنسيقات حاوية المحرر */
    .ql-container {
        font-family: 'Cairo', sans-serif !important;
        border-radius: 0 0 8px 8px;
        border-color: #e5e7eb;
    }

    .ql-snow .ql-picker-label {
        direction: rtl;
        text-align: right;
    }

    /* تنسيقات الوضع الليلي */
    .dark .ql-snow .ql-toolbar {
        background-color: #374151;
        border-color: #4b5563;
    }

    .dark .ql-snow.ql-toolbar button {
        color: #e5e7eb;
    }

    .dark .ql-snow .ql-stroke {
        stroke: #e5e7eb;
    }

    .dark .ql-snow .ql-fill {
        fill: #e5e7eb;
    }

    .dark .ql-snow .ql-picker {
        color: #e5e7eb;
    }

    .dark .ql-snow.ql-toolbar button:hover,
    .dark .ql-snow .ql-toolbar button:hover {
        color: #60a5fa;
    }

    .dark .ql-snow.ql-toolbar button:hover .ql-stroke,
    .dark .ql-snow .ql-toolbar button:hover .ql-stroke {
        stroke: #60a5fa;
    }

    .dark .ql-snow.ql-toolbar button:hover .ql-fill,
    .dark .ql-snow .ql-toolbar button:hover .ql-fill {
        fill: #60a5fa;
    }

    .dark .ql-container.ql-snow {
        border-color: #4b5563;
    }

    .dark .ql-editor {
        background-color: #1f2937;
        color: #e5e7eb;
    }

    .dark .ql-snow .ql-picker-options {
        background-color: #374151;
        border-color: #4b5563;
    }

    .dark .ql-snow .ql-picker-item:hover {
        background-color: #4b5563;
        color: #60a5fa;
    }
</style>
@endsection

@section('content')
<div class="p-2 sm:p-4">
    <div class="max-w-[95%] mx-auto p-2 sm:p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">تعديل الخبر</h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="post" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data" id="newsForm" onsubmit="return prepareForm()">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="raw_content" id="raw_content">
                    
                    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                        <!-- القسم الرئيسي -->
                        <div class="xl:col-span-3 space-y-6">
                            <!-- العنوان الفرعي -->
                            <div>
                                <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">العنوان الفرعي</label>
                                <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $news->subtitle) }}" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="أدخل العنوان الفرعي للخبر">
                                @error('subtitle')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- عنوان الخبر -->
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان الخبر</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                    required>
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- محرر المحتوى -->
                            <div>
                                <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">المحتوى</label>
                                <div id="editor" class="bg-white">{!! old('content', $news->content) !!}</div>
                                <input type="hidden" id="content" name="content" value="{{ old('content', $news->content) }}">
                                @error('content')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SEO -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">تحسين محركات البحث SEO</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <input type="hidden" id="meta_title" name="meta_title" value="{{ old('meta_title', $news->meta_title) }}">
                                    <input type="hidden" id="meta_description" name="meta_description" value="{{ old('meta_description', $news->meta_description) }}">
                                    
                                    <div>
                                        <label for="meta_keywords" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            الكلمات المفتاحية
                                            <span class="text-xs text-gray-500">(يتم استخراجها تلقائياً مع إمكانية التعديل)</span>
                                        </label>
                                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $news->meta_keywords) }}"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="الكلمات المفتاحية مفصولة بفواصل">
                                        @error('meta_keywords')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- القسم الجانبي -->
                        <div class="space-y-6">
                            <!-- معلومات النشر -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">معلومات النشر</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <div>
                                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">القسم</label>
                                        <select id="category_id" name="category_id" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="">اختر القسم</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategories) ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- مصدر الخبر -->
                                    <div>
                                        <label for="source" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مصدر الخبر</label>
                                        <input type="text" id="source" name="source" value="{{ old('source', $news->source) }}" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="مثال: سمانيوز، متابعات، وكالات">
                                        @error('source')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- حالة النشر -->
                                    <div>
                                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">حالة النشر</label>
                                        <select id="status" name="status" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>منشور</option>
                                            <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>مسودة</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- خيارات إضافية -->
                            <div class="flex flex-col space-y-3">
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_breaking" value="1" class="sr-only peer" {{ old('is_breaking', $news->is_breaking) ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">خبر عاجل</span>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">عرض في السلايدر</span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="show_in_slider" value="1" class="sr-only peer" {{ old('show_in_slider', $news->show_in_slider) ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- الصورة -->
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">صورة الخبر</label>
                                <div class="flex items-center justify-center w-full">
                                    <label for="image" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 overflow-hidden group">
                                        @if($news->image)
                                        <img id="preview-image" src="{{ url('storage/' . $news->image) }}" alt="صورة الخبر" class="absolute inset-0 w-full h-full object-cover group-hover:opacity-50 transition-opacity duration-300">
                                        <div class="relative z-10 flex flex-col items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-semibold">اضغط للتحديث</span>
                                            </p>
                                        </div>
                                        @else
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-semibold">اضغط للرفع</span> أو اسحب وأفلت
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG أو JPEG (الحد الأقصى 2MB)</p>
                                        </div>
                                        @endif
                                        <input id="image" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" />
                                    </label>
                                </div>
                                @error('image')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- تعليق الصورة -->
                            <div>
                                <label for="image_caption" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تعليق الصورة</label>
                                <div class="relative">
                                    <input type="text" id="image_caption" name="image_caption" value="{{ old('image_caption', $news->image_caption) }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-10"
                                        placeholder="أدخل تعليقاً للصورة">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <i class="fas fa-comment-alt text-gray-400"></i>
                                    </div>
                                </div>
                                @error('image_caption')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- أزرار الحفظ -->
                    <div class="mt-8 flex flex-wrap gap-4">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">تحديث الخبر</button>
                        <a href="{{ route('admin.news.index') }}" class="w-full sm:w-auto px-6 py-3 text-base font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                ['link', 'blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['clean']
            ]
        },
        placeholder: 'اكتب محتوى الخبر هنا...',
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var preview = document.getElementById('preview-image');
                if (preview) {
                    preview.src = e.target.result;
                } else {
                    preview = document.createElement('img');
                    preview.id = 'preview-image';
                    preview.src = e.target.result;
                    preview.classList.add('absolute', 'inset-0', 'w-full', 'h-full', 'object-cover', 'group-hover:opacity-50', 'transition-opacity', 'duration-300');
                    input.parentElement.insertBefore(preview, input.parentElement.firstChild);
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function prepareForm() {
        var content = document.querySelector('#content');
        var rawContent = document.querySelector('#raw_content');
        content.value = quill.root.innerHTML;
        rawContent.value = quill.getText();
        return true;
    }

    // Character counters for meta fields
    document.getElementById('meta_title').addEventListener('input', function() {
        document.getElementById('metaTitleCounter').textContent = `(${this.value.length} / 60)`;
    });

    document.getElementById('meta_description').addEventListener('input', function() {
        document.getElementById('metaDescCounter').textContent = `(${this.value.length} / 160)`;
    });

    // Trigger initial count
    document.getElementById('meta_title').dispatchEvent(new Event('input'));
    document.getElementById('meta_description').dispatchEvent(new Event('input'));

    // Set initial editor content
    quill.root.innerHTML = document.querySelector('#content').value;

    // تحديث الكلمات المفتاحية فقط إذا كانت فارغة
    const keywordsInput = document.getElementById('meta_keywords');
    if (!keywordsInput.value.trim()) {
        const text = quill.getText();
        const title = document.getElementById('title').value;
        const subtitle = document.getElementById('subtitle').value;
        const fullText = `${title} ${subtitle} ${text}`;
        keywordsInput.value = extractKeywords(fullText);
    }

    // استخراج الكلمات المفتاحية
    function extractKeywords(text) {
        // قائمة الكلمات التي يجب تجاهلها
        const stopWords = new Set(['في', 'من', 'على', 'إلى', 'عن', 'مع', 'هذا', 'هذه', 'تم', 'كان', 'كانت', 'أن', 'إن', 'هل', 'لم', 'لن', 'لا', 'ما', 'و', 'أو', 'ثم', 'بعد', 'قبل', 'حيث', 'كل', 'وقد', 'فقد', 'كما', 'بين', 'ذلك', 'عند', 'عندما', 'لكن', 'حتى', 'إذا', 'نحو', 'لدى', 'منذ']);
        
        // تنظيف النص
        text = text.replace(/[^\u0600-\u06FF\s]/g, ' ')  // إزالة كل شيء ما عدا الحروف العربية
                   .replace(/\s+/g, ' ')                  // توحيد المسافات
                   .trim();
        
        // تقسيم النص إلى كلمات
        let words = text.split(' ');
        
        // إنشاء خريطة لتتبع تكرار الكلمات
        let wordCount = new Map();
        
        // حساب تكرار كل كلمة
        words.forEach(word => {
            word = word.trim();
            if (word.length > 2 && !stopWords.has(word)) {  // تجاهل الكلمات القصيرة وكلمات التوقف
                wordCount.set(word, (wordCount.get(word) || 0) + 1);
            }
        });
        
        // تحويل الخريطة إلى مصفوفة وترتيبها حسب التكرار
        let sortedWords = Array.from(wordCount.entries())
            .sort((a, b) => b[1] - a[1])
            .slice(0, 10)  // أخذ أهم 10 كلمات
            .map(entry => entry[0]);
        
        return sortedWords.join('، ');
    }

    // تحديث الكلمات المفتاحية وبيانات الميتا عند تغيير المحتوى
    quill.on('text-change', function() {
        const text = quill.getText();
        const title = document.getElementById('title').value;
        const subtitle = document.getElementById('subtitle').value;
        
        // دمج العنوان والعنوان الفرعي والمحتوى
        const fullText = `${title} ${subtitle} ${text}`;
        
        // تحديث عنوان الميتا
        const metaTitle = title.length > 60 ? title.substring(0, 57) + '...' : title;
        document.getElementById('meta_title').value = metaTitle;

        // تحديث وصف الميتا
        let metaDescription = text.trim();
        if (metaDescription.length > 160) {
            metaDescription = metaDescription.substring(0, 157) + '...';
        } else if (metaDescription.length === 0) {
            metaDescription = subtitle || title;
        }
        document.getElementById('meta_description').value = metaDescription;
    });

    // تحديث البيانات عند تغيير العنوان أو العنوان الفرعي
    document.getElementById('title').addEventListener('input', function() {
        quill.emit('text-change');
    });
    
    document.getElementById('subtitle').addEventListener('input', function() {
        quill.emit('text-change');
    });
</script>
@endpush