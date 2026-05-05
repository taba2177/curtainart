@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Brands/Clients Logo Section Start -->
<section class="brands-section relative py-12 lg:py-16 bg-white" id="{{ $category->slug ?? 'brands' }}">
    <div class="container mx-auto px-4">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-10">
            @if($category->name)
            <span class="inline-block text-sm text-gray-500 font-medium uppercase tracking-wider mb-2 wow fadeInUp">{{ $category->name }}</span>
            @endif
            @if($category->subtitle)
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle }}</h2>
            @endif
            @auth
            <div class="flex items-center justify-center mt-3">
                <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-gray-400" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        @if($count <= 4)
        {{-- Few Brands - Static Display --}}
        <div class="flex flex-wrap items-center justify-center gap-8 lg:gap-12">
            @foreach($posts as $post)
            <div class="group wow fadeIn" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="h-12 lg:h-16 w-auto object-contain filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100 transition-all duration-300">
                @else
                <div class="px-6 py-3 bg-gray-100 rounded-lg">
                    <span class="text-gray-600 font-semibold">{{ $post->title }}</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        @elseif($count <= 8)
        {{-- Medium Brands - Two Rows --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8 items-center">
            @foreach($posts as $post)
            <div class="flex items-center justify-center p-4 group wow fadeIn" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.1 }}s">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="h-10 lg:h-14 w-auto max-w-full object-contain filter grayscale group-hover:grayscale-0 opacity-50 group-hover:opacity-100 transition-all duration-300">
                @else
                <div class="px-4 py-2 bg-gray-50 rounded-lg border border-gray-100 group-hover:border-primary-200 group-hover:bg-primary-50 transition-colors">
                    <span class="text-gray-500 group-hover:text-primary-600 font-medium text-sm">{{ $post->title }}</span>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        @else
        {{-- Many Brands - Auto-Scrolling Marquee --}}
        <div class="relative overflow-hidden">
            {{-- Gradient Overlays --}}
            <div class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none"></div>

            {{-- Marquee Container --}}
            <div class="flex animate-marquee space-x-12 rtl:space-x-reverse py-4">
                @foreach($posts as $post)
                <div class="flex-shrink-0 group">
                    @if(!empty($post->image))
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="h-10 lg:h-12 w-auto object-contain filter grayscale group-hover:grayscale-0 opacity-50 group-hover:opacity-100 transition-all duration-300">
                    @else
                    <div class="px-4 py-2 bg-gray-50 rounded-lg whitespace-nowrap">
                        <span class="text-gray-500 font-medium text-sm">{{ $post->title }}</span>
                    </div>
                    @endif
                </div>
                @endforeach
                {{-- Duplicate for seamless loop --}}
                @foreach($posts as $post)
                <div class="flex-shrink-0 group">
                    @if(!empty($post->image))
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="h-10 lg:h-12 w-auto object-contain filter grayscale group-hover:grayscale-0 opacity-50 group-hover:opacity-100 transition-all duration-300">
                    @else
                    <div class="px-4 py-2 bg-gray-50 rounded-lg whitespace-nowrap">
                        <span class="text-gray-500 font-medium text-sm">{{ $post->title }}</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- Marquee Animation Styles --}}
        <style>
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            [dir="rtl"] @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(50%); }
            }
            .animate-marquee {
                animation: marquee 30s linear infinite;
            }
            .animate-marquee:hover {
                animation-play-state: paused;
            }
        </style>
        @endif
    </div>
</section>
<!-- Brands/Clients Logo Section End -->
@endif
