@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                <i class="fas fa-edit text-blue-500 mr-2"></i>
                تعديل الإعلان
            </h1>
            <p class="text-gray-600 dark:text-gray-400">قم بتعديل تفاصيل الإعلان وموقعه</p>
        </div>

        <!-- Main Form Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden transition-all duration-300 hover:shadow-2xl">
            <div class="p-6 sm:p-8">
                <form action="{{ route('admin.advertisements.update', $advertisement->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title Input -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">عنوان الإعلان</label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-heading text-gray-400"></i>
                            </div>
                            <input type="text" name="title" value="{{ old('title', $advertisement->title) }}" 
                                class="block w-full pl-10 pr-4 py-3 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                placeholder="أدخل عنوان الإعلان">
                        </div>
                        @error('title')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link Input -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">رابط الإعلان</label>
                        <div class="relative rounded-lg shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-link text-gray-400"></i>
                            </div>
                            <input type="url" name="link" value="{{ old('link', $advertisement->link) }}" 
                                class="block w-full pl-10 pr-4 py-3 border-gray-200 dark:border-gray-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors duration-200"
                                placeholder="https://example.com">
                        </div>
                        @error('link')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Position Select -->
                    <div class="space-y-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">موقع الإعلان</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- إعلان الهيدر -->
                            <label class="relative flex items-center p-4 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                                <input type="radio" name="position" value="header" class="hidden peer" {{ old('position', $advertisement->position) == 'header' ? 'checked' : '' }}>
                                <div class="flex flex-col items-center flex-1 p-2">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-window-maximize text-xl text-blue-500 dark:text-blue-400"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white mb-1">أعلى الصفحة</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">468×60 بكسل</span>
                                </div>
                                <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 text-blue-500 transition-opacity duration-300">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-500 rounded-xl transition-colors duration-300"></div>
                            </label>

                            <!-- إعلان الشريط الجانبي -->
                            <label class="relative flex items-center p-4 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                                <input type="radio" name="position" value="sidebar" class="hidden peer" {{ old('position', $advertisement->position) == 'sidebar' ? 'checked' : '' }}>
                                <div class="flex flex-col items-center flex-1 p-2">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-columns text-xl text-blue-500 dark:text-blue-400"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white mb-1">الشريط الجانبي</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">300×600 بكسل</span>
                                </div>
                                <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 text-blue-500 transition-opacity duration-300">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-500 rounded-xl transition-colors duration-300"></div>
                            </label>
                            <!-- إعلان تحت الناف بار -->
                            <label class="relative flex items-center p-4 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                                <input type="radio" name="position" value="below_navbar" class="hidden peer" {{ old('position', $advertisement->position) == 'below_navbar' ? 'checked' : '' }}>
                                <div class="flex flex-col items-center flex-1 p-2">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-grip-lines text-xl text-blue-500 dark:text-blue-400"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white mb-1">تحت شريط التنقل</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">970×90 بكسل</span>
                                </div>
                                <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 text-blue-500 transition-opacity duration-300">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-500 rounded-xl transition-colors duration-300"></div>
                            </label>
                            <!-- إعلان التذييل -->
                            <label class="relative flex items-center p-4 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                                <input type="radio" name="position" value="footer" class="hidden peer" {{ old('position', $advertisement->position) == 'footer' ? 'checked' : '' }}>
                                <div class="flex flex-col items-center flex-1 p-2">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-window-maximize fa-flip-vertical text-xl text-blue-500 dark:text-blue-400"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white mb-1">أسفل الصفحة</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">728×90 بكسل</span>
                                </div>
                                <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 text-blue-500 transition-opacity duration-300">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-500 rounded-xl transition-colors duration-300"></div>
                            </label>

                            <!-- إعلان بين الأقسام -->
                            <label class="relative flex items-center p-4 border dark:border-gray-700 rounded-xl cursor-pointer hover:bg-blue-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                                <input type="radio" name="position" value="between_sections" class="hidden peer" {{ old('position', $advertisement->position) == 'between_sections' ? 'checked' : '' }}>
                                <div class="flex flex-col items-center flex-1 p-2">
                                    <div class="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-grip-lines text-xl text-blue-500 dark:text-blue-400"></i>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white mb-1">بين الأقسام</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">728×90 بكسل</span>
                                </div>
                                <div class="absolute top-2 right-2 opacity-0 peer-checked:opacity-100 text-blue-500 transition-opacity duration-300">
                                    <i class="fas fa-check-circle text-lg"></i>
                                </div>
                                <div class="absolute inset-0 border-2 border-transparent peer-checked:border-blue-500 rounded-xl transition-colors duration-300"></div>
                            </label>
                        </div>
                        @error('position')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Image Preview -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">الصورة الحالية</label>
                        @if($advertisement->image)
                            <div class="mt-2 relative">
                                <img src="{{ asset('storage/' . $advertisement->image) }}" alt="{{ $advertisement->title }}" class="max-w-xs rounded-lg shadow-md">
                            </div>
                        @endif
                    </div>

                    <!-- Image Upload -->
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">تغيير الصورة</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-lg hover:border-blue-500 dark:hover:border-blue-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <div class="flex flex-col items-center">
                                    <img id="preview" class="hidden mb-4 max-h-48 rounded-lg">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                </div>
                                <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                    <label for="image" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>اختر صورة</span>
                                        <input id="image" name="image" type="file" class="sr-only" onchange="showPreview(event)">
                                    </label>
                                    <p class="pl-1">أو قم بسحب وإفلات الصورة هنا</p>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    PNG, JPG, GIF حتى 2MB
                                </p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Switch -->
                    <div class="flex items-center justify-between">
                        <span class="flex-grow flex flex-col">
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">تفعيل الإعلان</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400">اختر ما إذا كنت تريد عرض الإعلان على الموقع</span>
                        </span>
                        <div x-data="{ on: {{ $advertisement->active ? 'true' : 'false' }} }">
                            <button type="button" 
                                    @click="on = !on"
                                    :class="{ 'bg-blue-600': on, 'bg-gray-200': !on }"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <span class="sr-only">تفعيل الإعلان</span>
                                <input type="hidden" name="active" :value="on ? '1' : '0'">
                                <span aria-hidden="true" 
                                      :class="{ 'translate-x-5': on, 'translate-x-0': !on }"
                                      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200">
                            <i class="fas fa-save mr-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showPreview(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        const preview = document.getElementById('preview');
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        }
        
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
