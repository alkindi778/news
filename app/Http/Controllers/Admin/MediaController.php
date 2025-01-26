<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(12);
        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('admin.media.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file' => 'required|file|max:10240|mimes:jpeg,png,jpg,gif,mp4,webm,ogg',
                'category_id' => 'nullable|exists:categories,id'
            ]);

            $file = $request->file('file');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            
            // حفظ الملف
            $file->storeAs('public/media', $fileName);

            // إنشاء سجل في قاعدة البيانات
            Media::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_name' => $fileName,
                'type' => str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video',
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'category_id' => $request->category_id,
                'status' => 'active',
                'disk' => 'public'
            ]);

            return redirect()->route('admin.media.index')
                ->with('success', 'تم رفع الملف بنجاح');
        } catch (\Exception $e) {
            Log::error('Error uploading media:', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء رفع الملف')->withInput();
        }
    }

    public function edit(Media $medium)
    {
        $categories = \App\Models\Category::all();
        return view('admin.media.edit', compact('medium', 'categories'));
    }

    public function update(Request $request, Media $medium)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'category_id' => 'nullable|exists:categories,id'
            ]);

            $medium->update($validated);

            return redirect()->route('admin.media.index')
                ->with('success', 'تم تحديث الملف بنجاح');
        } catch (\Exception $e) {
            Log::error('Error updating media:', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء تحديث الملف')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $media = Media::findOrFail($id);
            
            // حذف الملف الفعلي
            $filePath = 'media/' . $media->file_name;
            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            
            // حذف السجل من قاعدة البيانات
            $media->delete();

            return redirect()->route('admin.media.index')
                ->with('success', 'تم حذف الملف بنجاح');
        } catch (\Exception $e) {
            Log::error('Error deleting media:', ['error' => $e->getMessage()]);
            return back()->with('error', 'حدث خطأ أثناء حذف الملف');
        }
    }
}
