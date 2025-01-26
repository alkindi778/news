@extends('front.layouts.app')

@section('title')هيئة التحرير@endsection

@section('content')
<div class="bg-gradient-to-b from-red-50 to-white dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">هيئة التحرير</h1>
                <div class="w-24 h-1 bg-red-600 mx-auto rounded-full mb-4"></div>
                <p class="text-lg text-gray-600 dark:text-gray-300">فريق متميز من الخبراء والمتخصصين</p>
            </div>

            <!-- Editors Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($editors as $editor)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="relative">
                            @if($editor->hasMedia('avatar'))
                                <img src="{{ $editor->getFirstMediaUrl('avatar') }}" 
                                     alt="{{ $editor->name }}" 
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="fas fa-user text-6xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">{{ $editor->name }}</h3>
                            <p class="text-red-600 dark:text-red-400 mb-4">{{ $editor->title }}</p>
                            
                            @if($editor->bio)
                                <p class="text-gray-600 dark:text-gray-300 mb-6">{{ $editor->bio }}</p>
                            @endif

                            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                                @if($editor->email)
                                    <a href="mailto:{{ $editor->email }}" 
                                       class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                @endif
                                
                                @if($editor->social_links)
                                    @foreach($editor->social_links as $platform => $url)
                                        <a href="{{ $url }}" target="_blank" 
                                           class="text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                            <i class="fab fa-{{ $platform }}"></i>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
