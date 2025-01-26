@extends('front.layouts.app')

@section('title')سياسة الخصوصية@endsection

@section('content')
<div class="bg-gradient-to-b from-blue-50 to-white dark:from-gray-900 dark:to-gray-800 py-16">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-4">سياسة الخصوصية</h1>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="prose prose-lg max-w-none dark:prose-invert prose-headings:text-gray-800 dark:prose-headings:text-white prose-p:text-gray-600 dark:prose-p:text-gray-300">
                        <h2 class="text-2xl font-semibold mb-4">مقدمة</h2>
                        <p class="mb-6">نحن في <span class="text-red-600">{{ $site_settings->site_name ?? config('app.name') }}</span> نقدر خصوصيتك ونلتزم بحماية بياناتك الشخصية. تهدف هذه السياسة إلى توضيح كيفية جمعنا واستخدامنا وحمايتنا لمعلوماتك الشخصية عند استخدامك لموقعنا.</p>
                        
                        <h2 class="text-2xl font-semibold mb-4">جمع المعلومات</h2>
                        <p class="mb-6">نقوم بجمع المعلومات التي تقدمها لنا طواعية عند التسجيل في موقعنا، أو عند الاشتراك في نشرتنا الإخبارية، أو عند ملء النماذج على موقعنا. قد تشمل هذه المعلومات اسمك، عنوان بريدك الإلكتروني، ورقم هاتفك.</p>
                        
                        <h2 class="text-2xl font-semibold mb-4">استخدام المعلومات</h2>
                        <p class="mb-6">نستخدم المعلومات التي نجمعها لتحسين خدماتنا وتجربة المستخدم. قد نستخدم بريدك الإلكتروني لإرسال تحديثات حول خدماتنا أو لإعلامك بالأخبار والعروض الجديدة.</p>
                        
                        <h2 class="text-2xl font-semibold mb-4">حماية المعلومات</h2>
                        <p class="mb-6">نتخذ إجراءات أمنية صارمة لحماية معلوماتك من الوصول غير المصرح به أو التغيير أو الإفصاح أو الإتلاف. نحن نستخدم بروتوكولات تشفير متقدمة لضمان أمان بياناتك.</p>
                        <h2 class="text-2xl font-semibold mb-4">الاتصال بنا</h2>
                        <p class="mb-6">إذا كان لديك أي أسئلة أو استفسارات حول سياسة الخصوصية الخاصة بنا، يرجى <a href="{{ url('/contact') }}" class="text-red-600 hover:text-red-700 transition-colors duration-300">الاتصال بنا</a> عبر صفحة الاتصال الخاصة بنا.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
