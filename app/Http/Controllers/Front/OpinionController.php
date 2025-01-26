<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Opinion;
use App\Models\News;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    public function index()
    {
        $opinions = Opinion::with('author')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Get most read news
        $mostReadNews = News::with(['media', 'categories', 'author'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        return view('front.opinions.index', [
            'opinions' => $opinions,
            'mostReadNews' => $mostReadNews,
            'page_title' => 'مقالات الرأي'
        ]);
    }

    public function show($id)
    {
        $opinion = Opinion::with('author')
            ->where('status', 'published')
            ->findOrFail($id);

        // Increment views
        $opinion->increment('views_count');

        // Get most read news
        $mostReadNews = News::with(['media', 'categories', 'author'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        return view('front.opinions.show', [
            'opinion' => $opinion,
            'mostReadNews' => $mostReadNews,
            'page_title' => $opinion->title
        ]);
    }
}
