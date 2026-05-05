@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- What I Do Section Start -->
<section class="bg-gray-100 dark:bg-gray-900 py-12" id="{{ $category->slug ?? 'what-i-do' }}">
    <div class="container mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <div class="relative">
                <img src="{{ asset($posts->first()->image?->url ?? $posts->first()->getRandomImage()) }}" alt="{{ $category->name ?? '' }}" class="w-full h-64 object-cover object-center">
                <div class="absolute inset-0 bg-black opacity-20"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h1 class="text-3xl font-extrabold text-white rtl:text-right">{{ $category->name ?? '' }}</h1>
                </div>
            </div>

            @auth
            <div class="flex items-center px-6 pt-4">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
            </div>
            @endauth

            <div class="py-8 px-6">
                @if($count === 1)
                {{-- Single Spotlight Layout --}}
                @php $post = $posts->first(); @endphp
                <div class="max-w-2xl mx-auto">
                    <div class="flex items-start space-x-4 rtl:space-x-reverse wow fadeInUp group">
                        <div class="flex-shrink-0">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="text-2xl text-primary dark:text-secondary w-8 h-8" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $post->excerpt }}</p>
                            @else
                            <div class="text-gray-600 dark:text-gray-400 prose dark:prose-invert mt-2">
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                @elseif($count === 2)
                {{-- Two Columns Split Layout --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                    <div class="flex items-start space-x-4 rtl:space-x-reverse wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                        <div class="flex-shrink-0">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="text-2xl text-primary dark:text-secondary w-6 h-6" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                            @else
                            <div class="text-gray-600 dark:text-gray-400 prose dark:prose-invert">
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
                    @endforeach
                </div>

                @elseif($count === 3)
                {{-- Three Columns Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                    <div class="flex items-start space-x-4 rtl:space-x-reverse wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                        <div class="flex-shrink-0">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="text-2xl text-primary dark:text-secondary w-6 h-6" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                            @else
                            <div class="text-gray-600 dark:text-gray-400 prose dark:prose-invert">
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
                    @endforeach
                </div>

                @else
                {{-- Two Columns Grid for 4+ posts --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                    <div class="flex items-start space-x-4 rtl:space-x-reverse wow fadeInUp group" data-wow-delay="{{ (($loop->index % 2) + 1) * 0.1 }}s">
                        <div class="flex-shrink-0">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="text-2xl text-primary dark:text-secondary w-6 h-6" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                            @else
                            <div class="text-gray-600 dark:text-gray-400 prose dark:prose-invert">
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
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- What I Do Section End -->
@endif
