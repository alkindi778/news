@if(count($sliderNews) > 0)
<div class="relative mb-4 md:mb-8" 
     x-data="{ 
        currentSlide: 0,
        autoAdvance: null,
        touchStartX: 0,
        touchEndX: 0,
        startAutoAdvance() {
            this.autoAdvance = setInterval(() => {
                this.nextSlide();
            }, 5000);
        },
        stopAutoAdvance() {
            if (this.autoAdvance) clearInterval(this.autoAdvance);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide === {{ count($sliderNews) - 1 }}) ? 0 : this.currentSlide + 1;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide === 0) ? {{ count($sliderNews) - 1 }} : this.currentSlide - 1;
        },
        handleTouchStart(e) {
            this.touchStartX = e.touches[0].clientX;
            this.stopAutoAdvance();
        },
        handleTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].clientX;
            const swipeDistance = this.touchEndX - this.touchStartX;
            
            if (Math.abs(swipeDistance) > 50) { // الحد الأدنى للسحب
                if (swipeDistance > 0) {
                    this.nextSlide(); // سحب لليمين - السلايد التالي
                } else {
                    this.prevSlide(); // سحب لليسار - السلايد السابق
                }
            }
            this.startAutoAdvance();
        }
     }" 
     x-init="startAutoAdvance()"
     @mouseleave="startAutoAdvance()"
     @mouseenter="stopAutoAdvance()"
     @touchstart="handleTouchStart($event)"
     @touchend="handleTouchEnd($event)">
    
    <!-- Main Slider -->
    <div class="relative overflow-hidden rounded-lg">
        <div class="flex transition-transform duration-500 ease-in-out" 
             :style="{ transform: `translateX(${currentSlide * 100}%)` }">
            @foreach($sliderNews as $index => $news)
                <div class="w-full flex-shrink-0">
                    <div class="relative h-[400px] sm:h-[500px]">
                        <img src="{{ url('storage/' . $news->image) }}" 
                             alt="{{ $news->title }}"
                             class="w-full h-full object-fill">
                        
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                        
                        <!-- Content -->
                        <div class="absolute bottom-4 sm:bottom-6 right-0 p-3 sm:p-8 text-white w-full" style="direction: rtl;">
                            @if($news->category)
                                <a href="{{ route('front.category', $news->category->slug) }}" 
                                   class="inline-block bg-red-600 text-white px-2 py-1 sm:px-4 sm:py-1.5 text-xs sm:text-sm mb-2 sm:mb-4 hover:bg-red-700 transition-colors duration-200 rounded-md">
                                    {{ $news->category->name }}
                                </a>
                            @endif
                            
                            @if($news->subtitle)
                            <div class="mb-2 sm:mb-3">
                                <p class="inline-block bg-gradient-to-l from-primary-600/90 to-primary-800/90 backdrop-blur-sm text-white/95 px-4 sm:px-6 py-2 sm:py-3 rounded-lg text-sm sm:text-base leading-relaxed">
                                    {{ $news->subtitle }}
                                </p>
                            </div>
                            @endif

                            <h2 class="text-lg sm:text-2xl md:text-3xl font-bold mb-8 sm:mb-10 line-clamp-2 sm:line-clamp-3">
                                <a href="{{ route('front.news', $news->id) }}" class="hover:text-primary-500 transition-colors duration-200">
                                    {{ $news->title }}
                                </a>
                            </h2>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Buttons -->
        <button @click="stopAutoAdvance(); prevSlide()"
                class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/50 text-white hover:bg-black/70 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-600">
            <i class="fas fa-chevron-right text-sm sm:text-xl"></i>
        </button>
        
        <button @click="stopAutoAdvance(); nextSlide()"
                class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 w-8 h-8 sm:w-12 sm:h-12 flex items-center justify-center rounded-full bg-black/50 text-white hover:bg-black/70 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-600">
            <i class="fas fa-chevron-left text-sm sm:text-xl"></i>
        </button>

        <!-- Numbered Navigation -->
        <div class="absolute bottom-0 left-0 right-0 bg-black/50">
            <div class="flex items-center justify-center">
                @foreach($sliderNews as $index => $news)
                    <button @click="currentSlide = {{ $index }}"
                            class="px-2 sm:px-4 py-2 text-xs sm:text-sm text-white/80 hover:text-white transition-colors duration-200"
                            :class="{ 'text-red-500 font-bold': currentSlide === {{ $index }} }">
                        {{ $index + 1 }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif