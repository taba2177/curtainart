@props(['posts'])
@if($posts->isNotEmpty())
@php
$post = $posts->first();
@endphp
<div class="contact-us" id="contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-5">
                <!-- Contact Sidebar Start -->
                <div class="contact-sidebar wow fadeInUp" data-wow-delay="0.25s">
                    @foreach($posts->take(2) as $contactPost)
                    <!-- Contact Info Start -->
                    <div class="contact-info" style="justify-items: center;">
                        <div class="icon-box">
                            @if(!empty($contactPost->icon))
                            <x-icon name={{ "$contactPost->icon" }} class="w-8 h-8" />
                            @endif
                        </div>
                        <div class="contact-info-content">
                            <p>{{ $contactPost->metadata['label'] ?? '' }}</p>
                            @if(!empty($contactPost->metadata['link']))
                            <a href="{{ $contactPost->metadata['link'] }}">
                                <h3 dir="ltr">{{ $contactPost->metadata['value'] ?? '' }}</h3>
                            </a>
                            @else
                            <h3>{{ $contactPost->metadata['value'] ?? '' }}</h3>
                            @endif
                        </div>
                    </div>
                    <!-- Contact Info End -->
                    @endforeach

                    <!-- Contact Info Image Start -->
                    <div class="contact-info-image">
                        <figure>
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}"
                                alt="{{ $post->title }}">
                        </figure>
                    </div>
                    <!-- Contact Info Image End -->
                </div>
                <!-- Contact Sidebar End -->
            </div>

            <div class="col-lg-8 col-md-7">
                <!-- Contact Form start -->
                <div class="contact-form wow fadeInUp" data-wow-delay="0.25s">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h3 class="wow fadeInUp">{{ $post->postCategory->name ?? '' }}</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $post->title }}</h2>
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

                    <form id="contactForm" action="#" method="POST" data-toggle="validator">
                        <div class="row">
                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Enter Your name" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-6 mb-4">
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Enter Your email" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="phone" class="form-control" id="phone"
                                    placeholder="Phone number" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="website" class="form-control" id="website"
                                    placeholder="Subject" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-12 mb-5">
                                <textarea name="msg" class="form-control" id="msg" rows="3" placeholder="Message"
                                    required=""></textarea>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn-default">{{ $post->metadata['button'] ?? '' }}</button>
                                <div id="msgSubmit" class="h3 hidden"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Contact Form end -->
            </div>
        </div>
    </div>
</div>
@endif
