<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class WriterController extends Controller
{
    public function index()
    {
        $writers = Author::latest()->paginate(10);
        return view('admin.writers.index', compact('writers'));
    }

    public function create()
    {
        return view('admin.writers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:authors,email|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255'
        ]);

        if ($request->hasFile('image')) {
            $imageService = new ImageService();
            $validated['image'] = $imageService->saveOriginalImage(
                $request->file('image'),
                'authors'
            );
        }

        // Map social media URLs to database column names
        $validated['facebook_url'] = $validated['facebook'] ?? null;
        $validated['twitter_url'] = $validated['twitter'] ?? null;
        $validated['instagram_url'] = $validated['instagram'] ?? null;
        $validated['linkedin_url'] = $validated['linkedin'] ?? null;

        // Remove the old keys
        unset($validated['facebook'], $validated['twitter'], $validated['instagram'], $validated['linkedin']);

        Author::create($validated);
        return redirect()->route('admin.writers.index')->with('success', 'تم إضافة الكاتب بنجاح');
    }

    public function edit(Author $writer)
    {
        return view('admin.writers.edit', compact('writer'));
    }

    public function update(Request $request, Author $writer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:authors,email,' . $writer->id . '|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($writer->image) {
                Storage::delete('public/' . $writer->image);
            }

            $imageService = new ImageService();
            $validated['image'] = $imageService->saveOriginalImage(
                $request->file('image'),
                'authors'
            );
        }

        // Map social media URLs to database column names
        $validated['facebook_url'] = $validated['facebook'] ?? null;
        $validated['twitter_url'] = $validated['twitter'] ?? null;
        $validated['instagram_url'] = $validated['instagram'] ?? null;
        $validated['linkedin_url'] = $validated['linkedin'] ?? null;

        // Remove the old keys
        unset($validated['facebook'], $validated['twitter'], $validated['instagram'], $validated['linkedin']);

        $writer->update($validated);
        return redirect()->route('admin.writers.index')->with('success', 'تم تحديث بيانات الكاتب بنجاح');
    }

    public function destroy(Author $writer)
    {
        if ($writer->image) {
            Storage::disk('public')->delete($writer->image);
        }
        $writer->delete();
        return redirect()->route('admin.writers.index')->with('success', 'تم حذف الكاتب بنجاح');
    }

    public function articles(Author $writer)
    {
        $articles = $writer->opinions()->latest()->paginate(10);
        return view('admin.writers.articles', [
            'writer' => $writer,
            'articles' => $articles,
            'title' => 'مقالات الكاتب: ' . $writer->name
        ]);
    }
}