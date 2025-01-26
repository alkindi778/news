@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
            <i class="fas fa-chart-line text-blue-600 ml-2"></i>
            إحصائيات الموقع
        </h1>
        <p class="text-gray-600 dark:text-gray-400">نظرة عامة على أداء الموقع والتفاعلات</p>
    </div>

    <!-- أزرار التحكم -->
    <div class="flex flex-wrap gap-4 mb-8">
        <button id="refreshStats" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <i class="fas fa-sync-alt ml-2"></i>تحديث الإحصائيات
        </button>
    </div>

    <!-- بطاقات الإحصائيات -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- إجمالي الزيارات -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <i class="fas fa-eye text-blue-600 dark:text-blue-400"></i>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ number_format($stats['total_visits']) }}
                    </h4>
                    <p class="text-gray-500 dark:text-gray-400">إجمالي الزيارات</p>
                </div>
            </div>
        </div>

        <!-- المقالات -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <i class="fas fa-newspaper text-green-600 dark:text-green-400"></i>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ count($latestNews) }}
                    </h4>
                    <p class="text-gray-500 dark:text-gray-400">إجمالي المقالات</p>
                </div>
            </div>
        </div>

        <!-- التصنيفات -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <i class="fas fa-folder text-yellow-600 dark:text-yellow-400"></i>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ count($categories) }}
                    </h4>
                    <p class="text-gray-500 dark:text-gray-400">إجمالي التصنيفات</p>
                </div>
            </div>
        </div>

        <!-- الزوار النشطين -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900">
                    <i class="fas fa-users text-purple-600 dark:text-purple-400"></i>
                </div>
                <div class="mx-4">
                    <h4 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                        {{ $stats['visits_data'][count($stats['visits_data'])-1] }}
                    </h4>
                    <p class="text-gray-500 dark:text-gray-400">الزوار اليوم</p>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسوم البيانية -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- الزيارات اليومية -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                    <i class="fas fa-chart-line text-blue-600 ml-2"></i>
                    الزيارات اليومية
                </h3>
                <canvas id="dailyVisitsChart"></canvas>
            </div>
        </div>

        <!-- توزيع الزوار حسب الدول -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">
                    <i class="fas fa-globe text-green-600 ml-2"></i>
                    توزيع الزوار حسب الدول
                </h3>
                <div id="countryStats" class="space-y-4">
                    @forelse($stats['country_stats'] as $country)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 dark:text-gray-400">{{ $country['name'] }}</span>
                            <div class="flex items-center">
                                <span class="text-gray-800 dark:text-gray-200 font-semibold">{{ number_format($country['total']) }}</span>
                                <span class="text-gray-500 dark:text-gray-400 text-sm mr-2">زيارة</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center">لا توجد بيانات للدول حتى الآن</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // رسم بياني للزيارات اليومية
    const dailyVisitsCtx = document.getElementById('dailyVisitsChart').getContext('2d');
    new Chart(dailyVisitsCtx, {
        type: 'line',
        data: {
            labels: @json($stats['visits_labels']),
            datasets: [{
                label: 'الزيارات',
                data: @json($stats['visits_data']),
                borderColor: '#3B82F6',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // تحديث الإحصائيات
    document.getElementById('refreshStats').addEventListener('click', function() {
        fetch('/admin/statistics/refresh')
            .then(response => response.json())
            .then(data => {
                location.reload();
            });
    });
});
</script>
@endsection
