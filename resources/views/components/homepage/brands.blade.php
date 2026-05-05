@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<!-- Brands/Clients Logo Section Start -->
<section class="brands-section relative py-12 lg:py-16 bg-white" id="{{ $category->slug ?? 'brands' }}">
    <div class="container mx-auto px-4">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-10">
            @if($category->name)
            <span
                class="inline-block text-sm text-gray-500 font-medium uppercase tracking-wider mb-2 wow fadeInUp">{{ $category->name }}</span>
            @endif
            @if($category->subtitle)
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 wow fadeInUp" data-wow-delay="0.1s">
                {{ $category->subtitle }}</h2>
            @endif
            @auth
            <div class="flex items-center justify-center mt-3">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-gray-400" />
                <a href="{{ $category->editUrl ?? '#' }}"
                    class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        <!-- Swiper Container -->
        <div class="swiper brandsSwiper">
            <div class="swiper-wrapper">
                @foreach($posts as $post)
                @if($post->images && $post->images->isNotEmpty())
                @foreach($post->images as $image)
                <div class="swiper-slide">
                    <div class="flex items-center justify-center p-4 group">
                        <img src="{{ asset($image->url) }}" alt="{{ $post->title }}"
                            class="h-12 lg:h-16 w-auto max-w-full object-contain filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100 transition-all duration-300">
                    </div>
                </div>
                @endforeach
                @else
                <div class="swiper-slide">
                    <div class="flex items-center justify-center p-4">
                        <div class="px-6 py-3 bg-gray-100 rounded-lg">
                            <span class="text-gray-600 font-semibold">{{ $post->title }}</span>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Brands/Clients Logo Section End -->

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
const brandsSwiper = new Swiper('.brandsSwiper', {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 3000,
        disableOnInteraction: false,
    },
    breakpoints: {
        640: {
            slidesPerView: 3,
            spaceBetween: 30,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 40,
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 50,
        },
    }
});
</script>
@endif