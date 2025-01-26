<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Category;
use App\Models\User;
use App\Models\Visit;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get visit statistics for the last 7 days
        $visits_data = [];
        $visits_labels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $visits_labels[] = $date->format('Y-m-d');
            $visits_data[] = Visit::whereDate('created_at', $date->format('Y-m-d'))->count();
        }

        // Get country statistics
        $countryMapping = [
            'Saudi Arabia' => 'sa',
            'United Arab Emirates' => 'ae',
            'Kuwait' => 'kw',
            'Egypt' => 'eg',
            'Qatar' => 'qa',
            'Bahrain' => 'bh',
            'Oman' => 'om',
            'Jordan' => 'jo',
            'Iraq' => 'iq',
            'Yemen' => 'ye',
            'Lebanon' => 'lb',
            'Syria' => 'sy',
            'Palestine' => 'ps',
            'Libya' => 'ly',
            'Tunisia' => 'tn',
            'Algeria' => 'dz',
            'Morocco' => 'ma',
            'Sudan' => 'sd',
            'Somalia' => 'so',
            'Mauritania' => 'mr'
        ];

        $countryStats = Visit::select('country', DB::raw('count(*) as total'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('total', 'desc')
            ->take(10)
            ->get();

        $country_labels = $countryStats->pluck('country')->map(function($country) use ($countryMapping) {
            return $countryMapping[$country] ?? strtolower($country);
        })->toArray();

        $country_data = $countryStats->pluck('total')->toArray();
        
        // Get the top country
        $top_country = $countryStats->first() ? $countryStats->first()->country : 'غير متوفر';
        
        // Get total number of unique countries
        $total_countries = Visit::distinct('country')->whereNotNull('country')->count('country');

        // Get news count
        $newsCount = News::count();
        $opinionsCount = \App\Models\Opinion::count();

        // Get active writers count
        $writersCount = Author::whereNull('deleted_at')->count();

        // Get counts for dashboard statistics
        $stats = [
            'writers' => $writersCount,
            'news' => $newsCount + $opinionsCount,
            'news_count' => $newsCount,
            'opinions_count' => $opinionsCount,
            'categories' => Category::count(),
            'users' => User::count(),
            'total_visits' => Visit::count(),
            'visits_labels' => $visits_labels,
            'visits_data' => $visits_data,
            'country_labels' => $country_labels,
            'country_data' => $country_data,
            'top_country' => $top_country,
            'total_countries' => $total_countries
        ];

        // Get latest news
        $latestNews = News::with(['categories', 'author'])
            ->latest()
            ->take(5)
            ->get();

        // Get most viewed news
        $mostViewedNews = News::with(['categories', 'author'])
            ->orderBy('views_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'latestNews',
            'mostViewedNews',
            'country_labels',
            'country_data'
        ));
    }
}
