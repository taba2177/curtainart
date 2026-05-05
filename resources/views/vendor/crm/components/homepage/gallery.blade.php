@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Gallery/Portfolio Section Start -->
<section class="gallery-section relative py-16 lg:py-24 bg-gray-900" id="{{ $category->slug ?? 'gallery' }}">
    <div class="container mx-auto px-4">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            @if($category->name)
            <span
                class="inline-block px-4 py-1.5 bg-white/10 text-primary-300 text-sm font-semibold rounded-full mb-4 wow fadeInUp">{{ $category->name }}</span>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 wow fadeInUp" data-wow-delay="0.1s">
                {{ $category->subtitle }}</h2>
            @endif
            @if($category->description)
            <p class="text-gray-400 text-lg wow fadeInUp" data-wow-delay="0.2s">{!! $category->description !!}</p>
            @endif
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-gray-500" />
                <a href="{{ $category->editUrl ?? '#' }}"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-300">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        @if($count === 1)
        {{-- Single Image Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-4xl mx-auto wow fadeInUp">
            <div class="relative rounded-2xl overflow-hidden group cursor-pointer aspect-video">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                <div class="w-full h-full bg-gradient-to-br from-primary-600 to-secondary-600"></div>
                @endif
                <div
                    class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div
                        class="text-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                        <div
                            class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center mx-auto mb-4">
                            <x-icon name="heroicon-o-magnifying-glass-plus" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-white">{{ $post->title }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($post->images))
        {{ dd($post->images) }}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 lg:gap-3">
            @foreach($post->images as $image)
            <div class="relative rounded-lg overflow-hidden group cursor-pointer @if($loop->first) md:col-span-2 md:row-span-2 @endif aspect-square wow fadeInUp"
                data-wow-delay="{{ (($loop->index % 4) + 1) * 0.08 }}s">
                <img src="{{ asset($image?->url) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                    <x-icon name="heroicon-o-photo" class="w-12 h-12 text-gray-600" />
                </div>
                @endif
                <div
                    class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <x-icon name="heroicon-o-magnifying-glass-plus" class="w-8 h-8 text-white" />
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent">
                        <h4 class="text-white text-sm font-medium truncate">{{ $post->title }}</h4>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
        @elseif($count === 2)
        {{-- Two Images Side by Side --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
            @foreach($posts as $post)
            <div class="relative rounded-xl overflow-hidden group cursor-pointer aspect-[4/3] wow fadeInUp"
                data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                <div class="w-full h-full bg-gradient-to-br from-primary-600 to-secondary-600"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent">
                    <div class="absolute bottom-0 left-0 right-0 p-6">
                        <h3 class="text-lg font-bold text-white mb-1">{{ $post->title }}</h3>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-300 text-sm">{{ $post->excerpt }}</p>
                        @endif
                    </div>
                </div>
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                        <x-icon name="heroicon-o-magnifying-glass-plus" class="w-5 h-5 text-white" />
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Featured Layout - 1 Large + 2 Small --}}
        @php $firstPost = $posts->first(); $restPosts = $posts->skip(1); @endphp
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
            <div
                class="relative rounded-xl overflow-hidden group cursor-pointer aspect-square lg:aspect-auto lg:row-span-2 wow fadeInUp">
                @if(!empty($firstPost->image))
                <img src="{{ asset($firstPost->image) }}" alt="{{ $firstPost->title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                @else
                <div class="w-full h-full bg-gradient-to-br from-primary-600 to-secondary-600"></div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent">
                    <div class="absolute bottom-0 left-0 right-0 p-6 lg:p-8">
                        <span
                            class="inline-block px-3 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full mb-3">Featured</span>
                        <h3 class="text-xl lg:text-2xl font-bold text-white mb-2">{{ $firstPost->title }}</h3>
                        @if(!empty($firstPost->excerpt))
                        <p class="text-gray-300">{{ $firstPost->excerpt }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                @foreach($restPosts as $post)
                <div class="relative rounded-xl overflow-hidden group cursor-pointer aspect-square wow fadeInUp"
                    data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                    @if(!empty($post->image))
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-secondary-600 to-primary-600"></div>
                    @endif
                    <div
                        class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="text-center">
                            <x-icon name="heroicon-o-magnifying-glass-plus" class="w-8 h-8 text-white mx-auto" />
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent">
                        <h4 class="text-white text-sm font-semibold truncate">{{ $post->title }}</h4>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @elseif($count >= 4 && $count <= 6) {{-- Masonry Grid --}} <div
            class="grid grid-cols-2 md:grid-cols-3 gap-3 lg:gap-4">
            @foreach($posts as $post)
            <div class="relative rounded-lg overflow-hidden group cursor-pointer @if($loop->first || $loop->index === 3) md:row-span-2 aspect-auto md:aspect-[3/4] @else aspect-square @endif wow fadeInUp"
                data-wow-delay="{{ (($loop->index % 3) + 1) * 0.1 }}s">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800"></div>
                @endif
                <div
                    class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <div class="text-center transform scale-90 group-hover:scale-100 transition-transform duration-300">
                        <x-icon name="heroicon-o-magnifying-glass-plus" class="w-8 h-8 text-white mx-auto mb-2" />
                        <h4 class="text-white font-semibold text-sm px-2">{{ $post->title }}</h4>
                    </div>
                </div>
            </div>
            @endforeach
    </div>

    @else
    {{-- Large Gallery Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 lg:gap-3">
        @foreach($posts as $post)
        <div class="relative rounded-lg overflow-hidden group cursor-pointer @if($loop->first) md:col-span-2 md:row-span-2 @endif aspect-square wow fadeInUp"
            data-wow-delay="{{ (($loop->index % 4) + 1) * 0.08 }}s">
            @if(!empty($post->image))
            <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
            <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 flex items-center justify-center">
                <x-icon name="heroicon-o-photo" class="w-12 h-12 text-gray-600" />
            </div>
            @endif
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute inset-0 flex items-center justify-center">
                    <x-icon name="heroicon-o-magnifying-glass-plus" class="w-8 h-8 text-white" />
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/80 to-transparent">
                    <h4 class="text-white text-sm font-medium truncate">{{ $post->title }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- View All Button --}}
    @if($count > 4)
    <div class="text-center mt-10 wow fadeInUp" data-wow-delay="0.3s">
        <a href="{{ $category->url ?? '#' }}"
            class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-full border border-white/20 transition-colors duration-300">
            <span>عرض الكل</span>
            <x-icon name="heroicon-o-arrow-left" class="w-5 h-5 rtl:rotate-0 ltr:rotate-180" />
        </a>
    </div>
    @endif
    </div>
</section>
<!-- Gallery/Portfolio Section End -->
@endif