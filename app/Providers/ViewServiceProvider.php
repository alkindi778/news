<?php

namespace App\Providers;

use App\Models\News;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Share data with frontend views
        View::composer('front.*', function ($view) {
            // Share site settings
            $site_settings = Setting::first();
            $view->with('site_settings', $site_settings);

            // Share categories with all views
            $categories = Category::with('subcategories')
                ->whereNull('parent_id')
                ->orderBy('order')
                ->get();
            $view->with('categories', $categories);

            // Share latest news with all views
            $latestNews = News::with('media')
                ->published()
                ->latest()
                ->take(5)
                ->get(['id', 'title', 'slug', 'created_at', 'is_breaking', 'image']);
            $view->with('latestNews', $latestNews);
        });

        // Share data with admin views
        View::composer(['admin.*', 'layouts.admin'], function ($view) {
            // قائمة عناصر القائمة الجانبية
            $menuItems = [
                [
                    'title' => 'لوحة التحكم',
                    'route' => 'admin.dashboard',
                    'icon' => 'fas fa-home'
                ],
                [
                    'title' => 'الأخبار',
                    'route' => 'admin.news.index',
                    'icon' => 'fas fa-newspaper'
                ],
                [
                    'title' => 'الكتاب',
                    'route' => 'admin.writers.index',
                    'icon' => 'fas fa-users'
                ],
                [
                    'title' => 'الأقسام',
                    'route' => 'admin.categories.index',
                    'icon' => 'fas fa-th-list'
                ],
                [
                    'title' => 'المستخدمين',
                    'route' => 'admin.users.index',
                    'icon' => 'fas fa-user-shield'
                ],
                [
                    'title' => 'الإعدادات',
                    'route' => 'admin.settings.index',
                    'icon' => 'fas fa-cog'
                ]
            ];
            
            $view->with('menuItems', $menuItems);
            $view->with('site_settings', Setting::first());
        });
    }
}
