@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Mission Section Start -->
<section class="mission-section relative py-16 lg:py-24 overflow-hidden" id="{{ $category->slug ?? 'mission' }}">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"></div>
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-12 lg:mb-16">
            <span class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm text-white text-sm font-semibold rounded-full mb-4 wow fadeInUp">{{ $category->name ?? '' }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle ?? '' }}</h2>
            <p class="text-lg text-white/80 max-w-2xl mx-auto wow fadeInUp" data-wow-delay="0.2s">{{ $category->description ?? '' }}</p>
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-white/80" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-white/80 hover:text-white">تعديل</a>
            </div>
            @endauth
        </div>

        @if($count === 1)
        {{-- Single Mission Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-4xl mx-auto">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-8 lg:p-12 border border-white/20 wow fadeInUp">
                <div class="flex flex-col items-center text-center">
                    @if(!empty($post->icon))
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mb-6">
                        <x-icon name="{{ $post->icon }}" class="w-10 h-10 text-white" />
                    </div>
                    @endif
                    <h3 class="text-2xl lg:text-3xl font-bold text-white mb-6">{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p class="text-white/90 text-lg leading-relaxed">{{ $post->excerpt }}</p>
                    @else
                    <div class="prose prose-lg prose-invert max-w-none">
                        @foreach($post->blocks as $block)
                        @if($block->type === 'markdown')
                        @markdom($block->data->content)
                        @endif
                        @endforeach
                    </div>
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}" class="mt-8 inline-flex items-center gap-2 bg-white text-primary-600 px-8 py-4 rounded-xl font-bold hover:bg-white/90 transition-colors">
                        {{ $post->metadata['button'] }}
                        <x-heroicon-o-arrow-left class="w-5 h-5 rtl:rotate-180" />
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Missions Side by Side --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($posts as $post)
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 group hover:bg-white/15 transition-colors duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                <div class="flex items-start gap-5">
                    @if(!empty($post->icon))
                    <div class="flex-shrink-0 w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <x-icon name="{{ $post->icon }}" class="w-7 h-7 text-white" />
                    </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white mb-3">{{ $post->title }}</h3>
                        @if(!empty($post->excerpt))
                        <p class="text-white/80 leading-relaxed">{{ $post->excerpt }}</p>
                        @else
                        <div class="prose prose-invert prose-sm">
                            @foreach($post->blocks as $block)
                            @if($block->type === 'markdown')
                            @markdom($block->data->content)
                            @break
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @if(!empty($post->metadata['button']))
                <div class="mt-6 pt-6 border-t border-white/10">
                    <a href="{{ $post->url }}" class="inline-flex items-center gap-2 text-white font-semibold hover:gap-3 transition-all">
                        {{ $post->metadata['button'] }}
                        <x-heroicon-o-arrow-left class="w-4 h-4 rtl:rotate-180" />
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        @else
        {{-- Grid Layout for 3+ Missions --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 group hover:bg-white/15 transition-colors duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.1 }}s">
                <div class="flex items-center gap-4 mb-4">
                    @if(!empty($post->icon))
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <x-icon name="{{ $post->icon }}" class="w-6 h-6 text-white" />
                    </div>
                    @endif
                    <h3 class="text-lg font-bold text-white flex-1">{{ $post->title }}</h3>
                </div>
                @if(!empty($post->excerpt))
                <p class="text-white/80 text-sm line-clamp-3">{{ $post->excerpt }}</p>
                @else
                <div class="prose prose-invert prose-sm line-clamp-3">
                    @foreach($post->blocks as $block)
                    @if($block->type === 'markdown')
                    @markdom($block->data->content)
                    @break
                    @endif
                    @endforeach
                </div>
                @endif
                @if(!empty($post->metadata['button']))
                <a href="{{ $post->url }}" class="inline-flex items-center gap-1 text-white/90 hover:text-white text-sm font-medium mt-4 transition-colors">
                    {{ $post->metadata['button'] }}
                    <x-heroicon-o-arrow-left class="w-4 h-4 rtl:rotate-180" />
                </a>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Mission Section End -->
@endif
