<?php

namespace App\Providers;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure error handling
        error_reporting(E_ALL);
        \Config::set('app.debug', true);
        
        // Configure Carbon for Arabic
        Carbon::setLocale('ar');
        
        // Share site settings and current date with all views
        View::share([
            'site_settings' => Schema::hasTable('settings') ? Setting::first() : null,
            'current_date' => Carbon::now()->translatedFormat('l j F Y')
        ]);
    }
}
