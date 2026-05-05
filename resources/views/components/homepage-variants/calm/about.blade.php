@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
    $primary   = $posts->first();
@endphp
{{-- Calm Storytelling About: narrative prose with generous whitespace --}}
<section class="calm-about py-24 lg:py-36 bg-white dark:bg-slate-900"
    id="{{ $category->slug ?? 'about' }}">
    <div class="container mx-auto px-6 max-w-5xl">

        <div class="grid lg:grid-cols-[1fr_1.2fr] gap-16 items-start">

            {{-- Text narrative column --}}
            <div class="lg:sticky lg:top-28">

                {{-- Chapter marker --}}
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex flex-col items-center gap-1">
                        <span class="block w-px h-10 bg-teal-300 dark:bg-teal-700"></span>
                        <span class="block w-2 h-2 rounded-full bg-teal-400 dark:bg-teal-500"></span>
                    </div>
                    <span class="text-teal-700 dark:text-teal-400 text-sm font-semibold tracking-widest uppercase">
                        {{ $category->name ?? '' }}
                    </span>
                </div>

                @if($category->subtitle)
                <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100
                    leading-snug [text-wrap:balance] mb-7">
                    {{ $category->subtitle }}
                </h2>
                @endif

                <div class="prose prose-lg prose-slate dark:prose-invert max-w-none
                    prose-p:leading-[1.9] prose-p:text-slate-500 dark:prose-p:text-slate-400 mb-8">
                    @if(isset($primary->blocks[0]) && $primary->blocks[0]->type === 'markdown')
                        @markdom($primary->blocks[0]->data->content)
                    @elseif(!empty($primary->excerpt))
                        <p>{{ $primary->excerpt }}</p>
                    @endif
                </div>

                @if(!empty($primary->blocks[1]) && $primary->blocks[1]->type === 'markdown')
                <div class="prose prose-slate dark:prose-invert max-w-none prose-p:text-slate-500 mb-8">
                    @markdom($primary->blocks[1]->data->content)
                </div>
                @endif

                @if(!empty($primary->metadata['button']))
                <a href="{{ $primary->url }}"
                    class="inline-flex items-center gap-2 text-teal-700 dark:text-teal-400
                        font-semibold text-base border-b-2 border-teal-200 dark:border-teal-800
                        hover:border-teal-500 dark:hover:border-teal-500 transition-colors duration-300 pb-0.5">
                    {{ $primary->metadata['button'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                @endif

                @auth
                <div class="mt-6 flex items-center gap-1 text-xs text-slate-400">
                    <x-heroicon-s-pencil class="w-3 h-3" />
                    <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-teal-500 transition-colors">Edit</a>
                </div>
                @endauth
            </div>

            {{-- Image column: layered composition --}}
            <div class="relative mt-6 lg:mt-12">
                <div class="rounded-3xl overflow-hidden shadow-2xl shadow-slate-200 dark:shadow-slate-900 aspect-[3/4]">
                    <img src="{{ $primary->image?->url ?? $primary->getRandomImage() }}"
                        alt="{{ $primary->title }}"
                        class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                        loading="lazy" />
                </div>
                {{-- Subtle teal accent --}}
                <div class="absolute -bottom-5 -start-5 w-32 h-32 bg-teal-50 dark:bg-teal-950 rounded-3xl -z-10
                    border border-teal-100 dark:border-teal-900"></div>
            </div>

        </div>
    </div>
</section>
@endif
