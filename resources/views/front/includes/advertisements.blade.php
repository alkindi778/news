@php
    if (!isset($position)) {
        $position = 'header';
    }

    $ads = App\Models\Advertisement::where('position', $position)
        ->where('active', true)
        ->latest()
        ->get();
@endphp

@if($ads->isNotEmpty())
    @if($position === 'header')
        <div class="w-full bg-white dark:bg-gray-800 shadow-sm mb-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($ads as $ad)
                        @if($ad->image_url)
                            <div class="relative overflow-hidden rounded-lg transition-transform hover:scale-[1.02]">
                                <a href="{{ $ad->link }}" target="_blank" class="block" title="{{ $ad->title }}">
                                    <img src="{{ $ad->image_url }}" 
                                         alt="{{ $ad->title }}" 
                                         class="w-full h-auto object-cover rounded-lg">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @elseif($position === 'sidebar')
        <div class="space-y-4">
            @foreach($ads as $ad)
                @if($ad->image_url)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm overflow-hidden transition-transform hover:scale-[1.02]">
                        <a href="{{ $ad->link }}" target="_blank" class="block" title="{{ $ad->title }}">
                            <img src="{{ $ad->image_url }}" 
                                 alt="{{ $ad->title }}" 
                                 class="w-full h-auto object-cover">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    @elseif($position === 'footer')
        <div class="w-full bg-white dark:bg-gray-800 shadow-sm mt-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($ads as $ad)
                        @if($ad->image_url)
                            <div class="relative overflow-hidden rounded-lg transition-transform hover:scale-[1.02]">
                                <a href="{{ $ad->link }}" target="_blank" class="block" title="{{ $ad->title }}">
                                    <img src="{{ $ad->image_url }}" 
                                         alt="{{ $ad->title }}" 
                                         class="w-full h-auto object-cover rounded-lg">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endif
