@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Our FAQs Section Start -->
<div class="our-faqs" id="{{ $category->slug ?? 'faq' }}">
    <div class="container">
        <div class="row section-row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3 class="wow fadeInUp">{{ $category->name ?? '' }}</h3>
                    <h2 class="text-anime-style-3" data-cursor="-opaque">{{ $category->subtitle ?? '' }}</h2>
                    <p>{{ $category->description ?? '' }}</p>
                </div>
                @auth
                <div class="flex items-center mt-2">
                    <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1" />
                    <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-primary-500 hover:text-primary-600">تعديل</a>
                </div>
                @endauth
            </div>
        </div>

        @if($count === 1)
        {{-- Single FAQ Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="faq-accordion" id="accordion">
                    <div class="accordion-item wow fadeInUp">
                        <h2 class="accordion-header" id="heading0">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapse0">{{ $post->title }}</button>
                        </h2>
                        <div id="collapse0" class="accordion-collapse collapse show" aria-labelledby="heading0" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                @if(!empty($post->excerpt))
                                <p>{{ $post->excerpt }}</p>
                                @else
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @elseif($count >= 2 && $count <= 3)
        {{-- No image gallery, just accordion --}}
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="faq-accordion" id="accordion">
                    @foreach($posts as $post)
                    <div class="accordion-item wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button {{ $loop->index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $loop->index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $loop->index }}">{{ $post->title }}</button>
                        </h2>
                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                @if(!empty($post->excerpt))
                                <p>{{ $post->excerpt }}</p>
                                @else
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @else
        {{-- Full layout with image gallery for 4+ posts --}}
        <div class="row align-items-center">
            <div class="col-lg-5">
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
                        <x-icon name="{{ $posts->first()->icon }}" class="h-16 w-16 text-primary-500" />
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-7">
                <div class="faq-accordion" id="accordion">
                    @foreach($posts as $post)
                    <div class="accordion-item wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.25 }}s">
                        <h2 class="accordion-header" id="heading{{ $loop->index }}">
                            <button class="accordion-button {{ $loop->index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $loop->index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $loop->index }}">{{ $post->title }}</button>
                        </h2>
                        <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $loop->index }}" data-bs-parent="#accordion">
                            <div class="accordion-body">
                                @if(!empty($post->excerpt))
                                <p>{{ $post->excerpt }}</p>
                                @else
                                @foreach($post->blocks as $block)
                                @if($block->type === 'markdown')
                                @markdom($block->data->content)
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Our FAQs Section End -->
@endif
