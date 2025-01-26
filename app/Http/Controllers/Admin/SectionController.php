<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::orderBy('order')->paginate(10);
        $categories = Category::all();
        return view('admin.sections.index', compact('sections', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $templates = [
            'grid' => 'شبكة عادية',
            'featured' => 'مميز',
            'featured_with_list' => 'مميز مع قائمة',
            'fullwidth' => 'عرض كامل',
            'masonry' => 'شبكة متداخلة',
            'news_grid' => 'شبكة أخبار',
            'infographic' => 'انفوجرافيك',
            'videos' => 'فيديوهات'
        ];

        $types = [
            'latest' => 'آخر الأخبار',
            'popular' => 'الأكثر قراءة',
            'featured' => 'الأخبار المميزة',
            'custom' => 'محتوى مخصص',
            'videos' => 'قسم الفيديوهات'
        ];

        return view('admin.sections.create', compact('categories', 'templates', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'template' => 'required|string|in:grid,featured,featured_with_list,fullwidth,masonry,news_grid,infographic,videos',
            'style' => 'nullable|array',
            'style.background_color' => 'nullable|string',
            'style.title_color' => 'nullable|string',
            'style.border_color' => 'nullable|string',
            'content' => 'required_if:type,custom|nullable|string',
            'items_count' => 'required|integer|min:1|max:20',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'show_title' => 'boolean'
        ]);

        // معالجة نوع القسم
        if (str_starts_with($validated['type'], 'category_')) {
            $categoryId = (int) str_replace('category_', '', $validated['type']);
            $validated['type'] = 'category';
            $validated['category_id'] = $categoryId;
        }

        if ($request->type === 'videos') {
            $validated['template'] = 'videos';
        }

        Section::create($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function edit(Section $section)
    {
        $categories = Category::all();
        $templates = [
            'grid' => 'شبكة عادية',
            'featured' => 'مميز',
            'featured_with_list' => 'مميز مع قائمة',
            'fullwidth' => 'عرض كامل',
            'masonry' => 'شبكة متداخلة',
            'news_grid' => 'شبكة أخبار',
            'infographic' => 'انفوجرافيك',
            'videos' => 'فيديوهات'
        ];

        $types = [
            'latest' => 'آخر الأخبار',
            'popular' => 'الأكثر قراءة',
            'featured' => 'الأخبار المميزة',
            'custom' => 'محتوى مخصص',
            'videos' => 'قسم الفيديوهات'
        ];

        return view('admin.sections.edit', compact('section', 'categories', 'templates', 'types'));
    }

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'template' => 'required|string|in:grid,featured,featured_with_list,fullwidth,masonry,news_grid,infographic,videos',
            'style' => 'nullable|array',
            'style.background_color' => 'nullable|string',
            'style.title_color' => 'nullable|string',
            'style.border_color' => 'nullable|string',
            'content' => 'required_if:type,custom|nullable|string',
            'items_count' => 'required|integer|min:1|max:20',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
            'show_title' => 'boolean'
        ]);

        // معالجة نوع القسم
        if (str_starts_with($validated['type'], 'category_')) {
            $categoryId = (int) str_replace('category_', '', $validated['type']);
            $validated['type'] = 'category';
            $validated['category_id'] = $categoryId;
        } else {
            $validated['category_id'] = null;
        }

        if ($request->type === 'videos') {
            $validated['template'] = 'videos';
        }

        $section->update($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->route('admin.sections.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:sections,id'
        ]);

        if (Section::reorder($request->ids)) {
            return response()->json(['message' => 'تم إعادة الترتيب بنجاح']);
        }

        return response()->json(['message' => 'حدث خطأ أثناء إعادة الترتيب'], 500);
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'sections' => 'required|array',
            'sections.*' => 'required|integer|exists:sections,id'
        ]);

        foreach ($request->sections as $index => $sectionId) {
            Section::where('id', $sectionId)->update(['order' => $index + 1]);
        }

        return response()->json(['message' => 'تم تحديث ترتيب الأقسام بنجاح']);
    }
}
