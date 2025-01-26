@php
    $headerAd = App\Models\Advertisement::where('position', 'header')
        ->where('active', true)
        ->latest()
        ->first();
@endphp

@if($headerAd)
    <div class="flex-grow flex justify-center px-4">
        <a href="{{ $headerAd->link }}" target="_blank" class="block" title="{{ $headerAd->title }}">
            <img src="{{ asset('storage/' . $headerAd->image) }}" 
                 alt="{{ $headerAd->title }}" 
                 class="h-16 w-auto object-contain">
        </a>
    </div>
@endif
