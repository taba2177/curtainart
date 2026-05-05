@props(['posts'])
@if($posts->isNotEmpty())
<div class="our-projects" id="projects">
    <div class="light-bg-section">
        <div class="container-fluid">
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
                <div class="col-lg-3 col-md-6">
                    <!-- Project Item Start -->
                    <div class="project-item wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                        <!-- Project Image Start -->
                        <div class="project-image" data-cursor-text="">
                            <a href="{{$post->url}}">
                                <figure>
                                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                                        alt="{{ $post->title }}">
                                </figure>
                            </a>
                        </div>
                        <!-- Project Image End -->

                        <!-- Project Body Start -->
                        <div class="project-body">
                            <!-- Project Body Title Start -->
                            <div class="project-body-title">
                                <h3>{{ $post->title }}</h3>
                            </div>
                            <!-- Project Body Title End -->

                            <!-- Project Content Start -->
                            <div class="project-content">
                                @foreach ($post->blocks as $block)
                                @switch($block->type)
                                @case('markdown')
                                @markdom($block->data->content)
                                @break
                                @endswitch
                                @endforeach
                                <div class="project-content-footer">
                                    @if(!empty($post->metadata['button']))
                                    <a href="{{$post->url}}" class="readmore-btn">{{ $post->metadata['button'] }}</a>
                                    @endif
                                </div>
                            </div>
                            <!-- Project Content End -->
                        </div>
                        <!-- Project Body End -->
                    </div>
                    <!-- Project Item End -->
                </div>
                @endforeach

                <!-- Services Footer Btn Start -->
                <div class="project-footer-btn wow fadeInUp" data-wow-delay="1.25s">
                    <a href="{{ $posts->first()->postCategory->slug }}" class="btn-default">{{ $posts->first()->postCategory->name }}</a>
                </div>
                <!-- Services Footer Btn End -->
            </div>
        </div>
    </div>
</div>
@endif
