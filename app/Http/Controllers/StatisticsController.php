<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\News;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        $stats = $this->getStatistics();
        $latestNews = News::latest()->get();
        $categories = Category::all();
        return view('admin.statistics.index', compact('stats', 'latestNews', 'categories'));
    }

    public function refresh()
    {
        return response()->json($this->getStatistics());
    }

    private function getStatistics()
    {
        // إحصائيات الزيارات اليومية
        $dailyVisits = [];
        $visitLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $visitLabels[] = $date->format('d/m');
            $dailyVisits[] = Visit::whereDate('visit_date', $date->format('Y-m-d'))->count();
        }

        // توزيع الزوار حسب الدول
        $countryStats = Visit::whereNotNull('country')
            ->select('country', \DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->country,
                    'total' => $item->total
                ];
            });

        // إجمالي الزيارات
        $totalVisits = Visit::count();

        return [
            'total_visits' => $totalVisits,
            'visits_data' => $dailyVisits,
            'visits_labels' => $visitLabels,
            'country_stats' => $countryStats,
        ];
    }
}
