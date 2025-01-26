<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sidebar;
use App\Models\Category;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SidebarController extends Controller
{
    public function index()
    {
        $sidebars = Sidebar::orderBy('order')->get();
        return view('admin.sidebars.index', compact('sidebars'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $advertisements = Advertisement::where('active', true)
            ->where('position', 'sidebar')
            ->orderBy('title')
            ->get();
        return view('admin.sidebars.create', compact('categories', 'advertisements'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:category,ads,popular,custom,opinions',
            'category_id' => 'nullable|exists:categories,id',
            'ad_id' => 'nullable|exists:advertisements,id',
            'posts_count' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'layout_type' => 'nullable|in:grid,list',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['active'] = $request->has('active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sidebars', 'public');
        }

        // Get max order
        $maxOrder = Sidebar::max('order') ?? 0;
        $data['order'] = $maxOrder + 1;

        Sidebar::create($data);

        return redirect()->route('admin.sidebars.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    public function edit(Sidebar $sidebar)
    {
        $categories = Category::orderBy('name')->get();
        $advertisements = Advertisement::where('active', true)
            ->where('position', 'sidebar')
            ->orderBy('title')
            ->get();
        return view('admin.sidebars.edit', compact('sidebar', 'categories', 'advertisements'));
    }

    public function update(Request $request, Sidebar $sidebar)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'type' => 'required|in:category,ads,popular,custom,opinions',
            'category_id' => 'nullable|exists:categories,id',
            'ad_id' => 'nullable|exists:advertisements,id',
            'posts_count' => 'nullable|integer|min:1',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url',
            'layout_type' => 'nullable|in:grid,list',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['active'] = $request->has('active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($sidebar->image) {
                Storage::disk('public')->delete($sidebar->image);
            }
            $data['image'] = $request->file('image')->store('sidebars', 'public');
        }

        $sidebar->update($data);

        return redirect()->route('admin.sidebars.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Sidebar $sidebar)
    {
        if ($sidebar->image) {
            Storage::disk('public')->delete($sidebar->image);
        }
        $sidebar->delete();

        return redirect()->route('admin.sidebars.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }

    public function updateOrder(Request $request)
    {
        $items = $request->get('items', []);
        foreach ($items as $index => $id) {
            Sidebar::where('id', $id)->update(['order' => $index + 1]);
        }
        return response()->json(['success' => true]);
    }

    public function toggleVisibility(Sidebar $sidebar)
    {
        $sidebar->active = !$sidebar->active;
        $sidebar->save();

        return response()->json([
            'success' => true,
            'is_visible' => $sidebar->active
        ]);
    }
}