<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\News;
use App\Models\NewspaperCover;
use App\Models\Section; 
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get slider news without caching
        $sliderNews = News::with(['media', 'categories', 'author'])
            ->where('show_in_slider', true)
            ->where('status', 'published')
            ->latest()
            ->take(10)
            ->get();

        \Log::info('Slider News Count: ' . $sliderNews->count(), ['data' => $sliderNews->toArray()]);
        \Log::info('Slider News: ', ['data' => $sliderNews->toArray()]);

        // Get most read news
        $mostReadNews = News::with(['media', 'categories', 'author'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        \Log::info('Most Read News Count: ' . $mostReadNews->count(), ['data' => $mostReadNews->toArray()]);
        \Log::info('Most Read News: ', ['data' => $mostReadNews->toArray()]);

        // Get featured news
        $featuredNews = News::with(['media', 'categories', 'author'])
            ->published()
            ->featured()
            ->latest()
            ->take(5)
            ->get();

        \Log::info('Featured News Count: ' . $featuredNews->count(), ['data' => $featuredNews->toArray()]);
        \Log::info('Featured News: ', ['data' => $featuredNews->toArray()]);

        // Get news by categories
        $categories = Category::withCount('news')
            ->has('news')
            ->take(6)
            ->get();

        \Log::info('Categories Count: ' . $categories->count(), ['data' => $categories->toArray()]);
        \Log::info('Categories: ', ['data' => $categories->toArray()]);

        $newsByCategory = [];
        foreach ($categories as $category) {
            $newsByCategory[$category->id] = News::with(['media', 'categories', 'author'])
                ->inCategory($category->id)
                ->published()
                ->latest()
                ->take(4)
                ->get();

            \Log::info('News By Category ' . $category->id . ' Count: ' . $newsByCategory[$category->id]->count(), ['data' => $newsByCategory[$category->id]->toArray()]);
            \Log::info('News By Category ' . $category->id . ': ', ['data' => $newsByCategory[$category->id]->toArray()]);
        }

        // Get most viewed news
        $mostViewed = News::published()
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        \Log::info('Most Viewed News Count: ' . $mostViewed->count(), ['data' => $mostViewed->toArray()]);
        \Log::info('Most Viewed News: ', ['data' => $mostViewed->toArray()]);

        // Get latest newspaper cover
        $latestCover = NewspaperCover::latest()
            ->first();

        \Log::info('Latest Newspaper Cover: ', ['data' => $latestCover ? $latestCover->toArray() : null]);

        // Get active sections
        $sections = Section::where('is_active', true)
            ->orderBy('order')
            ->get();

        \Log::info('Active Sections Count: ' . $sections->count(), ['data' => $sections->toArray()]);
        \Log::info('Active Sections: ', ['data' => $sections->toArray()]);

        return view('front.pages.home', compact(
            'sliderNews',
            'mostReadNews',
            'featuredNews',
            'categories',
            'newsByCategory',
            'latestCover',
            'mostViewed',
            'sections'
        ));
    }
}
