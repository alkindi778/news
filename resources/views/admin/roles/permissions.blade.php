@extends('layouts.admin')

@section('title', 'إدارة الصلاحيات')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Messages -->
    @if(session('success'))
        <div id="success-message" class="mb-4 bg-green-100 border border-green-400 text-green-700 dark:bg-green-800 dark:border-green-700 dark:text-green-200 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div id="error-message" class="mb-4 bg-red-100 border border-red-400 text-red-700 dark:bg-red-800 dark:border-red-700 dark:text-red-200 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-800 dark:to-blue-900 px-6 py-4">
            <h3 class="text-xl font-bold text-white">قائمة الصلاحيات</h3>
        </div>
        <div class="p-6">
            <form id="permissions-form" action="{{ route('admin.roles.update-permissions', $role->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($permissions->groupBy(function($permission) {
                        return explode('_', $permission->name)[1] ?? 'other';
                    }) as $group => $groupPermissions)
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:shadow-md transition duration-300">
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 border-b border-gray-200 dark:border-gray-600 rounded-t-lg">
                                <h5 class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{ ucfirst($group) }}</h5>
                            </div>
                            <div class="p-4 space-y-3">
                                @foreach($groupPermissions as $permission)
                                    <label class="flex items-center space-x-3 space-x-reverse cursor-pointer group">
                                        <input type="checkbox" 
                                               name="permissions[]" 
                                               value="{{ $permission->id }}"
                                               class="permission-checkbox form-checkbox h-5 w-5 text-blue-600 dark:text-blue-500 rounded border-gray-300 dark:border-gray-600 focus:ring-blue-500 dark:focus:ring-blue-400 transition duration-150 ease-in-out dark:bg-gray-700"
                                               id="permission_{{ $permission->id }}"
                                               {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                        <span class="text-gray-700 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition duration-150">
                                            {{ str_replace('_', ' ', $permission->name) }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-8">
                    <button type="submit" id="submit-btn" class="bg-blue-600 dark:bg-blue-700 hover:bg-blue-700 dark:hover:bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5">
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('permissions-form');
    const submitBtn = document.getElementById('submit-btn');
    const successMessage = document.getElementById('success-message');
    const errorMessage = document.getElementById('error-message');
    
    // Hide messages after 5 seconds
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = 'none';
        }, 5000);
    }
    
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = 'none';
        }, 5000);
    }

    // Track original state of checkboxes
    const originalState = new Map();
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        originalState.set(checkbox.id, checkbox.checked);
    });

    form.addEventListener('submit', function(e) {
        // Disable submit button to prevent double submission
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'جاري الحفظ...';
        
        // Get all checked permissions
        const checkedPermissions = Array.from(this.querySelectorAll('input[name="permissions[]"]:checked'))
            .map(input => input.value);
        
        // Log changes
        console.log('Submitting permissions:', checkedPermissions);
        
        // Continue with form submission
        return true;
    });

    // Track changes in checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const hasChanges = Array.from(document.querySelectorAll('.permission-checkbox')).some(cb => 
                originalState.get(cb.id) !== cb.checked
            );
            
            submitBtn.classList.toggle('animate-pulse', hasChanges);
        });
    });
});
</script>
@endpush