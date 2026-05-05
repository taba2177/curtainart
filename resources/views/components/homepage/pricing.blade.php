@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Pricing Section Start -->
<section class="pricing-section relative py-16 lg:py-24 bg-white" id="{{ $category->slug ?? 'pricing' }}">
    <div class="absolute inset-0 bg-gradient-to-b from-gray-50 to-white"></div>

    <div class="container mx-auto px-4 relative z-10">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            @if($category->name)
            <span class="inline-block px-4 py-1.5 bg-primary-100 text-primary-700 text-sm font-semibold rounded-full mb-4 wow fadeInUp">{{ $category->name }}</span>
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
        {{-- Single Pricing Card --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-md mx-auto wow fadeInUp">
            <div class="bg-gradient-to-br from-primary-500 to-primary-600 rounded-3xl shadow-2xl p-8 text-center text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="relative">
                    @if(!empty($post->metadata['label']))
                    <span class="inline-block px-4 py-1 bg-white/20 text-white text-sm font-medium rounded-full mb-4">{{ $post->metadata['label'] }}</span>
                    @endif
                    <h3 class="text-2xl font-bold mb-3">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['value']))
                    <div class="text-5xl font-bold mb-4">
                        {{ $post->metadata['value'] }}
                        @if(!empty($post->metadata['period']))
                        <span class="text-lg font-normal opacity-80">/ {{ $post->metadata['period'] }}</span>
                        @endif
                    </div>
                    @endif
                    @if(!empty($post->excerpt))
                    <p class="text-white/80 mb-6">{{ $post->excerpt }}</p>
                    @endif
                    @if(!empty($post->metadata['button']) && !empty($post->metadata['link']))
                    <a href="{{ $post->metadata['link'] }}" class="inline-flex items-center gap-2 px-8 py-3 bg-white text-primary-600 font-semibold rounded-full hover:bg-gray-100 transition-colors">
                        <span>{{ $post->metadata['button'] }}</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Pricing Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-4xl mx-auto">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 border-2 @if($loop->first) border-gray-200 @else border-primary-500 @endif relative overflow-hidden group hover:shadow-xl transition-all duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                @if($loop->last)
                <div class="absolute top-4 right-4">
                    <span class="inline-block px-3 py-1 bg-primary-500 text-white text-xs font-semibold rounded-full">Popular</span>
                </div>
                @endif
                <div class="text-center">
                    @if(!empty($post->metadata['label']))
                    <span class="text-gray-500 text-sm font-medium uppercase tracking-wide">{{ $post->metadata['label'] }}</span>
                    @endif
                    <h3 class="text-xl font-bold text-gray-900 mt-2 mb-4">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['value']))
                    <div class="text-4xl font-bold text-gray-900 mb-1">
                        {{ $post->metadata['value'] }}
                    </div>
                    @if(!empty($post->metadata['period']))
                    <span class="text-gray-500 text-sm">{{ $post->metadata['period'] }}</span>
                    @endif
                    @endif
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 my-6">{{ $post->excerpt }}</p>
                    @endif
                    @if(!empty($post->metadata['button']) && !empty($post->metadata['link']))
                    <a href="{{ $post->metadata['link'] }}" class="inline-flex items-center justify-center w-full py-3 @if($loop->first) bg-gray-100 text-gray-700 hover:bg-gray-200 @else bg-primary-500 text-white hover:bg-primary-600 @endif font-semibold rounded-lg transition-colors">
                        {{ $post->metadata['button'] }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Pricing Cards (Classic) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-4 items-stretch">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg p-6 border-2 @if($loop->iteration === 2) border-primary-500 md:scale-105 md:z-10 @else border-gray-200 @endif relative overflow-hidden group hover:shadow-xl transition-all duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                @if($loop->iteration === 2)
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary-500 to-secondary-500"></div>
                <div class="text-center mb-2">
                    <span class="inline-block px-3 py-1 bg-primary-100 text-primary-600 text-xs font-semibold rounded-full">الأكثر طلباً</span>
                </div>
                @endif
                <div class="text-center">
                    @if(!empty($post->metadata['label']))
                    <span class="text-gray-500 text-sm font-medium uppercase tracking-wide">{{ $post->metadata['label'] }}</span>
                    @endif
                    <h3 class="text-lg font-bold text-gray-900 mt-1 mb-3">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['value']))
                    <div class="text-3xl font-bold text-gray-900 mb-1">
                        {{ $post->metadata['value'] }}
                    </div>
                    @if(!empty($post->metadata['period']))
                    <span class="text-gray-500 text-sm">{{ $post->metadata['period'] }}</span>
                    @endif
                    @endif
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 text-sm my-4">{{ $post->excerpt }}</p>
                    @endif
                    @if(!empty($post->metadata['button']) && !empty($post->metadata['link']))
                    <a href="{{ $post->metadata['link'] }}" class="inline-flex items-center justify-center w-full py-2.5 @if($loop->iteration === 2) bg-primary-500 text-white hover:bg-primary-600 @else bg-gray-100 text-gray-700 hover:bg-gray-200 @endif font-semibold rounded-lg transition-colors text-sm">
                        {{ $post->metadata['button'] }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Four+ Pricing Cards - Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min($count, 4) }} gap-4">
            @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-md p-5 border border-gray-200 relative group hover:shadow-lg hover:border-primary-300 transition-all duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.1 }}s">
                <div class="text-center">
                    @if(!empty($post->metadata['label']))
                    <span class="text-gray-400 text-xs font-medium uppercase tracking-wide">{{ $post->metadata['label'] }}</span>
                    @endif
                    <h3 class="text-base font-bold text-gray-900 mt-1 mb-2">{{ $post->title }}</h3>
                    @if(!empty($post->metadata['value']))
                    <div class="text-2xl font-bold text-primary-600 mb-3">
                        {{ $post->metadata['value'] }}
                    </div>
                    @endif
                    @if(!empty($post->metadata['button']) && !empty($post->metadata['link']))
                    <a href="{{ $post->metadata['link'] }}" class="inline-flex items-center justify-center w-full py-2 bg-gray-100 text-gray-700 hover:bg-primary-500 hover:text-white font-medium rounded-lg transition-colors text-sm">
                        {{ $post->metadata['button'] }}
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Pricing Section End -->
@endif
