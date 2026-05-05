@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Location/Map Section Start -->
<section class="location-section relative py-16 lg:py-24 bg-gray-50" id="{{ $category->slug ?? 'location' }}">
    <div class="container mx-auto px-4">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12">
            @if($category->name)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 text-sm font-semibold rounded-full mb-4 wow fadeInUp">
                <x-heroicon-o-map-pin class="w-4 h-4" />
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
        {{-- Single Location --}}
        @php $post = $posts->first(); @endphp
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center max-w-6xl mx-auto wow fadeInUp">
            {{-- Info Card --}}
            <div class="bg-white rounded-3xl shadow-xl p-8 order-2 lg:order-1">
                <div class="flex items-start gap-4 mb-6">
                    <div class="w-14 h-14 rounded-xl bg-primary-100 flex items-center justify-center flex-shrink-0">
                        <x-heroicon-o-building-office class="w-7 h-7 text-primary-600" />
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $post->title }}</h3>
                        @if(!empty($post->metadata['label']))
                        <span class="text-primary-600 text-sm font-medium">{{ $post->metadata['label'] }}</span>
                        @endif
                    </div>
                </div>

                @if(!empty($post->excerpt))
                <p class="text-gray-600 mb-6">{{ $post->excerpt }}</p>
                @endif

                <div class="space-y-4">
                    @if(!empty($post->metadata['value']))
                    <div class="flex items-center gap-3">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400" />
                        <span class="text-gray-700">{{ $post->metadata['value'] }}</span>
                    </div>
                    @endif
                    @if(!empty($post->metadata['phone']))
                    <div class="flex items-center gap-3">
                        <x-heroicon-o-phone class="w-5 h-5 text-gray-400" />
                        <a href="tel:{{ $post->metadata['phone'] }}" class="text-primary-600 hover:text-primary-700">{{ $post->metadata['phone'] }}</a>
                    </div>
                    @endif
                </div>

                @if(!empty($post->metadata['link']))
                <a href="{{ $post->metadata['link'] }}" target="_blank" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-primary-500 text-white font-semibold rounded-lg hover:bg-primary-600 transition-colors">
                    <x-heroicon-o-arrow-top-right-on-square class="w-5 h-5" />
                    <span>فتح الخريطة</span>
                </a>
                @endif
            </div>

            {{-- Map/Image --}}
            <div class="rounded-3xl overflow-hidden shadow-xl order-1 lg:order-2 aspect-video lg:aspect-square">
                @if(!empty($post->image))
                <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                    <x-heroicon-o-map class="w-20 h-20 text-gray-400" />
                </div>
                @endif
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Locations --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-5xl mx-auto">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                <div class="aspect-video overflow-hidden">
                    @if(!empty($post->image))
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <x-heroicon-o-map class="w-16 h-16 text-gray-300" />
                    </div>
                    @endif
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['value']))
                    <p class="text-gray-600 text-sm flex items-start gap-2">
                        <x-heroicon-o-map-pin class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" />
                        <span>{{ $post->metadata['value'] }}</span>
                    </p>
                    @endif
                    @if(!empty($post->metadata['phone']))
                    <p class="text-primary-600 text-sm flex items-center gap-2 mt-2">
                        <x-heroicon-o-phone class="w-4 h-4" />
                        <span>{{ $post->metadata['phone'] }}</span>
                    </p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Locations --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-shadow wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                <div class="aspect-[4/3] overflow-hidden">
                    @if(!empty($post->image))
                    <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-50 flex items-center justify-center">
                        <x-heroicon-o-map-pin class="w-12 h-12 text-primary-400" />
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-base font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['value']))
                    <p class="text-gray-600 text-sm line-clamp-2">{{ $post->metadata['value'] }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Four+ Locations - Grid with Map Icons --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 group hover:shadow-md hover:border-primary-200 transition-all duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.08 }}s">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-500 transition-colors">
                        <x-heroicon-o-map-pin class="w-5 h-5 text-primary-600 group-hover:text-white transition-colors" />
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $post->title }}</h3>
                </div>
                @if(!empty($post->metadata['value']))
                <p class="text-gray-500 text-xs line-clamp-2">{{ $post->metadata['value'] }}</p>
                @endif
                @if(!empty($post->metadata['phone']))
                <a href="tel:{{ $post->metadata['phone'] }}" class="text-primary-600 text-xs mt-2 inline-block hover:underline">{{ $post->metadata['phone'] }}</a>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Location/Map Section End -->
@endif
