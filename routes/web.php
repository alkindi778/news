<?php

use Illuminate\Support\Facades\Route;
use Spatie\Feed\Http\FeedController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OpinionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WriterController;
use App\Http\Controllers\WriterArticleController;
use App\Http\Controllers\NewspaperCoverController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\SidebarController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoleController;

// مسارات المصادقة
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin Routes
Route::middleware(['auth', 'web'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // الرئيسية
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Roles & Permissions
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->middleware('permission:view_roles')->name('index');
        Route::get('/create', [RoleController::class, 'create'])->middleware('permission:create_roles')->name('create');
        Route::post('/', [RoleController::class, 'store'])->middleware('permission:create_roles')->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:edit_roles')->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->middleware('permission:edit_roles')->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('permission:delete_roles')->name('destroy');
        Route::get('/{role}/permissions', [RoleController::class, 'editPermissions'])->middleware('permission:edit_roles')->name('edit-permissions');
        Route::put('/{role}/permissions', [RoleController::class, 'updatePermissions'])->middleware('permission:edit_roles')->name('update-permissions');
        Route::get('/permissions', [RoleController::class, 'permissions'])->middleware('permission:view_permissions')->name('permissions');
    });
    Route::resource('roles', RoleController::class);
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.update-permissions');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/info', [ProfileController::class, 'updateInfo'])->name('profile.update-info');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.update-preferences');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.update-avatar');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    Route::get('categories/sort', [CategoryController::class, 'sort'])->name('categories.sort');
    Route::post('categories/update-order', [CategoryController::class, 'updateOrder'])->name('categories.update-order');
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    
    // News
    Route::get('news/search', [NewsController::class, 'search'])->name('news.search');
    Route::resource('news', NewsController::class);
    Route::post('/news/upload-image', [NewsController::class, 'uploadImage'])->name('news.upload-image');
    Route::post('/news/upload-file', [NewsController::class, 'uploadFile'])->name('news.upload-file');
    Route::post('upload-editor-image', [NewsController::class, 'uploadEditorImage'])->name('upload.editor.image');
    
    // Breaking News
    Route::resource('breaking-news', \App\Http\Controllers\Admin\BreakingNewsController::class);
    
    // Comments
    Route::resource('comments', \App\Http\Controllers\Admin\CommentController::class);
    
    // Newspaper Covers
    Route::resource('newspaper-covers', NewspaperCoverController::class);
    Route::get('newspaper-covers/search', [NewspaperCoverController::class, 'search'])->name('newspaper-covers.search');
    
    // Users
    Route::controller(\App\Http\Controllers\Admin\UserController::class)
        ->prefix('users')
        ->name('users.')
        ->group(function () {
            Route::get('/', 'index')->middleware('permission:view_users')->name('index');
            Route::get('/create', 'create')->middleware('permission:create_users')->name('create');
            Route::post('/', 'store')->middleware('permission:create_users')->name('store');
            Route::get('/{user}/edit', 'edit')->middleware('permission:edit_users')->name('edit');
            Route::put('/{user}', 'update')->middleware('permission:edit_users')->name('update');
            Route::delete('/{user}', 'destroy')->middleware('permission:delete_users')->name('destroy');
        });
    
    // Statistics
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics');
    Route::get('statistics/refresh', [StatisticsController::class, 'refresh'])->name('statistics.refresh');
    
    // Pages
    Route::get('/pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::get('/pages/{page}', [PageController::class, 'show'])->name('pages.show');
    
    // Opinions/Articles
    Route::get('opinions/search', [OpinionController::class, 'search'])->name('opinions.search');
    Route::resource('opinions', OpinionController::class);
    
    // Writers
    Route::resource('writers', WriterController::class);
    Route::resource('writers.articles', WriterArticleController::class);

    // Videos
    Route::get('videos/search', [VideoController::class, 'search'])->name('videos.search');
    Route::resource('videos', VideoController::class);
    Route::post('/videos/get-info', [App\Http\Controllers\Admin\VideoController::class, 'getVideoInfo'])
        ->name('videos.get-info');

    // Tasks
    Route::post('/tasks/{task}/complete', [AdminDashboardController::class, 'completeTask'])->name('tasks.complete');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingsController::class, 'update'])->name('settings.update');

    // Sections
    Route::resource('sections', SectionController::class);
    Route::post('sections/reorder', [SectionController::class, 'reorder'])->name('sections.reorder');
    Route::post('sections/update-order', [SectionController::class, 'updateOrder'])->name('sections.update-order');

    // Media
    Route::resource('media', MediaController::class);

    // Sidebar Routes
    Route::resource('sidebars', SidebarController::class);
    Route::post('sidebars/update-order', [SidebarController::class, 'updateOrder'])->name('sidebars.updateOrder');

    // Advertisements
    Route::resource('advertisements', AdvertisementController::class);
    Route::post('advertisements/store', [AdvertisementController::class, 'store'])->name('advertisements.store');
    Route::get('advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');
});

// Front Routes
Route::name('front.')->group(function () {
    // الصفحة الرئيسية
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // المقالات
    Route::get('/opinion', [App\Http\Controllers\Front\OpinionController::class, 'index'])->name('opinion.index');
    Route::get('/opinion/{id}', [App\Http\Controllers\Front\OpinionController::class, 'show'])->name('opinion.show');
    
    // RSS Feed
    Route::feeds();
    
    // الأخبار
    Route::get('/news', [App\Http\Controllers\Front\NewsController::class, 'index'])->name('news.index');
    Route::get('/news/{slug}', [App\Http\Controllers\Front\NewsController::class, 'show'])->name('news.show');
    
    // التصنيفات
    Route::get('/category/{category:slug}', [App\Http\Controllers\Front\CategoryController::class, 'show'])->name('category');
    
    // News & Categories
    Route::get('/news/{id}', [\App\Http\Controllers\Front\NewsController::class, 'show'])->name('news');
    Route::get('/cat/{id}', [\App\Http\Controllers\Front\NewsController::class, 'category'])->name('category');
    Route::get('/author/{id}', [\App\Http\Controllers\Front\NewsController::class, 'author'])->name('author');

    // Opinions
    Route::get('/opinions', [\App\Http\Controllers\Front\OpinionController::class, 'index'])->name('opinions');
    Route::get('/opinion/{id}', [\App\Http\Controllers\Front\OpinionController::class, 'show'])->name('opinion.show');

    // Search
    Route::get('/search', [\App\Http\Controllers\Front\SearchController::class, 'index'])->name('search');

    // الفيديوهات
    Route::get('/videos', [\App\Http\Controllers\Front\VideoPageController::class, 'index'])->name('videos.index');
    Route::get('/videos/{video}', [\App\Http\Controllers\Front\VideoPageController::class, 'show'])->name('videos.show');

    // الصفحات الثابتة
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
    Route::get('/editorial-board', [PageController::class, 'editorialBoard'])->name('editorial-board');
    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/newspaper/archive', [NewsController::class, 'archive'])->name('newspaper.archive');
});