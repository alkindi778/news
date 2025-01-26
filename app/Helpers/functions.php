<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting($key, $default = null)
    {
        static $settings = null;

        if (is_null($settings)) {
            $settings = cache()->remember('settings', 60 * 24, function () {
                return Setting::first()?->toArray() ?? [];
            });
        }

        return $settings[$key] ?? $default;
    }
}
