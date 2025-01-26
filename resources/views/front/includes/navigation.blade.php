<nav x-data="{ scrolled: false, mobileMenu: false, openCategory: null }"
     @scroll.window="scrolled = (window.pageYOffset > 100)"
     :class="{'shadow-xl': scrolled}"
     class="bg-gradient-to-l from-primary-800 via-primary-700 to-primary-800 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 sticky top-0 z-50 transition-all duration-300 border-b border-white/10">

    <div class="container mx-auto px-4">
        <div class="flex items-center h-16 justify-between lg:justify-start">
            <!-- Mobile Menu Button (Right) -->
            <div class="lg:hidden">
                <button @click="mobileMenu = !mobileMenu"
                        class="inline-flex items-center justify-center p-2 rounded-lg text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20 transition-all duration-300">
                    <i class="fas" :class="mobileMenu ? 'fa-times' : 'fa-bars'"></i>
                </button>
            </div>

            <!-- Center Logo for Mobile -->
            <div class="lg:hidden flex justify-center"
                 x-cloak
                 x-show="scrolled"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100">
                <a href="{{ route('front.home') }}" class="flex items-center">
                    @if($site_settings && $site_settings->site_logo)
                        <img src="{{ url('storage/' . $site_settings->site_logo) }}"
                             alt="{{ $site_settings->site_name }}"
                             class="h-8 w-auto">
                    @else
                        <img src="{{ asset('front/images/default-logo.png') }}"
                             alt="شعار الموقع"
                             class="h-8 w-auto">
                    @endif
                </a>
            </div>

            <!-- Empty div for Mobile (to maintain center alignment) -->
            <div class="lg:hidden w-10" x-show="scrolled"></div>

            <!-- Left Side: Logo and Menu (Desktop) -->
            <div class="hidden lg:flex flex-1 items-center justify-start">
                <div class="flex items-center space-x-6 justify-start">
                    <!-- Logo -->
                    <div class="flex-shrink-0 hover:opacity-90 transition-opacity duration-300"
                         x-cloak
                         x-show="scrolled"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100">
                        <a href="{{ route('front.home') }}" class="flex items-center">
                            @if($site_settings && $site_settings->site_logo)
                                <img src="{{ url('storage/' . $site_settings->site_logo) }}"
                                     alt="{{ $site_settings->site_name }}"
                                     class="h-8 w-auto">
                            @else
                                <img src="{{ asset('front/images/default-logo.png') }}"
                                     alt="شعار الموقع"
                                     class="h-8 w-auto">
                            @endif
                        </a>
                    </div>

                    <!-- Menu Items -->
                    <div :class="{'space-x-6': scrolled, 'space-x-2': !scrolled}"
                         class="flex items-center transition-all duration-300 justify-start">
                        <a href="{{ route('front.home') }}"
                           class="text-white hover:text-white/90 px-3 py-2 rounded-lg transition-all duration-300 text-[15px] font-medium relative hover:bg-white/10
                                  {{ request()->routeIs('front.home') ? 'bg-white/15' : '' }}">
                            الرئيسية
                        </a>
                        @foreach($categories as $category)
                            <div class="relative group">
                                <a href="{{ route('front.category', $category->id) }}"
                                   class="inline-flex items-center text-white/90 hover:text-white px-4 py-2 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10
                                          {{ request()->segment(2) == $category->id ? 'bg-white/15' : '' }}">
                                    <span>{{ $category->name }}</span>
                                    @if($category->children && $category->children->count() > 0)
                                        <i class="fas fa-chevron-down mr-1.5 text-[10px] opacity-75 transition-transform duration-300 group-hover:rotate-180"></i>
                                    @endif
                                </a>
                                @if($category->children && $category->children->count() > 0)
                                    <div class="hidden group-hover:block absolute top-full right-0 mt-1 py-2 bg-white dark:bg-gray-800 rounded-lg shadow-xl z-50 min-w-[220px] border border-gray-100 dark:border-gray-700 transform opacity-0 group-hover:opacity-100 transition-all duration-300">
                                        @foreach($category->children as $child)
                                            <a href="{{ route('front.category', $child->id) }}"
                                               class="block px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-primary-50 dark:hover:bg-gray-700 transition-all duration-300 text-[15px] hover:text-primary-600
                                                      {{ request()->segment(2) == $child->id ? 'bg-primary-50/50 dark:bg-gray-700/50' : '' }}">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <a href="{{ route('front.opinions') }}"
                           class="text-white/90 hover:text-white px-4 py-2 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10
                                  {{ request()->routeIs('front.opinions') ? 'bg-white/15' : '' }}">
                            مقالات الرأي
                        </a>
                        <a href="{{ route('front.videos.index') }}"
                           class="text-white/90 hover:text-white px-4 py-2 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10 flex items-center gap-2
                                  {{ request()->routeIs('front.videos.*') ? 'bg-white/15' : '' }}">
                            <i class="fas fa-play text-xs"></i>
                            <span>الفيديوهات</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-cloak
         x-show="mobileMenu"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="lg:hidden border-t border-white/10">
        <div class="container mx-auto px-4 py-2 space-y-1">
            <a href="{{ route('front.home') }}"
               class="flex items-center text-white/90 hover:text-white px-4 py-3 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10
                      {{ request()->routeIs('front.home') ? 'bg-white/15' : '' }}">
                <i class="fas fa-home ml-3 text-sm"></i>
                <span>الرئيسية</span>
            </a>
            @foreach($categories as $category)
                <div class="relative">
                    <div class="flex items-center justify-between text-white/90 hover:text-white px-4 py-3 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10
                              {{ request()->segment(2) == $category->id ? 'bg-white/15' : '' }}">
                        <a href="{{ route('front.category', $category->id) }}"
                           class="flex items-center flex-grow">
                           <i class="fas fa-folder ml-3 text-sm opacity-75"></i>
                           <span>{{ $category->name }}</span>
                        </a>
                        @if($category->children && $category->children->count() > 0)
                            <button @click.prevent="openCategory = openCategory === {{ $category->id }} ? null : {{ $category->id }}"
                                    class="p-2 -ml-2 focus:outline-none focus:ring-2 focus:ring-white/20 rounded-lg">
                                <i class="fas fa-chevron-down text-xs opacity-75 transition-transform duration-300"
                                   :class="{ 'rotate-180': openCategory === {{ $category->id }} }"></i>
                            </button>
                        @endif
                    </div>
                    @if($category->children && $category->children->count() > 0)
                        <div x-show="openCategory === {{ $category->id }}"
                             x-collapse
                             x-cloak
                             class="pr-4 space-y-1 mt-1 border-r-2 border-primary-500/30 mr-6">
                            @foreach($category->children as $child)
                                <a href="{{ route('front.category', $child->id) }}"
                                   class="flex items-center text-white/80 hover:text-white px-4 py-2.5 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10
                                          {{ request()->segment(2) == $child->id ? 'bg-white/15' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-primary-500/50 ml-3"></span>
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
            <a href="{{ route('front.opinions') }}"
               class="flex items-center text-white/90 hover:text-white px-4 py-3 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10
                      {{ request()->routeIs('front.opinions') ? 'bg-white/15' : '' }}">
                <i class="fas fa-pen-fancy ml-3 text-sm"></i>
                <span>مقالات الرأي</span>
            </a>
            <a href="{{ route('front.videos.index') }}"
               class="flex items-center text-white/90 hover:text-white px-4 py-3 text-[15px] font-medium tracking-wide transition-all duration-300 rounded-lg hover:bg-white/10
                      {{ request()->routeIs('front.videos.*') ? 'bg-white/15' : '' }}">
                <i class="fas fa-play ml-3 text-sm"></i>
                <span>الفيديوهات</span>
            </a>
        </div>
    </div>
</nav>