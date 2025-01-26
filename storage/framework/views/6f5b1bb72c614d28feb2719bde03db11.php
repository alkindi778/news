<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex">
    <!-- Left Section -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-slate-900">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <?php if(config('settings.site_logo')): ?>
                <img class="h-12 w-auto" src="<?php echo e(asset(config('settings.site_logo'))); ?>" alt="<?php echo e(config('app.name')); ?>">
            <?php endif; ?>

            <!-- Title -->
            <h1 class="mt-10 text-4xl font-bold text-indigo-600 dark:text-indigo-400">
                تسجيل الدخول
            </h1>

            <!-- Login Form -->
            <form class="mt-10 space-y-6" action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <!-- Email Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">البريد الإلكتروني</label>
                    <div class="relative">
                        <input type="email" name="email" required 
                            class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 
                            bg-white dark:bg-slate-800 text-gray-900 dark:text-white
                            focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                            transition-colors text-base"
                            placeholder="أدخل بريدك الإلكتروني">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">كلمة المرور</label>
                    <div class="relative">
                        <input type="password" name="password" required 
                            class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 
                            bg-white dark:bg-slate-800 text-gray-900 dark:text-white
                            focus:ring-2 focus:ring-indigo-500 focus:border-transparent
                            transition-colors text-base"
                            placeholder="أدخل كلمة المرور">
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember_me" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                        <label for="remember_me" class="mr-2 block text-sm text-gray-700 dark:text-gray-300">
                            تذكرني
                        </label>
                    </div>
                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" 
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                            نسيت كلمة المرور؟
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Error Messages -->
                <?php if($errors->any()): ?>
                <div class="rounded-lg bg-red-50 dark:bg-red-900/30 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-circle-exclamation text-red-400"></i>
                        </div>
                        <div class="mr-3">
                            <div class="text-sm text-red-600 dark:text-red-400">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <p><?php echo e($error); ?></p>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full flex justify-center py-3 px-4 rounded-lg text-base font-medium text-white
                    bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 
                    focus:ring-indigo-500 transition-colors">
                    تسجيل الدخول
                </button>
            </form>

            <!-- Developer Signature -->
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <i class="fas fa-code"></i>
                    <span>تم التطوير بواسطة</span>
                    <button onclick="toggleContact(this)" 
                        class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors relative group"
                        data-name="Abdusalam Aref"
                        data-phone="775801243">
                        <span>Abdusalam Aref</span>
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white px-3 py-1 rounded text-xs
                            opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            اضغط للاتصال
                        </div>
                    </button>
                    <span>©</span>
                    <span><?php echo e(date('Y')); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Section -->
    <div class="hidden lg:flex lg:w-1/2 bg-indigo-600 items-center justify-center p-8">
        <div class="max-w-md text-center">
            <h2 class="text-4xl font-bold text-white mb-6">مرحباً بك!</h2>
            <p class="text-indigo-100 text-lg">
                سعداء برؤيتك مرة أخرى. قم بتسجيل الدخول للوصول إلى لوحة تحكم موقعك.
            </p>
        </div>
    </div>
</div>

<script>
function toggleContact(element) {
    const currentText = element.textContent.trim();
    const name = element.dataset.name;
    const phone = element.dataset.phone;
    
    if (currentText === name) {
        element.innerHTML = `<span><i class="fas fa-phone-alt ml-1"></i>${phone}</span>`;
    } else {
        element.innerHTML = `<span>${name}</span>`;
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>