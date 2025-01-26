@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.11.0/css/flag-icons.min.css" />
<style>
    body.light-mode {
        background-color: #e2e8f0;
    }
    
    .light-mode .bg-white {
        background-color: #f8fafc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }
    
    .light-mode .bg-gray-50 {
        background-color: #f1f5f9;
    }
    
    .light-mode .hover\:bg-gray-100:hover {
        background-color: #e5e7eb;
    }
    
    @media (max-width: 768px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }
        .chart-container {
            min-height: 400px;
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-6">
    <div class="mx-auto max-w-7xl">
        <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700">
            <div class="w-full mb-1">
                <div class="mb-4">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">لوحة التحكم</h1>
                </div>
                <!-- Quick Action Buttons -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-4 w-full">
                    <a href="{{ route('admin.news.create') }}" class="flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg w-full">
                        <i class="fas fa-newspaper ml-2 text-xl"></i>
                        إضافة خبر
                    </a>
                    <a href="{{ route('admin.opinions.create') }}" class="flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg w-full">
                        <i class="fas fa-pen-alt ml-2 text-xl"></i>
                        إضافة مقال
                    </a>
                    <a href="{{ route('admin.writers.create') }}" class="flex items-center justify-center px-4 py-3 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg w-full">
                        <i class="fas fa-user-edit ml-2 text-xl"></i>
                        إضافة كاتب
                    </a>
                    <a href="{{ route('admin.videos.create') }}" class="flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg w-full">
                        <i class="fas fa-video ml-2 text-xl"></i>
                        إضافة فيديو
                    </a>
                    <a href="{{ route('admin.newspaper-covers.create') }}" class="flex items-center justify-center px-4 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg w-full">
                        <i class="fas fa-book-open ml-2 text-xl"></i>
                        إضافة غلاف الصحيفة
                    </a>
                </div>
            </div>
        </div>
<br>
        <!-- الإحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- إجمالي الكتاب -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الكتاب</h3>
                    <i class="fas fa-users text-2xl text-blue-500"></i>
                </div>
                <div class="flex items-baseline">
                    <p class="text-2xl sm:text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $stats['writers'] }}
                    </p>
                    <p class="mr-2 text-sm text-gray-600 dark:text-gray-400">كاتب</p>
                </div>
            </div>

            <!-- إجمالي الأخبار -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">الأخبار</h3>
                    <i class="fas fa-newspaper text-2xl text-green-500"></i>
                </div>
                <div class="flex items-baseline">
                    <p class="text-2xl sm:text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $stats['news'] }}
                    </p>
                    <p class="mr-2 text-sm text-gray-600 dark:text-gray-400">خبر</p>
                </div>
            </div>

            <!-- الزيارات اليوم -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">زيارات اليوم</h3>
                    <i class="fas fa-chart-line text-2xl text-purple-500"></i>
                </div>
                <div class="flex items-baseline">
                    <p class="text-2xl sm:text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ end($stats['visits_data']) }}
                    </p>
                    <p class="mr-2 text-sm text-gray-600 dark:text-gray-400">زيارة</p>
                </div>
            </div>

            <!-- إجمالي الزيارات -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">إجمالي الزيارات</h3>
                    <i class="fas fa-chart-bar text-2xl text-red-500"></i>
                </div>
                <div class="flex items-baseline">
                    <p class="text-2xl sm:text-3xl font-semibold text-gray-900 dark:text-white">
                        {{ $stats['total_visits'] }}
                    </p>
                    <p class="mr-2 text-sm text-gray-600 dark:text-gray-400">زيارة</p>
                </div>
            </div>
        </div>

        <!-- الرسوم البيانية -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
            <!-- إحصائيات الزيارات -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">إحصائيات الزيارات</h3>
                    <i class="fas fa-chart-line text-2xl text-blue-500"></i>
                </div>
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div class="bg-blue-50 dark:bg-blue-900 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">اليوم</p>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ end($stats['visits_data']) }}</p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">هذا الأسبوع</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ array_sum(array_slice($stats['visits_data'], -7)) }}</p>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900 rounded-lg p-4 text-center">
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">هذا الشهر</p>
                        <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ array_sum($stats['visits_data']) }}</p>
                    </div>
                </div>
                <div class="chart-container h-64 sm:h-80">
                    <canvas id="visitsChart"></canvas>
                </div>
            </div>

            <!-- إحصائيات الدول -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center">
                        <i class="fas fa-globe text-green-500 mr-2"></i>
                        إحصائيات الدول
                    </h3>
                    <select id="countryStatsRange" class="text-sm bg-gray-100 dark:bg-gray-700 border-none rounded-md focus:ring-2 focus:ring-green-500">
                        <option value="7">آخر 7 أيام</option>
                        <option value="30">آخر 30 يوم</option>
                        <option value="90">آخر 3 أشهر</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-green-50 dark:bg-green-900/30 rounded-lg p-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">إجمالي الدول</p>
                        <p id="totalCountries" class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['total_countries'] }}</p>
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/30 rounded-lg p-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">أعلى دولة زيارة</p>
                        <p id="topCountry" class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['top_country'] }}</p>
                    </div>
                </div>
                <div class="chart-container h-64 sm:h-80">
                    <canvas id="countriesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- آخر التحديثات -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">آخر الأخبار</h3>
                <i class="fas fa-newspaper text-2xl text-blue-500"></i>
            </div>
            <div class="space-y-4">
                @foreach($latestNews as $news)
                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <i class="fas fa-newspaper text-blue-500 dark:text-blue-300"></i>
                    </div>
                    <div class="mr-4 flex-1">
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ Str::limit($news->title, 50) }}</h4>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $news->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('admin.news.edit', $news) }}" class="text-blue-500 hover:text-blue-600 transition-colors duration-200">
                        <i class="fas fa-edit text-lg"></i>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('admin.news.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                    عرض كل الأخبار
                    <i class="fas fa-arrow-left mr-2"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // الإعدادات المشتركة للرسوم البيانية
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    };

    // تحقق من حجم الشاشة
    const isMobile = window.innerWidth < 768;

    // رسم بياني للزيارات
    const visitsCtx = document.getElementById('visitsChart').getContext('2d');
    new Chart(visitsCtx, {
        type: 'line',
        data: {
            labels: @json($stats['visits_labels']),
            datasets: [{
                label: 'عدد الزيارات',
                data: @json($stats['visits_data']),
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: isMobile ? 2 : 4,
                pointHoverRadius: isMobile ? 4 : 6
            }]
        },
        options: {
            ...commonOptions,
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: isMobile ? 10 : 12
                        },
                        maxRotation: isMobile ? 45 : 0
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: isMobile ? 10 : 12
                        }
                    }
                }
            }
        }
    });

    // إعداد مخطط إحصائيات الدول
    const countriesCtx = document.getElementById('countriesChart').getContext('2d');
    
    new Chart(countriesCtx, {
        type: 'bar',
        data: {
            labels: @json($country_labels),
            datasets: [{
                label: 'عدد الزيارات',
                data: @json($country_data),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: isMobile ? 'y' : 'x',
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: isMobile ? 10 : 12
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: isMobile ? 10 : 12
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    bodyFont: {
                        size: isMobile ? 12 : 14
                    }
                }
            }
        }
    });

    // تحديث المخططات عند تغيير حجم النافذة
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            location.reload();
        }, 250);
    });
});
</script>
@endpush
