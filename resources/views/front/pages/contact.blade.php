@extends('front.layouts.app')

@section('title')اتصل بنا@endsection

@section('content')
<div class="bg-gradient-to-b from-red-50 to-white dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">اتصل بنا</h1>
                <div class="w-24 h-1 bg-red-600 mx-auto rounded-full mb-4"></div>
                <p class="text-lg text-gray-600 dark:text-gray-300">نحن هنا للإجابة على استفساراتك</p>
            </div>

            <!-- Contact Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                <!-- Email -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">البريد الإلكتروني</h3>
                    <a href="mailto:{{ $site_settings->contact_email }}" 
                       class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                        {{ $site_settings->contact_email }}
                    </a>
                </div>

                <!-- Phone -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">رقم الهاتف</h3>
                    <a href="tel:{{ $site_settings->contact_phone }}" 
                       class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">
                        {{ $site_settings->contact_phone }}
                    </a>
                </div>

                <!-- Address -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-2xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">العنوان</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $site_settings->contact_address }}</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">راسلنا</h2>
                    <form action="{{ route('front.contact.send') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">الاسم</label>
                                <input type="text" name="name" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900 transition-colors">
                            </div>
                            <div>
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">البريد الإلكتروني</label>
                                <input type="email" name="email" required
                                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900 transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">الموضوع</label>
                            <input type="text" name="subject" required
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900 transition-colors">
                        </div>
                        <div>
                            <label class="block text-gray-700 dark:text-gray-300 mb-2">الرسالة</label>
                            <textarea name="message" rows="6" required
                                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-800 dark:text-white focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:focus:ring-red-900 transition-colors"></textarea>
                        </div>
                        <div>
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                                إرسال الرسالة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
