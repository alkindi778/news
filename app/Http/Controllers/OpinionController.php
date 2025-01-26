<?php

namespace App\Http\Controllers;

use App\Models\Opinion;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    public function index()
    {
        $opinions = Opinion::latest()->paginate(10);
        return view('admin.opinions.index', compact('opinions'));
    }

    public function create()
    {
        $authors = \App\Models\Author::all();
        return view('admin.opinions.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:draft,published'
        ]);

        Opinion::create($validated);
        return redirect()->route('admin.opinions.index')->with('success', 'تم إضافة المقال بنجاح');
    }

    public function edit(Opinion $opinion)
    {
        $authors = \App\Models\Author::all();
        return view('admin.opinions.edit', compact('opinion', 'authors'));
    }

    public function update(Request $request, Opinion $opinion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'status' => 'required|in:draft,published'
        ]);

        $opinion->update($validated);
        return redirect()->route('admin.opinions.index')->with('success', 'تم تحديث المقال بنجاح');
    }

    public function destroy(Opinion $opinion)
    {
        $opinion->delete();
        return redirect()->route('admin.opinions.index')->with('success', 'تم حذف المقال بنجاح');
    }

    public function fetch(Request $request)
    {
        $query = Opinion::with('author')->latest();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', "%{$searchTerm}%");
        }

        $opinions = $query->paginate(10);

        return response()->json([
            'opinions' => $opinions->items(),
            'pagination' => [
                'total' => $opinions->total(),
                'per_page' => $opinions->perPage(),
                'current_page' => $opinions->currentPage(),
                'last_page' => $opinions->lastPage(),
            ]
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $opinions = Opinion::with('author')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhereHas('author', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'opinions' => $opinions->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'image' => $item->image ? url('storage/' . $item->image) : null,
                    'author' => $item->author ? [
                        'name' => $item->author->name,
                        'image' => $item->author->image ? url('storage/' . $item->author->image) : null
                    ] : null,
                    'status' => $item->status,
                    'views_count' => $item->views_count,
                    'published_at' => $item->published_at ? $item->published_at->format('Y-m-d H:i') : null,
                    'edit_url' => route('admin.opinions.edit', $item),
                    'delete_url' => route('admin.opinions.destroy', $item)
                ];
            })
        ]);
    }
}