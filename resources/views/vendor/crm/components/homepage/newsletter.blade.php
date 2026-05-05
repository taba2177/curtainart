@props(['posts'])
@if($posts->isNotEmpty())
@php
$category = $posts->first()->postCategory;
$count = $posts->count();
@endphp
<!-- Newsletter/Subscribe Section Start -->
<section class="newsletter-section relative py-16 lg:py-24 overflow-hidden" id="{{ $category->slug ?? 'newsletter' }}">
    <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-primary-700 to-primary-800"></div>
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container mx-auto px-4 relative z-10">
        @if($count === 1)
        {{-- Single Newsletter Block --}}
        @php $post = $posts->first(); @endphp
        <div class="max-w-3xl mx-auto text-center wow fadeInUp">
            <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center mx-auto mb-6">
                @if(!empty($post->icon))
                <x-icon name="{{ $post->icon }}" class="w-10 h-10 text-white" />
                @else
                <x-icon name="heroicon-o-envelope" class="w-10 h-10 text-white" />
                @endif
            </div>

            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">{{ $post->title }}</h2>

            @if(!empty($post->excerpt))
            <p class="text-white/80 text-lg mb-8 max-w-xl mx-auto">{{ $post->excerpt }}</p>
            @endif

            <form class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
                <input type="email" placeholder="أدخل بريدك الإلكتروني" class="flex-1 px-6 py-4 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 focus:bg-white/20 transition-colors">
                <button type="submit" class="px-8 py-4 bg-white text-primary-600 font-semibold rounded-full hover:bg-gray-100 transition-colors flex items-center justify-center gap-2">
                    <span>{{ $post->metadata['button'] ?? 'اشترك الآن' }}</span>
                    <x-icon name="heroicon-o-arrow-left" class="w-5 h-5 rtl:rotate-0 ltr:rotate-180" />
                </button>
            </form>

            @if(!empty($post->metadata['label']))
            <p class="text-white/60 text-sm mt-4">{{ $post->metadata['label'] }}</p>
            @endif
        </div>

        @else
        {{-- Multiple Items - Content + Form Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
            {{-- Content Side --}}
            <div class="wow fadeInRight">
                @if($category->name)
                <span class="inline-block px-4 py-1.5 bg-white/10 text-white text-sm font-medium rounded-full mb-4">{{ $category->name }}</span>
                @endif
                @if($category->subtitle)
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">{{ $category->subtitle }}</h2>
                @endif

                <div class="space-y-4 mt-6">
                    @foreach($posts as $post)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            @if(!empty($post->icon))
                            <x-icon name="{{ $post->icon }}" class="w-4 h-4 text-white" />
                            @else
                            <x-icon name="heroicon-o-check" class="w-4 h-4 text-white" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">{{ $post->title }}</h3>
                            @if(!empty($post->excerpt))
                            <p class="text-white/70 text-sm">{{ $post->excerpt }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @auth
                <div class="flex items-center mt-6">
                    <x-icon name="heroicon-s-pencil" class="inline-block w-3 h-3 rtl:ml-1 ltr:mr-1 text-white/60" />
                    <a href="{{ $category->editUrl ?? '#' }}" class="inline-flex items-center text-sm text-white/60 hover:text-white">تعديل</a>
                </div>
                @endauth
            </div>

            {{-- Form Side --}}
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20 wow fadeInLeft">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <x-icon name="heroicon-o-envelope" class="w-8 h-8 text-white" />
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">اشترك في النشرة البريدية</h3>
                    <p class="text-white/70 text-sm">احصل على آخر الأخبار والعروض</p>
                </div>

                <form class="space-y-4">
                    <input type="text" placeholder="الاسم الكامل" class="w-full px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors">
                    <input type="email" placeholder="البريد الإلكتروني" class="w-full px-5 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/60 focus:outline-none focus:ring-2 focus:ring-white/50 transition-colors">
                    <button type="submit" class="w-full py-3 bg-white text-primary-600 font-semibold rounded-xl hover:bg-gray-100 transition-colors flex items-center justify-center gap-2">
                        <span>اشترك الآن</span>
                        <x-icon name="heroicon-o-arrow-left" class="w-5 h-5 rtl:rotate-0 ltr:rotate-180" />
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</section>
<!-- Newsletter/Subscribe Section End -->
@endif
