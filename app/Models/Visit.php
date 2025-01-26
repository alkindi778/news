<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Visit extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'country',
        'city',
        'page_url',
        'referrer',
        'device_type',
        'browser',
        'platform',
        'visit_date'
    ];

    protected $casts = [
        'visit_date' => 'datetime'
    ];

    /**
     * تسجيل زيارة جديدة
     */
    public static function recordVisit(array $data): self
    {
        return static::create([
            'ip_address' => $data['ip_address'] ?? request()->ip(),
            'user_agent' => $data['user_agent'] ?? request()->userAgent(),
            'country' => $data['country'] ?? null,
            'city' => $data['city'] ?? null,
            'page_url' => $data['page_url'] ?? request()->fullUrl(),
            'referrer' => $data['referrer'] ?? request()->header('referer'),
            'device_type' => $data['device_type'] ?? static::detectDeviceType(),
            'browser' => $data['browser'] ?? static::detectBrowser(),
            'platform' => $data['platform'] ?? static::detectPlatform(),
            'visit_date' => now()
        ]);
    }

    /**
     * الحصول على إحصائيات الزيارات
     */
    public static function getStatistics(): array
    {
        return [
            'total_visits' => static::count(),
            'unique_visitors' => static::distinct('ip_address')->count(),
            'countries_count' => static::distinct('country')->count(),
            'active_days' => static::distinct(DB::raw('DATE(visit_date)'))->count(),
            'today_visits' => static::whereDate('visit_date', today())->count(),
            'monthly_visits' => static::whereMonth('visit_date', now()->month)->count(),
            'yearly_visits' => static::whereYear('visit_date', now()->year)->count()
        ];
    }

    /**
     * الحصول على الدول الأكثر زيارة
     */
    public static function getTopCountries(int $limit = 5): array
    {
        return static::select('country', DB::raw('COUNT(*) as visits'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderByDesc('visits')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * الحصول على إحصائيات الزيارات اليومية
     */
    public static function getDailyVisits(int $days = 7): array
    {
        return static::select(
                DB::raw('DATE(visit_date) as date'),
                DB::raw('COUNT(*) as visits')
            )
            ->where('visit_date', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();
    }

    /**
     * الحصول على إحصائيات الأجهزة
     */
    public static function getDeviceStatistics(): array
    {
        return static::select('device_type', DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type')
            ->toArray();
    }

    /**
     * الحصول على إحصائيات المتصفحات
     */
    public static function getBrowserStatistics(): array
    {
        return static::select('browser', DB::raw('COUNT(*) as count'))
            ->groupBy('browser')
            ->get()
            ->pluck('count', 'browser')
            ->toArray();
    }

    /**
     * اكتشاف نوع الجهاز
     */
    protected static function detectDeviceType(): string
    {
        $agent = request()->userAgent();
        
        if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', $agent)) {
            return 'tablet';
        }
        
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', $agent)) {
            return 'mobile';
        }
        
        return 'desktop';
    }

    /**
     * اكتشاف المتصفح
     */
    protected static function detectBrowser(): string
    {
        $agent = request()->userAgent();
        
        if (preg_match('/MSIE/i', $agent)) {
            return 'Internet Explorer';
        }
        if (preg_match('/Firefox/i', $agent)) {
            return 'Firefox';
        }
        if (preg_match('/Chrome/i', $agent)) {
            return 'Chrome';
        }
        if (preg_match('/Safari/i', $agent)) {
            return 'Safari';
        }
        if (preg_match('/Opera/i', $agent)) {
            return 'Opera';
        }
        
        return 'Unknown';
    }

    /**
     * اكتشاف نظام التشغيل
     */
    protected static function detectPlatform(): string
    {
        $agent = request()->userAgent();
        
        if (preg_match('/windows|win32/i', $agent)) {
            return 'Windows';
        }
        if (preg_match('/macintosh|mac os x/i', $agent)) {
            return 'Mac';
        }
        if (preg_match('/linux/i', $agent)) {
            return 'Linux';
        }
        if (preg_match('/android/i', $agent)) {
            return 'Android';
        }
        if (preg_match('/iphone|ipad|ipod/i', $agent)) {
            return 'iOS';
        }
        
        return 'Unknown';
    }
}
