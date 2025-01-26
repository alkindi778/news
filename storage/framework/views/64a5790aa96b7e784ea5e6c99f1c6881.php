<?php $__env->startSection('styles'); ?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<style>
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

    /* تنسيقات إضافية */
    .image-preview {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
    }
    .preview-container {
        position: relative;
        display: inline-block;
    }
    .preview-container .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255, 0, 0, 0.7);
        color: white;
        padding: 5px 10px;
        border-radius: 3px;
        cursor: pointer;
    }

    /* تحسينات إضافية للمحرر */
    .ql-toolbar.ql-snow .ql-formats {
        margin-right: 0;
        margin-left: 15px;
    }

    .ql-snow .ql-tooltip {
        direction: rtl;
        text-align: right;
    }

    .dark .ql-snow .ql-tooltip {
        background-color: #374151;
        border-color: #4b5563;
        color: #e5e7eb;
    }

    .dark .ql-snow .ql-tooltip input[type=text] {
        background-color: #1f2937;
        border-color: #4b5563;
        color: #e5e7eb;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="p-2 sm:p-4">
    <div class="max-w-[95%] mx-auto p-2 sm:p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">إضافة خبر جديد</h3>
            </div>
            <div class="p-4 sm:p-6">
                <form method="post" action="<?php echo e(route('admin.news.store')); ?>" enctype="multipart/form-data" id="newsForm" onsubmit="return prepareForm()">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="raw_content" id="raw_content">
                    
                    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                        <!-- القسم الرئيسي -->
                        <div class="xl:col-span-3 space-y-6">
                            <!-- العنوان الفرعي -->
                            <div>
                                <label for="subtitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">العنوان الفرعي</label>
                                <input type="text" id="subtitle" name="subtitle" value="<?php echo e(old('subtitle')); ?>" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="أدخل العنوان الفرعي للخبر">
                                <?php $__errorArgs = ['subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- عنوان الخبر -->
                            <div>
                                <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">عنوان الخبر</label>
                                <input type="text" id="title" name="title" value="<?php echo e(old('title')); ?>" 
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" 
                                    required>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- محرر المحتوى -->
                            <div>
                                <label for="content" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">المحتوى</label>
                                <input type="hidden" name="raw_content" id="raw_content">
                                <div id="editor" class="bg-white"></div>
                                <input type="hidden" id="content" name="content" value="<?php echo e(old('content')); ?>">
                                <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- SEO -->
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                                <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">تحسين محركات البحث SEO</h4>
                                </div>
                                <div class="p-4 space-y-4">
                                    <input type="hidden" id="meta_title" name="meta_title" value="<?php echo e(old('meta_title')); ?>">
                                    <input type="hidden" id="meta_description" name="meta_description" value="<?php echo e(old('meta_description')); ?>">
                                    
                                    <div>
                                        <label for="meta_keywords" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            الكلمات المفتاحية
                                            <span class="text-xs text-gray-500">(يتم استخراجها تلقائياً مع إمكانية التعديل)</span>
                                        </label>
                                        <input type="text" id="meta_keywords" name="meta_keywords" value="<?php echo e(old('meta_keywords')); ?>"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="الكلمات المفتاحية مفصولة بفواصل">
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
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id') == $category->id ? 'selected' : ''); ?>>
                                                    <?php echo e($category->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- مصدر الخبر -->
                                    <div>
                                        <label for="source" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">مصدر الخبر</label>
                                        <input type="text" id="source" name="source" value="<?php echo e(old('source')); ?>" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                            placeholder="مثال: سمانيوز، متابعات، وكالات">
                                        <?php $__errorArgs = ['source'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- حالة النشر -->
                                    <div>
                                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">حالة النشر</label>
                                        <select id="status" name="status" required
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>منشور</option>
                                            <option value="draft" <?php echo e(old('status') == 'draft' ? 'selected' : ''); ?>>مسودة</option>
                                        </select>
                                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                                <!-- خيارات إضافية -->
                                <div class="space-y-4 mt-4">
                                    <!-- خيارات الأخبار -->
                                    <div class="flex flex-col space-y-3">
                                        <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="is_breaking" value="1" class="sr-only peer" <?php echo e(old('is_breaking') ? 'checked' : ''); ?>>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-red-600"></div>
                                                <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">خبر عاجل</span>
                                            </label>
                                        </div>

                                        <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 dark:bg-gray-700">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">عرض في السلايدر</span>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" name="show_in_slider" value="1" class="sr-only peer" <?php echo e(old('show_in_slider') ? 'checked' : ''); ?>>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 dark:peer-focus:ring-purple-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-purple-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                    <!-- الصورة -->
                                    <div>
                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">صورة الخبر</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label for="image" class="relative flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 overflow-hidden group">
                                                <!-- صورة المعاينة -->
                                                <div id="preview-container" class="hidden absolute inset-0 w-full h-full">
                                                    <img id="preview-image" src="#" alt="معاينة الصورة" class="w-full h-full object-contain p-2">
                                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                        <button type="button" onclick="removeImage()" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 focus:outline-none transform hover:scale-110 transition-transform duration-300">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!-- رسالة الرفع -->
                                                <div id="upload-prompt" class="flex flex-col items-center justify-center pt-5 pb-6 relative z-10">
                                                    <div class="mb-3 text-gray-400 dark:text-gray-400">
                                                        <i class="fas fa-cloud-upload-alt text-4xl"></i>
                                                    </div>
                                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                        <span class="font-semibold">اضغط للرفع</span> أو اسحب وأفلت
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, WEBP (الحد الأقصى: 5MB)</p>
                                                </div>
                                                <input type="file" name="image" id="image" accept="image/png,image/jpeg,image/webp" class="hidden" required>
                                            </label>
                                        </div>
                                        <div id="image-error" class="mt-2 text-sm text-red-600 dark:text-red-500 hidden"></div>
                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <!-- تعليق الصورة -->
                                    <div>
                                        <label for="image_caption" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">تعليق الصورة</label>
                                        <div class="relative">
                                            <input type="text" id="image_caption" name="image_caption" value="<?php echo e(old('image_caption')); ?>"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-10"
                                                placeholder="أدخل تعليقاً للصورة">
                                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                <i class="fas fa-comment-alt text-gray-400"></i>
                                            </div>
                                        </div>
                                        <?php $__errorArgs = ['image_caption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <!-- أزرار الحفظ -->
                    <div class="mt-8 flex flex-wrap gap-4">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">إضافة الخبر</button>
                        <a href="<?php echo e(route('admin.news.index')); ?>" class="w-full sm:w-auto px-6 py-3 text-base font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 text-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-700 dark:focus:ring-gray-700">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // معالجة الصورة
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const uploadPrompt = document.getElementById('upload-prompt');
    const imageError = document.getElementById('image-error');

    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB in bytes

    function validateImage(file) {
        // التحقق من نوع الملف
        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            return 'يجب أن تكون الصورة من نوع PNG أو JPG أو WEBP';
        }

        // التحقق من حجم الملف
        if (file.size > MAX_FILE_SIZE) {
            return 'يجب أن لا يتجاوز حجم الصورة 5 ميجابايت';
        }

        return null;
    }

    function showError(message) {
        imageError.textContent = message;
        imageError.classList.remove('hidden');
    }

    function hideError() {
        imageError.textContent = '';
        imageError.classList.add('hidden');
    }

    function handleImageSelect(file) {
        const error = validateImage(file);
        if (error) {
            showError(error);
            imageInput.value = '';
            return false;
        }

        hideError();
        showPreview(file);
        return true;
    }

    // معالجة تحديد الملف
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleImageSelect(file);
        }
    });

    // دعم السحب والإفلات
    const dropZone = document.querySelector('label[for="image"]');

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
        dropZone.classList.add('border-primary-500');
        dropZone.classList.add('bg-primary-50');
        dropZone.classList.add('dark:bg-primary-900/10');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-primary-500');
        dropZone.classList.remove('bg-primary-50');
        dropZone.classList.remove('dark:bg-primary-900/10');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];
            if (handleImageSelect(file)) {
                imageInput.files = files;
            }
        }
    }

    function showPreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
            uploadPrompt.classList.add('hidden');
            // إضافة تأثير ظهور تدريجي
            previewContainer.style.opacity = '0';
            setTimeout(() => {
                previewContainer.style.opacity = '1';
                previewContainer.style.transition = 'opacity 0.3s ease-in-out';
            }, 50);
        }
        reader.readAsDataURL(file);
    }

    function removeImage() {
        imageInput.value = '';
        previewImage.src = '#';
        previewContainer.classList.add('hidden');
        uploadPrompt.classList.remove('hidden');
        hideError();
    }

    // معالجة المحتوى
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'align': [] }],
                [{ 'direction': 'rtl' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'اكتب محتوى الخبر هنا...',
        direction: 'rtl'
    });

    // تحميل المحتوى القديم إذا وجد
    var oldContent = <?php echo json_encode(old('content', '')); ?>;
    if (oldContent) {
        quill.root.innerHTML = oldContent;
    }

    function prepareForm() {
        // نقل المحتوى من المحرر إلى الحقل المخفي
        var content = document.querySelector('input[name=content]');
        var rawContent = document.querySelector('#raw_content');
        if (content && rawContent) {
            content.value = quill.root.innerHTML;
            rawContent.value = quill.getText();
        }
        return true;
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
        
        // استخراج الكلمات المفتاحية فقط إذا كان الحقل فارغاً
        const keywordsInput = document.getElementById('meta_keywords');
        if (!keywordsInput.value.trim()) {
            const keywords = extractKeywords(fullText);
            keywordsInput.value = keywords;
        }

        // تحديث عنوان الميتا
        const metaTitle = title.length > 60 ? title.substring(0, 57) + '...' : title;
        document.getElementById('meta_title').value = metaTitle;

        // تحديث وصف الميتا
        let metaDescription = text.trim();
        if (metaDescription.length > 160) {
            metaDescription = metaDescription.substring(0, 157) + '...';
        } else if (metaDescription.length === 0) {
            metaDescription = subtitle || title; // استخدام العنوان الفرعي أو الرئيسي إذا كان المحتوى فارغاً
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/admin/news/create.blade.php ENDPATH**/ ?>