@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
    $primary   = $posts->first();
@endphp
{{-- Bold Modular About: high-contrast two-column with stats bar --}}
<section class="bold-about py-16 lg:py-24 bg-white dark:bg-gray-900"
    id="{{ $category->slug ?? 'about' }}">
    <div class="container mx-auto px-4">

        {{-- Section label --}}
        <div class="inline-flex items-center gap-2 mb-8">
            <span class="block w-3 h-3 rounded-full bg-rose-500"></span>
            <span class="text-rose-600 text-xs font-bold uppercase tracking-[0.25em]">
                {{ $category->name ?? '' }}
            </span>
        </div>

        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

            {{-- Text block --}}
            <div>
                @if($category->subtitle)
                <h2 class="text-3xl md:text-4xl xl:text-5xl font-black text-gray-950 dark:text-white
                    leading-[1.1] tracking-tight mb-6">
                    {{ $category->subtitle }}
                </h2>
                @endif

                <div class="prose prose-lg dark:prose-invert max-w-none text-gray-600 dark:text-gray-300 mb-8">
                    @if(isset($primary->blocks[0]) && $primary->blocks[0]->type === 'markdown')
                        @markdom($primary->blocks[0]->data->content)
                    @elseif(!empty($primary->excerpt))
                        <p>{{ $primary->excerpt }}</p>
                    @endif
                </div>

                {{-- CTA --}}
                @if(!empty($primary->metadata['button']))
                <a href="{{ $primary->url }}"
                    class="inline-flex items-center gap-2 px-7 py-3.5 bg-rose-600 hover:bg-rose-500
                        text-white font-black text-sm rounded-xl shadow-lg shadow-rose-600/25
                        transition-all duration-200 hover:-translate-y-0.5">
                    {{ $primary->metadata['button'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                @endif

                @auth
                <div class="mt-4 flex items-center gap-1 text-xs text-gray-400">
                    <x-heroicon-s-pencil class="w-3 h-3" />
                    <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-rose-400 transition-colors">Edit</a>
                </div>
                @endauth
            </div>

            {{-- Image with bold corner accent --}}
            <div class="relative">
                <div class="relative rounded-2xl overflow-hidden aspect-[4/3] shadow-2xl">
                    <img src="{{ $primary->image?->url ?? $primary->getRandomImage() }}"
                        alt="{{ $primary->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105"
                        loading="lazy" />
                </div>

                {{-- Bold corner marker --}}
                <div class="absolute -bottom-3 -start-3 w-20 h-20 bg-rose-600 rounded-2xl -z-10"></div>
                <div class="absolute -top-3 -end-3 w-12 h-12 bg-amber-400 rounded-xl -z-10"></div>
            </div>
        </div>

    </div>
</section>
@endif
