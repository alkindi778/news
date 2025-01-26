<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        // Share categories with all views
        $categories = \App\Models\Category::orderBy('name')->get();
        view()->share('categories', $categories);

        // Share latest news with all views
        $latestNews = News::published()
            ->latest()
            ->take(5)
            ->get(['id', 'title', 'slug']);
        view()->share('latestNews', $latestNews);
    }

    public function index(Request $request)
    {
        $query = $request->get('q');
        
        $news = News::with(['media', 'categories', 'author'])
            ->published()
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('meta_title', 'like', "%{$query}%")
                  ->orWhere('meta_description', 'like', "%{$query}%")
                  ->orWhereHas('categories', function($q) use ($query) {
                      $q->where('name', 'like', "%{$query}%");
                  });
            })
            ->latest()
            ->paginate(12);

        return view('front.pages.search', [
            'news' => $news,
            'query' => $query
        ]);
    }
}
