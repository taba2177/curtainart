@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
    $primary   = $posts->first();
    $secondary = $posts->skip(1)->first();
@endphp
{{-- Editorial Premium Hero: asymmetric full-bleed layout --}}
<section class="editorial-hero relative min-h-[90vh] flex items-end overflow-hidden bg-gray-950"
    id="{{ $category->slug ?? 'hero' }}"
    style="scroll-margin-top:7rem">

    {{-- Full-bleed background image --}}
    <div class="absolute inset-0">
        <img src="{{ $primary->image?->url ?? $primary->getRandomImage() }}"
            alt="{{ $primary->title }}"
            class="w-full h-full object-cover opacity-60 scale-105 transition-transform duration-[8s] ease-out"
            loading="eager"
            fetchpriority="high"
            width="1920" height="1080"
            onerror="this.src='{{ asset('images/placeholder.svg') }}';this.onerror=null" />
        {{-- Deep editorial gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-gray-950 via-gray-900/70 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-gray-950/90 via-gray-950/40 to-transparent rtl:bg-gradient-to-l"></div>
    </div>

    {{-- Slide indicators on the right edge --}}
    @if($count > 1)
    <div class="absolute end-6 top-1/2 -translate-y-1/2 flex flex-col gap-2 z-20">
        @foreach($posts as $i => $post)
        <div class="w-1 rounded-full transition-all duration-500 {{ $i === 0 ? 'h-10 bg-amber-400' : 'h-4 bg-white/30' }}"></div>
        @endforeach
    </div>
    @endif

    {{-- Content panel --}}
    <div class="relative z-10 container mx-auto px-4 pb-16 pt-32 md:pb-24 max-w-4xl">

        {{-- Vertical eyebrow --}}
        <div class="flex items-center gap-3 mb-6">
            <span class="block w-8 h-px bg-amber-400"></span>
            <span class="text-amber-400 text-xs font-semibold uppercase tracking-[0.2em]">
                {{ $category->name ?? '' }}
            </span>
        </div>

        {{-- Headline --}}
        <h1 class="editorial-headline text-4xl md:text-6xl lg:text-7xl font-extrabold text-white leading-[1.05] mb-6
            [text-wrap:balance]">
            {{ $primary->title }}
        </h1>

        {{-- Body excerpt --}}
        @if(!empty($primary->excerpt))
        <p class="text-gray-300 text-lg md:text-xl max-w-xl leading-relaxed mb-8">
            {{ Str::of($primary->excerpt)->replaceMatches('/^#{1,6}\s*/m', '') }}
        </p>
        @endif

        {{-- CTA buttons --}}
        <div class="flex flex-wrap gap-4">
            @if(!empty($primary->metadata['button']))
            <a href="{{ $primary->url }}"
                class="inline-flex items-center gap-2 px-7 py-3.5 bg-amber-400 hover:bg-amber-300 text-gray-950
                    font-bold text-sm rounded-full transition-all duration-300 hover:scale-105 shadow-lg shadow-amber-500/30">
                {{ $primary->metadata['button'] }}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
            @endif
            @if(!empty($primary->metadata['button2']))
            <a href="{{ $primary->metadata['button2_link'] ?? $primary->url }}"
                class="inline-flex items-center gap-2 px-7 py-3.5 border-2 border-white/30 hover:border-white/60
                    text-white font-semibold text-sm rounded-full transition-all duration-300 backdrop-blur-sm">
                {{ $primary->metadata['button2'] }}
            </a>
            @endif
        </div>

        @auth
        <div class="mt-6 flex items-center gap-1 text-xs text-gray-400">
            <x-heroicon-s-pencil class="w-3 h-3" />
            <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-amber-400 transition-colors">Edit</a>
        </div>
        @endauth
    </div>

    {{-- Bottom scroll hint --}}
    <div class="absolute bottom-6 start-1/2 -translate-x-1/2 rtl:translate-x-1/2 z-10 flex flex-col items-center gap-1 text-white/40">
        <span class="text-[10px] uppercase tracking-widest">{{ __('Scroll') }}</span>
        <div class="w-px h-8 bg-white/20 animate-pulse"></div>
    </div>

</section>
@endif
