@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- معلومات عامة -->
                    <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-blue-500/10 dark:bg-blue-500/5 rounded-xl ml-4">
                                <i class="fas fa-info-circle text-2xl text-blue-500 dark:text-blue-400"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">معلومات عامة</h2>
                        </div>
                        
                        <div class="grid gap-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    اسم الموقع
                                </label>
                                <input type="text" name="site_name"
                                    value="{{ old('site_name', $settings->site_name) }}"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    وصف الموقع
                                </label>
                                <textarea name="site_description" rows="4"
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">{{ old('site_description', $settings->site_description) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    شعار الموقع
                                </label>
                                <div class="flex items-center gap-4">
                                    <div class="flex-1">
                                        <div class="relative">
                                            <input type="file" name="site_logo" accept="image/*"
                                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                        </div>
                                    </div>
                                    @if($settings->site_logo)
                                        <div class="flex-shrink-0">
                                            <img src="{{ url('storage/' . $settings->site_logo) }}" 
                                                alt="شعار الموقع" 
                                                class="h-16 w-auto object-contain rounded-lg"
                                                id="current_logo">
                                        </div>
                                    @endif
                                </div>

                                <!-- حجم الشعار -->
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">العرض (بالبكسل)</label>
                                        <input type="number" name="logo_width" value="{{ old('logo_width', $settings->logo_width) }}"
                                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                            min="1" id="logo_width">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الارتفاع (بالبكسل)</label>
                                        <input type="number" name="logo_height" value="{{ old('logo_height', $settings->logo_height) }}"
                                            class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                            min="1" id="logo_height">
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400" id="original_size">
                                    @if($settings->site_logo)
                                        <span>الحجم الأصلي: <span id="original_dimensions">...</span> بكسل</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    أيقونة الموقع (Favicon)
                                </label>
                                <div class="flex items-center gap-4">
                                    <div class="flex-1">
                                        <div class="relative">
                                            <input type="file" name="site_favicon" accept="image/x-icon,image/png"
                                                class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                                يفضل أن تكون بأبعاد 32x32 أو 16x16 بكسل، بصيغة ICO أو PNG
                                            </p>
                                        </div>
                                    </div>
                                    @if($settings->site_favicon)
                                        <div class="flex-shrink-0">
                                            <img src="{{ url($settings->site_favicon) }}" 
                                                alt="أيقونة الموقع" 
                                                class="h-8 w-8 object-contain rounded-lg"
                                                id="current_favicon">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- روابط التواصل الاجتماعي -->
                    <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center mb-6">
                            <div class="p-3 bg-blue-500/10 dark:bg-blue-500/5 rounded-xl ml-4">
                                <i class="fas fa-share-alt text-2xl text-blue-500 dark:text-blue-400"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">روابط التواصل الاجتماعي</h2>
                        </div>

                        <div class="grid gap-6">
                            <!-- فيسبوك -->
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fab fa-facebook text-blue-500 ml-2 text-xl"></i>
                                    <span>فيسبوك</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-facebook-f text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <input type="url" name="facebook_url" 
                                        value="{{ old('facebook_url', $settings->facebook_url) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                </div>
                            </div>

                            <!-- تويتر -->
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fab fa-twitter text-blue-400 ml-2 text-xl"></i>
                                    <span>تويتر</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-twitter text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <input type="url" name="twitter_url" 
                                        value="{{ old('twitter_url', $settings->twitter_url) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                </div>
                            </div>

                            <!-- انستغرام -->
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fab fa-instagram text-pink-500 ml-2 text-xl"></i>
                                    <span>انستغرام</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-instagram text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <input type="url" name="instagram_url" 
                                        value="{{ old('instagram_url', $settings->instagram_url) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                </div>
                            </div>

                            <!-- يوتيوب -->
                            <div>
                                <label class="flex items-center text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <i class="fab fa-youtube text-red-500 ml-2 text-xl"></i>
                                    <span>يوتيوب</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fab fa-youtube text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <input type="url" name="youtube_url" 
                                        value="{{ old('youtube_url', $settings->youtube_url) }}"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- زر الحفظ -->
                    <div class="p-8 bg-gray-50 dark:bg-gray-800/50">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-lg font-medium rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                <i class="fas fa-save ml-2"></i>
                                <span>حفظ الإعدادات</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logoInput = document.querySelector('input[name="site_logo"]');
        const currentLogo = document.getElementById('current_logo');
        const originalDimensions = document.getElementById('original_dimensions');
        const logoWidth = document.getElementById('logo_width');
        const logoHeight = document.getElementById('logo_height');

        // عرض الأبعاد الأصلية للشعار الحالي
        if (currentLogo) {
            currentLogo.onload = function() {
                originalDimensions.textContent = `${this.naturalWidth} × ${this.naturalHeight}`;
            }
        }

        // معاينة الصورة المختارة
        logoInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (currentLogo) {
                        currentLogo.src = e.target.result;
                        const img = new Image();
                        img.onload = function() {
                            originalDimensions.textContent = `${this.width} × ${this.height}`;
                            logoWidth.value = this.width;
                            logoHeight.value = this.height;
                        }
                        img.src = e.target.result;
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
@endsection
