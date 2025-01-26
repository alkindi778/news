@extends('front.layouts.app')

@section('title')شروط الاستخدام@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm p-6 lg:p-8">
        <h1 class="text-3xl font-bold mb-8">شروط الاستخدام</h1>
        
        <div class="prose dark:prose-invert max-w-none">
            <p class="mb-6">
                مرحباً بك في {{ config('app.name') }}. 
                باستخدامك لموقعنا، فإنك توافق على الالتزام بهذه الشروط والأحكام.
                يرجى قراءة هذه الشروط بعناية قبل استخدام الموقع.
            </p>

            <h2 class="text-2xl font-bold mt-8 mb-4">استخدام الموقع</h2>
            <ul class="list-disc mr-6 mb-6">
                <li>يجب استخدام الموقع لأغراض قانونية فقط وبطريقة لا تنتهك حقوق أي طرف ثالث</li>
                <li>يحظر استخدام الموقع بأي طريقة قد تسبب ضرراً للموقع أو تؤثر على توافره أو إمكانية الوصول إليه</li>
                <li>يحظر محاولة الوصول غير المصرح به إلى أنظمتنا أو شبكاتنا</li>
            </ul>

            <h2 class="text-2xl font-bold mt-8 mb-4">المحتوى</h2>
            <p class="mb-6">
                جميع المحتويات المنشورة على موقعنا محمية بموجب حقوق النشر والملكية الفكرية.
                لا يجوز نسخ أو إعادة نشر أي محتوى من الموقع دون إذن كتابي مسبق.
            </p>

            <h2 class="text-2xl font-bold mt-8 mb-4">التعليقات والمشاركات</h2>
            <p class="mb-4">
                عند نشر تعليقات أو مشاركات على موقعنا، فإنك توافق على:
            </p>
            <ul class="list-disc mr-6 mb-6">
                <li>عدم نشر أي محتوى غير قانوني أو مسيء أو تشهيري</li>
                <li>عدم انتحال شخصية أي شخص أو كيان</li>
                <li>عدم نشر محتوى يخرق حقوق الملكية الفكرية للآخرين</li>
                <li>تحمل المسؤولية الكاملة عن أي محتوى تنشره</li>
            </ul>

            <h2 class="text-2xl font-bold mt-8 mb-4">إخلاء المسؤولية</h2>
            <p class="mb-6">
                يتم توفير الموقع "كما هو" دون أي ضمانات من أي نوع.
                لا نضمن دقة أو اكتمال أو موثوقية أي محتوى على الموقع.
                لن نكون مسؤولين عن أي خسائر أو أضرار تنشأ عن استخدام الموقع.
            </p>

            <h2 class="text-2xl font-bold mt-8 mb-4">التعديلات</h2>
            <p class="mb-6">
                نحتفظ بالحق في تعديل هذه الشروط في أي وقت.
                سيتم نشر أي تغييرات على هذه الصفحة.
                استمرار استخدامك للموقع بعد نشر التغييرات يعني موافقتك على الشروط المعدلة.
            </p>

            <h2 class="text-2xl font-bold mt-8 mb-4">القانون المطبق</h2>
            <p class="mb-6">
                تخضع هذه الشروط وتفسر وفقاً للقوانين المعمول بها.
                أي نزاع ينشأ عن استخدام الموقع سيخضع للاختصاص القضائي الحصري للمحاكم المختصة.
            </p>

            <h2 class="text-2xl font-bold mt-8 mb-4">الاتصال بنا</h2>
            <p class="mb-6">
                إذا كان لديك أي أسئلة حول شروط الاستخدام هذه، يمكنك الاتصال بنا:
            </p>
            <ul class="list-none mb-6">
                @if(config('settings.contact_email'))
                    <li class="mb-2">
                        البريد الإلكتروني: 
                        <a href="mailto:{{ config('settings.contact_email') }}" class="text-primary-600 dark:text-primary-400 hover:underline">
                            {{ config('settings.contact_email') }}
                        </a>
                    </li>
                @endif
                @if(config('settings.contact_phone'))
                    <li class="mb-2">
                        الهاتف: 
                        <a href="tel:{{ config('settings.contact_phone') }}" class="text-primary-600 dark:text-primary-400 hover:underline">
                            {{ config('settings.contact_phone') }}
                        </a>
                    </li>
                @endif
            </ul>

            <p class="mt-8 text-sm text-gray-600 dark:text-gray-400">
                آخر تحديث: {{ now()->translatedFormat('d M Y') }}
            </p>
        </div>
    </div>
</div>
@endsection
