@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Team Section Start -->
<section class="team-section relative py-16 lg:py-24 bg-white" id="{{ $category->slug ?? 'team' }}">
    <div class="container mx-auto px-4">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            @if($category->name)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 text-primary-700 text-sm font-semibold rounded-full mb-4 wow fadeInUp">
                <span class="w-2 h-2 rounded-full bg-primary-500 animate-pulse"></span>
                {{ $category->name }}
            </span>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle }}</h2>
            @endif
            @if($category->description)
            <p class="text-gray-600 text-lg wow fadeInUp" data-wow-delay="0.2s">{!! $category->description !!}</p>
            @endif
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-gray-400" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        @if($count === 1)
        {{-- Single Team Member Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-md mx-auto wow fadeInUp">
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden group">
                @if(!empty($post->image))
                <div class="aspect-[4/5] overflow-hidden">
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @endif
                <div class="p-6 text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['label']))
                    <p class="text-primary-600 font-medium mb-4">{{ $post->metadata['label'] }}</p>
                    @endif
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 mb-4">{{ $post->excerpt }}</p>
                    @endif
                    <div class="flex justify-center gap-3">
                        @if(!empty($post->metadata['link']))
                        <a href="{{ $post->metadata['link'] }}" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-primary-500 flex items-center justify-center text-gray-600 hover:text-white transition-colors">
                            <x-heroicon-o-link class="w-5 h-5" />
                        </a>
                        @endif
                        @if(!empty($post->metadata['phone']))
                        <a href="tel:{{ $post->metadata['phone'] }}" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-primary-500 flex items-center justify-center text-gray-600 hover:text-white transition-colors">
                            <x-heroicon-o-phone class="w-5 h-5" />
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Team Members --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                @if(!empty($post->image))
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @endif
                <div class="p-5 text-center">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['label']))
                    <p class="text-primary-600 text-sm font-medium mb-3">{{ $post->metadata['label'] }}</p>
                    @endif
                    <div class="flex justify-center gap-2">
                        @if(!empty($post->metadata['link']))
                        <a href="{{ $post->metadata['link'] }}" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-primary-500 flex items-center justify-center text-gray-600 hover:text-white transition-colors">
                            <x-heroicon-o-link class="w-4 h-4" />
                        </a>
                        @endif
                        @if(!empty($post->metadata['phone']))
                        <a href="tel:{{ $post->metadata['phone'] }}" class="w-9 h-9 rounded-full bg-gray-100 hover:bg-primary-500 flex items-center justify-center text-gray-600 hover:text-white transition-colors">
                            <x-heroicon-o-phone class="w-4 h-4" />
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Team Members --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                @if(!empty($post->image))
                <div class="aspect-[3/4] overflow-hidden relative">
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 translate-y-4 group-hover:translate-y-0">
                        @if(!empty($post->metadata['link']))
                        <a href="{{ $post->metadata['link'] }}" class="w-9 h-9 rounded-full bg-white/90 hover:bg-primary-500 flex items-center justify-center text-gray-700 hover:text-white transition-colors">
                            <x-heroicon-o-link class="w-4 h-4" />
                        </a>
                        @endif
                        @if(!empty($post->metadata['phone']))
                        <a href="tel:{{ $post->metadata['phone'] }}" class="w-9 h-9 rounded-full bg-white/90 hover:bg-primary-500 flex items-center justify-center text-gray-700 hover:text-white transition-colors">
                            <x-heroicon-o-phone class="w-4 h-4" />
                        </a>
                        @endif
                    </div>
                </div>
                @endif
                <div class="p-5 text-center">
                    <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['label']))
                    <p class="text-primary-600 text-sm font-medium">{{ $post->metadata['label'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 4)
        {{-- Four Team Members - 2x2 Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-shadow duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.1 }}s">
                @if(!empty($post->image))
                <div class="aspect-square overflow-hidden">
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                </div>
                @endif
                <div class="p-4 text-center">
                    <h3 class="text-sm font-bold text-gray-900 mb-0.5 truncate">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['label']))
                    <p class="text-primary-600 text-xs font-medium truncate">{{ $post->metadata['label'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Five+ Team Members - Carousel/Slider Style --}}
        <div class="relative">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($posts as $post)
                <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-all duration-300 hover:-translate-y-1 wow fadeInUp" data-wow-delay="{{ (($loop->index % 5) + 1) * 0.08 }}s">
                    @if(!empty($post->image))
                    <div class="aspect-[4/5] overflow-hidden relative">
                        <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/70 via-transparent to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-3 text-center">
                            <h3 class="text-white text-sm font-bold mb-0.5 truncate">{{ $post->title }}</h3>
                            @if(!empty($post->metadata['label']))
                            <p class="text-white/80 text-xs truncate">{{ $post->metadata['label'] }}</p>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="p-4 text-center">
                        <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-3">
                            <x-heroicon-o-user class="w-8 h-8 text-primary-600" />
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 mb-0.5 truncate">{{ $post->title }}</h3>
                        @if(!empty($post->metadata['label']))
                        <p class="text-primary-600 text-xs truncate">{{ $post->metadata['label'] }}</p>
                        @endif
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
<!-- Team Section End -->
@endif
