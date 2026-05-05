
@props(['posts'])
@if($posts->isNotEmpty())
<!-- Why Choose Us Section Start -->
<div class="why-choose-us" id="why-choose">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp text-xs">{{ $posts->first()->postCategory->name ?? '' }}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">
                        {{ $posts->first()->postCategory->subtitle ?? '' }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.25s">
                        {{ $posts->first()->postCategory->description ?? '' }}</p>
                </div>
                <!-- Section Title End -->
                @if(auth()->check())
                <div class="flex items-center">
                    <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 border" />
                    <a class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600"
                        href="{{ $posts->first()->postCategory->editUrl }}" title="edit">
                        تعديل <p>Welcome, {{ auth()->user()->name }}</p>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            @foreach($posts as $post)
            @if($loop->index % 3 == 1)
            <!-- Middle column (for images) -->
            <div class="col-lg-4 col-md-6">
                <!-- Why Choose Image Start -->
                <div class="why-choose-image">
                    <figure class="image-anime reveal">
                        <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                            alt="{{ $post->title }}">
                    </figure>
                </div>
                <!-- Why Choose Image End -->
            </div>
            @else
            <!-- Left/Right columns (for content) -->
            <div class="col-lg-4 col-md-6">
                <!-- Why Choose Item Start -->
                <div class="why-choose-item wow fadeInUp" data-wow-delay="0.25s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name={{ "$post->icon" }} class="w-8 h-8" />
                        @endif
                    </div>
                    <div class="why-choose-content">
                        <h3>{{ $post->title }}</h3>
                        @foreach ($post->blocks as $block)
                        @switch($block->type)
                        @case('markdown')
                        @markdom($block->data->content)
                        @break
                        @endswitch
                        @endforeach
                    </div>
                </div>
                <!-- Why Choose Item End -->
            </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
<!-- Why Choose Us Section End -->
@endif
