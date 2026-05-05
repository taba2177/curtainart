@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
    $primary   = $posts->first();
@endphp
{{-- Editorial Premium About: asymmetric two-column with large image reveal --}}
<section class="editorial-about py-20 lg:py-32 bg-white dark:bg-gray-950 overflow-hidden"
    id="{{ $category->slug ?? 'about' }}"
    style="scroll-margin-top:7rem">
    <div class="container mx-auto px-4">

        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Image column (appears second on mobile, first on LTR desktop, second on RTL desktop) --}}
            <div class="relative order-2 lg:order-1 rtl:lg:order-2">
                <div class="relative rounded-2xl overflow-hidden aspect-[4/5] shadow-2xl">
                    <img src="{{ $primary->image?->url ?? $primary->getRandomImage() }}"
                        alt="{{ $primary->title }}"
                        class="w-full h-full object-cover transition-transform duration-700 hover:scale-105"
                        loading="lazy"
                        width="600" height="750"
                        onerror="this.src='{{ asset('images/placeholder.svg') }}';this.onerror=null" />
                    {{-- Amber accent block --}}
                    <div class="absolute -bottom-4 -end-4 w-32 h-32 bg-amber-400 rounded-2xl -z-10"></div>
                </div>
                {{-- Floating stat tag --}}
                <div class="absolute top-8 -end-4 lg:-end-8 bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-4 z-10 max-w-[160px]">
                    <div class="text-3xl font-extrabold leading-none mb-1" style="color:#b45309">
                        {{ $category->subtitle ? substr($category->subtitle, 0, 4) : '15+' }}
                    </div>
                    <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 leading-tight">
                        {{ __('Years of Excellence') }}
                    </div>
                </div>
            </div>

            {{-- Text column --}}
            <div class="order-1 lg:order-2 rtl:lg:order-1">

                {{-- Section label --}}
                <div class="flex items-center gap-3 mb-5">
                    <span class="block w-8 h-px bg-amber-400"></span>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em]" style="color:#b45309">
                        {{ $category->name ?? '' }}
                    </span>
                </div>

                {{-- Headline --}}
                @if($category->subtitle)
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 dark:text-white
                    leading-tight mb-6 [text-wrap:balance]">
                    {{ $category->subtitle }}
                </h2>
                @endif

                {{-- Body from blocks --}}
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
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 dark:bg-amber-400 text-white dark:text-gray-950
                        font-bold text-sm rounded-full transition-all duration-300 hover:scale-105 shadow hover:shadow-lg">
                    {{ $primary->metadata['button'] }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                @endif

                @auth
                <div class="mt-4 flex items-center gap-1 text-xs text-gray-400">
                    <x-heroicon-s-pencil class="w-3 h-3" />
                    <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-amber-400 transition-colors">Edit</a>
                </div>
                @endauth
            </div>

        </div>
    </div>
</section>
@endif
