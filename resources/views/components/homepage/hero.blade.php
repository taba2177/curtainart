@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Hero Section Start -->
<div class="hero bg-section hero-slider" id="{{ $category->slug ?? 'hero' }}">
    <div class="hero-slider-layout">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach($posts as $post)
                <!-- Hero Slide -->
                <div class="swiper-slide">
                    <div class="hero-slide">
                        <!-- Slider Image -->
                        <div class="hero-slider-image">
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                        </div>

                        <!-- Slider Content -->
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="hero-content">
                                        <div class="section-title">
                                            <h3 class="wow fadeInUp">{{ $post->title }}</h3>
                                            @if(!empty($post->excerpt))
                                            {{--
                                            <p class="wow fadeInUp" data-wow-delay="0.25s">{{ $post->excerpt }}</p>
                                            @else
                                             --}}
                                            <div class="wow fadeInUp" data-wow-delay="0.25s">
                                                @foreach($post->blocks as $block)
                                                @if($block->type === 'markdown')
                                                @markdom($block->data->content)
                                                @endif
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="hero-content-body wow fadeInUp" data-wow-delay="0.5s">
                                            @if(!empty($post->metadata['button']))
                                            <a href="{{ $post->url }}" class="btn-default">{{ $post->metadata['button'] }}</a>
                                            @endif
                                            @if(!empty($post->metadata['button2']))
                                            <a href="{{ $post->metadata['button2_link'] ?? $post->url }}" class="btn-default btn-highlighted">{{ $post->metadata['button2'] }}</a>
                                            @endif
                                        </div>

                                        <!-- Admin Edit -->
                                        @auth
                                        <div class="flex items-center mt-4">
                                            <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                                            <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                                        </div>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($count > 1)
            <div class="swiper-pagination"></div>
            @endif
        </div>
    </div>
</div>
<!-- Hero Section End -->
@endif
