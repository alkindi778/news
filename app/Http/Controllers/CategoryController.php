<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::with(['parent', 'children'])
            ->withCount('news');

        // إذا كان هناك بحث، نبحث في كل الأقسام
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        } else {
            // إذا لم يكن هناك بحث، نعرض الأقسام الرئيسية فقط
            $query->whereNull('parent_id');
        }

        $categories = $query->orderBy('order')->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'categories' => $categories
            ]);
        }

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();
            
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'order' => 'nullable|integer',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string'
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }

    public function sort()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('order')
            ->get();
            
        return view('admin.categories.sort', compact('categories'));
    }

    public function reorder(Request $request)
    {
        $items = $request->input('items');
        
        foreach ($items as $item) {
            Category::where('id', $item['id'])->update(['order' => $item['order']]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'تم حفظ الترتيب بنجاح'
        ]);
    }
}
