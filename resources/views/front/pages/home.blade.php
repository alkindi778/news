@extends('front.layouts.app')

@section('title')الرئيسية@endsection

@section('content')
<div class="container mx-auto px-4 py-8">
    @php
        $betweenSectionsAds = App\Models\Advertisement::where('position', 'between_sections')
            ->where('active', true)
            ->latest()
            ->get();
        $adIndex = 0;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-8">
            @include('front.includes.slider')
            
            <!-- Newspaper Cover for Mobile -->
            <div class="lg:hidden mb-8">
                @include('front.includes.sidebar_cover')
            </div>
            
            <!-- All Sections -->
            <div id="sortable-sections" class="flex flex-wrap -mx-3">
                @foreach($sections as $index => $section)
                    @if($section->template === 'featured_with_list')
                        @include('front.sections.templates.featured_with_list', [
                            'section' => $section,
                            'news_items' => $section->getContent()
                        ])
                    @else
                        <div class="w-full px-3 mb-6">
                            @include('front.sections.templates.' . $section->template, [
                                'section' => $section,
                                'news_items' => $section->getContent()
                            ])
                        </div>
                    @endif

                    {{-- Show Advertisement between sections, one ad per position --}}
                    @if($index < count($sections) - 1 && isset($betweenSectionsAds[$adIndex]))
                        <div class="w-full px-3 mb-6">
                            @if($betweenSectionsAds[$adIndex]->code)
                                {!! $betweenSectionsAds[$adIndex]->code !!}
                            @elseif($betweenSectionsAds[$adIndex]->image)
                                <a href="{{ $betweenSectionsAds[$adIndex]->url }}" target="_blank" class="block">
                                    <img src="{{ url('storage/' . $betweenSectionsAds[$adIndex]->image) }}" 
                                         alt="{{ $betweenSectionsAds[$adIndex]->title }}"
                                         class="w-full h-auto rounded-lg">
                                </a>
                            @endif
                        </div>
                        @php $adIndex++; @endphp
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Desktop Sidebar -->
            <div class="hidden lg:block">
                @include('front.includes.sidebar_cover')
            </div>
            
            <!-- Sidebar Content (Visible on all devices) -->
            @include('front.includes.sidebar')
        </div>
    </div>
</div>
@endsection

@push('scripts')
@auth
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sortableList = document.getElementById('sortable-sections');
            if (sortableList) {
                new Sortable(sortableList, {
                    animation: 150,
                    ghostClass: 'bg-blue-100',
                    handle: '.section-handle',
                    onEnd: function(evt) {
                        const items = [...evt.to.children].map((el, index) => ({
                            id: el.dataset.id,
                            order: index
                        }));

                        fetch('/admin/sections/reorder', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ items })
                        });
                    }
                });
            }
        });
    </script>
@endauth
@endpush