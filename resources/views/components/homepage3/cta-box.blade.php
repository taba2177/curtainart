@props(['posts'])
@if($posts->isNotEmpty())
@php
$post = $posts->first();
@endphp
@if(auth()->check())
<div class="flex items-center">
    <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 border" />
    <a class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600"
        href="{{ $posts->first()->postCategory->editUrl }}" title="edit">
        تعديل <p>Welcome, {{ auth()->user()->name }}</p>
    </a>
</div>
@endif
<div class="cta-box" id="cta">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-8">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $post->title }}</h2>
                    <div class="wow fadeInUp">
                        @foreach ($post->blocks as $block)
                        @switch($block->type)
                        @case('markdown')
                        @markdom($block->data->content)
                        @break
                        @endswitch
                        @endforeach
                    </div>
                </div>
                <!-- Section Title End -->
                <!-- Section Btn Start -->
                @if(!empty($post->metadata['button']))
                <div class="section-btn wow fadeInUp" data-wow-delay="0.25s">
                    <a href="{{ $post->url }}" class="btn-default btn-large">{{ $post->metadata['button'] }}</a>
                </div>
                @endif
                <!-- Section Btn End -->
            </div>

            <div class="col-lg-5 col-md-4">
                <!-- Cta Box Image Start -->
                <div class="cta-box-image">
                    <figure>
                        <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                    </figure>
                </div>
                <!-- Cta Box Image End -->
            </div>
        </div>
    </div>
</div>
@endif
