@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
    $primary   = $posts->first();
@endphp
{{-- Bold Modular Hero: strong split layout with high-contrast CTA block --}}
<section class="bold-hero min-h-[92vh] relative flex items-center overflow-hidden bg-gray-950"
    id="{{ $category->slug ?? 'hero' }}">

    {{-- Image fills the right half --}}
    <div class="absolute inset-y-0 end-0 w-full lg:w-1/2 rtl:start-0 rtl:end-auto">
        <img src="{{ $primary->image?->url ?? $primary->getRandomImage() }}"
            alt="{{ $primary->title }}"
            class="w-full h-full object-cover opacity-70 lg:opacity-100"
            loading="eager" />
        {{-- Edge fade for blend --}}
        <div class="absolute inset-y-0 start-0 w-1/2 bg-gradient-to-e from-gray-950 to-transparent lg:block hidden rtl:bg-gradient-to-s"></div>
        <div class="absolute inset-0 bg-gray-950/60 lg:bg-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 container mx-auto px-4 py-20 md:py-28 lg:w-1/2 lg:pe-16">

        {{-- Bold label block --}}
        <div class="inline-flex items-center gap-2 mb-6">
            <span class="block w-3 h-3 rounded-full bg-rose-500 animate-pulse"></span>
            <span class="text-rose-400 text-xs font-bold uppercase tracking-[0.25em]">
                {{ $category->name ?? '' }}
            </span>
        </div>

        {{-- Headline —Heavy display weight --}}
        <h1 class="bold-headline text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black text-white
            leading-[1.0] tracking-tight mb-6 [text-wrap:balance]">
            {{ $primary->title }}
        </h1>

        {{-- Excerpt --}}
        @if(!empty($primary->excerpt))
        <p class="text-gray-300 text-lg leading-relaxed mb-8 max-w-md">
            {{ $primary->excerpt }}
        </p>
        @endif

        {{-- CTA block with strong contrast --}}
        <div class="flex flex-col sm:flex-row gap-3">
            @if(!empty($primary->metadata['button']))
            <a href="{{ $primary->url }}"
                class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-rose-600 hover:bg-rose-500
                    text-white font-black text-base rounded-xl transition-all duration-200
                    shadow-lg shadow-rose-600/30 hover:shadow-rose-500/40 hover:-translate-y-0.5">
                {{ $primary->metadata['button'] }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            @endif
            @if(!empty($primary->metadata['button2']))
            <a href="{{ $primary->metadata['button2_link'] ?? $primary->url }}"
                class="inline-flex items-center justify-center gap-2 px-8 py-4 border-2 border-gray-600
                    hover:border-gray-400 text-gray-300 hover:text-white font-bold text-base rounded-xl
                    transition-all duration-200 bg-white/5 hover:bg-white/10 backdrop-blur">
                {{ $primary->metadata['button2'] }}
            </a>
            @endif
        </div>

        @auth
        <div class="mt-8 flex items-center gap-1 text-xs text-gray-500">
            <x-heroicon-s-pencil class="w-3 h-3" />
            <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-rose-400 transition-colors">Edit</a>
        </div>
        @endauth

    </div>

    {{-- Decorative diagonal stripe --}}
    <div class="absolute bottom-0 inset-x-0 h-1 bg-gradient-to-r from-rose-600 via-orange-500 to-amber-400"></div>

</section>
@endif
