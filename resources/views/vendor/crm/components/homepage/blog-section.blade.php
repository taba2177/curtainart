@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Blog Section Start -->
<section class="bg-gray-50 dark:bg-gray-900 py-12" id="{{ $category->slug ?? 'blog-section' }}">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-6 border-b dark:border-gray-700 pb-2">
            <div class="flex items-center">
                @if(!empty($posts->first()->icon))
                <x-icon name="{{ $posts->first()->icon }}" class="h-6 w-6 mr-2 text-primary-500 rtl:ml-2" />
                @endif
                <a href="{{ $category->url ?? '#' }}" class="text-lg font-semibold text-gray-800 dark:text-gray-100 hover:text-primary-500 dark:hover:text-primary-400 transition-colors">{{ $category->name ?? '' }}</a>
            </div>
            @if(!empty($category->metadata['button']))
            <a href="{{ $category->url ?? '#' }}" class="text-primary-500 hover:text-primary-400 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">{{ $category->metadata['button'] }}</a>
            @endif
            @auth
            <div class="flex items-center">
                <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
            </div>
            @endauth
        </div>

        @if($count === 1)
        {{-- Single Spotlight Layout --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-2xl mx-auto">
            <div class="rounded-xl overflow-hidden shadow-md dark:shadow-gray-700 flex flex-col bg-white dark:bg-gray-800 wow fadeInUp group">
                <a href="{{ $post->url }}">
                    <div class="relative">
                        <img class="w-full object-cover object-center aspect-video" src="{{ asset($post->image?->url ?? $post->getRandomImage()) }}" alt="{{ $post->title }}">
                        <div class="absolute inset-0 bg-black opacity-20 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute top-3 rtl:left-3 right-3">
                            <span class="bg-primary-500 text-white text-xs font-medium px-3 py-1 rounded-full">{{ $category->name ?? '' }}</span>
                        </div>
                    </div>
                </a>
                <div class="px-4 py-3 sm:px-6 sm:py-4 flex-grow flex flex-col justify-between">
                    <div>
                        <a href="{{ $post->url }}" class="block text-lg font-semibold text-gray-900 dark:text-gray-50 hover:text-primary-500 dark:hover:text-primary-400 transition-colors mb-2">{{ $post->title }}</a>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                        @else
                        <div class="prose dark:prose-invert line-clamp-3">
                            @foreach($post->blocks as $block)
                            @if($block->type === 'markdown')
                            @markdom($block->data->content)
                            @break
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-gray-500 dark:text-gray-400 text-sm flex items-center">
                            <x-icon name="heroicon-o-clock" class="h-4 w-4 mr-1 rtl:ml-1" />
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Columns Split Layout --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 lg:gap-8">
            @foreach($posts as $post)
            <div class="rounded-xl overflow-hidden shadow-md dark:shadow-gray-700 flex flex-col bg-white dark:bg-gray-800 wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                <a href="{{ $post->url }}">
                    <div class="relative">
                        <img class="w-full object-cover object-center aspect-video" src="{{ asset($post->image?->url ?? $post->getRandomImage()) }}" alt="{{ $post->title }}">
                        <div class="absolute inset-0 bg-black opacity-20 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute top-3 rtl:left-3 right-3">
                            <span class="bg-primary-500 text-white text-xs font-medium px-3 py-1 rounded-full">{{ $category->name ?? '' }}</span>
                        </div>
                    </div>
                </a>
                <div class="px-4 py-3 sm:px-6 sm:py-4 flex-grow flex flex-col justify-between">
                    <div>
                        <a href="{{ $post->url }}" class="block text-lg font-semibold text-gray-900 dark:text-gray-50 hover:text-primary-500 dark:hover:text-primary-400 transition-colors mb-2">{{ $post->title }}</a>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                        @else
                        <div class="prose dark:prose-invert line-clamp-3">
                            @foreach($post->blocks as $block)
                            @if($block->type === 'markdown')
                            @markdom($block->data->content)
                            @break
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-gray-500 dark:text-gray-400 text-sm flex items-center">
                            <x-icon name="heroicon-o-clock" class="h-4 w-4 mr-1 rtl:ml-1" />
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Three Columns Grid for 3+ posts --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
            <div class="rounded-xl overflow-hidden shadow-md dark:shadow-gray-700 flex flex-col bg-white dark:bg-gray-800 wow fadeInUp group" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.1 }}s">
                <a href="{{ $post->url }}">
                    <div class="relative">
                        <img class="w-full object-cover object-center aspect-video" src="{{ asset($post->image?->url ?? $post->getRandomImage()) }}" alt="{{ $post->title }}">
                        <div class="absolute inset-0 bg-black opacity-20 group-hover:opacity-10 transition-opacity duration-300"></div>
                        <div class="absolute top-3 rtl:left-3 right-3">
                            <span class="bg-primary-500 text-white text-xs font-medium px-3 py-1 rounded-full">{{ $post->postCategory->name ?? '' }}</span>
                        </div>
                    </div>
                </a>
                <div class="px-4 py-3 sm:px-6 sm:py-4 flex-grow flex flex-col justify-between">
                    <div>
                        <a href="{{ $post->url }}" class="block text-lg font-semibold text-gray-900 dark:text-gray-50 hover:text-primary-500 dark:hover:text-primary-400 transition-colors mb-2">{{ $post->title }}</a>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                        @else
                        <div class="prose dark:prose-invert line-clamp-3">
                            @foreach($post->blocks as $block)
                            @if($block->type === 'markdown')
                            @markdom($block->data->content)
                            @break
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-gray-500 dark:text-gray-400 text-sm flex items-center">
                            <x-icon name="heroicon-o-clock" class="h-4 w-4 mr-1 rtl:ml-1" />
                            {{ $post->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Blog Section End -->
@endif
