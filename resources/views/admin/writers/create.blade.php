@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2">
            <i class="fas fa-user-plus text-blue-600 mr-2"></i>
            إضافة كاتب جديد
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-400">أدخل معلومات الكاتب الجديد</p>
    </div>

    <form action="{{ route('admin.writers.store') }}" method="POST" enctype="multipart/form-data" class="max-w-4xl mx-auto">
        @csrf
        
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <div class="p-8">
                <!-- المعلومات الأساسية -->
                <div class="mb-12">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 border-b pb-2">المعلومات الأساسية</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <label for="name" class="block text-lg font-medium text-gray-700 dark:text-gray-300">الاسم</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                value="{{ old('name') }}"
                                placeholder="أدخل اسم الكاتب">
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="email" class="block text-lg font-medium text-gray-700 dark:text-gray-300">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                value="{{ old('email') }}"
                                placeholder="example@domain.com">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="phone" class="block text-lg font-medium text-gray-700 dark:text-gray-300">رقم الهاتف</label>
                            <input type="tel" name="phone" id="phone"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                value="{{ old('phone') }}"
                                placeholder="00967xxxxxxxxx"
                                dir="ltr">
                            @error('phone')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-4">
                            <label for="title" class="block text-lg font-medium text-gray-700 dark:text-gray-300">المسمى الوظيفي</label>
                            <input type="text" name="title" id="title"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                value="{{ old('title') }}"
                                placeholder="مثال: كاتب محتوى">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- نبذة عن الكاتب -->
                <div class="mb-12">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 border-b pb-2">نبذة عن الكاتب</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="bio" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">نبذة تعريفية</label>
                            <textarea name="bio" id="bio" rows="6"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="اكتب نبذة مختصرة عن الكاتب">{{ old('bio') }}</textarea>
                            @error('bio')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-4">الصورة الشخصية</label>
                            <div class="flex items-center space-x-6 space-x-reverse">
                                <div class="flex-shrink-0">
                                    <div id="image-preview" class="h-32 w-32 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border-4 border-blue-500">
                                        <i class="fas fa-user text-gray-400 text-4xl" id="default-avatar"></i>
                                        <img src="#" alt="معاينة الصورة" class="h-full w-full object-cover hidden" id="preview-image">
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="image" id="image" accept="image/*"
                                           class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-blue-50 file:text-blue-700
                                                  hover:file:bg-blue-100
                                                  dark:file:bg-gray-700 dark:file:text-gray-300"
                                           onchange="previewImage(this);">
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                        اختر صورة شخصية. الصيغ المدعومة: JPG، PNG، GIF. الحد الأقصى: 2 ميجابايت
                                    </p>
                                    @error('image')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function previewImage(input) {
                        var preview = document.getElementById('preview-image');
                        var defaultAvatar = document.getElementById('default-avatar');
                        
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            
                            reader.onload = function(e) {
                                preview.src = e.target.result;
                                preview.classList.remove('hidden');
                                defaultAvatar.classList.add('hidden');
                            }
                            
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            preview.classList.add('hidden');
                            defaultAvatar.classList.remove('hidden');
                        }
                    }
                </script>

                <!-- روابط التواصل الاجتماعي -->
                <div>
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 border-b pb-2">روابط التواصل الاجتماعي</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label for="twitter" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">تويتر</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-lg">
                                    <i class="fab fa-twitter"></i>
                                </span>
                                <input type="url" name="twitter" id="twitter"
                                    class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('twitter') }}"
                                    placeholder="https://twitter.com/username">
                            </div>
                            @error('twitter')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="facebook" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">فيسبوك</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-lg">
                                    <i class="fab fa-facebook-f"></i>
                                </span>
                                <input type="url" name="facebook" id="facebook"
                                    class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('facebook') }}"
                                    placeholder="https://facebook.com/profile">
                            </div>
                            @error('facebook')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="linkedin" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">لينكد إن</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-lg">
                                    <i class="fab fa-linkedin-in"></i>
                                </span>
                                <input type="url" name="linkedin" id="linkedin"
                                    class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('linkedin') }}"
                                    placeholder="https://linkedin.com/in/profile">
                            </div>
                            @error('linkedin')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="website" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">الموقع الشخصي</label>
                            <div class="mt-1 flex rounded-md shadow-sm">
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-lg">
                                    <i class="fas fa-globe"></i>
                                </span>
                                <input type="url" name="website" id="website"
                                    class="flex-1 block w-full rounded-none rounded-l-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('website') }}"
                                    placeholder="https://example.com">
                            </div>
                            @error('website')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- أزرار التحكم -->
            <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-lg font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300">
                    <i class="fas fa-save mr-2"></i>
                    حفظ الكاتب
                </button>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const previewImage = document.getElementById('preview-image');
        const defaultAvatar = document.getElementById('default-avatar');

        imageInput.addEventListener('change', function(e) {
            const file = this.files[0];
            
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');
                        defaultAvatar.classList.add('hidden');
                    };
                    
                    reader.onerror = function(error) {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء قراءة الصورة. يرجى المحاولة مرة أخرى.');
                    };

                    reader.readAsDataURL(file);
                } else {
                    alert('يرجى اختيار ملف صورة صالح');
                    this.value = '';
                }
            }
        });
    });
</script>
@endsection
