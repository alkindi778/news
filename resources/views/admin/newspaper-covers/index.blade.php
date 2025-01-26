@extends('layouts.admin')

@section('title', 'أغلفة الصحف')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">أغلفة الصحف</h2>
        <a href="{{ route('admin.newspaper-covers.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
            <svg class="w-5 h-5 ml-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            إضافة غلاف جديد
        </a>
    </div>
    
    <!-- Search Bar -->
    <div class="mb-8">
        <div class="relative bg-white/50 dark:bg-gray-800/50 backdrop-blur-xl shadow-xl rounded-2xl overflow-hidden border border-white/20 dark:border-gray-700/30">
            <div class="flex items-center p-2">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <i class="fas fa-search text-gray-400/80 dark:text-gray-500"></i>
                    </div>
                    <input type="text" 
                           id="searchInput"
                           class="w-full pr-10 bg-gray-50/50 dark:bg-gray-800/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm rounded-xl border-0 ring-1 ring-gray-200/50 dark:ring-gray-700/50 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-500 block p-3.5 transition-all duration-200" 
                           placeholder="ابحث في أغلفة الصحف...">
                </div>
                <div id="searchLoading" class="absolute left-14 flex items-center hidden">
                    <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-500 border-t-transparent"></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <!-- Mobile View -->
        <div class="block sm:hidden">
            @forelse($covers as $cover)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-4 p-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $cover->title }}</h3>
                    <span class="px-3 py-1 text-xs leading-5 font-semibold rounded-full {{ $cover->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900' }}">
                        {{ $cover->status === 'active' ? 'نشط' : 'غير نشط' }}
                    </span>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-center">
                        <img src="{{ url('storage/' . $cover->cover_image) }}" 
                             alt="{{ $cover->title }}" 
                             class="h-40 w-auto rounded-lg shadow-sm">
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <p><span class="font-medium">اسم الصحيفة:</span> {{ $cover->newspaper_name }}</p>
                        <p><span class="font-medium">تاريخ النشر:</span> {{ $cover->publish_date->format('Y-m-d') }}</p>
                        <p><span class="font-medium">المشاهدات:</span> {{ $cover->views }}</p>
                        @if($cover->pdf_link)
                            <a href="{{ $cover->pdf_link }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline block mt-2">
                                <i class="fas fa-external-link-alt ml-1"></i>
                                عرض العدد
                            </a>
                        @endif
                    </div>
                    <div class="flex justify-end space-x-3 space-x-reverse pt-3 border-t dark:border-gray-700">
                        <a href="{{ route('admin.newspaper-covers.edit', $cover) }}" 
                           class="text-blue-500 hover:text-blue-600 p-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.newspaper-covers.destroy', $cover) }}" 
                              method="POST" 
                              class="inline" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الغلاف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 p-2">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-10">
                <div class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="font-medium">لا توجد أغلفة صحف</span>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Desktop View (Original Table) -->
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 hidden sm:table">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">#</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">العنوان</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">اسم الصحيفة</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">صورة الغلاف</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">رابط العدد</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">تاريخ النشر</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">المشاهدات</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody id="tableBody" class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse($covers as $cover)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $cover->title }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $cover->newspaper_name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <img src="{{ url('storage/' . $cover->cover_image) }}" 
                             alt="{{ $cover->title }}" 
                             class="h-20 w-auto rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 dark:ring-1 dark:ring-gray-600">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        @if($cover->pdf_link)
                            <a href="{{ $cover->pdf_link }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">
                                <i class="fas fa-external-link-alt ml-1"></i>
                                عرض العدد
                            </a>
                        @else
                            <span class="text-gray-400 dark:text-gray-500">لا يوجد رابط</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $cover->publish_date->format('Y-m-d') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cover->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900' }}">
                            {{ $cover->status === 'active' ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $cover->views }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <a href="{{ route('admin.newspaper-covers.edit', $cover) }}" class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.newspaper-covers.destroy', $cover) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الغلاف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400 text-sm">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="font-medium">لا توجد أغلفة صحف</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $covers->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const searchLoading = document.getElementById('searchLoading');
    const tableBody = document.getElementById('tableBody');

    // Live search functionality
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchLoading.classList.remove('hidden');
            searchTimeout = setTimeout(() => performSearch(query), 300);
        } else if (query.length === 0) {
            window.location.href = '{{ route("admin.newspaper-covers.index") }}';
        }
    });

    async function performSearch(query) {
        try {
            const response = await fetch(`{{ route('admin.newspaper-covers.search') }}?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const data = await response.json();
            updateCoversDisplay(data.covers);
        } catch (error) {
            console.error('Error performing search:', error);
        } finally {
            searchLoading.classList.add('hidden');
        }
    }

    function updateCoversDisplay(covers) {
        if (!tableBody) return;
        
        tableBody.innerHTML = covers.length ? covers.map(cover => `
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${cover.id}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">${cover.title}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${cover.newspaper_name}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <img src="/storage/${cover.cover_image}" 
                         alt="${cover.title}" 
                         class="h-20 w-auto rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 dark:ring-1 dark:ring-gray-600">
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    ${cover.pdf_link ? `
                        <a href="${cover.pdf_link}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 hover:underline">
                            <i class="fas fa-external-link-alt ml-1"></i>
                            عرض العدد
                        </a>
                    ` : '<span class="text-gray-400 dark:text-gray-500">لا يوجد رابط</span>'}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${cover.publish_date}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${cover.status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-200 dark:text-green-900' : 'bg-red-100 text-red-800 dark:bg-red-200 dark:text-red-900'}">
                        ${cover.status === 'active' ? 'نشط' : 'غير نشط'}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${cover.views}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <div class="flex items-center space-x-3 space-x-reverse">
                        <a href="/admin/newspaper-covers/${cover.id}/edit" class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="/admin/newspaper-covers/${cover.id}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الغلاف؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        `).join('') : '<tr><td colspan="9" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">لا توجد نتائج</td></tr>';
    }
</script>
@endpush