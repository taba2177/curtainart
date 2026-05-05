@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
@endphp
{{-- Calm Storytelling Services: soft narrative cards with ample spacing --}}
<section class="calm-services py-24 lg:py-36 bg-slate-50 dark:bg-slate-800"
    id="{{ $category->slug ?? 'services' }}">
    <div class="container mx-auto px-6 max-w-6xl">

        {{-- Section intro --}}
        <div class="text-center max-w-2xl mx-auto mb-16">
            <div class="flex items-center justify-center gap-3 mb-5">
                <span class="block w-px h-8 bg-teal-300 dark:bg-teal-700"></span>
                <span class="text-teal-700 dark:text-teal-400 text-xs font-semibold tracking-[0.2em] uppercase">
                    {{ $category->name ?? '' }}
                </span>
                <span class="block w-px h-8 bg-teal-300 dark:bg-teal-700"></span>
            </div>
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 leading-snug [text-wrap:balance]">
                {{ $category->subtitle }}
            </h2>
            @endif
            @if($category->description)
            <p class="mt-4 text-slate-500 dark:text-slate-400 text-lg leading-relaxed">
                {{ $category->description }}
            </p>
            @endif
            @auth
            <div class="mt-4 flex items-center justify-center gap-1 text-xs text-slate-400">
                <x-heroicon-s-pencil class="w-3 h-3" />
                <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-teal-500 transition-colors">Edit</a>
            </div>
            @endauth
        </div>

        {{-- Service cards: soft, narrative --}}
        @if($count === 1)
        @php $post = $posts->first(); @endphp
        <div class="max-w-2xl mx-auto bg-white dark:bg-slate-900 rounded-3xl shadow-sm
            border border-slate-100 dark:border-slate-700 overflow-hidden hover:shadow-md transition-shadow duration-500">
            <div class="aspect-video overflow-hidden">
                <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover" loading="lazy" />
            </div>
            <div class="p-8 lg:p-10">
                <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-3">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-slate-500 dark:text-slate-400 leading-loose mb-6">{{ $post->excerpt }}</p>
                @endif
                @if(!empty($post->metadata['button']))
                <a href="{{ $post->url }}"
                    class="inline-flex items-center gap-2 text-teal-700 dark:text-teal-400 font-semibold
                        border-b border-teal-200 dark:border-teal-800 hover:border-teal-500 transition-colors pb-0.5">
                    {{ $post->metadata['button'] }}
                </a>
                @endif
            </div>
        </div>

        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $index => $post)
            <article class="calm-service-card group bg-white dark:bg-slate-900 rounded-3xl overflow-hidden
                border border-slate-100 dark:border-slate-700 shadow-sm
                hover:shadow-xl hover:shadow-slate-100/80 dark:hover:shadow-slate-900/80
                hover:-translate-y-1 transition-all duration-500">
                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                        loading="lazy" />
                </div>
                <div class="p-7">
                    {{-- Soft teal line --}}
                    <div class="w-8 h-0.5 bg-teal-300 dark:bg-teal-700 mb-5 transition-all duration-300 group-hover:w-12 group-hover:bg-teal-500"></div>

                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-3 leading-snug">
                        {{ $post->title }}
                    </h3>
                    @if(!empty($post->excerpt))
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-loose line-clamp-3 mb-4">
                        {{ $post->excerpt }}
                    </p>
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}"
                        class="inline-flex items-center gap-1.5 text-sm font-semibold text-teal-700 dark:text-teal-400
                            hover:text-teal-500 transition-colors">
                        {{ $post->metadata['button'] }}
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </article>
            @endforeach
        </div>
        @endif

    </div>
</section>
@endif
