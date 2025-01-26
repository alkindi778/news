@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">إدارة الشريط الجانبي</h1>
            <a href="{{ route('admin.sidebar.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-plus ml-2"></i>إضافة قسم جديد
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الترتيب
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                العنوان
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                النوع
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الحالة
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="sidebar-sections">
                        @foreach($sections as $section)
                            <tr data-id="{{ $section->id }}" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="handle flex items-center cursor-move">
                                        <svg class="h-5 w-5 text-gray-400 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        <span>{{ $section->order_num }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $section->title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $section->getTypeText() }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button onclick="toggleSectionVisibility({{ $section->id }}, this)" 
                                            class="px-3 py-1 rounded-full text-sm font-semibold {{ $section->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $section->is_visible ? 'ظاهر' : 'مخفي' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left">
                                    <div class="flex items-center space-x-4 space-x-reverse">
                                        <a href="{{ route('admin.sidebar.edit', $section) }}" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteSection({{ $section->id }})" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
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
            fetch('{{ route("admin.sidebar.updateOrder") }}', {
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
                    alert(data.message || 'حدث خطأ أثناء تحديث الترتيب');
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
        const response = await fetch(`{{ url('admin/sidebar') }}/${id}/toggle-visibility`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();
        
        if (data.success) {
            if (data.is_visible) {
                button.classList.remove('bg-red-100', 'text-red-800');
                button.classList.add('bg-green-100', 'text-green-800');
                button.textContent = 'ظاهر';
            } else {
                button.classList.remove('bg-green-100', 'text-green-800');
                button.classList.add('bg-red-100', 'text-red-800');
                button.textContent = 'مخفي';
            }
        } else {
            alert(data.message || 'حدث خطأ أثناء تحديث حالة القسم');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث حالة القسم');
    }
}

async function deleteSection(id) {
    if (!confirm('هل أنت متأكد من حذف هذا القسم؟')) {
        return;
    }

    try {
        const response = await fetch(`{{ url('admin/sidebar') }}/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();
        
        if (data.success) {
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.remove();
            }
            alert('تم حذف القسم بنجاح');
        } else {
            alert(data.message || 'حدث خطأ أثناء حذف القسم');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('حدث خطأ في الاتصال بالخادم');
    }
}
</script>
@endpush
@endsection
