@props(['posts'])
@if($posts->isNotEmpty())
@php
$post = $posts->first();
@endphp
<div class="about-us" id="{{ $post->slug ?? 'about' }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <!-- About Us Image Start -->
                <div class="about-image">
                    <div class="about-img">
                        <figure class="reveal">
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                        </figure>
                    </div>
                </div>
                <!-- About Us Image End -->
                @if(auth()->check())
                <div class="flex items-center">
                    <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 border" />
                    <a class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600"
                        href="{{ $posts->first()->postCategory->editUrl }}" title="edit">
                        تعديل <p>{{ auth()->user()->name }}</p>
                    </a>
                </div>
                @endif
            </div>

            <div class="col-lg-7">
                <!-- About Content Start -->
                <div class="about-content">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">{{ $post->postCategory->name ?? '' }}</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $post->postCategory->subtitle ?? '' }}</h2>
                        <div class="wow fadeInUp" data-wow-delay="0.25s">
                            @if(isset($post->blocks[0]) && $post->blocks[0]->type === 'markdown')
                            @markdom($post->blocks[0]->data->content)
                            @endif
                        </div>
                    </div>
                    <!-- Section Title End -->

                    <!-- About Content Body Start -->
                    <div class="about-content-body wow fadeInUp" data-wow-delay="0.5s">
                        @if(isset($post->blocks[1]) && $post->blocks[1]->type === 'markdown')
                        @markdom($post->blocks[1]->data->content)
                        @endif
                    </div>
                    <!-- About Content Body End -->

                    <!-- About Content Footer Start -->
                    <div class="about-content-footer wow fadeInUp" data-wow-delay="0.75s">
                        @if(!empty($post->metadata['button']))
                        <div class="about-footer-btn">
                            <a href="{{ $post->url }}" class="btn-default">{{ $post->metadata['button'] }}</a>
                        </div>
                        @endif
                        @if(!empty($post->metadata['phone']))
                        <div class="about-contact-support">
                            <div class="icon-box">
                                @if(!empty($post->icon))
                                <x-icon name={{ "$post->icon" }} class="w-8 h-8" />
                                @endif
                            </div>
                            <div class="about-support-content">
                                <p>{{ $post->metadata['phone_label'] ?? '' }}</p>
                                <a href="tel:{{ $post->metadata['phone'] }}">
                                    <h3 dir="ltr" style="text-align: end">{{ $post->metadata['phone'] }}</h3>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- About Content Footer End -->
                </div>
            </div>
        </div>
    </div>
</div>
@endif
