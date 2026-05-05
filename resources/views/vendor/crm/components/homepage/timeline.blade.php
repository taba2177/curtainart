@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Timeline/Process Section Start -->
<section class="timeline-section relative py-16 lg:py-24 bg-white overflow-hidden" id="{{ $category->slug ?? 'timeline' }}">
    <div class="absolute left-0 top-0 w-full h-full bg-[url('data:image/svg+xml,%3Csvg width=&quot;40&quot; height=&quot;40&quot; viewBox=&quot;0 0 40 40&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;%23f3f4f6&quot; fill-opacity=&quot;0.4&quot; fill-rule=&quot;evenodd&quot;%3E%3Cpath d=&quot;M0 40L40 0H20L0 20M40 40V20L20 40&quot;/%3E%3C/g%3E%3C/svg%3E')]"></div>

    <div class="container mx-auto px-4 relative z-10">
        @if($category->name || $category->subtitle)
        <div class="text-center max-w-2xl mx-auto mb-12 lg:mb-16">
            @if($category->name)
            <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary-100 text-primary-700 text-sm font-semibold rounded-full mb-4 wow fadeInUp">
                <x-icon name="heroicon-o-clock" class="w-4 h-4" />
                {{ $category->name }}
            </span>
            @endif
            @if($category->subtitle)
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mb-4 wow fadeInUp" data-wow-delay="0.1s">{{ $category->subtitle }}</h2>
            @endif
            @if($category->description)
            <p class="text-gray-600 text-lg wow fadeInUp" data-wow-delay="0.2s">{!! $category->description !!}</p>
            @endif
            @auth
            <div class="flex items-center justify-center mt-4">
                <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-gray-400" />
                <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-gray-400 hover:text-gray-600">تعديل</a>
            </div>
            @endauth
        </div>
        @endif

        @if($count === 1)
        {{-- Single Step --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-xl mx-auto wow fadeInUp">
            <div class="bg-gradient-to-br from-primary-50 to-white rounded-3xl p-8 shadow-lg text-center border border-primary-100">
                <div class="w-20 h-20 rounded-full bg-primary-500 flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary-500/30">
                    @if(!empty($post->icon))
                    <x-icon name="{{ $post->icon }}" class="w-10 h-10 text-white" />
                    @else
                    <span class="text-3xl font-bold text-white">1</span>
                    @endif
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $post->title }}</h3>
                @if(!empty($post->excerpt))
                <p class="text-gray-600 text-lg leading-relaxed">{{ $post->excerpt }}</p>
                @endif
            </div>
        </div>

        @elseif($count === 2)
        {{-- Two Steps - Arrow Connection --}}
        <div class="flex flex-col md:flex-row items-center justify-center gap-4 lg:gap-8 max-w-4xl mx-auto">
            @foreach($posts as $post)
            <div class="flex-1 w-full wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 text-center group hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 rounded-full bg-primary-100 flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-500 transition-colors">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-8 h-8 text-primary-600 group-hover:text-white transition-colors" />
                        @else
                        <span class="text-2xl font-bold text-primary-600 group-hover:text-white transition-colors">{{ $loop->iteration }}</span>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                    @if(!empty($post->excerpt))
                    <p class="text-gray-600 text-sm">{{ $post->excerpt }}</p>
                    @endif
                </div>
            </div>
            @if(!$loop->last)
            <div class="hidden md:flex items-center justify-center w-12 flex-shrink-0">
                <x-icon name="heroicon-o-arrow-left" class="w-8 h-8 text-primary-400 rtl:rotate-0 ltr:rotate-180" />
            </div>
            <div class="flex md:hidden items-center justify-center h-8">
                <x-icon name="heroicon-o-arrow-down" class="w-8 h-8 text-primary-400" />
            </div>
            @endif
            @endforeach
        </div>

        @elseif($count === 3)
        {{-- Three Steps - Horizontal Timeline --}}
        <div class="relative max-w-5xl mx-auto">
            {{-- Timeline Line --}}
            <div class="hidden md:block absolute top-10 left-[10%] right-[10%] h-1 bg-primary-100"></div>
            <div class="hidden md:block absolute top-10 left-[10%] h-1 bg-primary-500 transition-all duration-500" style="width: 80%;"></div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <div class="relative wow fadeInUp" data-wow-delay="{{ ($loop->index + 1) * 0.15 }}s">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-primary-500 flex items-center justify-center mb-6 shadow-lg shadow-primary-500/30 relative z-10">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="w-10 h-10 text-white" />
                            @else
                            <span class="text-2xl font-bold text-white">{{ $loop->iteration }}</span>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-600 text-sm">{{ $post->excerpt }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @elseif($count === 4)
        {{-- Four Steps - Horizontal with connectors --}}
        <div class="relative max-w-6xl mx-auto">
            <div class="hidden lg:block absolute top-12 left-[12%] right-[12%] h-0.5 bg-gradient-to-r from-primary-500 via-primary-400 to-primary-500"></div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($posts as $post)
                <div class="relative wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.1 }}s">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center mb-4 shadow-lg relative z-10 transform hover:scale-105 transition-transform">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="w-12 h-12 text-white" />
                            @else
                            <span class="text-3xl font-bold text-white">{{ $loop->iteration }}</span>
                            @endif
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-1">{{ $post->title }}</h3>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-600 text-sm">{{ \Illuminate\Support\Str::limit($post->excerpt, 60) }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @elseif($count >= 5 && $count <= 6)
        {{-- 5-6 Steps - Vertical Timeline --}}
        <div class="max-w-4xl mx-auto relative">
            {{-- Vertical Line --}}
            <div class="absolute right-4 md:right-1/2 top-0 bottom-0 w-0.5 bg-primary-200 hidden md:block" style="transform: translateX(50%);"></div>

            @foreach($posts as $post)
            <div class="relative mb-8 md:mb-12 wow fadeIn{{ $loop->odd ? 'Right' : 'Left' }}" data-wow-delay="{{ ($loop->index + 1) * 0.1 }}s">
                <div class="flex flex-col md:flex-row items-center @if($loop->even) md:flex-row-reverse @endif">
                    {{-- Content --}}
                    <div class="w-full md:w-5/12 @if($loop->odd) md:text-left md:pr-8 @else md:text-right md:pl-8 @endif">
                        <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-shadow">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-gray-600 text-sm">{{ $post->excerpt }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Circle Marker --}}
                    <div class="w-full md:w-2/12 flex justify-center my-4 md:my-0">
                        <div class="w-12 h-12 rounded-full bg-primary-500 flex items-center justify-center shadow-lg relative z-10">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="w-6 h-6 text-white" />
                            @else
                            <span class="text-lg font-bold text-white">{{ $loop->iteration }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Spacer --}}
                    <div class="hidden md:block w-5/12"></div>
                </div>
            </div>
            @endforeach
        </div>

        @else
        {{-- 7+ Steps - Compact Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($posts as $post)
            <div class="bg-white rounded-lg shadow-sm p-4 border border-gray-100 group hover:shadow-md hover:border-primary-200 transition-all duration-300 wow fadeInUp" data-wow-delay="{{ (($loop->index % 4) + 1) * 0.08 }}s">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary-100 flex items-center justify-center flex-shrink-0 group-hover:bg-primary-500 transition-colors">
                        @if(!empty($post->icon))
                        <x-icon name="{{ $post->icon }}" class="w-5 h-5 text-primary-600 group-hover:text-white transition-colors" />
                        @else
                        <span class="text-sm font-bold text-primary-600 group-hover:text-white transition-colors">{{ $loop->iteration }}</span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $post->title }}</h3>
                        @if(!empty($post->excerpt))
                        <p class="text-gray-500 text-xs line-clamp-2 mt-1">{{ $post->excerpt }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Timeline/Process Section End -->
@endif
