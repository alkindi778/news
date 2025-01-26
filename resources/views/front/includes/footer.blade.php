<footer class="bg-gradient-to-b from-primary-900 to-primary-800 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div class="footer-section">
                <div class="mb-6">
                    @if($site_settings && $site_settings->site_logo)
                        <img src="{{ url('storage/' . $site_settings->site_logo) }}"
                            alt="{{ $site_settings->site_name }}"
                            class="h-auto w-full max-w-[200px]">
                    @else
                        <h2 class="text-3xl font-bold">{{ $site_settings->site_name }}</h2>
                    @endif
                </div>
                <p class="text-gray-300 leading-relaxed mb-6">
                    {{ $site_settings->site_description }}
                </p>
                <div class="flex space-x-4 rtl:space-x-reverse">
                    @foreach(['facebook' => '#1877f2', 'twitter' => '#1da1f2', 'instagram' => '#e4405f', 'youtube' => '#ff0000'] as $platform => $color)
                        @if($site_settings->{$platform . '_url'})
                            <a href="{{ $site_settings->{$platform . '_url'} }}" target="_blank" class="social-icon" style="background-color: {{ $color }};">
                                <i class="fab fa-{{ $platform }} fa-lg"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            <style>
                .social-icon {
                    width: 40px;
                    height: 40px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    color: white;
                    transition: all 0.3s ease;
                }
                .social-icon:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                }
            </style>

            <div class="footer-section">
                <h3 class="text-xl font-semibold mb-6 border-b border-primary-700 pb-2">روابط سريعة</h3>
                <ul class="space-y-3">
                    @foreach(['about' => 'من نحن', 'contact' => 'اتصل بنا', 'privacy' => 'سياسة الخصوصية', 'terms' => 'شروط الاستخدام', 'editorial-board' => 'هيئة التحرير'] as $route => $title)
                        <li>
                            <a href="{{ route('front.' . $route) }}" class="hover:text-primary-300 transition-colors duration-300">
                                <i class="fas fa-chevron-left ml-2 text-sm"></i>{{ $title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="footer-section">
                <h3 class="text-xl font-semibold mb-6 border-b border-primary-700 pb-2">أحدث الأخبار</h3>
                <div class="space-y-4">
                    @foreach($latestNews->take(3) as $news)
                        <a href="{{ route('front.news', $news->id) }}" class="flex items-center group">
                            <div class="w-16 h-16 bg-primary-700 rounded-lg overflow-hidden flex-shrink-0">
                                @if($news->image)
                                    <img src="{{ url('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-primary-300">
                                        <i class="fas fa-newspaper fa-lg"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mr-4 flex-grow">
                                <h4 class="text-sm font-medium group-hover:text-primary-300 transition-colors duration-300">{{ Str::limit($news->title, 50) }}</h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="footer-section">
                <h3 class="text-xl font-semibold mb-6 border-b border-primary-700 pb-2">خريطة الأقسام</h3>
                <ul class="grid grid-cols-2 gap-4">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('front.category', $category->id) }}" class="hover:text-primary-300 transition-colors duration-300">
                                <i class="fas fa-folder ml-2 text-sm"></i>{{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-primary-700 flex flex-col sm:flex-row justify-between items-center bg-primary-800 p-4 rounded-lg">
            <div class="text-gray-300 mb-4 sm:mb-0 order-2 sm:order-1">
                <p>تصميم وتطوير: <a href="https://www.facebook.com/a.a.alkindi/" target="_blank" class="hover:text-primary-300 transition-colors duration-300">abdusalam altowi</a></p>
            </div>
            <div class="text-gray-300 order-1 sm:order-2">
                <p>جميع الحقوق محفوظة © {{ date('Y') }} {{ $site_settings->site_name }}</p>
            </div>
        </div>
    </div>
</footer>