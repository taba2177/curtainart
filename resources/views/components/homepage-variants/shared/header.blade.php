@props(['variant', 'categories' => null])
@php
    $categories = $categories ?? \Taba\Crm\Models\PostCategory::RegisterInHeader();
    $isRtl = app()->getLocale() === 'ar';
    $variantClass = $variant['accent_class'] ?? '';
@endphp

<header x-data="{
    open: false,
    scrollY: 0,
    lastY: 0,
    hidden: false,
    init() {
        this.scrollY = window.scrollY;
        this.lastY = this.scrollY;
        window.addEventListener('scroll', () => {
            this.scrollY = window.scrollY;
            if (this.scrollY > 200) {
                this.hidden = this.scrollY > this.lastY;
            } else {
                this.hidden = false;
            }
            this.lastY = this.scrollY;
        }, { passive: true });
    }
}" :class="hidden ? '-translate-y-full' : 'translate-y-0'" class="variant-header {{ $variantClass }}-header bg-white/85 dark:bg-gray-900/85 backdrop-blur-md shadow-sm sticky top-[52px] z-40 border-b border-gray-100 dark:border-gray-800" style="transition:transform 0.3s ease">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16 md:h-20">

            {{-- Logo --}}
            <a href="{{ url('/') }}" rel="home" class="flex-shrink-0 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                <img class="h-10 w-auto hidden dark:inline-block"
                    src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}"
                    width="140" height="44" />
                <img class="h-10 w-auto inline-block dark:hidden"
                    src="{{ asset('images/logo-dark.svg') }}" alt="{{ config('app.name') }}"
                    width="140" height="44" />
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-6 xl:gap-8" aria-label="{{ __('Main navigation') }}">
                <a href="{{ url('/') }}"
                    class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                    {{ __('home') }}
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('dynamic.route', ['slug' => $category->slug]) }}"
                        class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                        {{ $category->name }}
                    </a>
                @endforeach
            </nav>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                {{-- Language switch --}}
                <a href="{{ route('lang.switch', ['lang' => $isRtl ? 'en' : 'ar']) }}"
                    aria-label="{{ ($isRtl ? 'English' : 'العربية') }} – {{ __('Switch language') }}"
                    class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200 flex items-center gap-1 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    {{ $isRtl ? 'English' : 'العربية' }}
                </a>

                {{-- CTA --}}
                <a href="{{ url('contact') }}"
                    class="hidden md:inline-flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-sm font-bold rounded-full shadow hover:shadow-md transition-all duration-300 hover:scale-105 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2">
                    {{ __('Contact Us') }}
                </a>

                {{-- Mobile menu toggle --}}
                <button
                    class="lg:hidden p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2"
                    aria-label="{{ __('Open menu') }}"
                    :aria-expanded="open.toString()"
                    @click="open = !open">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Nav Drawer --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="lg:hidden border-t border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 pb-4">
        <div class="container mx-auto px-4 pt-3 flex flex-col gap-2">
            <a href="{{ url('/') }}" @click="open = false"
                class="block py-2 text-base font-semibold text-gray-800 dark:text-gray-200 hover:text-primary-600 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                {{ __('home') }}
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('dynamic.route', ['slug' => $category->slug]) }}" @click="open = false"
                    class="block py-2 text-base font-semibold text-gray-800 dark:text-gray-200 hover:text-primary-600 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                    {{ $category->name }}
                </a>
            @endforeach
            <a href="{{ url('contact') }}" @click="open = false"
                class="mt-2 inline-flex w-full justify-center items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-500 text-white text-sm font-bold rounded-full focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2">
                {{ __('Contact Us') }}
            </a>
        </div>
    </div>
</header>
