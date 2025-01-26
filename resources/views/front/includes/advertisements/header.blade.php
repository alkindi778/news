@php
    $headerAd = \App\Models\Advertisement::where('position', 'header')
        ->where('status', 'active')
        ->where('start_date', '<=', now())
        ->where(function($query) {
            $query->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
        })
        ->inRandomOrder()
        ->first();
@endphp

@if($headerAd)
    <div class="header-ad">
        @if($headerAd->url)
            <a href="{{ $headerAd->url }}" target="_blank" class="block">
                <img src="{{ asset('storage/' . $headerAd->image_path) }}" 
                     alt="{{ $headerAd->name }}" 
                     class="max-w-full h-auto mx-auto">
            </a>
        @else
            <img src="{{ asset('storage/' . $headerAd->image_path) }}" 
                 alt="{{ $headerAd->name }}" 
                 class="max-w-full h-auto mx-auto">
        @endif
    </div>
@endif
