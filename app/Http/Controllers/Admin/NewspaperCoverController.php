<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewspaperCover;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewspaperCoverController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $covers = NewspaperCover::latest('publish_date')->paginate(10);
        return view('admin.newspaper-covers.index', compact('covers'));
    }

    public function create()
    {
        return view('admin.newspaper-covers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'newspaper_name' => 'required|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_link' => 'required|string|max:255',
            'publish_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $this->imageService->saveOriginalImage(
                $request->file('cover_image'),
                'newspaper-covers'
            );
            $validated['cover_image'] = $path;
        }

        NewspaperCover::create($validated);

        return redirect()->route('admin.newspaper-covers.index')
            ->with('success', 'تم إضافة غلاف الصحيفة بنجاح');
    }

    public function edit(NewspaperCover $newspaperCover)
    {
        return view('admin.newspaper-covers.edit', compact('newspaperCover'));
    }

    public function update(Request $request, NewspaperCover $newspaperCover)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'newspaper_name' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_link' => 'required|string|max:255',
            'publish_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($newspaperCover->cover_image) {
                Storage::disk('public')->delete($newspaperCover->cover_image);
            }

            // Save new image
            $path = $this->imageService->saveOriginalImage(
                $request->file('cover_image'),
                'newspaper-covers'
            );
            $validated['cover_image'] = $path;
        }

        $newspaperCover->update($validated);

        return redirect()->route('admin.newspaper-covers.index')
            ->with('success', 'تم تحديث غلاف الصحيفة بنجاح');
    }

    public function destroy(NewspaperCover $newspaperCover)
    {
        if ($newspaperCover->cover_image) {
            Storage::disk('public')->delete($newspaperCover->cover_image);
        }

        $newspaperCover->delete();

        return redirect()->route('admin.newspaper-covers.index')
            ->with('success', 'تم حذف غلاف الصحيفة بنجاح');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        $covers = NewspaperCover::where('title', 'like', "%{$query}%")
            ->orWhere('newspaper_name', 'like', "%{$query}%")
            ->latest()
            ->get()
            ->map(function ($cover) {
                return [
                    'id' => $cover->id,
                    'title' => $cover->title,
                    'newspaper_name' => $cover->newspaper_name,
                    'cover_image' => $cover->cover_image,
                    'pdf_link' => $cover->pdf_link,
                    'publish_date' => $cover->publish_date->format('Y-m-d'),
                    'status' => $cover->status,
                    'views' => $cover->views
                ];
            });
            
        return response()->json(['covers' => $covers]);
    }
}
