@props(['posts'])
@if($posts->isNotEmpty())
@php
$count = $posts->count();
$category = $posts->first()->postCategory;
@endphp
<section id="{{ $category->slug ?? 'services' }}" class="overflow-x-hidden bg-primary-color py-12 lg:py-16">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="mb-8 {{ $count === 1 ? 'max-w-3xl mx-auto text-center' : '' }}">
            <span class="text-xs uppercase text-white/80 font-medium inline-block wow fadeInUp" data-wow-delay=".2s">{{ $category->name }}</span>
            <h2 class="mt-2 text-2xl md:text-3xl lg:text-4xl font-semibold text-white" data-wow-delay=".3s">{{ $category->subtitle }}</h2>
            <p class="mt-2 text-white/80">{{ $category->description ?? '' }}</p>
        </div>

        <!-- Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ min($count, 4) }} gap-6">
            @foreach($posts as $post)
            <div class="group relative p-6 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10 hover:border-white/30 transition wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                <div class="mb-4">
                    @if(!empty($post->icon))
                    <x-icon name={{ "$post->icon" }} class="w-8 h-8 text-white/90" />
                    @else
                    <img src="{{ $post->image?->url ?? $post->getRandomImage() }}" alt="{{ $post->title ?? '' }}" class="w-10 h-10 object-cover rounded" />
                    @endif
                </div>
                <h3 class="text-lg font-semibold text-white">{{ $post->title ?? '' }}</h3>
                @if(!empty($post->excerpt))
                <p class="mt-2 text-white/80">{{ $post->excerpt }}</p>
                @else
                <div class="mt-2 text-white/80 prose prose-invert">
                    @foreach ($post->blocks as $block)
                    @if($block->type === 'markdown')
                    @markdom($block->data->content)
                    @endif
                    @endforeach
                </div>
                @endif
                @if(!empty($post->metadata['button']))
                <a class="mt-4 inline-flex items-center gap-2 text-white hover:opacity-80" href="{{ $post->url }}">{{ $post->metadata['button'] }}</a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
