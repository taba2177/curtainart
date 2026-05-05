@props(['posts'])

@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
@endphp
<section class="bg-gray-100 dark:bg-gray-900 py-12">
    <div class="container mx-auto px-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
            <div class="relative">
                <img src="{{ asset($posts->first()->image?->url ?? $posts->first()->getRandomImage()) }}" alt="{{ $category->name ?? '' }}" class="w-full h-64 object-cover object-center">
                <div class="absolute inset-0 bg-black opacity-20"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h1 class="text-3xl font-extrabold text-white rtl:text-right">{{ $category->name ?? '' }}</h1>
                </div>
            </div>

            <div class="py-8 px-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                    <div class="flex items-start space-x-4 rtl:space-x-reverse wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                        <div class="flex-shrink-0">
                            @if(!empty($post->icon))
                            <x-icon name={{ "$post->icon" }} class="text-2xl text-primary dark:text-secondary w-6 h-6" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-gray-600 dark:text-gray-400">{{ $post->excerpt }}</p>
                            @else
                            <div class="text-gray-600 dark:text-gray-400 prose dark:prose-invert">
                                @foreach ($post->blocks as $block)
                                @switch($block->type)
                                @case('markdown')
                                @markdom($block->data->content)
                                @break
                                @endswitch
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif
