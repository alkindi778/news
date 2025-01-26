@extends('layouts.admin')

@section('title', 'مقالات الكاتب ' . $writer->name)

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            مقالات الكاتب: {{ $writer->name }}
        </h1>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($articles as $article)
                <li>
                    <div class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 truncate">
                                    {{ $article->title }}
                                </h3>
                                <div class="mt-2 flex items-center text-sm text-gray-500 dark:text-gray-400">
                                    <span class="ml-4">
                                        <i class="fas fa-calendar ml-1"></i>
                                        {{ $article->created_at->format('Y/m/d') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-eye ml-1"></i>
                                        {{ $article->views_count ?? 0 }} مشاهدة
                                    </span>
                                </div>
                            </div>
                            <div class="flex-shrink-0 flex">
                                <a href="{{ route('admin.news.edit', $article) }}" 
                                   class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                   title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $article) }}" 
                                      method="POST" 
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا المقال؟')"
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-4 sm:px-6 text-center text-gray-500 dark:text-gray-400">
                    لا توجد مقالات لهذا الكاتب
                </li>
            @endforelse
        </ul>
    </div>

    <div class="mt-4">
        {{ $articles->links() }}
    </div>
</div>
@endsection
