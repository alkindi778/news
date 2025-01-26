@extends('layouts.admin')

@section('title', 'إدارة الإعلانات')

@section('content')
<div class="py-6 bg-gray-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                    إدارة الإعلانات
                </h2>
            </div>
            <div class="mt-4 flex md:mt-0 md:mr-4">
                <a href="{{ route('admin.advertisements.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:bg-red-500 dark:hover:bg-red-600">
                    <i class="fas fa-plus ml-2"></i>
                    إضافة إعلان جديد
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="bg-white dark:bg-gray-700 shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                العنوان
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الموقع
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الصورة
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                تاريخ الإنشاء
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                العمليات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                        @forelse($advertisements as $advertisement)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-200">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $advertisement->title }}
                                    </div>
                                    @if($advertisement->url)
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            <a href="{{ $advertisement->url }}" target="_blank" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                                <i class="fas fa-external-link-alt ml-1"></i>
                                                رابط الإعلان
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $advertisement->position === 'header' 
                                            ? 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100'
                                            : ($advertisement->position === 'sidebar'
                                                ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                                                : ($advertisement->position === 'footer'
                                                    ? 'bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100'
                                                    : ($advertisement->position === 'below_navbar'
                                                        ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100'
                                                        : 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100'))) }}">
                                        @if($advertisement->position === 'header')
                                            <i class="fas fa-window-maximize ml-1"></i>
                                            أعلى الصفحة
                                        @elseif($advertisement->position === 'sidebar')
                                            <i class="fas fa-columns ml-1"></i>
                                            الشريط الجانبي
                                        @elseif($advertisement->position === 'footer')
                                            <i class="fas fa-window-maximize fa-flip-vertical ml-1"></i>
                                            أسفل الصفحة
                                        @elseif($advertisement->position === 'below_navbar')
                                            <i class="fas fa-grip-lines ml-1"></i>
                                            تحت شريط التنقل
                                        @else
                                            <i class="fas fa-grip-lines ml-1"></i>
                                            بين الأقسام
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($advertisement->image)
                                        <img src="{{ url('storage/' . $advertisement->image) }}" 
                                             alt="{{ $advertisement->title }}" 
                                             class="h-16 w-auto object-contain rounded">
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">
                                            <i class="fas fa-image text-2xl"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $advertisement->active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100' }}">
                                        {{ $advertisement->active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $advertisement->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center space-x-2 space-x-reverse">
                                        <a href="{{ route('admin.advertisements.edit', $advertisement->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors duration-200">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        <form action="{{ route('admin.advertisements.destroy', $advertisement->id) }}" 
                                              method="POST" 
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-200"
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا الإعلان؟')">
                                                <i class="fas fa-trash text-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                    <div class="flex flex-col items-center justify-center py-8">
                                        <i class="fas fa-ad text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">لا توجد إعلانات حالياً</p>
                                        <a href="{{ route('admin.advertisements.create') }}" 
                                           class="mt-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
                                            <i class="fas fa-plus ml-2"></i>
                                            إضافة إعلان جديد
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($advertisements->hasPages())
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-600">
                    {{ $advertisements->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
