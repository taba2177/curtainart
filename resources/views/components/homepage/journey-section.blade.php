@props(['posts'])

@if($posts->isNotEmpty())
@php
// Use the first post for section-wide details
$firstPost = $posts->first();
$category = $firstPost->postCategory;
@endphp

<section id="{{ $category?->slug ?? 'journey' }}"
    style="background-image: url({{ $firstPost->images[0]?->url ?? $firstPost->image?->url }}); background-size: cover; background-position: center; background-attachment: fixed;"
    class="relative z-0 py-20 overflow-hidden">

    <div class="absolute top-0 right-0 w-full h-full bg-white/80 dark:bg-black/70 backdrop-blur-md -z-10"></div>

    <div
        class="absolute top-1/2 right-1/2 -translate-x-1/2 -translate-y-1/2 w-1/2 h-1/2 bg-gradient-to-br from-primary-500/20 to-secondary-500/20 rounded-full blur-3xl -z-20">
    </div>

    <div class="container">
        {{-- Section Header --}}
        <div class="mb-12 md:mb-16 text-center wow fadeInDown">
            <h2
                class="text-3xl md:text-4xl lg:text-5xl uppercase font-bold text-secondary-color dark:text-white-color tracking-wide">
                {{ $category?->subtitle ?? 'رحلتك الهندسية... مع جديان' }}
            </h2>
            <p class="mt-4 max-w-2xl mx-auto text-base text-gray-600 dark:text-gray-300">
                {{ $category?->description ?? 'نرافقك خطوة بخطوة من الفكرة إلى الواقع لتحقيق رؤيتك الهندسية بأعلى معايير الجودة.' }}
            </p>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════ --}}
        {{-- LAYOUT 1: Single Post - Immersive Spotlight Design --}}
        {{-- ═══════════════════════════════════════════════════════════════ --}}
        @if($posts->count() === 1)
        @php $post = $posts->first(); @endphp
        <div class="max-w-4xl mx-auto wow fadeInUp">
            <div
                class="relative bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-3xl shadow-2xl overflow-hidden group border border-white/50 dark:border-gray-700/50">
                <div class="flex flex-col lg:flex-row items-center">
                    {{-- Image Side --}}
                    <div class="w-full lg:w-1/2 relative">
                        <div class="absolute -top-4 -right-4 w-20 h-20 bg-primary-500/20 rounded-full blur-xl"></div>
                        <a href="{{ $post->url }}" class="block aspect-[4/3] overflow-hidden" data-tilt>
                            <img src="{{ asset($post->image?->url ?? $post->getRandomImage()) }}"
                                class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-110"
                                alt="{{ $post->title }}" />
                        </a>
                        {{-- Floating Step Number --}}
                        <div
                            class="absolute top-6 right-6 w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:rotate-12 transition-transform duration-300">
                            @if($post->icon)
                            <x-icon name="{{ $post->icon }}" class="w-8 h-8 text-white" />
                            @else
                            <span class="text-2xl font-bold text-white">01</span>
                            @endif
                        </div>
                    </div>

                    {{-- Content Side --}}
                    <div class="w-full lg:w-1/2 p-8 lg:p-12">
                        <h3
                            class="text-2xl lg:text-3xl text-secondary-color dark:text-white-color font-bold uppercase mb-6">
                            <a href="{{ $post->url }}" class="hover:text-primary-500 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h3>

                        <div class="prose dark:prose-invert text-gray-700 dark:text-gray-200 mb-6">
                            @foreach ($post->blocks as $block)
                            @switch($block->type)
                            @case('markdown')
                            @markdom($block->data->content)
                            @break
                            @case('figure')
                            <x-figure :image="$block->data->image" :alt="$block->data->alt"
                                :caption="$block->data->caption" />
                            @break
                            @endswitch
                            @endforeach
                        </div>

                        {{-- CTA Button --}}
                        @if($post->slug)
                        <a href="{{ $post->url }}"
                            class="inline-flex items-center gap-3 px-6 py-3 bg-gradient-to-r from-primary-500 to-secondary-500 hover:from-primary-600 hover:to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            {{ __('اكتشف المزيد') }}
                            <x-icon name="heroicon-o-arrow-left" class="w-5 h-5 rtl:rotate-180" />
                        </a>
                        @endif

                        {{-- Admin Edit --}}
                        @auth
                        <div class="mt-6">
                            <a href="{{ route('filament.admin.resources.posts.edit', $post->id) }}"
                                class="inline-flex items-center gap-2 text-yellow-600 hover:text-yellow-700 text-sm font-medium transition-colors">
                                <x-icon name="heroicon-o-pencil-square" class="w-4 h-4" />
                                {{ __('تعديل') }}
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════ --}}
        {{-- LAYOUT 2: Two Posts - Split Timeline Design --}}
        {{-- ═══════════════════════════════════════════════════════════════ --}}
        @elseif($posts->count() === 2)
        <div class="relative max-w-6xl mx-auto">
            {{-- Center Connection Line (Desktop) --}}
            <div
                class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-1.5 bg-gradient-to-r from-primary-500 to-secondary-500 rounded-full hidden lg:block">
            </div>

            <div class="grid md:grid-cols-2 gap-8 lg:gap-16">
                @foreach($posts as $index => $post)
                <div class="relative group wow fadeInUp" data-wow-delay="{{ $index * 0.2 }}s">
                    <div
                        class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/50 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        {{-- Image --}}
                        <div class="relative">
                            <div class="absolute -top-4 -right-4 w-16 h-16 bg-primary-500/20 rounded-full blur-xl">
                            </div>
                            <a href="{{ $post->url }}" class="block aspect-[16/10] overflow-hidden" data-tilt>
                                <img src="{{ asset($post->image?->url ?? $post->getRandomImage()) }}"
                                    class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105"
                                    alt="{{ $post->title }}" />
                            </a>
                            {{-- Step Number Badge --}}
                            <div
                                class="absolute top-4 right-4 w-14 h-14 bg-gradient-to-br {{ $index === 0 ? 'from-primary-500 to-blue-600' : 'from-secondary-500 to-purple-600' }} rounded-xl flex items-center justify-center shadow-lg transform group-hover:rotate-6 transition-transform duration-300">
                                @if($post->icon)
                                <x-icon name="{{ $post->icon }}" class="w-7 h-7 text-white" />
                                @else
                                <span
                                    class="text-xl font-bold text-white">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                @endif
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6 lg:p-8">
                            <h3
                                class="text-xl lg:text-2xl text-secondary-color dark:text-white-color font-bold uppercase mb-4 group-hover:text-primary-500 transition-colors">
                                <a href="{{ $post->url }}">{{ $post->title }}</a>
                            </h3>

                            <div class="prose dark:prose-invert text-gray-700 dark:text-gray-200 line-clamp-4">
                                @foreach ($post->blocks as $block)
                                @switch($block->type)
                                @case('markdown')
                                @markdom($block->data->content)
                                @break
                                @case('figure')
                                <x-figure :image="$block->data->image" :alt="$block->data->alt"
                                    :caption="$block->data->caption" />
                                @break
                                @endswitch
                                @endforeach
                            </div>

                            {{-- Read More --}}
                            @if($post->slug)
                            <a href="{{ $post->url }}"
                                class="inline-flex items-center gap-2 mt-4 text-primary-500 hover:text-primary-600 font-semibold transition-colors group/link">
                                {{ __('اقرأ المزيد') }}
                                <x-icon name="heroicon-o-arrow-left"
                                    class="w-4 h-4 rtl:rotate-180 transform group-hover/link:-translate-x-1 rtl:group-hover/link:translate-x-1 transition-transform" />
                            </a>
                            @endif

                            {{-- Admin Edit --}}
                            @auth
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('filament.admin.resources.posts.edit', $post->id) }}"
                                    class="inline-flex items-center gap-2 text-yellow-600 hover:text-yellow-700 text-sm font-medium transition-colors">
                                    <x-icon name="heroicon-o-pencil-square" class="w-4 h-4" />
                                    {{ __('تعديل المرحلة') }}
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>

                    {{-- Connection Dot (Desktop) --}}
                    <div
                        class="absolute {{ $index === 0 ? 'right-0 translate-x-1/2' : 'left-0 -translate-x-1/2' }} top-1/2 -translate-y-1/2 w-5 h-5 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full border-4 border-white dark:border-gray-900 shadow-lg hidden lg:block">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════ --}}
        {{-- LAYOUT 3: Three+ Posts - Alternating Timeline Design --}}
        {{-- ═══════════════════════════════════════════════════════════════ --}}
        @else
        <div class="relative flex flex-col items-center">
            {{-- Vertical Timeline Line --}}
            <div
                class="absolute top-0 right-1/2 -translate-x-1/2 h-full w-1 bg-gradient-to-b from-primary-500 via-secondary-500 to-purple-500 rounded-full hidden md:block">
            </div>

            @foreach($posts as $index => $post)
            @php
            $isEven = $index % 2 === 0;
            $colors = [
            ['from-primary-500', 'to-blue-600'],
            ['from-secondary-500', 'to-purple-600'],
            ['from-emerald-500', 'to-teal-600'],
            ['from-rose-500', 'to-pink-600'],
            ['from-amber-500', 'to-orange-600'],
            ];
            $color = $colors[$index % count($colors)];
            @endphp

            <div class="w-full flex justify-center mb-10 md:mb-0 wow fadeInUp" data-wow-delay="{{ $index * 0.15 }}s">
                {{-- Timeline Node (Desktop) --}}
                <div class="absolute right-1/2 -translate-x-1/2 z-10 hidden md:flex flex-col items-center"
                    style="top: {{ ($index * 100 / $posts->count()) + (50 / $posts->count()) }}%;">
                    <div
                        class="w-12 h-12 bg-gradient-to-br {{ $color[0] }} {{ $color[1] }} rounded-full flex items-center justify-center shadow-lg border-4 border-white dark:border-gray-900 group-hover:scale-125 transition-transform duration-300">
                        <span
                            class="text-white font-bold text-lg">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                <div
                    class="w-full flex flex-col md:flex-row items-center gap-8 md:gap-12 {{ $isEven ? '' : 'md:flex-row-reverse' }}">
                    {{-- Image Side --}}
                    <div class="w-full md:w-5/12 relative group/img">
                        <div
                            class="absolute -top-4 {{ $isEven ? '-right-4' : '-left-4' }} w-16 h-16 bg-primary-500/20 rounded-full blur-xl">
                        </div>
                        <a href="{{ $post->url }}"
                            class="block rounded-2xl overflow-hidden shadow-2xl transform transition-all duration-500 hover:scale-105 hover:shadow-3xl"
                            data-tilt>
                            <img src="{{ asset($post->image?->url ?? $post->getRandomImage()) }}"
                                class="w-full h-full object-cover aspect-[4/3]" alt="{{ $post->title }}" />
                        </a>
                        {{-- Floating Step Badge --}}
                        <div
                            class="absolute top-4 {{ $isEven ? 'right-4' : 'left-4' }} w-14 h-14 bg-gradient-to-br {{ $color[0] }} {{ $color[1] }} rounded-xl flex items-center justify-center shadow-xl transform group-hover/img:rotate-12 transition-transform duration-300">
                            @if($post->icon)
                            <x-icon name="{{ $post->icon }}" class="w-7 h-7 text-white" />
                            @else
                            <span
                                class="text-xl font-bold text-white">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Content Side --}}
                    <div
                        class="w-full md:w-5/12 {{ $isEven ? 'md:text-start' : 'md:text-start' }} relative group/content">
                        {{-- Mobile Step Number --}}
                        <div class="md:hidden flex items-center gap-3 mb-4">
                            <div
                                class="w-10 h-10 bg-gradient-to-br {{ $color[0] }} {{ $color[1] }} rounded-full flex items-center justify-center shadow-md">
                                <span
                                    class="text-white font-bold">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('المرحلة') }}
                                {{ $index + 1 }}</span>
                        </div>

                        <div
                            class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-6 lg:p-8 shadow-xl border border-white/50 dark:border-gray-700/50 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            <h3
                                class="text-xl lg:text-2xl text-secondary-color dark:text-white-color font-bold uppercase mb-4 group-hover/content:text-primary-500 transition-colors">
                                <a href="{{ $post->url }}">{{ $post->title }}</a>
                            </h3>

                            <div class="prose dark:prose-invert text-gray-700 dark:text-gray-200">
                                @foreach ($post->blocks as $block)
                                @switch($block->type)
                                @case('markdown')
                                @markdom($block->data->content)
                                @break
                                @case('figure')
                                <x-figure :image="$block->data->image" :alt="$block->data->alt"
                                    :caption="$block->data->caption" />
                                @break
                                @endswitch
                                @endforeach
                            </div>

                            {{-- Admin Edit --}}
                            @auth
                            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('filament.admin.resources.posts.edit', $post->id) }}"
                                    class="inline-flex items-center gap-2 text-yellow-600 hover:text-yellow-700 text-sm font-medium transition-colors">
                                    <x-icon name="heroicon-o-pencil-square" class="w-4 h-4" />
                                    {{ __('تعديل') }}
                                </a>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Timeline End Marker --}}
            <div class="hidden md:flex justify-center mt-8">
                <div
                    class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center shadow-xl border-4 border-white dark:border-gray-900">
                    <x-icon name="heroicon-o-check" class="w-7 h-7 text-white" />
                </div>
            </div>
        </div>
        @endif

        {{-- Section CTA Button --}}
        @if($category && isset($firstPost->metadata['button']))
        <div class="text-center mt-12 wow fadeInUp" data-wow-delay="{{ $posts->count() * 0.15 }}s">
            <a href="{{ $category->url }}" class="btn-default btn-large">
                {!! $firstPost->metadata['button'] !!}
            </a>
        </div>
        @endif
    </div>
</section>
@endif
