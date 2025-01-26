<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="<?php echo e($site_settings->description ?? config('app.description', 'موقع عدن الإخباري')); ?>">
    <meta name="keywords" content="<?php echo e($site_settings->keywords ?? config('app.keywords', 'أخبار,عدن,اليمن')); ?>">
    
    <title><?php echo $__env->yieldContent('title'); ?> <?php echo e($site_settings->site_name ? '| '.$site_settings->site_name : config('app.name')); ?></title>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;500;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    },
                    fontFamily: {
                        'kufi': ['Noto Kufi Arabic', 'sans-serif'],
                    },
                }
            },
            darkMode: 'class',
        }
    </script>
    
    <style>
        :root {
            --primary-color: #3b82f6;
            --primary-hover: #60a5fa;
        }
        
        [x-cloak] { 
            display: none !important; 
        }
        
        .search-input {
            transition: all 0.3s;
        }
        .search-input:focus {
             box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }
        .latest-news-bar {
            background-color: #2d3748;
            color: #fff;
            padding: 0.75rem 0;
        }
        .latest-news-bar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .latest-news-label {
            background-color: #1a202c;
            padding: 0.25rem 0.75rem;
            border-radius: 0.375rem;
            display: inline-flex;
            align-items: center;
            white-space: nowrap;
            margin-left: 10px;
        }
        .latest-news-content {
            overflow: hidden;
            white-space: nowrap;
            animation: marquee 15s linear infinite;
        }
        .latest-news-content a {
            color: #fff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin: 0 10px;
            transition: color 0.3s;
        }
        .latest-news-content a:hover {
            color: #cbd5e0;
        }
        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        @media (max-width: 768px) {
           .latest-news-content {
               animation: none;
           }
           .latest-news-content a {
               margin: 5px;
           }

            .search-input {
              width: 100%;
              max-width: 250px;
            }
            
           .latest-news-bar .container {
              justify-content: center;
            }
           .latest-news-label {
              margin: 0 0 10px 0;
            }
        }

        /* Base Styles */
        body {
            font-family: 'Noto Kufi Arabic', sans-serif;
        }

        /* Dark mode styles */
        .dark .dark\:bg-slate-900 {
            background-color: rgb(15 23 42);
        }

        /* Breaking News Animation */
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        .animate-marquee {
            animation: marquee 20s linear infinite;
        }
    </style>
</head>
<body class="font-kufi bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-gray-100" x-data="{ mobileMenu: false }">
    <?php echo $__env->make('front.includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Breaking News Section -->
    <?php if($breaking_news = \App\Models\News::where('is_breaking', true)->where('status', 'published')->latest()->first()): ?>
    <div x-data="{ showBreakingNews: localStorage.getItem('hideBreakingNews_<?php echo e($breaking_news->id); ?>') !== 'true' }" 
         x-show="showBreakingNews" 
         class="fixed bottom-0 left-0 right-0 z-50">
        <div class="bg-red-600 shadow-lg">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6 space-x-reverse">
                        <span class="bg-white text-red-600 px-4 py-2 rounded-md font-bold text-base uppercase">خبر عاجل</span>
                        <a href="<?php echo e(route('front.news.show', $breaking_news->slug)); ?>" class="text-white hover:text-red-100 font-bold text-xl">
                            <?php echo e($breaking_news->title); ?>

                        </a>
                    </div>
                    <button @click="showBreakingNews = false; localStorage.setItem('hideBreakingNews_<?php echo e($breaking_news->id); ?>', 'true')" 
                            class="text-white hover:text-red-200 focus:outline-none p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="py-8">
        <div class="max-w-7xl mx-auto">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </main>

    <?php echo $__env->make('front.includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        function copyToClipboard(text) {
            // Create a temporary input element
            const input = document.createElement('input');
            input.style.position = 'fixed';
            input.style.opacity = 0;
            input.value = text;
            document.body.appendChild(input);
            
            // Select and copy the text
            input.select();
            input.setSelectionRange(0, 99999);
            document.execCommand('copy');
            
            // Remove the temporary input
            document.body.removeChild(input);
            
            // Show feedback to the user
            const button = document.querySelector('.copy-link-button');
            const originalText = button.textContent;
            button.textContent = 'تم النسخ!';
            
            setTimeout(() => {
                button.textContent = originalText;
            }, 2000);
        }

        function initializeDarkMode() {
            const darkModePreference = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (darkModePreference === 'dark' || (!darkModePreference && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');

            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            initializeDarkMode();

            const darkModeToggle = document.getElementById('darkModeToggle');
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', () => {
                    toggleDarkMode();
                    darkModeToggle.classList.add('scale-95');
                    setTimeout(() => {
                        darkModeToggle.classList.remove('scale-95');
                    }, 200);
                });
            }
        });

        initializeDarkMode();
    </script>

    <!-- Copy Text Script -->
    <script>
        document.addEventListener('copy', function(e) {
            // Get the selected text
            var selectedText = window.getSelection().toString();
            
            if(selectedText && selectedText.trim() !== '') {
                // Prevent the default copy behavior
                e.preventDefault();
                
                // Get the current URL or try to get the article URL if available
                var currentUrl = window.location.href;
                
                // Create the additional text to append
                var additionalText = '\n\nاقرأ المزيد : ' + currentUrl;
                
                // Add social media links if they exist in settings
                <?php if($site_settings->facebook_url): ?>
                additionalText += '\nصفحتنا على الفيس بوك <?php echo e($site_settings->facebook_url); ?>';
                <?php endif; ?>
                
                <?php if($site_settings->twitter_url): ?>
                additionalText += '\nصفحتنا على تويتر <?php echo e($site_settings->twitter_url); ?>';
                <?php endif; ?>

                // Set the modified text to the clipboard
                e.clipboardData.setData('text/plain', selectedText + additionalText);
            }
        });
    </script>
</body>
</html><?php /**PATH C:\xampp\htdocs\temp-laravel\resources\views/front/layouts/app.blade.php ENDPATH**/ ?>