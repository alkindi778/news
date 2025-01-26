<?php

namespace Database\Seeders;

use App\Models\Visit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VisitsSeeder extends Seeder
{
    public function run()
    {
        $countries = ['السعودية', 'مصر', 'الإمارات', 'الكويت', 'عمان'];
        $cities = ['الرياض', 'القاهرة', 'دبي', 'الكويت', 'مسقط'];
        $browsers = ['Chrome', 'Firefox', 'Safari', 'Edge'];
        $platforms = ['Windows', 'Mac', 'Linux', 'iOS', 'Android'];
        $deviceTypes = ['desktop', 'mobile', 'tablet'];

        // إضافة زيارات للأيام السبعة الماضية
        for ($day = 6; $day >= 0; $day--) {
            $date = Carbon::now()->subDays($day);
            
            // إضافة عدة زيارات لكل يوم
            $visitsCount = rand(5, 15);
            for ($i = 0; $i < $visitsCount; $i++) {
                Visit::create([
                    'ip_address' => rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255) . '.' . rand(1, 255),
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/90.0.4430.212',
                    'country' => $countries[array_rand($countries)],
                    'city' => $cities[array_rand($cities)],
                    'page_url' => 'http://laravel.test/temp-laravel/public/news/' . rand(1, 10),
                    'referrer' => 'http://laravel.test/temp-laravel/public',
                    'device_type' => $deviceTypes[array_rand($deviceTypes)],
                    'browser' => $browsers[array_rand($browsers)],
                    'platform' => $platforms[array_rand($platforms)],
                    'visit_date' => $date->format('Y-m-d H:i:s'),
                    'created_at' => $date->format('Y-m-d H:i:s'),
                    'updated_at' => $date->format('Y-m-d H:i:s')
                ]);
            }
        }
    }
}
