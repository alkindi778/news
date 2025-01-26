<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default author if not exists
        $author = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );

        $categories = Category::all();

        $news = [
            [
                'title' => 'عدن: افتتاح معرض الكتاب السنوي بمشاركة دور نشر محلية وعربية',
                'content' => 'شهدت مدينة عدن افتتاح معرض الكتاب السنوي بمشاركة واسعة من دور النشر المحلية والعربية...',
                'image' => 'https://images.unsplash.com/photo-1526721940322-10fb6e3ae94a?w=800',
                'status' => 'published',
                'is_featured' => true,
                'is_breaking' => true,
                'created_at' => Carbon::now(),
                'categories' => ['ثقافة', 'محلي', 'كتب']
            ],
            [
                'title' => 'تدشين مشروع تطوير الواجهة البحرية في عدن',
                'content' => 'بدأت أعمال تطوير الواجهة البحرية في مدينة عدن ضمن خطة شاملة لتحسين البنية التحتية...',
                'image' => 'https://images.unsplash.com/photo-1565109000045-64190e824c9a?w=800',
                'status' => 'published',
                'is_featured' => true,
                'is_breaking' => true,
                'created_at' => Carbon::now()->subHours(2),
                'categories' => ['اقتصاد', 'محلي', 'بنية تحتية']
            ],
            [
                'title' => 'افتتاح أول مركز تكنولوجي متخصص في عدن',
                'content' => 'تم افتتاح أول مركز تكنولوجي متخصص في عدن لتدريب الشباب على أحدث التقنيات...',
                'image' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=800',
                'status' => 'published',
                'is_featured' => false,
                'is_breaking' => true,
                'created_at' => Carbon::now()->subHours(4),
                'categories' => ['تقنية', 'محلي', 'تعليم']
            ],
            [
                'title' => 'إطلاق مهرجان عدن السينمائي الدولي',
                'content' => 'تستعد مدينة عدن لاستضافة مهرجان عدن السينمائي الدولي بمشاركة عربية ودولية واسعة...',
                'image' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e26?w=800',
                'status' => 'published',
                'is_featured' => false,
                'is_breaking' => true,
                'created_at' => Carbon::now()->subHours(6),
                'categories' => ['فنون', 'محلي', 'سينما']
            ],
            [
                'title' => 'افتتاح مستشفى جديد في عدن بمواصفات عالمية',
                'content' => 'تم افتتاح مستشفى جديد في عدن مجهز بأحدث المعدات الطبية والتقنيات العلاجية...',
                'image' => 'https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?w=800',
                'status' => 'published',
                'is_featured' => true,
                'is_breaking' => true,
                'created_at' => Carbon::now()->subHours(8),
                'categories' => ['صحة', 'محلي', 'خدمات صحية']
            ],
        ];

        foreach ($news as $item) {
            $categoryNames = $item['categories'];
            unset($item['categories']);
            
            $newsItem = News::create(array_merge($item, [
                'author_id' => $author->id,
            ]));

            // Attach categories
            $categoryIds = $categories->whereIn('name', $categoryNames)->pluck('id');
            $newsItem->categories()->attach($categoryIds);
        }
    }
}