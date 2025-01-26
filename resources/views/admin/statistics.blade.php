@extends('layouts.admin')

@section('title', 'الإحصائيات')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto p-6">
        <!-- إحصائيات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- إجمالي الأخبار -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                        <i class="fas fa-newspaper text-2xl text-blue-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">إجمالي الأخبار</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['total_news'] }}</p>
                    </div>
                </div>
            </div>

            <!-- إجمالي الفيديوهات -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                        <i class="fas fa-video text-2xl text-green-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">إجمالي الفيديوهات</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['total_videos'] }}</p>
                    </div>
                </div>
            </div>

            <!-- إجمالي الكتاب -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                        <i class="fas fa-users text-2xl text-purple-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">إجمالي الكتاب</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['total_authors'] }}</p>
                    </div>
                </div>
            </div>

            <!-- إجمالي الزيارات -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                        <i class="fas fa-chart-line text-2xl text-yellow-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">إجمالي الزيارات</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['total_visits'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- إحصائيات المهام -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <!-- إجمالي المهام -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-500 bg-opacity-10">
                        <i class="fas fa-tasks text-2xl text-indigo-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">إجمالي المهام</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['total_tasks'] }}</p>
                    </div>
                </div>
            </div>

            <!-- المهام المعلقة -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-500 bg-opacity-10">
                        <i class="fas fa-clock text-2xl text-red-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">المهام المعلقة</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['pending_tasks'] }}</p>
                    </div>
                </div>
            </div>

            <!-- المهام المكتملة -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                        <i class="fas fa-check-circle text-2xl text-green-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">المهام المكتملة</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['completed_tasks'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- إحصائيات الزيارات -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- زيارات اليوم -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                        <i class="fas fa-calendar-day text-2xl text-blue-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">زيارات اليوم</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['today_visits'] }}</p>
                    </div>
                </div>
            </div>

            <!-- زيارات الأسبوع -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                        <i class="fas fa-calendar-week text-2xl text-purple-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">زيارات الأسبوع</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['week_visits'] }}</p>
                    </div>
                </div>
            </div>

            <!-- زيارات الشهر -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                        <i class="fas fa-calendar-alt text-2xl text-yellow-500"></i>
                    </div>
                    <div class="mr-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">زيارات الشهر</p>
                        <p class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $stats['month_visits'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
