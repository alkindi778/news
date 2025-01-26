<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_YouTube;

class VideoController extends Controller
{
    protected $youtube;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setDeveloperKey(config('services.youtube.api_key'));
        $this->youtube = new Google_Service_YouTube($client);
    }

    public function index()
    {
        $videos = Video::latest()->paginate(10);
        
        $videosData = collect($videos->items())->map(function($video) {
            return [
                'id' => $video->id,
                'title' => $video->title,
                'description' => $video->description,
                'status' => $video->status,
                'youtube_id' => $video->getYoutubeVideoId(),
                'thumbnail_url' => $video->getThumbnailUrl(),
                'video_url' => $video->getVideoUrl(),
                'views_count' => $video->views_count,
                'created_at' => $video->created_at,
                'edit_url' => route('admin.videos.edit', $video),
                'delete_url' => route('admin.videos.destroy', $video)
            ];
        });

        return view('admin.videos.index', [
            'videos' => $videos,
            'videosData' => $videosData,
            'template' => 'front.sections.templates.videos'
        ]);
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'status' => 'boolean'
        ]);

        $video = Video::create($validated);
        $video->generateThumbnail();

        return redirect()->route('admin.videos.index')
            ->with('success', 'تم إضافة الفيديو بنجاح');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'status' => 'boolean'
        ]);

        $video->update($validated);
        $video->generateThumbnail();

        return redirect()->route('admin.videos.index')
            ->with('success', 'تم تحديث الفيديو بنجاح');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')
            ->with('success', 'تم حذف الفيديو بنجاح');
    }

    /**
     * جلب معلومات الفيديو من YouTube API
     */
    public function getVideoInfo(Request $request)
    {
        $videoId = $this->extractVideoId($request->url);
        if (!$videoId) {
            return response()->json(['error' => 'رابط فيديو غير صالح'], 400);
        }

        try {
            $response = $this->youtube->videos->listVideos('snippet', ['id' => $videoId]);
            
            if (empty($response->items)) {
                return response()->json(['error' => 'لم يتم العثور على الفيديو'], 404);
            }

            $videoInfo = $response->items[0]->snippet;
            return response()->json([
                'title' => $videoInfo->title,
                'description' => $videoInfo->description
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'حدث خطأ أثناء جلب معلومات الفيديو: ' . $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            $videos = Video::when($query, function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(10);

            $videosData = collect($videos->items())->map(function($video) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'description' => $video->description,
                    'status' => $video->status,
                    'youtube_id' => $video->getYoutubeVideoId(),
                    'edit_url' => route('admin.videos.edit', $video),
                    'delete_url' => route('admin.videos.destroy', $video)
                ];
            });

            if ($request->wantsJson()) {
                return response()->json([
                    'data' => $videosData,
                    'current_page' => $videos->currentPage(),
                    'last_page' => $videos->lastPage(),
                    'per_page' => $videos->perPage(),
                    'total' => $videos->total()
                ]);
            }

            return view('admin.videos.index', [
                'videos' => $videos,
                'videosData' => $videosData
            ]);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'حدث خطأ أثناء البحث',
                    'message' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'حدث خطأ أثناء البحث');
        }
    }

    /**
     * استخراج معرف الفيديو من رابط YouTube
     */
    private function extractVideoId($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        return null;
    }
}
