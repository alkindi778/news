<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewspaperCover;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageService;

class NewsController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        $categories = Category::all();
        $selectedCategories = old('category_id') ? [old('category_id')] : [];
        $news = new News(); // إنشاء كائن فارغ للاستخدام في النموذج
        return view('admin.news.create', compact('categories', 'selectedCategories', 'news'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'source' => 'required|string|max:50',
            'status' => 'required|in:published,draft,scheduled',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_caption' => 'nullable|string|max:255',
            'is_breaking' => 'nullable|boolean',
            'show_in_slider' => 'nullable|boolean'
        ]);

        // تنظيف المحتوى من أي كود ضار
        $validated['content'] = strip_tags($request->content, '<p><br><strong><em><ul><ol><li><a><blockquote><h1><h2><h3><h4><h5><h6><img><table><tr><td><th>');

        // Generate slug from title
        $validated['slug'] = Str::slug($request->title);
        
        // معالجة الصورة باستخدام ImageService
        if ($request->hasFile('image')) {
            $imagePath = $this->imageService->saveOriginalImage(
                $request->file('image'),
                'news'
            );
            
            if (!$imagePath) {
                return back()->with('error', 'فشل في رفع الصورة. يرجى المحاولة مرة أخرى.');
            }
            
            $validated['image'] = $imagePath;
        }

        // تعيين قيم الخيارات الإضافية
        $validated['is_breaking'] = $request->has('is_breaking');
        $validated['show_in_slider'] = $request->has('show_in_slider');

        // إنشاء الخبر مع البيانات المصادق عليها
        $news = News::create($validated);
        
        // ربط الخبر مع القسم
        $news->categories()->attach($request->category_id);
        
        return redirect()->route('admin.news.index')
            ->with('success', 'تم إضافة الخبر بنجاح');
    }

    public function edit(News $news)
    {
        $categories = Category::all();
        $selectedCategories = $news->categories->pluck('id')->toArray();
        return view('admin.news.edit', compact('news', 'categories', 'selectedCategories'));
    }

    public function update(Request $request, News $news)
    {
        // إذا كان التحديث فقط لحالة الخبر العاجل
        if ($request->has('is_breaking') && count($request->all()) <= 3) { // 3 للـ is_breaking و _token و _method
            $news->update(['is_breaking' => false]);
            // Clear the cache
            \Cache::forget('slider_news');
            return redirect()->back()->with('success', 'تم إيقاف الخبر العاجل بنجاح');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'raw_content' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'source' => 'required|string|max:50',
            'status' => 'required|in:published,draft,scheduled',
            'meta_title' => 'nullable|string|max:60',
            'meta_description' => 'nullable|string|max:160',
            'meta_keywords' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_caption' => 'nullable|string|max:255',
            'is_breaking' => 'nullable|boolean',
            'show_in_slider' => 'nullable|boolean'
        ]);

        // Generate slug from title if title has changed
        if ($news->title !== $request->title) {
            $validated['slug'] = Str::slug($request->title);
        }

        // Set boolean fields
        $validated['is_breaking'] = $request->has('is_breaking');
        $validated['show_in_slider'] = $request->has('show_in_slider');

        // Handle image upload if present
        if ($request->hasFile('image')) {
            // Delete old image
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            
            // Store and convert new image to webp
            $imagePath = $this->imageService->saveOriginalImage($request->file('image'), 'news');
            if (!$imagePath) {
                return back()->with('error', 'Failed to upload image. Please try again.');
            }
            $validated['image'] = $imagePath;
        }

        // Update news article
        $news->update($validated);

        // Sync categories
        if ($request->has('category_id')) {
            $news->categories()->sync($request->category_id);
        }

        return redirect()->route('admin.news.index')->with('success', 'تم تحديث الخبر بنجاح');
    }

    public function destroy(News $news)
    {
        try {
            // حذف الصورة من التخزين إذا كانت موجودة
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            // حذف الخبر من قاعدة البيانات
            $news->delete();

            return redirect()->route('admin.news.index')
                ->with('success', 'تم حذف الخبر والصورة المرتبطة به بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error deleting news: ' . $e->getMessage());
            return redirect()->route('admin.news.index')
                ->with('error', 'حدث خطأ أثناء حذف الخبر. يرجى المحاولة مرة أخرى.');
        }
    }

    public function uploadEditorImage(Request $request)
    {
        try {
            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if ($request->hasFile('upload')) {
                $image = $request->file('upload');
                $fileName = time() . '_' . $image->getClientOriginalName();
                
                // حفظ الصورة في المسار الصحيح
                $path = $image->storeAs('editor-images', $fileName, 'public');
                
                return response()->json([
                    'uploaded' => 1,
                    'fileName' => $fileName,
                    'url' => Storage::disk('public')->url($path)
                ]);
            }

            return response()->json([
                'uploaded' => 0,
                'error' => ['message' => 'لم يتم العثور على الصورة']
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Upload Error: ' . $e->getMessage());
            return response()->json([
                'uploaded' => 0,
                'error' => ['message' => 'حدث خطأ أثناء رفع الصورة: ' . $e->getMessage()]
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        
        $news = News::with('categories')
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%")
                  ->orWhere('subtitle', 'like', "%{$query}%");
            })
            ->latest()
            ->take(10)
            ->get();

        return response()->json([
            'news' => $news->map(function($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'subtitle' => $item->subtitle,
                    'image' => $item->image ? url('storage/' . $item->image) : null,
                    'status' => $item->status,
                    'views_count' => $item->views_count,
                    'published_at' => $item->published_at ? $item->published_at->format('Y-m-d H:i') : null,
                    'categories' => $item->categories->map(function($category) {
                        return [
                            'id' => $category->id,
                            'name' => $category->name
                        ];
                    }),
                    'featured' => $item->featured,
                    'breaking' => $item->breaking,
                    'edit_url' => route('admin.news.edit', $item),
                    'delete_url' => route('admin.news.destroy', $item)
                ];
            })
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
