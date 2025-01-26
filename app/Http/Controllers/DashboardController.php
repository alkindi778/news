<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Author;
use App\Models\Visit;
use App\Models\News;
use App\Models\Opinion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // إحصائيات عامة
        $stats = [
            'writers' => Author::count(),
            'visits_data' => [Visit::whereDate('created_at', Carbon::today())->count()],
            'popular_articles_labels' => array_merge(
                News::whereNull('deleted_at')->pluck('title')->toArray(),
                Opinion::whereNull('deleted_at')->pluck('title')->toArray()
            )
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function statistics()
    {
        // إضافة بيانات الزيارات للأيام السبعة الماضية
        $visits_data = [];
        $visits_labels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $visits_labels[] = Carbon::now()->subDays($i)->format('d/m');
            $visits_data[] = Visit::whereDate('created_at', $date)->count();
        }

        // إضافة بيانات المقالات الشائعة
        $popular_articles = News::orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'writers' => Author::count(),
            'visits_data' => $visits_data,
            'visits_labels' => $visits_labels,
            'popular_articles_labels' => $popular_articles->pluck('title')->toArray(),
            'popular_articles_data' => $popular_articles->pluck('views_count')->toArray()
        ];

        return view('admin.statistics.index', compact('stats'));
    }
}