@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Stats Counter Section Start -->
<section class="stats-counter relative py-16 lg:py-20 overflow-hidden" id="{{ $category->slug ?? 'stats' }}">
    <div class="absolute inset-0 bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.1&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container mx-auto px-4 relative z-10">
        @if($category->name || $category->subtitle)
        <div class="text-center mb-12">
            @if($category->name)
            <span class="inline-block px-4 py-2 bg-white/10 backdrop-blur-sm text-white text-sm font-semibold rounded-full mb-4 wow fadeInUp">{{ $category->name }}</span>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl font-bold text-white wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle }}</h2>
            @endif
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-heroicon-s-pencil class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-white/80" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-white/80 hover:text-white">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        @if($count === 1)
        {{-- Single Stat Spotlight --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-md mx-auto text-center">
            <div class="bg-white/10 backdrop-blur-md rounded-3xl p-10 border border-white/20 wow fadeInUp">
                @if(!empty($post->icon))
                <div class="w-20 h-20 bg-primary-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <x-icon name="{{ $post->icon }}" class="w-10 h-10 text-white" />
                </div>
                @endif
                @if(!empty($post->metadata['value']))
                <div class="text-5xl lg:text-6xl font-bold text-white mb-2" data-count="{{ $post->metadata['value'] }}">{{ $post->metadata['value'] }}</div>
                @endif
                <h3 class="text-xl font-semibold text-white/90 mb-2">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-white/70">{{ $post->excerpt }}</p>
                @endif
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Stats Side by Side --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            @foreach($posts as $post)
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 text-center group hover:bg-white/15 transition-colors duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                @if(!empty($post->icon))
                <div class="w-16 h-16 bg-primary-500 rounded-xl flex items-center justify-center mx-auto mb-5 group-hover:scale-110 transition-transform duration-300">
                    <x-icon name="{{ $post->icon }}" class="w-8 h-8 text-white" />
                </div>
                @endif
                @if(!empty($post->metadata['value']))
                <div class="text-4xl lg:text-5xl font-bold text-white mb-2">{{ $post->metadata['value'] }}</div>
                @endif
                <h3 class="text-lg font-semibold text-white/90 mb-1">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-white/70 text-sm">{{ $post->excerpt }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Stats Row --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 lg:p-8 border border-white/20 text-center group hover:bg-white/15 transition-colors duration-300 wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                @if(!empty($post->icon))
                <div class="w-14 h-14 bg-primary-500 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
                    <x-icon name="{{ $post->icon }}" class="w-7 h-7 text-white" />
                </div>
                @endif
                @if(!empty($post->metadata['value']))
                <div class="text-3xl lg:text-4xl font-bold text-white mb-2">{{ $post->metadata['value'] }}</div>
                @endif
                <h3 class="text-base font-semibold text-white/90 mb-1">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-white/70 text-sm">{{ $post->excerpt }}</p>
                @endif
            </div>
            @endforeach
        </div>

        @else
        {{-- Four+ Stats Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 lg:gap-6">
            @foreach($posts as $post)
            <div class="bg-white/10 backdrop-blur-md rounded-xl p-5 lg:p-6 border border-white/20 text-center group hover:bg-white/15 transition-colors duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.1 }}s">
                @if(!empty($post->icon))
                <div class="w-12 h-12 bg-primary-500 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform duration-300">
                    <x-icon name="{{ $post->icon }}" class="w-6 h-6 text-white" />
                </div>
                @endif
                @if(!empty($post->metadata['value']))
                <div class="text-2xl lg:text-3xl font-bold text-white mb-1">{{ $post->metadata['value'] }}</div>
                @endif
                <h3 class="text-sm font-semibold text-white/90">{{ $post->title }}</h3>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Stats Counter Section End -->
@endif
