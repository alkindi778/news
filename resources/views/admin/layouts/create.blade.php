@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">إضافة قسم جديد</h1>
                <a href="{{ route('admin.sidebar.index') }}" class="text-blue-600 hover:text-blue-900">
                    <i class="fas fa-arrow-right ml-2"></i>رجوع
                </a>
            </div>

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.sidebar.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">عنوان القسم</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">نوع القسم</label>
                    <select name="type" id="type" required onchange="toggleFields()"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">اختر نوع القسم</option>
                        <option value="category" {{ old('type') == 'category' ? 'selected' : '' }}>تصنيف</option>
                        <option value="popular" {{ old('type') == 'popular' ? 'selected' : '' }}>الأكثر قراءة</option>
                        <option value="latest" {{ old('type') == 'latest' ? 'selected' : '' }}>آخر الأخبار</option>
                        <option value="ads" {{ old('type') == 'ads' ? 'selected' : '' }}>إعلان</option>
                        <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>محتوى مخصص</option>
                    </select>
                </div>

                <div id="category_field" class="hidden">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">التصنيف</label>
                    <select name="category_id" id="category_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">اختر التصنيف</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="ad_field" class="hidden">
                    <label for="ad_id" class="block text-sm font-medium text-gray-700 mb-1">الإعلان</label>
                    <select name="ad_id" id="ad_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">اختر الإعلان</option>
                        @foreach($ads as $ad)
                            <option value="{{ $ad->id }}" {{ old('ad_id') == $ad->id ? 'selected' : '' }}>
                                {{ $ad->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="content_field" class="hidden">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">المحتوى المخصص</label>
                    <textarea name="content" id="content" rows="4"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('content') }}</textarea>
                </div>

                <div id="posts_count_field" class="hidden">
                    <label for="posts_count" class="block text-sm font-medium text-gray-700 mb-1">عدد المقالات</label>
                    <input type="number" name="posts_count" id="posts_count" value="{{ old('posts_count', 5) }}" min="1" max="50"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        حفظ القسم
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleFields() {
    const type = document.getElementById('type').value;
    
    // إخفاء جميع الحقول
    document.getElementById('category_field').classList.add('hidden');
    document.getElementById('ad_field').classList.add('hidden');
    document.getElementById('content_field').classList.add('hidden');
    document.getElementById('posts_count_field').classList.add('hidden');
    
    // إظهار الحقول المطلوبة حسب النوع
    switch(type) {
        case 'category':
            document.getElementById('category_field').classList.remove('hidden');
            document.getElementById('posts_count_field').classList.remove('hidden');
            break;
        case 'popular':
        case 'latest':
            document.getElementById('posts_count_field').classList.remove('hidden');
            break;
        case 'ads':
            document.getElementById('ad_field').classList.remove('hidden');
            break;
        case 'custom':
            document.getElementById('content_field').classList.remove('hidden');
            break;
    }
}

// تشغيل الدالة عند تحميل الصفحة لإظهار الحقول المناسبة
document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endpush
@endsection
