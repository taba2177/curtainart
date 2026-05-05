
@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Why Choose Us Section Start -->
<div class="why-choose-us" id="{{ $category->slug ?? 'why-choose' }}">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp text-xs">{{ $category->name ?? '' }}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category->subtitle ?? '' }}</h2>
                    <p class="wow fadeInUp" data-wow-delay="0.25s">{{ $category->description ?? '' }}</p>
                </div>
                @auth
                <div class="flex items-center mt-2">
                    <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
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
                <div class="why-choose-item wow fadeInUp text-center group">
                    <div class="icon-box mx-auto mb-3">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-10 h-10" />
                        @endif
                    </div>
                    <div class="why-choose-content">
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
                    @if($post->image)
                    <div class="why-choose-image mt-4">
                        <figure class="image-anime reveal">
                            <img src="{{ $post->image->url }}" alt="{{ $post->title }}">
                        </figure>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Columns Split Layout --}}
        <div class="row">
            @foreach($posts as $post)
            <div class="col-lg-6 col-md-6">
                <div class="why-choose-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-8 h-8" />
                        @endif
                    </div>
                    <div class="why-choose-content">
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
        {{-- Original 3-column layout with middle image --}}
        <div class="row">
            @foreach($posts as $post)
            @if($loop->index === 1)
            <div class="col-lg-4 col-md-6">
                <div class="why-choose-image">
                    <figure class="image-anime reveal">
                        <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                    </figure>
                </div>
            </div>
            @else
            <div class="col-lg-4 col-md-6">
                <div class="why-choose-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-8 h-8" />
                        @endif
                    </div>
                    <div class="why-choose-content">
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
            @endif
            @endforeach
        </div>

        @else
        {{-- Grid layout for 4+ posts --}}
        <div class="row">
            @foreach($posts as $post)
            @if($loop->index === 1 && $count >= 4)
            {{-- Show image for second post when 4+ items --}}
            <div class="col-lg-4 col-md-6">
                <div class="why-choose-image">
                    <figure class="image-anime reveal">
                        <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                    </figure>
                </div>
            </div>
            @else
            <div class="col-lg-4 col-md-6">
                <div class="why-choose-item wow fadeInUp group" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.25 }}s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-8 h-8" />
                        @endif
                    </div>
                    <div class="why-choose-content">
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
            @endif
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- Why Choose Us Section End -->
@endif
