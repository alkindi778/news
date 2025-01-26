@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 sm:text-4xl">
                        <i class="fas fa-sort mr-2"></i> ترتيب الأقسام
                    </h2>
                    <p class="mt-2 text-sm text-gray-400">
                        <span class="font-medium text-primary-200">قم بسحب وإفلات الأقسام لتغيير ترتيبها</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul id="sortable-categories" class="divide-y divide-gray-200">
                @foreach($categories as $category)
                    <li class="category-item" data-id="{{ $category->id }}">
                        <div class="px-4 py-4 flex items-center">
                            <div class="handle cursor-move mr-3">
                                <i class="fas fa-grip-vertical text-gray-400"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm font-medium text-indigo-600 truncate">
                                        {{ $category->name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var el = document.getElementById('sortable-categories');
            var sortable = new Sortable(el, {
                animation: 150,
                handle: '.handle',
                onEnd: function() {
                    var items = document.querySelectorAll('.category-item');
                    var order = Array.from(items).map(function(item, index) {
                        return {
                            id: item.dataset.id,
                            order: index + 1
                        };
                    });

                    fetch('/admin/categories/update-order', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>
    @endpush
@endsection
