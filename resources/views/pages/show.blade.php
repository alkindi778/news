@extends('layouts.app')

@section('meta_tags')
    <meta name="description" content="{{ $page->meta_description }}">
    <meta name="keywords" content="{{ $page->meta_keywords }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <!-- عنوان الصفحة -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $page->title }}</h1>
            </div>

            <!-- محتوى الصفحة -->
            <div class="p-6">
                <div class="prose dark:prose-invert max-w-none">
                    {!! $page->content !!}
                </div>
            </div>

            <!-- تذييل الصفحة -->
            <div class="p-6 bg-gray-50 dark:bg-gray-700">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    آخر تحديث: {{ $page->updated_at->format('Y-m-d') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
