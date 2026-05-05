@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Partners Section Start -->
<section class="partners-section py-16 lg:py-24 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800" id="{{ $category->slug ?? 'partners' }}">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12 lg:mb-16">
            <span class="inline-block px-4 py-2 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold rounded-full mb-4 wow fadeInUp">{{ $category->name ?? '' }}</span>
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle ?? '' }}</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto wow fadeInUp" data-wow-delay="0.2s">{{ $category->description ?? '' }}</p>
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
            </div>
            @endauth
        </div>

        @if($count === 1)
        {{-- Single Partner Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-4xl mx-auto">
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden group wow fadeInUp">
                <div class="absolute inset-0 bg-gradient-to-r from-primary-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="flex flex-col lg:flex-row items-center p-8 lg:p-12">
                    <div class="flex-shrink-0 mb-8 lg:mb-0 lg:mr-12 rtl:lg:ml-12 rtl:lg:mr-0">
                        @if($post->image)
                        <img src="{{ $post->image->url }}" alt="{{ $post->title }}" class="w-40 h-40 lg:w-48 lg:h-48 object-cover rounded-2xl shadow-lg">
                        @else
                        <div class="w-40 h-40 lg:w-48 lg:h-48 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="w-20 h-20 text-white" />
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="text-center lg:text-start rtl:lg:text-end flex-1">
                        <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}</h3>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">{{ $post->excerpt }}</p>
                        @else
                        <div class="prose dark:prose-invert prose-lg mb-6">
                            @foreach($post->blocks as $block)
                            @if($block->type === 'markdown')
                            @markdom($block->data->content)
                            @break
                            @endif
                            @endforeach
                        </div>
                        @endif
                        @if(!empty($post->metadata['button']))
                        <a href="{{ $post->url }}" class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                            {{ $post->metadata['button'] }}
                            <x-heroicon-o-arrow-left class="w-5 h-5 rtl:rotate-180" />
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Partners Side by Side --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($posts as $post)
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-xl overflow-hidden group wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                <div class="absolute inset-0 bg-gradient-to-br from-primary-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="p-8">
                    <div class="flex items-start gap-6">
                        <div class="flex-shrink-0">
                            @if($post->image)
                            <img src="{{ $post->image->url }}" alt="{{ $post->title }}" class="w-20 h-20 object-cover rounded-xl shadow-md">
                            @else
                            <div class="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-md">
                                @if(!empty($post->icon))
                                <x-icon name="{{ $post->icon }}" class="w-10 h-10 text-white" />
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                            @else
                            <div class="prose dark:prose-invert prose-sm">
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @break
                                @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(!empty($post->metadata['button']))
                    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                        <a href="{{ $post->url }}" class="inline-flex items-center gap-2 text-primary-500 hover:text-primary-600 font-semibold transition-colors">
                            {{ $post->metadata['button'] }}
                            <x-heroicon-o-arrow-left class="w-4 h-4 rtl:rotate-180" />
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Grid Layout for 3+ Partners --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.1 }}s">
                <div class="absolute top-0 left-0 rtl:right-0 rtl:left-auto w-1 h-full bg-gradient-to-b from-primary-500 to-primary-600 transform -translate-x-full group-hover:translate-x-0 rtl:translate-x-full rtl:group-hover:translate-x-0 transition-transform duration-300"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-4">
                        @if($post->image)
                        <img src="{{ $post->image->url }}" alt="{{ $post->title }}" class="w-14 h-14 object-cover rounded-xl">
                        @else
                        <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="w-7 h-7 text-white" />
                            @endif
                        </div>
                        @endif
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex-1">{{ $post->title }}</h3>
                    </div>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3">{{ $post->excerpt }}</p>
                    @else
                    <div class="prose dark:prose-invert prose-sm line-clamp-3">
                        @foreach($post->blocks as $block)
                        @if($block->type === 'markdown')
                        @markdom($block->data->content)
                        @break
                        @endif
                        @endforeach
                    </div>
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}" class="inline-flex items-center gap-1 text-primary-500 hover:text-primary-600 text-sm font-medium mt-4 transition-colors">
                        {{ $post->metadata['button'] }}
                        <x-heroicon-o-arrow-left class="w-4 h-4 rtl:rotate-180" />
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Partners Section End -->
@endif
