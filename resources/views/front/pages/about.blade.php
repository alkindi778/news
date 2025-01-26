@extends('front.layouts.app')

@section('title')من نحن@endsection

@section('content')
<div class="bg-gradient-to-b from-pink-50 to-white dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">من نحن</h1>
                <div class="w-24 h-1 bg-pink-600 mx-auto rounded-full mb-4"></div>
                <p class="text-lg text-gray-600 dark:text-gray-300">صحيفة شقائق - صوت المرأة في الجنوب</p>
            </div>

            <!-- Main Content -->
            <div class="space-y-8">
                <!-- About Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl">
                    <div class="bg-gradient-to-r from-pink-600 to-pink-700 p-6">
                        <h2 class="text-2xl font-bold text-white">مرحباً بكم في صحيفة شقائق</h2>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                            <span class="font-semibold text-pink-600 dark:text-pink-500">صحيفة شقائق</span>
                            هي صحيفة نسائية رائدة تهتم بشؤون المرأة في الجنوب والأسرة والطفل. نسعى لتمكين المرأة وتعزيز دورها في المجتمع من خلال تقديم محتوى هادف ومتنوع يلبي احتياجاتها ويعكس تطلعاتها.
                        </p>
                    </div>
                </div>

                <!-- Vision & Mission Grid -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Vision Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center ml-4">
                                <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">رؤيتنا</h3>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            نتطلع إلى مجتمع يقدر المرأة ويمنحها فرصًا متساوية للمشاركة في جميع مجالات الحياة، ونسعى لأن نكون المنصة الرائدة في تمكين المرأة الجنوبية وإبراز إنجازاتها.
                        </p>
                    </div>

                    <!-- Mission Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900 rounded-full flex items-center justify-center ml-4">
                                <svg class="w-6 h-6 text-pink-600 dark:text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white">مهمتنا</h3>
                        </div>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-pink-500 ml-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">تقديم محتوى إعلامي هادف يعكس قضايا المرأة والأسرة</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-pink-500 ml-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">توفير منصة للمرأة الجنوبية للتعبير عن آرائها وتجاربها</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-pink-500 ml-2 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300">نشر الوعي حول حقوق المرأة والطفل</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Values Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-600 to-pink-700 p-6">
                        <h2 class="text-2xl font-bold text-white">قيمنا</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-center p-4 bg-pink-50 dark:bg-gray-700 rounded-lg transform transition-all duration-300 hover:bg-pink-100 dark:hover:bg-gray-600">
                                <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center ml-4">
                                    <i class="fas fa-balance-scale text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">المساواة</h3>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm">نؤمن بالمساواة بين الجميع ونعمل على تعزيزها</p>
                                </div>
                            </div>
                            <div class="flex items-center p-4 bg-pink-50 dark:bg-gray-700 rounded-lg transform transition-all duration-300 hover:bg-pink-100 dark:hover:bg-gray-600">
                                <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center ml-4">
                                    <i class="fas fa-hands-helping text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">التمكين</h3>
                                    <p class="text-gray-700 dark:text-gray-300 text-sm">نسعى لتمكين المرأة في جميع مجالات الحياة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-pink-600 to-pink-700 p-6">
                        <h2 class="text-2xl font-bold text-white">تواصل معنا</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Email -->
                            <div class="flex items-center p-4 bg-pink-50 dark:bg-gray-700 rounded-lg">
                                <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center ml-4">
                                    <i class="fas fa-envelope text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">البريد الإلكتروني</h3>
                                    <a href="mailto:info@shaqaeq.com" 
                                       class="text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300">
                                        info@shaqaeq.com
                                    </a>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="flex items-center p-4 bg-pink-50 dark:bg-gray-700 rounded-lg">
                                <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center ml-4">
                                    <i class="fas fa-phone-alt text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">رقم الهاتف</h3>
                                    <a href="tel:+967712345678" 
                                       class="text-pink-600 dark:text-pink-400 hover:text-pink-700 dark:hover:text-pink-300">
                                        +967 71 234 5678
                                    </a>
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="flex items-center p-4 bg-pink-50 dark:bg-gray-700 rounded-lg">
                                <div class="w-10 h-10 bg-pink-600 rounded-full flex items-center justify-center ml-4">
                                    <i class="fas fa-map-marker-alt text-white"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1">العنوان</h3>
                                    <p class="text-gray-700 dark:text-gray-300">العاصمة عدن - الجنوب العربي</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
