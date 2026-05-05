@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Video Section Start -->
<section class="video-section relative py-16 lg:py-24 bg-gray-900 overflow-hidden" id="{{ $category->slug ?? 'video' }}">
    <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900"></div>

    <div class="container mx-auto px-4 relative z-10">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12">
            @if($category->name)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 text-primary-300 text-sm font-semibold rounded-full mb-4 wow fadeInUp">
                <x-heroicon-o-play class="w-4 h-4" />
                {{ $category->name }}
            </span>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle }}</h2>
            @endif
            @if($category->description)
            <p class="text-gray-400 text-lg wow fadeInUp" data-wow-delay="0.2s">{!! $category->description !!}</p>
            @endif
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-gray-500" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-300">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        @if($count === 1)
        {{-- Single Video Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-4xl mx-auto wow fadeInUp">
            <div class="relative rounded-2xl overflow-hidden aspect-video group cursor-pointer shadow-2xl">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800"></div>
                @endif
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors"></div>

                {{-- Play Button --}}
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-white/30 rounded-full animate-ping"></div>
                        <a href="{{ $post->metadata['link'] ?? '#' }}" class="relative w-20 h-20 lg:w-24 lg:h-24 bg-white rounded-full flex items-center justify-center shadow-2xl group-hover:scale-110 transition-transform duration-300" target="_blank">
                            <x-heroicon-s-play class="w-10 h-10 lg:w-12 lg:h-12 text-primary-600 translate-x-1" />
                        </a>
                    </div>
                </div>

                {{-- Title Overlay --}}
                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/80 to-transparent">
                    <h3 class="text-xl lg:text-2xl font-bold text-white">{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-300 mt-2">{{ $post->excerpt }}</p>
                    @endif
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Videos --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-5xl mx-auto">
            @foreach($posts as $post)
            <div class="relative rounded-xl overflow-hidden aspect-video group cursor-pointer shadow-xl wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800"></div>
                @endif
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors"></div>

                <div class="absolute inset-0 flex items-center justify-center">
                    <a href="{{ $post->metadata['link'] ?? '#' }}" class="w-16 h-16 bg-white/90 rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform" target="_blank">
                        <x-heroicon-s-play class="w-8 h-8 text-primary-600 translate-x-0.5" />
                    </a>
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 to-transparent">
                    <h3 class="text-lg font-bold text-white">{{ $post->title }}</h3>
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Videos - Featured Layout --}}
        @php $firstPost = $posts->first(); $restPosts = $posts->skip(1); @endphp
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
            {{-- Main Video --}}
            <div class="lg:col-span-2 relative rounded-xl overflow-hidden aspect-video group cursor-pointer shadow-xl wow fadeInUp">
                @if(!empty($firstPost->image))
                <img src="{{ asset($firstPost->image) }}" alt="{{ $firstPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800"></div>
                @endif
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors"></div>

                <div class="absolute inset-0 flex items-center justify-center">
                    <a href="{{ $firstPost->metadata['link'] ?? '#' }}" class="w-20 h-20 bg-white/90 rounded-full flex items-center justify-center shadow-xl group-hover:scale-110 transition-transform" target="_blank">
                        <x-heroicon-s-play class="w-10 h-10 text-primary-600 translate-x-0.5" />
                    </a>
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-5 bg-gradient-to-t from-black/80 to-transparent">
                    <span class="inline-block px-3 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full mb-2">Featured</span>
                    <h3 class="text-xl font-bold text-white">{{ $firstPost->title }}</h3>
                </div>
            </div>

            {{-- Side Videos --}}
            <div class="flex flex-row lg:flex-col gap-4">
                @foreach($restPosts as $post)
                <div class="flex-1 relative rounded-lg overflow-hidden aspect-video lg:aspect-auto group cursor-pointer shadow-lg wow fadeInUp" data-wow-delay="{{ ($loop->index + 2) * 0.1 }}s">
                    @if(!empty($post->image))
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800"></div>
                    @endif
                    <div class="absolute inset-0 bg-black/50 group-hover:bg-black/40 transition-colors"></div>

                    <div class="absolute inset-0 flex items-center justify-center">
                        <a href="{{ $post->metadata['link'] ?? '#' }}" class="w-12 h-12 bg-white/90 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform" target="_blank">
                            <x-heroicon-s-play class="w-6 h-6 text-primary-600 translate-x-0.5" />
                        </a>
                    </div>

                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent">
                        <h3 class="text-sm font-semibold text-white truncate">{{ $post->title }}</h3>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @else
        {{-- Four+ Videos - Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($posts as $post)
            <div class="relative rounded-lg overflow-hidden aspect-video group cursor-pointer shadow-lg wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.08 }}s">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                    <x-heroicon-o-video-camera class="w-10 h-10 text-gray-600" />
                </div>
                @endif
                <div class="absolute inset-0 bg-black/50 group-hover:bg-black/30 transition-colors"></div>

                <div class="absolute inset-0 flex items-center justify-center">
                    <a href="{{ $post->metadata['link'] ?? '#' }}" class="w-10 h-10 bg-white/90 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform" target="_blank">
                        <x-heroicon-s-play class="w-5 h-5 text-primary-600 translate-x-0.5" />
                    </a>
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/80 to-transparent">
                    <h3 class="text-xs font-semibold text-white truncate">{{ $post->title }}</h3>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Video Section End -->
@endif
