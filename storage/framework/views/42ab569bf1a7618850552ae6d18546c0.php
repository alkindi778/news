<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($site_settings->site_name ?? config('app.name')); ?></title>

    <link rel="icon" type="image/x-icon" href="<?php echo e(url('favicon.ico')); ?>">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <style>
        /* Add any custom styles here */
        body {
            font-family: system-ui, -apple-system, sans-serif;
        }

        /* تخصيص حجم الشعار */
        .site-logo {
            width: <?php echo e($site_settings->logo_width ?? 'auto'); ?>px;
            height: <?php echo e($site_settings->logo_height ?? '64'); ?>px;
            object-fit: contain;
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <?php if(isset($header)): ?>
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>