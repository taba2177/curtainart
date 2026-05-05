@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $post      = $posts->first();
@endphp
{{-- Editorial Premium CTA: full-width editorial call to action --}}
<section class="editorial-cta py-24 lg:py-32 bg-gray-950 relative overflow-hidden"
    id="{{ $category->slug ?? 'cta' }}">

    {{-- Decorative grid pattern --}}
    <div class="absolute inset-0 bg-[linear-gradient(rgba(251,191,36,0.03)_1px,transparent_1px),linear-gradient(to_right,rgba(251,191,36,0.03)_1px,transparent_1px)] bg-[size:40px_40px]"></div>
    <div class="absolute top-1/2 start-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>

    <div class="relative container mx-auto px-4 text-center max-w-3xl">

        <div class="flex items-center justify-center gap-3 mb-6">
            <span class="block w-8 h-px bg-amber-400"></span>
            <span class="text-amber-400 text-xs font-semibold uppercase tracking-[0.2em]">
                {{ $category->name ?? '' }}
            </span>
            <span class="block w-8 h-px bg-amber-400"></span>
        </div>

        @if($category->subtitle)
        <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-6 [text-wrap:balance]">
            {{ $category->subtitle }}
        </h2>
        @endif

        @if(!empty($post->excerpt))
        <p class="text-gray-300 text-lg leading-relaxed mb-10 max-w-xl mx-auto">
            {{ $post->excerpt }}
        </p>
        @endif

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            @if(!empty($post->metadata['button']))
            <a href="{{ $post->url }}"
                class="inline-flex items-center gap-2 px-8 py-4 bg-amber-400 hover:bg-amber-300 text-gray-950
                    font-bold text-base rounded-full transition-all duration-300 hover:scale-105 shadow-lg shadow-amber-500/20">
                {{ $post->metadata['button'] }}
            </a>
            @endif
            @if(!empty($post->metadata['button2']))
            <a href="{{ $post->metadata['button2_link'] ?? '#' }}"
                class="inline-flex items-center gap-2 px-8 py-4 border-2 border-gray-600 hover:border-amber-400
                    text-gray-300 hover:text-amber-400 font-semibold text-base rounded-full transition-all duration-300">
                {{ $post->metadata['button2'] }}
            </a>
            @endif
        </div>

        @auth
        <div class="mt-8 flex items-center justify-center gap-1 text-xs text-gray-500">
            <x-heroicon-s-pencil class="w-3 h-3" />
            <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-amber-400 transition-colors">Edit</a>
        </div>
        @endauth

    </div>
</section>
@endif
