@props(['posts'])
@if($posts->isNotEmpty())
<div class="service-benefit parallaxie" id="services">
    <div class="container">
        <div class="row">
            @if(auth()->check())
            <div class="flex items-center">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 border" />
                <a class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600"
                    href="{{ $posts->first()->postCategory->editUrl }}" title="edit">
                    تعديل <p>Welcome, {{ auth()->user()->name }}</p>
                </a>
            </div>
            @endif
            @foreach($posts as $post)
            <div class="col-lg-4 col-md-6">
                <!-- Service Benefit Item Start -->
                <div class="service-benefit-item wow fadeInUp" data-wow-delay="{{ $loop->index * 0.25 }}s">
                    <div class="icon-box">
                        @if(!empty($post->icon))
                        <x-icon name={{ "$post->icon" }} class="w-12 h-12" />
                        @else
                        <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                        @endif
                    </div>
                    <div class="service-benefit-content">
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
                <!-- Service Benefit Item End -->
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
