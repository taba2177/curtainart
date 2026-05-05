@props(['posts'])
@if($posts->isNotEmpty())
<div class="our-blog" id="blog">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <!-- Section Title Start -->
                <div class="section-title">
                    <h3 class="wow fadeInUp">{{ $posts->first()->postCategory->name ?? '' }}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">
                        {{ $posts->first()->postCategory->subtitle ?? '' }}</h2>
                    <p>{{ $posts->first()->postCategory->description ?? '' }}</p>
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
            <div class="col-lg-4 col-md-6">
                <!-- Blog Item Start -->
                <div class="blog-item wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                    <!-- Post Featured Image Start-->
                    <div class="post-featured-image" data-cursor-text="">
                        <figure>
                            <a href="{{ $post->url }}" class="image-anime">
                                <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                            </a>
                        </figure>
                    </div>
                    <!-- Post Featured Image End -->

                    <!-- post Item Content Start -->
                    <div class="post-item-content">
                        <!-- post Item Body Start -->
                        <div class="post-item-body">
                            <h2><a href="{{$post->url}}">{{ $post->title }}</a></h2>
                        </div>
                        <!-- Post Item Body End-->

                        <!-- post Item Body Start -->
                        <div class="post-item-body">
                            @if(!empty($post->excerpt))
                            <p>{{ $post->excerpt }}</p>
                            @endif
                        </div>
                        <!-- Post Item Body End-->

                        <!-- Post Item Footer Start-->
                        <div class="post-item-footer">
                            @if(!empty($post->metadata['button']))
                            <a href="{{$post->url}}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                            @endif
                        </div>
                        <!-- Post Item Footer End-->
                    </div>
                    <!-- post Item Content End -->
                </div>
                <!-- Blog Item End -->
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
