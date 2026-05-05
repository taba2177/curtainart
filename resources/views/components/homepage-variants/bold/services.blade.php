@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
@endphp
{{-- Bold Modular Services: dense card grid with accent bar and CTA prominence --}}
<section class="bold-services py-16 lg:py-24 bg-gray-950 dark:bg-gray-950 text-white"
    id="{{ $category->slug ?? 'services' }}">
    <div class="container mx-auto px-4">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-12 gap-6">
            <div>
                <div class="inline-flex items-center gap-2 mb-4">
                    <span class="block w-3 h-3 rounded-full bg-rose-500 animate-pulse"></span>
                    <span class="text-rose-400 text-xs font-bold uppercase tracking-[0.25em]">
                        {{ $category->name ?? '' }}
                    </span>
                </div>
                @if($category->subtitle)
                <h2 class="text-3xl md:text-4xl xl:text-5xl font-black text-white leading-tight">
                    {{ $category->subtitle }}
                </h2>
                @endif
                @auth
                <div class="mt-3 flex items-center gap-1 text-xs text-gray-500">
                    <x-heroicon-s-pencil class="w-3 h-3" />
                    <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-rose-400 transition-colors">Edit</a>
                </div>
                @endauth
            </div>
            @if($category->description)
            <p class="text-gray-400 text-base leading-relaxed md:max-w-xs">{{ $category->description }}</p>
            @endif
        </div>

        {{-- Service cards —high-contrast modular grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($posts as $index => $post)
            <article class="bold-card group relative bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden
                hover:border-rose-600 transition-all duration-300 hover:shadow-2xl hover:shadow-rose-900/20
                hover:-translate-y-1">

                {{-- Card image --}}
                <div class="relative aspect-[16/9] overflow-hidden">
                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover opacity-80 group-hover:opacity-100
                            transition-all duration-500 group-hover:scale-105"
                        loading="lazy" />
                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
                    {{-- Index badge --}}
                    <div class="absolute top-3 start-3">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg
                            bg-rose-600/90 text-white text-xs font-black backdrop-blur-sm">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>
                </div>

                {{-- Card body --}}
                <div class="p-6">
                    <h3 class="text-lg font-black text-white mb-2 leading-snug group-hover:text-rose-300 transition-colors">
                        {{ $post->title }}
                    </h3>
                    @if(!empty($post->excerpt))
                    <p class="text-sm text-gray-400 leading-relaxed line-clamp-2 mb-4">
                        {{ $post->excerpt }}
                    </p>
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-400
                            hover:text-rose-300 transition-colors">
                        {{ $post->metadata['button'] }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    @endif
                </div>

                {{-- Bottom accent bar (shown on hover) --}}
                <div class="absolute bottom-0 inset-x-0 h-0.5 bg-gradient-to-r from-rose-600 to-orange-500
                    scale-x-0 group-hover:scale-x-100 origin-start transition-transform duration-300"></div>
            </article>
            @endforeach
        </div>

    </div>
</section>
@endif
