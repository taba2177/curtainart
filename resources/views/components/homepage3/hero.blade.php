@props(['posts'])
<!-- Hero Section Start -->
<div class="hero bg-section hero-slider">

    <div class="hero-slider-layout">
        <div class="swiper">
            <div class="swiper-wrapper">
                @foreach($posts as $post)
                <!-- Hero Slide Start -->
                <div class="swiper-slide">
                    <div class="hero-slide">
                        <!-- Slider Image Start -->
                        <div class="hero-slider-image">
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                                alt="{{ $post->title }}">
                        </div>
                        <!-- Slider Image End -->

                        <!-- Slider Content Start -->
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-12">
                                    <!-- Hero Content Start -->
                                    <div class="hero-content">
                                        <div class="section-title">
                                            <h3 class="wow fadeInUp">{{ $post->title }}</h3>
                                            @foreach ($post->blocks as $block)
                                            @if($block->type === 'markdown')
                                            <p class="wow fadeInUp" data-wow-delay="0.25s">
                                                @markdom($block->data->content)
                                            </p>
                                            @endif
                                            @endforeach
                                        </div>

                                        <div class="hero-content-body wow fadeInUp" data-wow-delay="0.5s">
                                            @if(!empty($post->metadata['button']))
                                            <a href="{{ $post->url }}" class="btn-default">
                                                {{ $post->metadata['button'] }}
                                            </a>
                                            @endif
                                            @if(!empty($post->metadata['button2']))
                                            <a href="{{ $post->metadata['button2_link'] ?? $post->url }}" class="btn-default btn-highlighted">
                                                {{ $post->metadata['button2'] }}
                                            </a>
                                            @endif
                                        </div>
                                        @if(auth()->check())
                                        <div class="flex items-center">
                                            <x-heroicon-s-pencil
                                                class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 border" />
                                            <a class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600"
                                                href="{{ $posts->first()->postCategory->editUrl }}" title="edit">
                                                تعديل <p>Welcome, {{ auth()->user()->name }}</p>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- Hero Content End -->
                                </div>
                            </div>
                        </div>
                        <!-- Slider Content End -->
                    </div>
                </div>
                <!-- Hero Slide End -->
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
<!-- Hero Section End -->
