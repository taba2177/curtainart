@props(['posts'])
@if($posts->isNotEmpty())
<div class="our-faqs" id="faq">
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

        <div class="row align-items-center">
            <div class="col-lg-5">
                <!-- Our FAQs Images Start -->
                <div class="our-faqs-images">
                    <div class="row align-items-end">
                        <div class="col-md-6 col-6">
                            <div class="faqs-img-1">
                                <figure class="image-anime reveal">
                                    <img src="{{ $posts->get(0)?->image?->url ?? $posts->get(0)?->getRandomImage() }}" alt="{{ $posts->get(0)?->title ?? '' }}">
                                </figure>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="faqs-img-2">
                                <figure class="image-anime reveal">
                                    <img src="{{ $posts->get(1)?->image?->url ?? $posts->get(1)?->getRandomImage() }}" alt="{{ $posts->get(1)?->title ?? '' }}">
                                </figure>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-start">
                        <div class="col-md-6 col-6">
                            <div class="faqs-img-1">
                                <figure class="image-anime reveal">
                                    <img src="{{ $posts->get(2)?->image?->url ?? $posts->get(2)?->getRandomImage() }}" alt="{{ $posts->get(2)?->title ?? '' }}">
                                </figure>
                            </div>
                        </div>
                        <div class="col-md-6 col-6">
                            <div class="faqs-img-2">
                                <figure class="image-anime reveal">
                                    <img src="{{ $posts->get(3)?->image?->url ?? $posts->get(3)?->getRandomImage() }}" alt="{{ $posts->get(3)?->title ?? '' }}">
                                </figure>
                            </div>
                        </div>
                    </div>

                    @if(!empty($posts->first()->icon))
                    <div class="our-faqs-bulitup">
                        <x-icon name="$posts->first()->icon" class="h-16 w-16 text-primary-500" />
                    </div>
                    @endif
                </div>
                <!-- Our FAQs Images End -->
            </div>

            <div class="col-lg-7">
                <!-- FAQ Accordion Start -->
                <div class="faq-accordion" id="accordion">
                    @foreach($posts as $post)
                    <!-- FAQ Item Start -->
                    <div class="accordion-item wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button {{ $loop->index > 0 ? 'collapsed' : '' }}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}"
                                aria-expanded="{{ $loop->index === 0 ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $loop->index }}">{{ $post->title }}</button>
                        </h2>
                        <div id="collapse{{ $loop->index }}"
                            class="accordion-collapse collapse {{ $loop->index === 0 ? 'show' : '' }}"
                            aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                @foreach ($post->blocks as $block)
                                @switch($block->type)
                                @case('markdown')
                                @markdom($block->data->content)
                                @break
                                @endswitch
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- FAQ Item End -->
                    @endforeach
                </div>
                <!-- FAQ Accordion End -->
            </div>
        </div>
    </div>
</div>
@endif
