@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- About Section Start -->
<div class="about-us" id="{{ $category->slug ?? 'about' }}">
    <div class="container">
        @if($count === 1)
        {{-- Single Spotlight Layout --}}
        @php $post = $posts->first(); @endphp
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-image">
                    <div class="about-img">
                        <figure class="reveal">
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                        </figure>
                    </div>
                </div>
                @auth
                <div class="flex items-center mt-2">
                    <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                    <a href="{{ $category->editUrl ?? '#' }}"
                        class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                </div>
                @endauth
            </div>
            <div class="col-lg-6">
                <div class="about-content">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">{{ $category->name ?? '' }}</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category->subtitle ?? '' }}</h2>
                        <div class="wow fadeInUp" data-wow-delay="0.25s">
                            {{-- @if(!empty($post->excerpt))
                            <p>{{ $post->excerpt }}</p> --}}
                            @if(isset($post->blocks[0]) && $post->blocks[0]->type === 'markdown')
                            @markdom($post->blocks[0]->data->content)
                            @endif
                        </div>
                    </div>
                    <div class="about-content-body wow fadeInUp" data-wow-delay="0.5s">
                        @if(isset($post->blocks[1]) && $post->blocks[1]->type === 'markdown')
                        @markdom($post->blocks[1]->data->content)
                        @endif
                    </div>
                    <div class="about-content-footer wow fadeInUp" data-wow-delay="0.75s">
                        @if(!empty($post->metadata['button']))
                        <div class="about-footer-btn">
                            <a href="{{ $post->url }}" class="btn-default">{{ $post->metadata['button'] }}</a>
                        </div>
                        @endif
                        @if(!empty($post->metadata['phone']))
                        <div class="about-contact-support">
                            <div class="icon-box">
                                @if(!empty($post->icon))
                                <x-icon name="{{ $post->icon }}" class="w-8 h-8" />
                                @endif
                            </div>
                            <div class="about-support-content">
                                <p>{{ $post->metadata['phone_label'] ?? '' }}</p>
                                <a href="tel:{{ $post->metadata['phone'] }}">
                                    <h3 dir="ltr" style="text-align: end">{{ $post->metadata['phone'] }}</h3>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Columns Split Layout --}}
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h3 class="wow fadeInUp">{{ $category->name ?? '' }}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category->subtitle ?? '' }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.25s">{{ $category->description ?? '' }}</p>
                </div>
                @auth
                <div class="flex items-center justify-center mt-2">
                    <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                    <a href="{{ $category->editUrl ?? '#' }}"
                        class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                </div>
                @endauth
            </div>
        </div>
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-6 col-md-6">
                <div class="about-item wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="about-image mb-4">
                        <figure class="reveal">
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                        </figure>
                    </div>
                    <h3>{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p>{{ $post->excerpt }}</p>
                    @else
                    @foreach($post->blocks as $block)
                    @if($block->type === 'markdown')
                    @markdom($block->data->content)
                    @endif
                    @endforeach
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}" class="btn-default mt-3">{{ $post->metadata['button'] }}</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Grid Layout for 3+ posts --}}
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <h3 class="wow fadeInUp">{{ $category->name ?? '' }}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category->subtitle ?? '' }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.25s">{{ $category->description ?? '' }}</p>
                </div>
                @auth
                <div class="flex items-center justify-center mt-2">
                    <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                    <a href="{{ $category->editUrl ?? '#' }}"
                        class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                </div>
                @endauth
            </div>
        </div>
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="about-item wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="about-image mb-4">
                        <figure class="reveal">
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                        </figure>
                    </div>
                    <h3>{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p>{{ $post->excerpt }}</p>
                    @else
                    @foreach($post->blocks as $block)
                    @if($block->type === 'markdown')
                    @markdom($block->data->content)
                    @endif
                    @endforeach
                    @endif
                    @if(!empty($post->metadata['button']))
                    <a href="{{ $post->url }}" class="btn-default mt-3">{{ $post->metadata['button'] }}</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- About Section End -->
@endif
