@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Our Blog Section Start -->
<div class="our-blog" id="{{ $category->slug ?? 'blog' }}">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp">{{ $category->name ?? '' }}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category->subtitle ?? '' }}</h2>
                    <p>{{ $category->description ?? '' }}</p>
                </div>
                @auth
                <div class="flex items-center mt-2">
                    <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                    <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                </div>
                @endauth
            </div>
        </div>

        @if($count === 1)
        {{-- Single Spotlight Layout --}}
        @php $post = $posts->first(); @endphp
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="blog-item wow fadeInUp group">
                    <div class="post-featured-image" data-cursor-text="">
                        <figure>
                            <a href="{{ $post->url }}" class="image-anime">
                                <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                            </a>
                        </figure>
                    </div>
                    <div class="post-item-content">
                        <div class="post-item-body">
                            <h2><a href="{{ $post->url }}">{{ $post->title }}</a></h2>
                        </div>
                        <div class="post-item-body">
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
                        </div>
                        @if(!empty($post->metadata['button']))
                        <div class="post-item-footer">
                            <a href="{{ $post->url }}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Columns Split Layout --}}
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-6 col-md-6">
                <div class="blog-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="post-featured-image" data-cursor-text="">
                        <figure>
                            <a href="{{ $post->url }}" class="image-anime">
                                <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                            </a>
                        </figure>
                    </div>
                    <div class="post-item-content">
                        <div class="post-item-body">
                            <h2><a href="{{ $post->url }}">{{ $post->title }}</a></h2>
                        </div>
                        <div class="post-item-body">
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
                        </div>
                        @if(!empty($post->metadata['button']))
                        <div class="post-item-footer">
                            <a href="{{ $post->url }}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Three Columns Grid for 3+ posts --}}
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="blog-item wow fadeInUp group" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.25 }}s">
                    <div class="post-featured-image" data-cursor-text="">
                        <figure>
                            <a href="{{ $post->url }}" class="image-anime">
                                <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                            </a>
                        </figure>
                    </div>
                    <div class="post-item-content">
                        <div class="post-item-body">
                            <h2><a href="{{ $post->url }}">{{ $post->title }}</a></h2>
                        </div>
                        <div class="post-item-body">
                            @if(!empty($post->excerpt))
                            <p>{{ $post->excerpt }}</p>
                            @endif
                        </div>
                        @if(!empty($post->metadata['button']))
                        <div class="post-item-footer">
                            <a href="{{ $post->url }}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Our Blog Section End -->
@endif
