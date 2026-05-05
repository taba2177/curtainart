@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Testimonials Section Start -->
<section class="testimonials-section relative py-16 lg:py-24 bg-gray-50 overflow-hidden" id="{{ $category->slug ?? 'testimonials' }}">
    <div class="absolute top-0 left-0 w-80 h-80 bg-primary-100 rounded-full opacity-60 blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-secondary-100 rounded-full opacity-50 blur-3xl translate-x-1/2 translate-y-1/2"></div>

    <div class="container mx-auto px-4 relative z-10">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            @if($category->name)
            <span class="inline-block px-4 py-1.5 bg-primary-100 text-primary-700 text-sm font-medium rounded-full mb-4 wow fadeInUp">{{ $category->name }}</span>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle }}</h2>
            @endif
            @if($category->description)
            <p class="text-gray-600 text-lg wow fadeInUp" data-wow-delay="0.2s">{!! $category->description !!}</p>
            @endif
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-gray-400" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        @if($count === 1)
        {{-- Single Testimonial Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-3xl mx-auto wow fadeInUp">
            <div class="bg-white rounded-3xl shadow-xl p-8 lg:p-12 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <svg class="w-12 h-12 text-primary-500" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                    </svg>
                </div>
                <div class="flex flex-col items-center text-center">
                    @if(!empty($post->image))
                    <div class="w-24 h-24 rounded-full overflow-hidden mb-6 ring-4 ring-primary-100">
                        <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    @if(!empty($post->excerpt))
                    <p class="text-gray-700 text-xl lg:text-2xl leading-relaxed mb-6">{{ $post->excerpt }}</p>
                    @endif
                    <h4 class="text-lg font-bold text-gray-900 mb-1">{{ $post->title }}</h4>
                    @if(!empty($post->metadata['label']))
                    <span class="text-primary-600 font-medium">{{ $post->metadata['label'] }}</span>
                    @endif
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Testimonials --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-5xl mx-auto">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8 relative group hover:shadow-xl transition-shadow duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                <div class="absolute top-6 right-6">
                    <svg class="w-8 h-8 text-primary-200 group-hover:text-primary-300 transition-colors" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                    </svg>
                </div>
                <div class="flex items-start gap-4 mb-4">
                    @if(!empty($post->image))
                    <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0 ring-2 ring-primary-100">
                        <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-gray-900 mb-1">{{ $post->title }}</h4>
                        @if(!empty($post->metadata['label']))
                        <span class="text-sm text-primary-600">{{ $post->metadata['label'] }}</span>
                        @endif
                    </div>
                </div>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 leading-relaxed">{{ $post->excerpt }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Testimonials - Carousel Style --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg p-6 relative group hover:shadow-xl hover:-translate-y-1 transition-all duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                <div class="absolute top-4 right-4">
                    <svg class="w-6 h-6 text-primary-200" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                    </svg>
                </div>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 leading-relaxed mb-6 pt-4">{{ $post->excerpt }}</p>
                @endif
                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                    @if(!empty($post->image))
                    <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
                        <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div>
                        <h4 class="font-semibold text-gray-900 text-sm">{{ $post->title }}</h4>
                        @if(!empty($post->metadata['label']))
                        <span class="text-xs text-primary-600">{{ $post->metadata['label'] }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Four+ Testimonials - Masonry/Grid Layout --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <div class="bg-white rounded-xl shadow-md p-5 relative group hover:shadow-lg transition-shadow duration-300 wow fadeInUp @if($loop->first) md:col-span-2 lg:col-span-1 @endif" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.1 }}s">
                <div class="flex items-start gap-3 mb-3">
                    @if(!empty($post->image))
                    <div class="w-11 h-11 rounded-full overflow-hidden flex-shrink-0">
                        <img src="{{ asset($post->image?->url) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-gray-900 text-sm truncate">{{ $post->title }}</h4>
                        @if(!empty($post->metadata['label']))
                        <span class="text-xs text-primary-600 block truncate">{{ $post->metadata['label'] }}</span>
                        @endif
                    </div>
                    <svg class="w-5 h-5 text-primary-200 flex-shrink-0" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                    </svg>
                </div>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 text-sm leading-relaxed">{{ $post->excerpt }}</p>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Testimonials Section End -->
@endif
