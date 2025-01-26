@csrf

<div class="row">
    <div class="col-md-8">
        <!-- Title -->
        <div class="form-group">
            <label for="title">عنوان القسم</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                value="{{ old('title', $section->title ?? '') }}" required>
            @error('title')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description">وصف القسم</label>
            <textarea name="description" id="description" rows="3" 
                class="form-control @error('description') is-invalid @enderror">{{ old('description', $section->description ?? '') }}</textarea>
            @error('description')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Type -->
        <div class="form-group">
            <label for="type">نوع القسم</label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                <option value="">اختر نوع القسم</option>
                <option value="category" {{ old('type', $section->type ?? '') == 'category' ? 'selected' : '' }}>تصنيف محدد</option>
                <option value="popular" {{ old('type', $section->type ?? '') == 'popular' ? 'selected' : '' }}>الأكثر قراءة</option>
                <option value="latest" {{ old('type', $section->type ?? '') == 'latest' ? 'selected' : '' }}>آخر الأخبار</option>
                <option value="featured" {{ old('type', $section->type ?? '') == 'featured' ? 'selected' : '' }}>أخبار مميزة</option>
                <option value="custom" {{ old('type', $section->type ?? '') == 'custom' ? 'selected' : '' }}>محتوى مخصص</option>
            </select>
            @error('type')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Category (shown only when type is 'category') -->
        <div class="form-group" id="categoryGroup" style="display: none;">
            <label for="category_id">التصنيف</label>
            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                <option value="">اختر التصنيف</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" 
                        {{ old('category_id', $section->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Custom Content (shown only when type is 'custom') -->
        <div class="form-group" id="contentGroup" style="display: none;">
            <label for="content">المحتوى المخصص</label>
            <textarea name="content" id="content" rows="5" 
                class="form-control @error('content') is-invalid @enderror">{{ old('content', $section->content ?? '') }}</textarea>
            @error('content')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <!-- Items Count -->
        <div class="form-group">
            <label for="items_count">عدد العناصر</label>
            <input type="number" name="items_count" id="items_count" 
                class="form-control @error('items_count') is-invalid @enderror"
                value="{{ old('items_count', $section->items_count ?? 6) }}" min="1" max="20">
            @error('items_count')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Order -->
        <div class="form-group">
            <label for="order">الترتيب</label>
            <input type="number" name="order" id="order" 
                class="form-control @error('order') is-invalid @enderror"
                value="{{ old('order', $section->order ?? 0) }}" min="0">
            @error('order')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Status -->
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                    {{ old('is_active', $section->is_active ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="is_active">تفعيل القسم</label>
            </div>
        </div>

        <!-- Show Title -->
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="show_title" name="show_title" value="1"
                    {{ old('show_title', $section->show_title ?? true) ? 'checked' : '' }}>
                <label class="custom-control-label" for="show_title">إظهار العنوان</label>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const categoryGroup = document.getElementById('categoryGroup');
    const contentGroup = document.getElementById('contentGroup');

    function toggleFields() {
        const selectedType = typeSelect.value;
        
        // Toggle category field
        categoryGroup.style.display = selectedType === 'category' ? 'block' : 'none';
        
        // Toggle content field
        contentGroup.style.display = selectedType === 'custom' ? 'block' : 'none';
    }

    // Initial toggle
    toggleFields();

    // Listen for changes
    typeSelect.addEventListener('change', toggleFields);
});
</script>
@endpush
