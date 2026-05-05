@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
@endphp
{{-- Editorial Premium Testimonials: editorial pull-quote layout --}}
<section class="editorial-testimonials py-20 lg:py-28 bg-white dark:bg-gray-950 relative overflow-hidden"
    id="{{ $category->slug ?? 'testimonials' }}"
    style="scroll-margin-top:7rem">

    {{-- Background texture --}}
    <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:32px_32px] opacity-30 dark:opacity-10"></div>

    <div class="relative container mx-auto px-4">

        {{-- Section header --}}
        <div class="text-center max-w-2xl mx-auto mb-14">
            @if($category->name)
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="block w-8 h-px bg-amber-400"></span>
                <span class="text-xs font-semibold uppercase tracking-[0.2em]" style="color:#b45309">{{ $category->name }}</span>
                <span class="block w-8 h-px bg-amber-400"></span>
            </div>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white leading-tight">
                {{ $category->subtitle }}
            </h2>
            @endif
            @auth
            <div class="mt-3 flex items-center justify-center gap-1 text-xs text-gray-400">
                <x-heroicon-s-pencil class="w-3 h-3" />
                <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-amber-400 transition-colors">Edit</a>
            </div>
            @endauth
        </div>

        @if($count === 1)
        {{-- Single featured pull-quote --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-3xl mx-auto text-center">
            <svg class="w-14 h-14 text-amber-300 mx-auto mb-6 opacity-60" fill="currentColor" viewBox="0 0 32 32"
                aria-hidden="true">
                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
            </svg>
            @if(!empty($post->excerpt))
            <blockquote class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-gray-100 italic leading-relaxed mb-8">
                "{{ $post->excerpt }}"
            </blockquote>
            @endif
            <div class="flex items-center justify-center gap-4">
                @if($post->image)
                <img src="{{ $post->image?->url }}" alt="{{ $post->title }}"
                    class="w-14 h-14 rounded-full object-cover ring-2 ring-amber-200" loading="lazy"
                    width="56" height="56"
                    onerror="this.src='{{ asset('images/placeholder.svg') }}';this.onerror=null" />
                @endif
                <div class="text-start rtl:text-end">
                    <div class="font-bold text-gray-900 dark:text-white">{{ $post->title }}</div>
                    @if(!empty($post->metadata['label']))
                    <div class="text-sm text-amber-500">{{ $post->metadata['label'] }}</div>
                    @endif
                </div>
            </div>
        </div>

        @else
        {{-- Multi-quote editorial layout --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($posts as $post)
            <article class="editorial-quote group relative bg-gray-50 dark:bg-gray-900 rounded-3xl p-8
                border border-gray-100 dark:border-gray-800 hover:border-amber-200 dark:hover:border-amber-800
                hover:shadow-lg hover:-translate-y-1"
                style="transition:box-shadow 0.3s ease,transform 0.3s ease,border-color 0.3s ease">

                {{-- Top accent --}}
                <div class="w-10 h-1 bg-amber-400 rounded-full mb-6"></div>

                @if(!empty($post->excerpt))
                <blockquote class="text-gray-700 dark:text-gray-300 text-base leading-relaxed italic mb-6">
                    "{{ $post->excerpt }}"
                </blockquote>
                @endif

                <div class="flex items-center gap-3 mt-auto">
                    @if($post->image)
                    <img src="{{ $post->image?->url }}" alt="{{ $post->title }}"
                        class="w-10 h-10 rounded-full object-cover ring-2 ring-amber-100 dark:ring-amber-900"
                        loading="lazy"
                        onerror="this.src='{{ asset('images/placeholder.svg') }}';this.onerror=null" />
                    @endif
                    <div>
                        <div class="font-bold text-sm text-gray-900 dark:text-white">{{ $post->title }}</div>
                        @if(!empty($post->metadata['label']))
                        <div class="text-xs text-amber-500">{{ $post->metadata['label'] }}</div>
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
