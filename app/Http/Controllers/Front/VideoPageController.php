<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Section;
use Illuminate\Http\Request;

class VideoPageController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::query()->with('section')->latest();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('section')) {
            $query->where('section_id', $request->section);
        }

        $videos = $query->paginate(12);
        
        // إنشاء كائن Section وهمي للعنوان الرئيسي
        $section = (object)[
            'title' => 'مكتبة الفيديو'
        ];

        return view('front.pages.videos', compact('videos', 'section'));
    }

    public function show(Video $video)
    {
        $relatedVideos = Video::where('id', '!=', $video->id)
            ->when($video->section_id, function($query) use ($video) {
                return $query->where('section_id', $video->section_id);
            })
            ->latest()
            ->limit(6)
            ->get();

        return view('front.pages.video-details', compact('video', 'relatedVideos'));
    }
}
