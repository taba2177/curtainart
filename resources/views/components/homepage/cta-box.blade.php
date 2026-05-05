@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$post = $posts->first();
$count = $posts->count();
@endphp
<!-- CTA Box Section Start -->
<div class="cta-box" id="{{ $category->slug ?? 'cta' }}">
    <div class="container">
        @auth
        <div class="flex items-center mb-4">
            <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
            <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
        </div>
        @endauth

        @if($count === 1)
        {{-- Single Spotlight Layout --}}
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-8">
                <div class="section-title">
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $post->title }}</h2>
                    <div class="wow fadeInUp">
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
                @if(!empty($post->metadata['button']))
                <div class="section-btn wow fadeInUp" data-wow-delay="0.25s">
                    <a href="{{ $post->url }}" class="btn-default btn-large">{{ $post->metadata['button'] }}</a>
                </div>
                @endif
            </div>
            <div class="col-lg-5 col-md-4">
                <div class="cta-box-image">
                    <figure>
                        <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                    </figure>
                </div>
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Columns Split Layout --}}
        <div class="row">
            @foreach($posts as $item)
            <div class="col-lg-6 col-md-6">
                <div class="cta-item wow fadeInUp group" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <div class="section-title">
                        <h3 class="text-anime-style-3" data-cursor="-opaque">{{ $item->title }}</h3>
                        <div class="wow fadeInUp">
                            @if(!empty($item->excerpt))
                            <p>{{ $item->excerpt }}</p>
                            @else
                            @foreach($item->blocks as $block)
                            @if($block->type === 'markdown')
                            @markdom($block->data->content)
                            @break
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @if(!empty($item->metadata['button']))
                    <div class="section-btn mt-3">
                        <a href="{{ $item->url }}" class="btn-default">{{ $item->metadata['button'] }}</a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- Grid Layout for 3+ posts --}}
        <div class="row">
            @foreach($posts as $item)
            <div class="col-lg-4 col-md-6">
                <div class="cta-item wow fadeInUp group" data-wow-delay="{{ (($loop->index % 3) + 1) * 0.25 }}s">
                    <div class="section-title">
                        <h3 class="text-anime-style-3" data-cursor="-opaque">{{ $item->title }}</h3>
                        <div class="wow fadeInUp">
                            @if(!empty($item->excerpt))
                            <p>{{ $item->excerpt }}</p>
                            @else
                            @foreach($item->blocks as $block)
                            @if($block->type === 'markdown')
                            @markdom($block->data->content)
                            @break
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @if(!empty($item->metadata['button']))
                    <div class="section-btn mt-3">
                        <a href="{{ $item->url }}" class="btn-default">{{ $item->metadata['button'] }}</a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>
<!-- CTA Box Section End -->
@endif
