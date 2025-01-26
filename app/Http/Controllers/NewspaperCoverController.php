<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewspaperCover;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class NewspaperCoverController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the newspaper covers.
     */
    public function index()
    {
        $covers = NewspaperCover::latest()->paginate(10);
        return view('admin.newspaper-covers.index', compact('covers'));
    }

    /**
     * Show the form for creating a new newspaper cover.
     */
    public function create()
    {
        return view('admin.newspaper-covers.create');
    }

    /**
     * Store a newly created newspaper cover in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'newspaper_name' => 'required|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Increased max size to 10MB
            'pdf_link' => 'nullable|url|max:255',
            'publish_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            $imagePath = $this->imageService->saveOriginalImage(
                $request->file('cover_image'),
                'newspaper-covers'
            );
            $validated['cover_image'] = $imagePath;
        }

        NewspaperCover::create($validated);

        return redirect()->route('admin.newspaper-covers.index')
            ->with('success', 'تم إضافة غلاف الصحيفة بنجاح');
    }

    /**
     * Show the form for editing the specified newspaper cover.
     */
    public function edit(NewspaperCover $newspaperCover)
    {
        return view('admin.newspaper-covers.edit', compact('newspaperCover'));
    }

    /**
     * Update the specified newspaper cover in storage.
     */
    public function update(Request $request, NewspaperCover $newspaperCover)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'newspaper_name' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Increased max size to 10MB
            'pdf_link' => 'nullable|url|max:255',
            'publish_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if ($newspaperCover->cover_image) {
                Storage::disk('public')->delete($newspaperCover->cover_image);
            }
            
            $imagePath = $this->imageService->saveOriginalImage(
                $request->file('cover_image'),
                'newspaper-covers'
            );
            $validated['cover_image'] = $imagePath;
        }

        $newspaperCover->update($validated);

        return redirect()->route('admin.newspaper-covers.index')
            ->with('success', 'تم تحديث غلاف الصحيفة بنجاح');
    }

    /**
     * Remove the specified newspaper cover from storage.
     */
    public function destroy(NewspaperCover $newspaperCover)
    {
        try {
            // حذف الصورة من التخزين إذا كانت موجودة
            if ($newspaperCover->cover_image) {
                Storage::disk('public')->delete($newspaperCover->cover_image);
            }
            
            // حذف السجل من قاعدة البيانات
            $newspaperCover->delete();

            return redirect()->route('admin.newspaper-covers.index')
                ->with('success', 'تم حذف غلاف الصحيفة والصورة المرتبطة به بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error deleting newspaper cover: ' . $e->getMessage());
            return redirect()->route('admin.newspaper-covers.index')
                ->with('error', 'حدث خطأ أثناء حذف غلاف الصحيفة. يرجى المحاولة مرة أخرى.');
        }
    }
}
