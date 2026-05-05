@props(['posts'])
@if($posts->isNotEmpty())
@php
    $category = $posts->first()->postCategory;
    $count     = $posts->count();
@endphp
{{-- Bold Modular Testimonials: high-contrast dark card layout --}}
<section class="bold-testimonials py-16 lg:py-24 bg-rose-600"
    id="{{ $category->slug ?? 'testimonials' }}">
    <div class="container mx-auto px-4">

        {{-- Section header --}}
        <div class="text-center mb-12">
            @if($category->name)
            <div class="inline-flex items-center gap-2 mb-4">
                <span class="block w-3 h-3 rounded-full bg-white/60"></span>
                <span class="text-rose-100 text-xs font-bold uppercase tracking-[0.25em]">{{ $category->name }}</span>
                <span class="block w-3 h-3 rounded-full bg-white/60"></span>
            </div>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl font-black text-white leading-tight">{{ $category->subtitle }}</h2>
            @endif
            @auth
            <div class="mt-3 flex items-center justify-center gap-1 text-xs text-rose-200">
                <x-heroicon-s-pencil class="w-3 h-3" />
                <a href="{{ $category->editUrl ?? '#' }}" class="hover:text-white transition-colors">Edit</a>
            </div>
            @endauth
        </div>

        @if($count === 1)
        @php $post = $posts->first(); @endphp
        <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-sm rounded-3xl p-8 lg:p-12 border border-white/20 text-center">
            @if(!empty($post->excerpt))
            <blockquote class="text-xl md:text-2xl font-bold text-white italic leading-relaxed mb-8">
                "{{ $post->excerpt }}"
            </blockquote>
            @endif
            <div class="flex items-center justify-center gap-4">
                @if($post->image)
                <img src="{{ $post->image?->url }}" alt="{{ $post->title }}"
                    class="w-14 h-14 rounded-full object-cover ring-2 ring-white/40" loading="lazy" />
                @endif
                <div class="text-start rtl:text-end">
                    <div class="font-black text-white">{{ $post->title }}</div>
                    @if(!empty($post->metadata['label']))
                    <div class="text-sm text-rose-100">{{ $post->metadata['label'] }}</div>
                    @endif
                </div>
            </div>
        </div>

        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
            <article class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6
                hover:bg-white/15 transition-all duration-300">
                <svg class="w-9 h-9 text-white/30 mb-5" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z"/>
                </svg>
                @if(!empty($post->excerpt))
                <blockquote class="text-white/90 text-sm leading-relaxed italic mb-6">
                    "{{ $post->excerpt }}"
                </blockquote>
                @endif
                <div class="flex items-center gap-3">
                    @if($post->image)
                    <img src="{{ $post->image?->url }}" alt="{{ $post->title }}"
                        class="w-10 h-10 rounded-full object-cover ring-1 ring-white/30" loading="lazy" />
                    @endif
                    <div>
                        <div class="font-black text-sm text-white">{{ $post->title }}</div>
                        @if(!empty($post->metadata['label']))
                        <div class="text-xs text-rose-100">{{ $post->metadata['label'] }}</div>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        @endif

    </div>
</section>
@endif
