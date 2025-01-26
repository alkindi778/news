@extends('layouts.admin')

@section('title', 'تعديل صلاحيات الدور: ' . $role->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-8">
        تعديل صلاحيات الدور: {{ $role->name }}
    </h2>

    <form action="{{ route('admin.roles.update-permissions', $role) }}" method="POST" x-data="permissionsForm()">
        @csrf
        @method('PUT')

        <div class="space-y-8">
            @foreach($permissions->groupBy('group') as $group => $groupPermissions)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden" x-ref="{{ Str::slug($group) }}">
                <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        {{ $group }}
                    </h4>
                    <button type="button" @click="selectAll('{{ Str::slug($group) }}')" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition duration-150 ease-in-out">
                        تحديد الكل
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($groupPermissions as $permission)
                    <label class="flex items-center space-x-3 space-x-reverse">
                        <input type="checkbox" 
                               name="permissions[]" 
                               value="{{ $permission->id }}"
                               class="form-checkbox h-5 w-5 text-red-600 transition duration-150 ease-in-out"
                               @checked($role->hasPermissionTo($permission->name))>
                        <span class="text-gray-700 dark:text-gray-300">{{ $permission->display_name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-10 flex justify-end space-x-4 space-x-reverse">
            <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                حفظ التغييرات
            </button>
            <a href="{{ route('admin.roles.index') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition duration-150 ease-in-out">
                إلغاء
            </a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('permissionsForm', () => ({
        selectAll(group) {
            const checkboxes = this.$refs[group].querySelectorAll('input[type="checkbox"]');
            const anyUnchecked = Array.from(checkboxes).some(checkbox => !checkbox.checked);
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = anyUnchecked;
            });
        }
    }));
});
</script>
@endpush
