@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">إدارة الشريط الجانبي</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">قم بإدارة وترتيب أقسام الشريط الجانبي</p>
            </div>
            <a href="{{ route('admin.sidebars.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors duration-150 ease-in-out">
                <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة قسم جديد
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/50 p-4 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="mr-3">
                        <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700/50">
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الترتيب
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                العنوان
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                النوع
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="sidebar-sections">
                        @foreach($sidebars as $sidebar)
                            <tr data-id="{{ $sidebar->id }}" class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="handle flex items-center cursor-move group-hover:text-gray-900 dark:group-hover:text-white transition-colors duration-150">
                                        <svg class="ml-2 h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 7a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 13a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-sm text-gray-900 dark:text-gray-300">{{ $sidebar->order }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $sidebar->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($sidebar->type)
                                        @case('category')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200">
                                                قسم أخبار
                                            </span>
                                            @break
                                        @case('popular')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/50 text-purple-800 dark:text-purple-200">
                                                الأكثر قراءة
                                            </span>
                                            @break
                                        @case('ads')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/50 text-yellow-800 dark:text-yellow-200">
                                                إعلان
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                                مخصص
                                            </span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick="toggleSectionVisibility({{ $sidebar->id }}, this)" 
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $sidebar->active ? 'bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200' }}">
                                        <span class="flex-shrink-0 h-1.5 w-1.5 rounded-full {{ $sidebar->active ? 'bg-green-400' : 'bg-red-400' }} ml-2"></span>
                                        {{ $sidebar->active ? 'ظاهر' : 'مخفي' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-reverse space-x-3">
                                    <a href="{{ route('admin.sidebars.edit', $sidebar) }}" 
                                       class="inline-flex items-center text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                        <svg class="ml-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        تعديل
                                    </a>
                                    <form action="{{ route('admin.sidebars.destroy', $sidebar) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300"
                                                onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                            <svg class="ml-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('sidebar-sections');
    if (!tbody) return;

    new Sortable(tbody, {
        animation: 150,
        handle: '.handle',
        draggable: 'tr',
        onEnd: function() {
            const rows = tbody.getElementsByTagName('tr');
            const items = Array.from(rows).map(row => row.dataset.id);
            
            // تحديث أرقام الترتيب المعروضة
            Array.from(rows).forEach((row, index) => {
                const orderSpan = row.querySelector('.handle span');
                if (orderSpan) {
                    orderSpan.textContent = index + 1;
                }
            });

            // إرسال الترتيب الجديد للخادم
            fetch('{{ route("admin.sidebars.updateOrder") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ items: items })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('حدث خطأ أثناء تحديث الترتيب');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ في الاتصال بالخادم');
            });
        }
    });
});

async function toggleSectionVisibility(id, button) {
    try {
        const response = await fetch(`{{ url('admin/sidebars') }}/${id}/toggle-visibility`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();
        
        if (data.success) {
            if (data.is_visible) {
                button.classList.remove('bg-red-100', 'dark:bg-red-900/50', 'text-red-800', 'dark:text-red-200');
                button.classList.add('bg-green-100', 'dark:bg-green-900/50', 'text-green-800', 'dark:text-green-200');
                button.textContent = 'ظاهر';
            } else {
                button.classList.remove('bg-green-100', 'dark:bg-green-900/50', 'text-green-800', 'dark:text-green-200');
                button.classList.add('bg-red-100', 'dark:bg-red-900/50', 'text-red-800', 'dark:text-red-200');
                button.textContent = 'مخفي';
            }
        } else {
            alert('حدث خطأ أثناء تحديث حالة القسم');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث حالة القسم');
    }
}
</script>
@endpush
@endsection
