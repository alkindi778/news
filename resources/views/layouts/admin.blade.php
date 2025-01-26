<!DOCTYPE html>
<html lang="ar" dir="rtl" class="dark:bg-gray-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>لوحة التحكم - {{ config('app.name') }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
    
    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap');
        body {
            font-family: 'Tajawal', sans-serif;
        }
        
        /* تخصيص شريط التمرير */
        ::-webkit-scrollbar {
            width: 5px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        
        /* تحسين المظهر على الهواتف */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-right: 0 !important;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body class="bg-[#F4F6F9] dark:bg-gray-900" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-600 bg-opacity-75 z-20 lg:hidden"
             @click="sidebarOpen = false">
        </div>

        @include('admin.sidebar.sidebar')

        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto lg:mr-64 relative">
            <!-- Top Navigation -->
            <nav class="bg-white dark:bg-gray-800 shadow-md border-b border-gray-200 dark:border-gray-700">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button @click="sidebarOpen = !sidebarOpen" 
                                    class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-red-500">
                                <span class="sr-only">فتح القائمة</span>
                                <i class="fas fa-bars text-xl"></i>
                            </button>

                            <!-- Breadcrumb - Show on larger screens -->
                            <div class="hidden md:flex items-center mr-4 text-sm text-gray-600 dark:text-gray-400">
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600 dark:hover:text-red-400">
                                    <i class="fas fa-home"></i>
                                    <span class="mx-1">الرئيسية</span>
                                </a>
                                @hasSection('breadcrumb')
                                    <span class="mx-2">/</span>
                                    @yield('breadcrumb')
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 space-x-reverse">
                            <!-- Dark Mode Toggle -->
                            <button id="darkModeToggle" 
                                    class="p-2 text-gray-500 hover:text-gray-600 dark:text-gray-400 dark:hover:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <i class="fas fa-moon text-xl dark:hidden"></i>
                                <i class="fas fa-sun text-xl hidden dark:block"></i>
                            </button>

                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        type="button"
                                        class="flex items-center text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 px-3 py-2 transition-colors duration-200">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random" 
                                         alt="{{ auth()->user()->name }}"
                                         class="h-8 w-8 rounded-full object-cover">
                                    <span class="mx-2 text-sm">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-sm"></i>
                                </button>
                                <!-- Dropdown Menu -->
                                <div x-show="open"
                                     x-cloak
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute left-0 mt-2 w-64 rounded-xl shadow-xl bg-white dark:bg-gray-800 ring-1 ring-black/5 divide-y divide-gray-100 dark:divide-gray-700 z-50 transform origin-top">
                                    
                                    <!-- User Info Section -->
                                    <div class="px-4 py-3">
                                        <p class="text-sm leading-5 text-gray-500 dark:text-gray-400">مرحباً بك</p>
                                        <p class="text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 truncate">
                                            {{ auth()->user()->name }}
                                        </p>
                                    </div>

                                    <!-- Menu Items -->
                                    <div class="py-1">
                                        <a href="{{ route('admin.profile.index') }}" 
                                           class="group flex items-center px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-150">
                                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-400 group-hover:bg-primary-50 group-hover:text-primary-600 dark:group-hover:bg-gray-600 dark:group-hover:text-primary-400 ml-3 transition-all duration-150">
                                                <i class="fas fa-user-circle"></i>
                                            </span>
                                            <div>
                                                <span class="block font-medium">الملف الشخصي</span>
                                                <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5">إدارة حسابك الشخصي</span>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Logout Section -->
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="group flex w-full items-center px-4 py-2.5 text-sm hover:bg-red-50 dark:hover:bg-red-500/10 transition-all duration-150">
                                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 dark:bg-red-500/20 text-red-400 group-hover:bg-red-100 dark:group-hover:bg-red-500/30 ml-3 transition-all duration-150">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </span>
                                                <div>
                                                    <span class="block font-medium text-red-600 dark:text-red-400">تسجيل الخروج</span>
                                                    <span class="block text-xs text-red-500/70 dark:text-red-400/70 mt-0.5">إنهاء الجلسة الحالية</span>
                                                </div>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="py-6">
                <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-[#F4F6F9] dark:bg-gray-900">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const htmlElement = document.documentElement;
        
        // Function to update dark mode UI
        function updateDarkMode(isDark) {
            if (isDark) {
                htmlElement.classList.add('dark');
                localStorage.setItem('darkMode', 'true');
            } else {
                htmlElement.classList.remove('dark');
                localStorage.setItem('darkMode', 'false');
            }
        }

        if (darkModeToggle) {
            // Toggle dark mode on button click
            darkModeToggle.addEventListener('click', function() {
                const isDark = !htmlElement.classList.contains('dark');
                updateDarkMode(isDark);
            });

            // Check for saved dark mode preference
            const savedDarkMode = localStorage.getItem('darkMode');
            if (savedDarkMode === 'true') {
                updateDarkMode(true);
            } else if (savedDarkMode === 'false') {
                updateDarkMode(false);
            } else {
                // If no preference is saved, use system preference
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                updateDarkMode(prefersDark);
                
                // Listen for system dark mode changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    if (localStorage.getItem('darkMode') === null) {
                        updateDarkMode(e.matches);
                    }
                });
            }
        }
    </script>
    <script>
        // استخدام MutationObserver بدلاً من DOMNodeInserted
        document.addEventListener('DOMContentLoaded', function() {
            const config = { 
                childList: true, 
                subtree: true 
            };

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach(function(node) {
                            if (node.nodeType === 1) {
                                initializeScrollBehavior(node);
                            }
                        });
                    }
                });
            });

            observer.observe(document.body, config);

            function initializeScrollBehavior(element) {
                const scrollElements = element.querySelectorAll('[data-scroll]');
                scrollElements.forEach(function(el) {
                    el.addEventListener('click', function(e) {
                        e.preventDefault();
                        const targetId = this.getAttribute('href');
                        const targetElement = document.querySelector(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });
            }

            initializeScrollBehavior(document.body);
        });
    </script>
    @stack('scripts')
</body>
</html>