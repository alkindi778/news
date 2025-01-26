<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ShareSettings
{
    public function handle(Request $request, Closure $next)
    {
        $settings = Setting::first();
        View::share('site_settings', $settings);
        
        return $next($request);
    }
}
