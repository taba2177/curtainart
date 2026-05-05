@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$post = $posts->first();
$count = $posts->count();
@endphp
<!-- Contact Us Section Start -->
<div class="contact-us" id="{{ $category->slug ?? 'contact' }}">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 col-md-5">
                <div class="contact-sidebar wow fadeInUp" data-wow-delay="0.25s">
                    @foreach($posts->take(2) as $contactPost)
                    <div class="contact-info" style="justify-items: center;">
                        <div class="icon-box">
                            @if(!empty($contactPost->icon))
                            <x-icon name="{{ $contactPost->icon }}" class="w-8 h-8" />
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
                    @endforeach
                    <div class="contact-info-image">
                        <figure>
                            <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title }}">
                        </figure>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <div class="contact-form wow fadeInUp" data-wow-delay="0.25s">
                    <div class="section-title">
                        <h3 class="wow fadeInUp">{{ $category->name ?? '' }}</h3>
                        <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $post->title }}</h2>
                    </div>
                    @auth
                    <div class="flex items-center mt-2 mb-4">
                        <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                        <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                    </div>
                    @endauth

                    <form id="contactForm" action="#" method="POST" data-toggle="validator">
                        <div class="row">
                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="name" class="form-control" id="name" placeholder="{{ $post->metadata['name_placeholder'] ?? 'Enter Your name' }}" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-6 mb-4">
                                <input type="email" name="email" class="form-control" id="email" placeholder="{{ $post->metadata['email_placeholder'] ?? 'Enter Your email' }}" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="{{ $post->metadata['phone_placeholder'] ?? 'Phone number' }}" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-6 mb-4">
                                <input type="text" name="subject" class="form-control" id="subject" placeholder="{{ $post->metadata['subject_placeholder'] ?? 'Subject' }}" required="">
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="form-group col-md-12 mb-5">
                                <textarea name="msg" class="form-control" id="msg" rows="3" placeholder="{{ $post->metadata['message_placeholder'] ?? 'Message' }}" required=""></textarea>
                                <div class="help-block with-errors"></div>
                            </div>

                            <div class="col-md-12">
                                @if(!empty($post->metadata['button']))
                                <button type="submit" class="btn-default">{{ $post->metadata['button'] }}</button>
                                @endif
                                <div id="msgSubmit" class="h3 hidden"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact Us Section End -->
@endif
