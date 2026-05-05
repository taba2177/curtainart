@props(['posts'])
@if($posts->isNotEmpty())
@php
// Base category from the first post
$category = $posts->first()->postCategory;

// Try to use child categories' posts (if any) instead of parent posts
$childCategoriesWithPosts = \Taba\Crm\Models\PostCategory::where('parent_id', $category->id)
->with(['posts' => function($query) { $query->published()->orderBy('order', 'asc'); }])
->orderBy('order', 'asc')
->get()
->filter(function($child) { return $child->posts->isNotEmpty(); });

// Build the collection to display: prefer children posts if available
$displayPosts = $childCategoriesWithPosts->isNotEmpty()
? $childCategoriesWithPosts->flatMap(function($child){ return $child->posts; })
: $posts;

// Normalize to collection and unique by id to avoid duplicates, keep order
$displayPosts = collect($displayPosts)->unique('id')->values();
$count = $displayPosts->count();
@endphp
<!-- Our Service Section Start -->
<div class="our-service" id="{{ $category->slug ?? 'products' }}">
    <div class="light-bg-section">
        <div class="container mx-auto px-4">
            <div class="row section-row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">{{ $category->name ?? '' }}</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category->subtitle ?? '' }}</h2>
                        <p>{{ $category->description ?? '' }}</p>
                    </div>
                    @auth
                    <div class="flex items-center mt-2">
                        <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                        <a href="{{ $category->editUrl ?? '#' }}"
                            class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                    </div>
                    @endauth
                </div>
            </div>

            @if($count === 1)
            {{-- Single Spotlight Layout --}}
            @php $post = $displayPosts->first(); @endphp
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="service-item wow fadeInUp group">
                        <div class="service-image" data-cursor-text="">
                            <a href="{{ $post->url }}">
                                <figure>
                                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                                        alt="{{ $post->title }}">
                                </figure>
                            </a>
                        </div>
                        <div class="service-body">
                            <div class="service-body-title">
                                <h3>{{ $post->title }}</h3>
                            </div>
                            <div class="service-content">
                                @if(!empty($post->excerpt))
                                <p>{{ $post->excerpt }}</p>
                                @else
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @break
                                @endif
                                @endforeach
                                @endif
                                @if(!empty($post->metadata['button']))
                                <div class="service-content-footer">
                                    <a href="{{ $post->url }}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @elseif($count === 2)
            {{-- Two Columns Split Layout --}}
            <div class="row">
                @foreach($displayPosts as $post)
                <div class="col-lg-6 col-md-6">
                    <div class="service-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                        <div class="service-image" data-cursor-text="">
                            <a href="{{ $post->url }}">
                                <figure>
                                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                                        alt="{{ $post->title }}">
                                </figure>
                            </a>
                        </div>
                        <div class="service-body">
                            <div class="service-body-title">
                                <h3>{{ $post->title }}</h3>
                            </div>
                            <div class="service-content">
                                @if(!empty($post->excerpt))
                                <p>{{ $post->excerpt }}</p>
                                @else
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @break
                                @endif
                                @endforeach
                                @endif
                                @if(!empty($post->metadata['button']))
                                <div class="service-content-footer">
                                    <a href="{{ $post->url }}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @elseif($count === 3)
            {{-- Three Columns Grid --}}
            <div class="row">
                @foreach($displayPosts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                        <div class="service-image" data-cursor-text="">
                            <a href="{{ $post->url }}">
                                <figure>
                                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                                        alt="{{ $post->title }}">
                                </figure>
                            </a>
                        </div>
                        <div class="service-body">
                            <div class="service-body-title">
                                <h3>{{ $post->title }}</h3>
                            </div>
                            <div class="service-content">
                                @if(!empty($post->excerpt))
                                <p>{{ $post->excerpt }}</p>
                                @else
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @break
                                @endif
                                @endforeach
                                @endif
                                @if(!empty($post->metadata['button']))
                                <div class="service-content-footer">
                                    <a href="{{ $post->url }}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @else
            {{-- Four Columns Grid for 4+ posts --}}
            <div class="row">
                @foreach($displayPosts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="service-item wow fadeInUp group"
                        data-wow-delay="{{ (($loop->index % 4) + 1) * 0.25 }}s">
                        <div class="service-image" data-cursor-text="">
                            <a href="{{ $post->url }}">
                                <figure>
                                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                                        alt="{{ $post->title }}">
                                </figure>
                            </a>
                        </div>
                        <div class="service-body">
                            <div class="service-body-title">
                                <h3>{{ $post->title }}</h3>
                            </div>
                            <div class="service-content">
                                @if(!empty($post->excerpt))
                                <p>{{ $post->excerpt }}</p>
                                @else
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @break
                                @endif
                                @endforeach
                                @endif
                                @if(!empty($post->metadata['button']))
                                <div class="service-content-footer">
                                    <a href="{{ $post->url }}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

            @if(!empty($category->slug))
            <div class="service-footer-btn wow fadeInUp" data-wow-delay="1.25s">
                <a href="{{ route('dynamic.route', $category->slug) }}" class="btn-default">
                    {{ $displayPosts->first()->metadata['button'] ?? $category->name }}
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Our Service Section End -->
@endif
