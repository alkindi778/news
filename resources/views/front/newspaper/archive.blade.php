@extends('front.layouts.app')

@section('title', 'أرشيف الصحيفة')

@section('content')
<div class="bg-gradient-to-br from-blue-100 to-indigo-200 dark:from-gray-900 dark:to-indigo-900 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- رأس الصفحة -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4 relative inline-block">
                <span class="relative z-10">أرشيف الصحيفة</span>
                <svg class="absolute top-full left-0 w-full h-2 text-primary-600" viewBox="0 0 200 4" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 2 Q 50 4 100 2 T 200 2" stroke="currentColor" fill="none" stroke-width="4"/>
                </svg>
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-300">استعرض تاريخ صحافتنا عبر الزمن</p>
        </div>

        <!-- شريط البحث -->
        <div class="mb-12 max-w-4xl mx-auto">
            <form action="{{ route('front.newspaper.archive') }}" method="GET" class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 space-y-4">
                <div class="flex flex-wrap md:flex-nowrap gap-4">
                    <div class="w-full md:flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">بحث</label>
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   value="{{ request('search') }}"
                                   class="block w-full rounded-lg border-gray-300 dark:border-gray-600 pr-4 pl-10 py-3 text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200"
                                   placeholder="ابحث في الأرشيف...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/3">
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">السنة</label>
                        <select name="year" 
                                id="year"
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 py-3 text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                            <option value="">كل السنوات</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit"
                        class="w-full px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fas fa-search mr-2"></i>
                    بحث
                </button>
            </form>
        </div>

        <!-- شبكة الأغلفة -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($covers as $cover)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative aspect-[3/4]">
                        <img src="{{ url('storage/' . $cover->cover_image) }}"
                             alt="{{ $cover->title }}"
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    </div>

                    <div class="p-4 space-y-3">
                        <h3 class="text-gray-900 dark:text-white font-bold text-xl mb-2">{{ $cover->newspaper_name }}</h3>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ $cover->title }}</p>
                        <div class="flex items-center justify-center text-sm text-gray-500 dark:text-gray-400">
                            <span>
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $cover->publish_date->format('Y-m-d') }}
                            </span>
                        </div>
                        @if($cover->pdf_link)
                            <a href="{{ $cover->pdf_link }}"
                               target="_blank"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-external-link-alt"></i>
                                عرض العدد
                            </a>
                        @endif
                        @if($cover->pdf_file)
                            <a href="{{ url('storage/' . $cover->pdf_file) }}"
                               target="_blank"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-lg transition-all duration-200 transform hover:scale-105">
                                <i class="fas fa-file-pdf"></i>
                                تحميل PDF
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                    <div class="text-gray-400 dark:text-gray-500 mb-6">
                        <i class="fas fa-newspaper text-7xl animate-pulse"></i>
                    </div>
                    <h3 class="text-2xl font-medium text-gray-900 dark:text-gray-100 mb-3">لا توجد أعداد في الأرشيف</h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md">لم يتم العثور على أي أعداد تطابق معايير البحث. حاول تغيير معايير البحث أو العودة لاحقًا.</p>
                </div>
            @endforelse
        </div>

        <!-- الترقيم -->
        @if($covers->hasPages())
            <div class="mt-12">
                {{ $covers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
