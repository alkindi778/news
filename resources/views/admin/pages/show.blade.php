@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- رأس الصفحة -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $title }}</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-primary-300 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt ml-1"></i> لوحة التحكم
                        </a>
                        <span class="mx-2 text-gray-600">/</span>
                        <a href="{{ route('admin.settings.index') }}" class="hover:text-primary-300 transition-colors duration-200">
                            الإعدادات
                        </a>
                        <span class="mx-2 text-gray-600">/</span>
                        <span class="text-primary-200">{{ $title }}</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- محتوى الصفحة -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="prose dark:prose-invert max-w-none">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>
@endsection
