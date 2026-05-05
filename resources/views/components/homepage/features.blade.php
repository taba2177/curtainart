@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Features/Advantages Section Start -->
<section class="features-section relative py-16 lg:py-24 bg-gradient-to-br from-gray-50 to-white overflow-hidden" id="{{ $category->slug ?? 'features' }}">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary-50/50 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-primary-100 rounded-full opacity-30 blur-3xl -translate-x-1/2 translate-y-1/2"></div>

    <div class="container mx-auto px-4 relative z-10">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            @if($category->name)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 text-sm font-semibold rounded-full mb-4 wow fadeInUp">
                <x-heroicon-o-sparkles class="w-4 h-4" />
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
        {{-- Single Feature Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-3xl mx-auto wow fadeInUp">
            <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-12 flex flex-col lg:flex-row items-center gap-8">
                <div class="flex-shrink-0">
                    <div class="w-24 h-24 lg:w-32 lg:h-32 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center shadow-lg">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-12 h-12 lg:w-16 lg:h-16 text-white" />
                        @else
                        <x-heroicon-o-star class="w-12 h-12 lg:w-16 lg:h-16 text-white" />
                        @endif
                    </div>
                </div>
                <div class="text-center lg:text-right flex-1">
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-3">{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 text-lg leading-relaxed mb-4">{{ $post->excerpt }}</p>
                    @endif
                    @if(!empty($post->metadata['button']) && !empty($post->metadata['link']))
                    <a href="{{ $post->metadata['link'] }}" class="inline-flex items-center gap-2 text-primary-600 font-semibold hover:text-primary-700">
                        <span>{{ $post->metadata['button'] }}</span>
                        <x-heroicon-o-arrow-left class="w-5 h-5 rtl:rotate-0 ltr:rotate-180" />
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Features --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-4xl mx-auto">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
                    @if(!empty($post->icon))
                    <x-icon name="{{ $post->icon }}" class="w-8 h-8 text-white" />
                    @else
                    <x-heroicon-o-check-badge class="w-8 h-8 text-white" />
                    @endif
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 leading-relaxed">{{ $post->excerpt }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Features --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg p-6 group hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary-100 rounded-full opacity-50 -translate-y-1/2 translate-x-1/2 group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-7 h-7 text-white" />
                        @else
                        <span class="text-white font-bold text-xl">{{ $loop->iteration }}</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 text-sm leading-relaxed">{{ $post->excerpt }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 4)
        {{-- Four Features - 2x2 Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-md p-5 group hover:shadow-lg transition-all duration-300 text-center wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.1 }}s">
                <div class="w-16 h-16 rounded-full bg-primary-50 flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-100 transition-colors duration-300">
                    @if(!empty($post->icon))
                    <x-icon name="{{ $post->icon }}" class="w-8 h-8 text-primary-600" />
                    @else
                    <x-heroicon-o-cube class="w-8 h-8 text-primary-600" />
                    @endif
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 text-sm leading-relaxed">{{ \Illuminate\Support\Str::limit($post->excerpt, 80) }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @elseif($count >= 5 && $count <= 6)
        {{-- 5-6 Features - Horizontal Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-md p-4 flex items-start gap-4 group hover:shadow-lg transition-all duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.1 }}s">
                <div class="w-12 h-12 rounded-lg bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                    @if(!empty($post->icon))
                    <x-icon name="{{ $post->icon }}" class="w-6 h-6 text-white" />
                    @else
                    <span class="text-white font-bold">{{ $loop->iteration }}</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-bold text-gray-900 mb-1 truncate">{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 text-xs leading-relaxed line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- 7+ Features - Compact Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-sm p-4 group hover:shadow-md transition-all duration-300 border border-gray-100 wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.08 }}s">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-500 transition-colors duration-300">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-5 h-5 text-primary-600 group-hover:text-white transition-colors" />
                        @else
                        <x-heroicon-o-check class="w-5 h-5 text-primary-600 group-hover:text-white transition-colors" />
                        @endif
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $post->title }}</h3>
                </div>
                @if(!empty($post->excerpt))
                <p class="text-gray-500 text-xs leading-relaxed line-clamp-2">{{ $post->excerpt }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Features/Advantages Section End -->
@endif
