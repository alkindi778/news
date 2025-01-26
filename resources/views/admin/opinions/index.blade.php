@extends('layouts.admin')

@section('content')
<div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-white min-h-screen">
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <!-- Header Section -->
        <div class="mb-6 bg-gray-50 dark:bg-gray-800 rounded-xl shadow-2xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700/50 backdrop-blur-sm">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4 space-x-reverse">
                    <div class="p-3 bg-blue-500/10 dark:bg-blue-500/5 rounded-lg">
                        <i class="fas fa-pen-fancy text-2xl sm:text-3xl text-blue-500 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">إدارة المقالات</h1>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">إدارة ونشر المقالات والآراء</p>
                    </div>
                </div>
                <a href="{{ route('admin.opinions.create') }}" 
                   class="w-full sm:w-auto relative inline-flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm rounded-lg transition-all duration-300 ease-out transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fas fa-plus ml-2 text-lg"></i>
                    <span class="font-bold">إضافة مقال جديد</span>
                </a>
            </div>
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
                               placeholder="ابحث في المقالات...">
                    </div>
                    <div id="searchLoading" class="absolute left-14 flex items-center hidden">
                        <div class="animate-spin rounded-full h-5 w-5 border-2 border-blue-500 border-t-transparent"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول المقالات -->
        <div class="bg-white dark:bg-gray-800/50 overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 dark:border-gray-700/50">
            <!-- Mobile View (Cards) -->
            <div class="block sm:hidden">
                @forelse($opinions as $opinion)
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700/50">
                        <div class="flex items-start space-x-4 space-x-reverse">
                            @if($opinion->image)
                                <img class="w-20 h-20 rounded-lg object-cover" 
                                     src="{{ url('storage/' . $opinion->image) }}" 
                                     alt="{{ $opinion->title }}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
                            @endif
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900 dark:text-white mb-2">{{ $opinion->title }}</div>
                                <div class="flex items-center mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    @if($opinion->author && $opinion->author->image)
                                        <img src="{{ url('storage/' . $opinion->author->image) }}" 
                                             alt="{{ $opinion->author->name }}" 
                                             class="w-6 h-6 rounded-full ml-2">
                                    @endif
                                    <span>{{ $opinion->author ? $opinion->author->name : 'غير محدد' }}</span>
                                </div>
                                <div class="flex items-center space-x-2 space-x-reverse">
                                    <a href="{{ route('admin.opinions.edit', $opinion) }}" 
                                       class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.opinions.destroy', $opinion) }}" 
                                          method="POST" 
                                          class="inline-block"
                                          onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                        لا توجد مقالات حالياً
                    </div>
                @endforelse
            </div>

            <!-- Desktop View (Table) -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">العنوان</th>
                            <th scope="col" class="px-4 py-3">الكاتب</th>
                            <th scope="col" class="px-4 py-3">الحالة</th>
                            <th scope="col" class="px-4 py-3">المشاهدات</th>
                            <th scope="col" class="px-4 py-3">تاريخ النشر</th>
                            <th scope="col" class="px-4 py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($opinions as $opinion)
                            <tr class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/25">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if($opinion->image)
                                            <img class="w-10 h-10 rounded-lg object-cover ml-3" 
                                                 src="{{ url('storage/' . $opinion->image) }}" 
                                                 alt="{{ $opinion->title }}"
                                                 onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
                                        @endif
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $opinion->title }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        @if($opinion->author && $opinion->author->image)
                                            <img src="{{ url('storage/' . $opinion->author->image) }}" 
                                                 alt="{{ $opinion->author->name }}" 
                                                 class="w-6 h-6 rounded-full ml-2">
                                        @endif
                                        <span>{{ $opinion->author ? $opinion->author->name : 'غير محدد' }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($opinion->status === 'published')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">منشور</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">مسودة</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ number_format($opinion->views_count) }}</td>
                                <td class="px-4 py-3">{{ $opinion->published_at ? $opinion->published_at->format('Y-m-d H:i') : '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <a href="{{ route('admin.opinions.edit', $opinion) }}" class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.opinions.destroy', $opinion) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    لا توجد مقالات حالياً
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $opinions->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const searchLoading = document.getElementById('searchLoading');
    const opinionsContainer = document.querySelector('.block.sm\\:hidden'); // Mobile container
    const opinionsTable = document.querySelector('tbody'); // Desktop container

    // Live search functionality
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();
        
        if (query.length >= 2) {
            searchLoading.classList.remove('hidden');
            searchTimeout = setTimeout(() => performSearch(query), 300);
        } else if (query.length === 0) {
            window.location.href = '{{ route("admin.opinions.index") }}';
        }
    });

    async function performSearch(query) {
        try {
            const response = await fetch(`{{ route('admin.opinions.search') }}?query=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            const data = await response.json();
            updateOpinionsDisplay(data.opinions);
        } catch (error) {
            console.error('Error performing search:', error);
        } finally {
            searchLoading.classList.add('hidden');
        }
    }

    function updateOpinionsDisplay(opinions) {
        // Update mobile view
        if (opinionsContainer) {
            opinionsContainer.innerHTML = opinions.length ? opinions.map(item => `
                <div class="p-4 border-b border-gray-200 dark:border-gray-700/50">
                    <div class="flex items-start space-x-4 space-x-reverse">
                        ${item.image ? `
                            <img class="w-20 h-20 rounded-lg object-cover" 
                                 src="${item.image}" 
                                 alt="${item.title}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
                        ` : ''}
                        <div class="flex-1">
                            <div class="font-semibold text-gray-900 dark:text-white mb-2">${item.title}</div>
                            <div class="flex items-center mb-2 text-sm text-gray-500 dark:text-gray-400">
                                ${item.author && item.author.image ? `
                                    <img src="${item.author.image}" 
                                         alt="${item.author.name}" 
                                         class="w-6 h-6 rounded-full ml-2">
                                ` : ''}
                                <span>${item.author ? item.author.name : 'غير محدد'}</span>
                            </div>
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <a href="${item.edit_url}" class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="${item.delete_url}" method="POST" class="inline-block" onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('') : '<div class="p-4 text-center text-gray-500 dark:text-gray-400">لا توجد نتائج</div>';
        }

        // Update desktop view
        if (opinionsTable) {
            opinionsTable.innerHTML = opinions.length ? opinions.map(item => `
                <tr class="border-b border-gray-200 dark:border-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700/25">
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            ${item.image ? `
                                <img class="w-10 h-10 rounded-lg object-cover ml-3" 
                                     src="${item.image}" 
                                     alt="${item.title}"
                                     onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
                            ` : ''}
                            <div class="font-semibold text-gray-900 dark:text-white">${item.title}</div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center">
                            ${item.author && item.author.image ? `
                                <img src="${item.author.image}" 
                                     alt="${item.author.name}" 
                                     class="w-6 h-6 rounded-full ml-2">
                            ` : ''}
                            <span>${item.author ? item.author.name : 'غير محدد'}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        ${item.status === 'published' 
                            ? '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">منشور</span>'
                            : '<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">مسودة</span>'}
                    </td>
                    <td class="px-4 py-3">${number_format(item.views_count)}</td>
                    <td class="px-4 py-3">${item.published_at || '-'}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <a href="${item.edit_url}" class="text-blue-500 dark:text-blue-400 hover:text-blue-600">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="${item.delete_url}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 dark:text-red-400 hover:text-red-600">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `).join('') : `
                <tr>
                    <td colspan="6" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                        لا توجد نتائج
                    </td>
                </tr>
            `;
        }
    }
</script>
@endpush