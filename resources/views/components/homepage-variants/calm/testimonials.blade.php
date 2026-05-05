@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
@endphp
{{-- Calm Storytelling Testimonials: spacious centered narrative quotes --}}
<section class="calm-testimonials py-24 lg:py-36 bg-white dark:bg-slate-900 relative"
    id="{{ $category->slug ?? 'testimonials' }}">

    {{-- Faint watermark circle --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="w-[600px] h-[600px] rounded-full border border-teal-100 dark:border-teal-900 opacity-40"></div>
        <div class="absolute w-[800px] h-[800px] rounded-full border border-teal-50 dark:border-teal-900/50 opacity-30"></div>
    </div>

    <div class="relative container mx-auto px-6 max-w-5xl">

        {{-- Section header --}}
        <div class="text-center max-w-xl mx-auto mb-16">
            @if($category->name)
            <div class="flex items-center justify-center gap-3 mb-5">
                <span class="block w-px h-8 bg-teal-300 dark:bg-teal-700"></span>
                <span class="text-teal-700 dark:text-teal-400 text-xs font-semibold tracking-[0.2em] uppercase">{{ $category->name }}</span>
                <span class="block w-px h-8 bg-teal-300 dark:bg-teal-700"></span>
            </div>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 dark:text-slate-100 leading-snug">
                {{ $category->subtitle }}
            </h2>
            @endif
            @auth
            <div class="mt-4 flex items-center justify-center gap-1 text-xs text-slate-400">
                <x-heroicon-s-pencil class="w-3 h-3" />
                <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-teal-500 transition-colors">Edit</a>
            </div>
            @endauth
        </div>

        @if($count === 1)
        {{-- Single centered pull-quote --}}
        @php $post = $posts->first(); @endphp
        <div class="text-center max-w-2xl mx-auto">
            <svg class="w-12 h-12 text-teal-200 dark:text-teal-800 mx-auto mb-6" fill="currentColor" viewBox="0 0 32 32"
                aria-hidden="true">
                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
            </svg>
            @if(!empty($post->excerpt))
            <blockquote class="text-2xl md:text-3xl text-slate-700 dark:text-slate-200 font-medium italic
                leading-[1.7] mb-8">
                "{{ $post->excerpt }}"
            </blockquote>
            @endif
            <div class="flex items-center justify-center gap-4">
                @if($post->image)
                <img src="{{ $post->image?->url }}" alt="{{ $post->title }}"
                    class="w-14 h-14 rounded-full object-cover ring-2 ring-teal-100 dark:ring-teal-900" loading="lazy" />
                @endif
                <div class="text-start rtl:text-end">
                    <div class="font-bold text-slate-800 dark:text-slate-100">{{ $post->title }}</div>
                    @if(!empty($post->metadata['label']))
                    <div class="text-sm text-teal-600 dark:text-teal-400">{{ $post->metadata['label'] }}</div>
                    @endif
                </div>
            </div>
        </div>

        @else
        {{-- Multi-quote row: clean, spaced out --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($posts as $post)
            <article class="calm-quote flex flex-col text-center group">
                {{-- Subtle quote opener --}}
                <div class="w-8 h-0.5 bg-teal-200 dark:bg-teal-800 mx-auto mb-6 transition-all duration-500 group-hover:w-14 group-hover:bg-teal-400"></div>

                @if(!empty($post->excerpt))
                <blockquote class="text-slate-600 dark:text-slate-300 text-base italic leading-[1.9] mb-6 flex-1">
                    "{{ $post->excerpt }}"
                </blockquote>
                @endif

                <div class="flex items-center justify-center gap-3">
                    @if($post->image)
                    <img src="{{ $post->image?->url }}" alt="{{ $post->title }}"
                        class="w-10 h-10 rounded-full object-cover ring-1 ring-teal-100 dark:ring-teal-900" loading="lazy" />
                    @endif
                    <div class="text-start rtl:text-end">
                        <div class="font-semibold text-sm text-slate-800 dark:text-slate-100">{{ $post->title }}</div>
                        @if(!empty($post->metadata['label']))
                        <div class="text-xs text-teal-600 dark:text-teal-400">{{ $post->metadata['label'] }}</div>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif

    </div>
</section>
@endif
