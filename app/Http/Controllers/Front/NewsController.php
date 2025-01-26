<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\Author;
use App\Models\Opinion;
use App\Models\NewspaperCover;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function index()
    {
        $page_title = 'آخر الأخبار';
        
        $news = News::with(['media', 'categories', 'author'])
            ->published()
            ->latest()
            ->paginate(12);

        return view('front.pages.news-index', compact('news', 'page_title'));
    }

    public function show($id)
    {
        $article = News::with(['media', 'categories', 'author', 'comments.user'])
            ->findOrFail($id);

        // للتحقق من البيانات
        \Log::info('Article data:', [
            'meta_keywords' => $article->meta_keywords,
            'all_data' => $article->toArray()
        ]);

        // زيادة عدد المشاهدات
        DB::table('news')->where('id', $id)->increment('views_count');

        $page_title = $article->title;

        // Get related articles
        $relatedArticles = News::with('media')
            ->whereHas('categories', function ($query) use ($article) {
                $query->whereIn('categories.id', $article->categories->pluck('id'));
            })
            ->where('id', '!=', $article->id)
            ->published()
            ->latest()
            ->take(3)
            ->get();

        // Get most read news
        $mostReadNews = News::with(['media', 'categories', 'author'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        return view('front.pages.news', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'mostReadNews' => $mostReadNews,
            'page_title' => $page_title
        ]);
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $page_title = $category->name;
        
        $posts = News::with(['media', 'categories', 'author'])
            ->whereHas('categories', function ($query) use ($id) {
                $query->where('categories.id', $id);
            })
            ->published()
            ->latest()
            ->paginate(12);

        // Get most read news
        $mostReadNews = News::with(['media', 'categories', 'author'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        return view('front.pages.category', [
            'category' => $category,
            'posts' => $posts,
            'mostReadNews' => $mostReadNews,
            'page_title' => $page_title
        ]);
    }

    public function author($id)
    {
        $author = \App\Models\Author::findOrFail($id);
        
        $articles = Opinion::where('author_id', $author->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get most read news
        $mostReadNews = News::with(['media', 'categories', 'author'])
            ->published()
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        return view('front.pages.author', [
            'author' => $author,
            'articles' => $articles,
            'mostReadNews' => $mostReadNews,
            'page_title' => 'مقالات الكاتب: ' . $author->name
        ]);
    }

    /**
     * عرض صفحة أرشيف الصحيفة
     */
    public function archive(Request $request)
    {
        $query = NewspaperCover::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $search = $request->search;
                    $query->where('title', 'like', "%{$search}%")
                          ->orWhere('newspaper_name', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('year'), function ($q) use ($request) {
                $q->whereYear('publish_date', $request->year);
            })
            ->latest('publish_date');

        $covers = $query->paginate(16)->withQueryString();
        
        // الحصول على قائمة السنوات المتاحة
        $years = NewspaperCover::selectRaw('YEAR(publish_date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('front.newspaper.archive', compact('covers', 'years'));
    }
}
