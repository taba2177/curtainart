@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
@endphp
{{-- Editorial Premium Services: editorial magazine grid --}}
<section class="editorial-services py-20 lg:py-28 bg-gray-50 dark:bg-gray-900"
    id="{{ $category->slug ?? 'services' }}"
    style="scroll-margin-top:7rem">
    <div class="container mx-auto px-4">

        {{-- Section header --}}
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-14 gap-6">
            <div class="max-w-2xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="block w-8 h-px bg-amber-400"></span>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em]" style="color:#b45309">
                        {{ $category->name ?? '' }}
                    </span>
                </div>
                @if($category->subtitle)
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white
                    leading-tight [text-wrap:balance]">
                    {{ $category->subtitle }}
                </h2>
                @endif
            </div>
            @if($category->description)
            <p class="lg:max-w-xs text-gray-500 dark:text-gray-400 text-base leading-relaxed">
                {{ $category->description }}
            </p>
            @endif
            @auth
            <div class="flex items-center gap-1 text-xs text-gray-400">
                <x-heroicon-s-pencil class="w-3 h-3" />
                <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-amber-400 transition-colors">Edit</a>
            </div>
            @endauth
        </div>

        {{-- Editorial asymmetric grid --}}
        @if($count === 1)
        @php $post = $posts->first(); @endphp
        <div class="max-w-3xl bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row">
            <div class="md:w-2/5 aspect-video md:aspect-auto">
                <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover" loading="lazy" width="400" height="300"
                    onerror="this.src='{{ asset('images/placeholder.svg') }}';this.onerror=null" />
            </div>
            <div class="p-8 flex-1 flex flex-col justify-center">
                <h3 class="text-2xl font-extrabold text-gray-900 dark:text-white mb-3">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed mb-4">{{ $post->excerpt }}</p>
                @endif
                @if(!empty($post->metadata['button']))
                <a href="{{ $post->url }}"
                    class="self-start inline-flex items-center gap-2 text-sm font-bold hover:text-amber-400 transition-colors" style="color:#b45309">
                    {{ $post->metadata['button'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                @endif
            </div>
        </div>

        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $index => $post)
            <article class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow
                hover:shadow-xl hover:-translate-y-1
                {{ $index === 0 ? 'md:col-span-2 lg:col-span-1 lg:row-span-1' : '' }}"
                style="transition:box-shadow 0.3s ease,transform 0.3s ease">
                <div class="aspect-[16/9] overflow-hidden">
                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                        loading="lazy" width="640" height="360"
                        onerror="this.src='{{ asset('images/placeholder.svg') }}';this.onerror=null" />
                </div>
                <div class="p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="block w-5 h-px bg-amber-400"></span>
                        <span class="text-xs font-semibold uppercase tracking-wider" style="color:#b45309">
                            {{ $category->name ?? '' }}
                        </span>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mb-2 leading-snug">
                        {{ $post->title }}
                    </h3>
                    @if(!empty($post->excerpt))
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed line-clamp-2 mb-4">
                        {{ $post->excerpt }}
                    </p>
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}"
                        class="inline-flex items-center gap-1.5 text-sm font-bold text-gray-900 dark:text-amber-400
                            hover:text-amber-500 transition-colors">
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
