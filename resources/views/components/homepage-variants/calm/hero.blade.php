@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
    $primary   = $posts->first();
@endphp
{{-- Calm Storytelling Hero: centered narrative with generous whitespace --}}
<section class="calm-hero relative min-h-screen flex flex-col items-center justify-center overflow-hidden bg-slate-50 dark:bg-slate-900"
    id="{{ $category->slug ?? 'hero' }}">

    {{-- Soft background image with heavy veil --}}
    <div class="absolute inset-0">
        <img src="{{ $primary->image?->url ?? $primary->getRandomImage() }}"
            alt="{{ $primary->title }}"
            class="w-full h-full object-cover opacity-20 dark:opacity-10 scale-110 transition-transform duration-[12s] ease-linear"
            loading="eager" />
        <div class="absolute inset-0 bg-gradient-to-b from-slate-50/80 via-slate-50/60 to-slate-50/90 dark:from-slate-900/80 dark:via-slate-900/60 dark:to-slate-900/90"></div>
    </div>

    {{-- Decorative subtle element --}}
    <div class="absolute top-1/4 start-1/4 w-72 h-72 rounded-full bg-teal-100/30 dark:bg-teal-900/20 blur-3xl -z-0"></div>
    <div class="absolute bottom-1/4 end-1/4 w-96 h-96 rounded-full bg-sky-100/30 dark:bg-sky-900/20 blur-3xl -z-0"></div>

    {{-- Content: centered, narrative voice --}}
    <div class="relative z-10 container mx-auto px-6 text-center max-w-3xl py-24">

        {{-- Overline --}}
        <p class="text-teal-700 dark:text-teal-400 text-sm font-semibold tracking-widest uppercase mb-8
            opacity-0 animate-[fadeInDown_0.8s_ease_0.2s_forwards]">
            {{ $category->name ?? '' }}
        </p>

        {{-- Headline — narrative-first, calm rhythm --}}
        <h1 class="calm-headline text-4xl md:text-5xl lg:text-6xl font-bold text-slate-800 dark:text-slate-100
            leading-[1.15] tracking-tight mb-8 [text-wrap:balance]
            opacity-0 animate-[fadeInUp_0.9s_ease_0.4s_forwards]">
            {{ $primary->title }}
        </h1>

        {{-- Spacious body text --}}
        @if(!empty($primary->excerpt))
        <p class="text-slate-500 dark:text-slate-400 text-xl leading-loose mb-10 max-w-xl mx-auto
            opacity-0 animate-[fadeInUp_0.9s_ease_0.6s_forwards]">
            {{ $primary->excerpt }}
        </p>
        @endif

        {{-- Quiet CTAs --}}
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4
            opacity-0 animate-[fadeInUp_0.9s_ease_0.8s_forwards]">
            @if(!empty($primary->metadata['button']))
            <a href="{{ $primary->url }}"
                class="inline-flex items-center gap-2 px-8 py-3.5 bg-teal-600 hover:bg-teal-500 text-white
                    font-semibold text-base rounded-full transition-all duration-300 shadow-lg shadow-teal-600/20
                    hover:shadow-teal-500/30 hover:-translate-y-0.5">
                {{ $primary->metadata['button'] }}
            </a>
            @endif
            @if(!empty($primary->metadata['button2']))
            <a href="{{ $primary->metadata['button2_link'] ?? $primary->url }}"
                class="inline-flex items-center gap-2 px-8 py-3.5 border border-slate-300 dark:border-slate-700
                    text-slate-600 dark:text-slate-300 hover:text-teal-700 dark:hover:text-teal-400
                    font-semibold text-base rounded-full transition-all duration-300
                    hover:border-teal-300 dark:hover:border-teal-700">
                {{ $primary->metadata['button2'] }}
            </a>
            @endif
        </div>

        @auth
        <div class="mt-10 flex items-center justify-center gap-1 text-xs text-slate-400">
            <x-heroicon-s-pencil class="w-3 h-3" />
            <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-teal-500 transition-colors">Edit</a>
        </div>
        @endauth
    </div>

    {{-- Gentle scroll hint --}}
    <div class="absolute bottom-8 start-1/2 -translate-x-1/2 rtl:translate-x-1/2 z-10 flex flex-col items-center gap-2
        text-slate-400 opacity-0 animate-[fadeIn_1s_ease_1.5s_forwards]">
        <div class="w-px h-10 bg-teal-300/50 animate-[scrollHint_2s_ease_infinite]"></div>
    </div>

</section>
@endif
