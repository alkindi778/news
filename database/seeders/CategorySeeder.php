<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'سياسة',
                'slug' => 'politics',
                'description' => 'أخبار سياسية محلية وعالمية'
            ],
            [
                'name' => 'اقتصاد',
                'slug' => 'economy',
                'description' => 'أخبار اقتصادية ومالية'
            ],
            [
                'name' => 'رياضة',
                'slug' => 'sports',
                'description' => 'أخبار رياضية'
            ],
            [
                'name' => 'تكنولوجيا',
                'slug' => 'technology',
                'description' => 'أخبار التكنولوجيا والتقنية'
            ],
            [
                'name' => 'ثقافة',
                'slug' => 'culture',
                'description' => 'أخبار ثقافية وفنية'
            ],
            [
                'name' => 'صحة',
                'slug' => 'health',
                'description' => 'أخبار صحية وطبية'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
