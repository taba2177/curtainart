@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();

// Load children categories with their published posts using fresh query
$childCategoriesWithPosts = \Taba\Crm\Models\PostCategory::where('parent_id', $category->id)
->with(['posts' => function($query) {
$query->published()->orderBy('order', 'asc');
}])
->orderBy('order', 'asc')
->get()
->filter(function($child) {
return $child->posts->isNotEmpty();
});

$showChildCategories = $childCategoriesWithPosts->count() > 0;
@endphp
<!-- Services Showcase Section Start -->
<section class="services-showcase py-16 lg:py-24 bg-gray-50 dark:bg-gray-900" id="{{ $category->slug ?? 'services' }}">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mb-12 lg:mb-16">
            <div class="max-w-2xl mb-6 lg:mb-0">
                <span
                    class="inline-block px-4 py-2 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold rounded-full mb-4 wow fadeInUp">{{ $category->name ?? '' }}</span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4 wow fadeInUp"
                    data-wow-delay="0.1s">{{ $category->subtitle ?? '' }}</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 wow fadeInUp" data-wow-delay="0.2s">
                    {{ $category->description ?? '' }}</p>
            </div>
            @auth
            <div class="flex items-center">
                <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                <a href="{{ $category->editUrl ?? '#' }}"
                    class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
            </div>
            @endauth
        </div>

        {{-- ═══════════════════════════════════════════════════════════════ --}}
        {{-- CHILD CATEGORIES LAYOUT - Show child categories with their posts --}}
        {{-- ═══════════════════════════════════════════════════════════════ --}}
        @if($showChildCategories)
        @php $childCount = $childCategoriesWithPosts->count(); @endphp

        {{-- Single Child Category --}}
        @if($childCount === 1)
        @php $childCategory = $childCategoriesWithPosts->first(); @endphp
        <div class="max-w-5xl mx-auto">
            <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden wow fadeInUp">
                {{-- Child Category Header --}}
                <div class="p-6 lg:p-8 border-b border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        @if($childCategory->icon)
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <x-icon name="{{ $childCategory->icon }}" class="w-7 h-7 text-white" />
                        </div>
                        @endif
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $childCategory->title }}
                            </h3>
                            @if($childCategory->description)
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $childCategory->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Child Category Posts --}}
                <div class="p-6 lg:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($childCategory->posts as $post)
                        <a href="{{ $post->url }}"
                            class="group flex items-start gap-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            @if($post->icon)
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-900/50 transition-colors">
                                <x-icon name="{{ $post->icon }}"
                                    class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                            </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <h4
                                    class="font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    {{ $post->title }}</h4>
                                @if($post->excerpt)
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mt-1">
                                    {{ $post->excerpt }}</p>
                                @endif
                            </div>
                            <x-icon name="heroicon-o-arrow-left"
                                class="w-5 h-5 text-gray-400 group-hover:text-primary-500 rtl:rotate-180 flex-shrink-0 transform group-hover:-translate-x-1 rtl:group-hover:translate-x-1 transition-all" />
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Two Child Categories --}}
        @elseif($childCount === 2)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($childCategoriesWithPosts as $index => $childCategory)
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden wow fadeInUp"
                data-wow-delay="{{ ($index + 1) * 0.15 }}s">
                {{-- Child Category Header --}}
                <div
                    class="p-6 bg-gradient-to-r {{ $index === 0 ? 'from-primary-500 to-primary-600' : 'from-secondary-500 to-secondary-600' }}">
                    <div class="flex items-center gap-4">
                        @if($childCategory->icon)
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                            <x-icon name="{{ $childCategory->icon }}" class="w-6 h-6 text-white" />
                        </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-bold text-white">{{ $childCategory->title }}</h3>
                            @if($childCategory->description)
                            <p class="text-white/80 text-sm mt-1">{{ $childCategory->description }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Child Category Posts --}}
                <div class="p-6">
                    <div class="space-y-3">
                        @foreach($childCategory->posts->take(5) as $post)
                        <a href="{{ $post->url }}"
                            class="group flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            @if($post->icon)
                            <div
                                class="flex-shrink-0 w-9 h-9 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 transition-colors">
                                <x-icon name="{{ $post->icon }}"
                                    class="w-4 h-4 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors" />
                            </div>
                            @endif
                            <span
                                class="flex-1 font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">{{ $post->title }}</span>
                            <x-icon name="heroicon-o-chevron-left"
                                class="w-4 h-4 text-gray-400 group-hover:text-primary-500 rtl:rotate-180 transition-colors" />
                        </a>
                        @endforeach
                    </div>

                    @if($childCategory->posts->count() > 5)
                    <a href="{{ $childCategory->url }}"
                        class="inline-flex items-center gap-2 text-primary-500 hover:text-primary-600 font-semibold mt-4 transition-colors">
                        {{ __('عرض الكل') }} ({{ $childCategory->posts->count() }})
                        <x-icon name="heroicon-o-arrow-left" class="w-4 h-4 rtl:rotate-180" />
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Three+ Child Categories - Tabs or Accordion Style --}}
        @else
        <div x-data="{ activeTab: '{{ $childCategoriesWithPosts->first()->slug }}' }">
            {{-- Category Tabs --}}
            <div class="flex flex-wrap gap-2 mb-8 justify-center">
                @foreach($childCategoriesWithPosts as $childCategory)
                <button @click="activeTab = '{{ $childCategory->slug }}'"
                    :class="activeTab === '{{ $childCategory->slug }}' ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'"
                    class="flex items-center gap-2 px-5 py-3 rounded-xl font-semibold transition-all duration-300 wow fadeInUp"
                    data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                    @if($childCategory->icon)
                    <x-icon name="{{ $childCategory->icon }}" class="w-5 h-5" />
                    @endif
                    <span>{{ $childCategory->title }}</span>
                    <span class="px-2 py-0.5 text-xs rounded-full"
                        :class="activeTab === '{{ $childCategory->slug }}' ? 'bg-white/20' : 'bg-gray-200 dark:bg-gray-600'">{{ $childCategory->posts->count() }}</span>
                </button>
                @endforeach
            </div>

            {{-- Tab Content --}}
            @foreach($childCategoriesWithPosts as $childCategory)
            <div x-show="activeTab === '{{ $childCategory->slug }}'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">

                {{-- Category Description --}}
                @if($childCategory->description)
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400">{{ $childCategory->description }}</p>
                </div>
                @endif

                {{-- Posts Grid --}}
                <div class="p-6">
                    @php $childPosts = $childCategory->posts; $childPostCount = $childPosts->count(); @endphp

                    @if($childPostCount <= 4) <div
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min($childPostCount, 4) }} gap-4">
                        @foreach($childPosts as $post)
                        <a href="{{ $post->url }}"
                            class="group block p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start gap-3">
                                @if($post->icon)
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-900/50 transition-colors">
                                    <x-icon name="{{ $post->icon }}"
                                        class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="font-bold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                        {{ $post->title }}</h4>
                                    @if($post->excerpt)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mt-1">
                                        {{ $post->excerpt }}</p>
                                    @endif
                                </div>
                            </div>
                        </a>
                        @endforeach
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach($childPosts as $post)
                    <a href="{{ $post->url }}"
                        class="group flex items-center gap-3 p-4 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-md transition-all duration-300">
                        @if($post->icon)
                        <div
                            class="flex-shrink-0 w-9 h-9 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                            <x-icon name="{{ $post->icon }}" class="w-4 h-4 text-primary-600 dark:text-primary-400" />
                        </div>
                        @endif
                        <span
                            class="flex-1 font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-1">{{ $post->title }}</span>
                        <x-icon name="heroicon-o-chevron-left"
                            class="w-4 h-4 text-gray-400 group-hover:text-primary-500 rtl:rotate-180 flex-shrink-0 transition-colors" />
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- View All Link --}}
            <div class="px-6 pb-6">
                <a href="{{ $childCategory->url }}"
                    class="inline-flex items-center gap-2 text-primary-500 hover:text-primary-600 font-semibold transition-colors">
                    {{ __('عرض جميع') }} {{ $childCategory->title }}
                    <x-icon name="heroicon-o-arrow-left" class="w-4 h-4 rtl:rotate-180" />
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- PARENT POSTS LAYOUTS - Original layouts when no child categories --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @elseif($count === 1)
    {{-- Single Service Hero Card --}}
    @php $post = $posts->first(); @endphp
    <div class="max-w-5xl mx-auto">
        <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl overflow-hidden group wow fadeInUp">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="relative h-64 lg:h-auto">
                    @if($post->image)
                    <img src="{{ $post->image->url }}" alt="{{ $post->title }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    @else
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-24 h-24 text-white/50" />
                        @endif
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent lg:hidden"></div>
                </div>
                <div class="p-8 lg:p-12">
                    @if(!empty($post->icon))
                    <div
                        class="hidden lg:flex w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-2xl items-center justify-center mb-6">
                        <x-icon name="{{ $post->icon }}" class="w-8 h-8 text-primary-600 dark:text-primary-400" />
                    </div>
                    @endif
                    <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $post->title }}
                    </h3>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">{{ $post->excerpt }}</p>
                    @else
                    <div class="prose dark:prose-invert prose-lg mb-6">
                        @foreach($post->blocks as $block)
                        @if($block->type === 'markdown')
                        @markdom($block->data->content)
                        @endif
                        @endforeach
                    </div>
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}"
                        class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-8 py-4 rounded-xl font-bold transition-colors">
                        {{ $post->metadata['button'] }}
                        <x-icon name="heroicon-o-arrow-left" class="w-5 h-5 rtl:rotate-180" />
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @elseif($count === 2)
    {{-- Two Services Split Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @foreach($posts as $post)
        <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden group hover:shadow-2xl transition-shadow duration-300 wow fadeInUp"
            data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
            <div class="relative h-56 overflow-hidden">
                @if($post->image)
                <img src="{{ $post->image->url }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                @else
                <div
                    class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                    @if(!empty($post->icon))
                    <x-icon name="{{ $post->icon }}" class="w-16 h-16 text-white/50" />
                    @endif
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                @if(!empty($post->icon))
                <div
                    class="absolute bottom-4 right-4 rtl:left-4 rtl:right-auto w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <x-icon name="{{ $post->icon }}" class="w-6 h-6 text-white" />
                </div>
                @endif
            </div>
            <div class="p-6 lg:p-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $post->excerpt }}</p>
                @else
                <div class="prose dark:prose-invert prose-sm mb-4">
                    @foreach($post->blocks as $block)
                    @if($block->type === 'markdown')
                    @markdom($block->data->content)
                    @break
                    @endif
                    @endforeach
                </div>
                @endif
                @if(!empty($post->metadata['button']))
                <a href="{{ $post->url }}"
                    class="inline-flex items-center gap-2 text-primary-500 hover:text-primary-600 font-semibold transition-colors">
                    {{ $post->metadata['button'] }}
                    <x-icon name="heroicon-o-arrow-left"
                        class="w-4 h-4 rtl:rotate-180 transform group-hover:-translate-x-1 rtl:group-hover:translate-x-1 transition-transform" />
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    @elseif($count >= 3 && $count <= 4) {{-- 3-4 Services Masonry Grid --}} <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <div class="@if($loop->first) md:col-span-2 lg:col-span-1 lg:row-span-2 @endif bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300 wow fadeInUp"
            data-wow-delay="{{ (($loop->index % 3) + 1) * 0.1 }}s">
            <div class="relative @if($loop->first) h-48 lg:h-64 @else h-40 @endif overflow-hidden">
                @if($post->image)
                <img src="{{ $post->image->url }}" alt="{{ $post->title }}"
                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                @else
                <div
                    class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                    @if(!empty($post->icon))
                    <x-icon name="{{ $post->icon }}" class="w-12 h-12 text-white/50" />
                    @endif
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
            </div>
            <div class="p-6">
                <div class="flex items-start gap-3 mb-3">
                    @if(!empty($post->icon))
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                        <x-icon name="{{ $post->icon }}" class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                    </div>
                    @endif
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $post->title }}</h3>
                </div>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 dark:text-gray-400 text-sm @if(!$loop->first) line-clamp-2 @endif">
                    {{ $post->excerpt }}</p>
                @else
                <div class="prose dark:prose-invert prose-sm @if(!$loop->first) line-clamp-2 @endif">
                    @foreach($post->blocks as $block)
                    @if($block->type === 'markdown')
                    @markdom($block->data->content)
                    @break
                    @endif
                    @endforeach
                </div>
                @endif
                @if(!empty($post->metadata['button']))
                <a href="{{ $post->url }}"
                    class="inline-flex items-center gap-1 text-primary-500 hover:text-primary-600 text-sm font-medium mt-4 transition-colors">
                    {{ $post->metadata['button'] }}
                    <x-icon name="heroicon-o-arrow-left" class="w-4 h-4 rtl:rotate-180" />
                </a>
                @endif
            </div>
        </div>
        @endforeach
        </div>

        @else
        {{-- 5+ Services Regular Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($posts as $post)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden group hover:shadow-lg transition-shadow duration-300 wow fadeInUp"
                data-wow-delay="{{ (($loop->index % 4) + 1) * 0.1 }}s">
                <div class="relative h-36 overflow-hidden">
                    @if($post->image)
                    <img src="{{ $post->image->url }}" alt="{{ $post->title }}"
                        class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500">
                    @else
                    <div
                        class="w-full h-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-10 h-10 text-white/50" />
                        @endif
                    </div>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $post->title }}
                    </h3>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">{{ $post->excerpt }}</p>
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}"
                        class="inline-flex items-center gap-1 text-primary-500 hover:text-primary-600 text-sm font-medium mt-3 transition-colors">
                        {{ $post->metadata['button'] }}
                        <x-icon name="heroicon-o-arrow-left" class="w-3 h-3 rtl:rotate-180" />
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
        </div>
</section>
<!-- Services Showcase Section End -->
@endif