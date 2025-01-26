@extends('layouts.admin')

@section('styles')
<style>
    .sortable-item {
        cursor: move;
    }
    .sortable-ghost {
        opacity: 0.4;
        background-color: #4a5568 !important;
    }
    .handle {
        cursor: move;
        padding: 5px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.css">
@endsection

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <main class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- رأس الصفحة -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-folder ml-2 text-blue-600 dark:text-blue-500"></i>
                            إدارة الأقسام
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            إدارة وتنظيم أقسام الموقع
                        </p>
                    </div>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-sm font-medium rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <i class="fas fa-plus ml-2"></i>
                        إضافة قسم جديد
                    </a>
                </div>
            </div>

            <!-- رسائل النجاح والخطأ -->
            @if (session('success'))
                <div class="mb-6 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle ml-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <!-- جدول الأقسام -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            قائمة الأقسام
                        </h3>
                        
                        <!-- حقل البحث -->
                        <div class="flex-1 max-w-sm mr-4">
                            <form action="{{ route('admin.categories.index') }}" method="GET" class="flex">
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out"
                                    placeholder="ابحث عن قسم...">
                                <button type="submit" 
                                    class="mr-2 inline-flex items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    <i class="fas fa-grip-vertical cursor-move mx-2 handle"></i>
                                    الاسم
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    القسم الأب
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    عدد الأخبار
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    الترتيب
                                </th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    الإجراءات
                                </th>
                            </tr>
                        </thead>
                        <tbody id="sortable-categories" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($categories as $category)
                                <!-- القسم الرئيسي -->
                                <tr data-id="{{ $category->id }}" class="sortable-item hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <span class="handle mr-2">
                                                <i class="fas fa-grip-vertical text-gray-400"></i>
                                            </span>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $category->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $category->parent ? $category->parent->name : '-' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $category->news_count }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600 dark:text-gray-300">
                                            {{ $category->order }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                        <div class="flex justify-end space-x-2 space-x-reverse">
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-400 transition duration-150 ease-in-out">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')" 
                                                  class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- الأقسام الفرعية -->
                                @foreach($category->children as $child)
                                    <tr data-id="{{ $child->id }}" class="sortable-item hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <span class="handle mr-2">
                                                    <i class="fas fa-grip-vertical text-gray-400"></i>
                                                </span>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white mr-4">
                                                    <i class="fas fa-level-up-alt fa-rotate-90 text-gray-400 dark:text-gray-500 ml-2"></i>
                                                    {{ $child->name }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $category->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $child->news_count }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600 dark:text-gray-300">
                                                {{ $child->order }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                            <div class="flex justify-end space-x-2 space-x-reverse">
                                                <a href="{{ route('admin.categories.edit', $child) }}" 
                                                   class="text-blue-600 hover:text-blue-900 dark:text-blue-500 dark:hover:text-blue-400 transition duration-150 ease-in-out">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.categories.destroy', $child) }}" 
                                                      method="POST" 
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا القسم؟')" 
                                                      class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-500 dark:hover:text-red-400 transition duration-150 ease-in-out">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                            لا توجد أقسام حالياً
                                        </td>
                                    </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- الترقيم -->
                @if($categories instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
