@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Service Benefit Section Start -->
<div class="service-benefit parallaxie" id="{{ $category->slug ?? 'services' }}">
    <div class="container">
        @auth
        <div class="flex items-center mb-4">
            <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
            <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
        </div>
        @endauth

        @if($count === 1)
        {{-- Single Spotlight Layout --}}
        @php $post = $posts->first(); @endphp
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="service-benefit-item wow fadeInUp text-center group">
                    <div class="icon-box mx-auto">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-16 h-16" />
                        @elseif($post->image)
                        <img src="{{ $post->image->url }}" alt="{{ $post->title }}">
                        @endif
                    </div>
                    <div class="service-benefit-content">
                        <h3>{{ $post->title }}</h3>
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
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Columns Split Layout --}}
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-6 col-md-6">
                <div class="service-benefit-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-12 h-12" />
                        @elseif($post->image)
                        <img src="{{ $post->image->url }}" alt="{{ $post->title }}">
                        @endif
                    </div>
                    <div class="service-benefit-content">
                        <h3>{{ $post->title }}</h3>
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
                </div>
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Columns Grid --}}
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <div class="service-benefit-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-12 h-12" />
                        @elseif($post->image)
                        <img src="{{ $post->image->url }}" alt="{{ $post->title }}">
                        @endif
                    </div>
                    <div class="service-benefit-content">
                        <h3>{{ $post->title }}</h3>
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
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Four Columns Grid for 4+ posts --}}
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-3 col-md-6">
                <div class="service-benefit-item wow fadeInUp group" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.25 }}s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-12 h-12" />
                        @elseif($post->image)
                        <img src="{{ $post->image->url }}" alt="{{ $post->title }}">
                        @endif
                    </div>
                    <div class="service-benefit-content">
                        <h3>{{ $post->title }}</h3>
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
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Service Benefit Section End -->
@endif
