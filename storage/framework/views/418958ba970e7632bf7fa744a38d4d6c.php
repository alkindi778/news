<?php $__env->startSection('title', '404 - الصفحة غير موجودة'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-100 to-indigo-200 dark:from-gray-900 dark:to-indigo-900">
    <div class="max-w-4xl mx-auto px-6 py-16 text-center">
        <div class="mb-16 relative">
            <h1 class="text-9xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-600 animate-pulse">404</h1>
            <h2 class="text-5xl font-bold text-indigo-800 dark:text-indigo-200 mb-6">عذراً، الصفحة غير موجودة</h2>
            <p class="text-2xl text-indigo-600 dark:text-indigo-300">يبدو أن الصفحة التي تبحث عنها قد ضاعت في الفضاء الإلكتروني</p>
        </div>

        <div class="mb-16">
            <div class="relative w-80 h-80 mx-auto animate-float">
                <svg class="w-full h-full text-indigo-500 dark:text-indigo-400 filter drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9h10v2H7v-2zm3.3-3.8L8.4 9.1 7 7.7l3.8-3.8 1.4 1.4-1.9 1.9zm5.4 0l1.9-1.9-1.4-1.4L12.3 7l1.4 1.4 1.9-1.9z"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-6xl animate-bounce filter drop-shadow-md">🚀</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4 rtl:space-x-reverse">
            <button onclick="window.history.back()" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-medium rounded-full transition duration-300 ease-in-out transform hover:scale-105">
                <svg class="w-5 h-5 ml-2 rtl:ml-0 rtl:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                العودة للصفحة السابقة
            </button>
        </div>

        <div class="mt-16 text-lg text-indigo-700 dark:text-indigo-300">
            <p class="mb-4 font-semibold">ماذا يمكنك أن تفعل الآن؟</p>
            <ul class="space-y-2">
                <li class="flex items-center"><span class="text-2xl mr-2">🔍</span> تأكد من صحة الرابط المدخل</li>
                <li class="flex items-center"><span class="text-2xl mr-2">🔄</span> حاول تحديث الصفحة</li>
                <li class="flex items-center"><span class="text-2xl mr-2">🏠</span> عد إلى الصفحة الرئيسية</li>
                <li class="flex items-center"><span class="text-2xl mr-2">💡</span> ابحث عن المحتوى الذي تريده</li>
            </ul>
        </div>
    </div>
</div>

<style>
@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/errors/404.blade.php ENDPATH**/ ?>