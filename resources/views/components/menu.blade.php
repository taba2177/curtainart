@props(['name'])

{{-- {{ dd($name,\App\Models\Menu::get()) }} --}}
@if ($menu = \App\Models\Menu::where('name', $name)->first())
@php
$items = is_array($menu->items ?? null) ? $menu->items : [];

$telephoneUrl = null;
$telephoneLabel = null;
$whatsAppUrl = null;
$whatsAppLabel = null;

foreach ($items as $item) {
$url = $item['url'] ?? '';
$type = $item['type'] ?? null;
$title = $item['title'] ?? null;

// Phone detection and normalization
if (!$telephoneUrl && ($type === 'phone' || str_starts_with($url, 'tel:') || preg_match('/^\+?\d[\d\s\-()]+$/', $url)))
{
$digits = preg_replace('/[^\d]/', '', str_replace('tel:', '', $url));
if ($digits) {
$telephoneUrl = 'tel:' . $digits;
$telephoneLabel = $title ?: $digits;
}
}

// WhatsApp detection and normalization
if (!$whatsAppUrl && ($type === 'whatsapp' || str_contains($url, 'wa.me') || str_contains($url, 'whatsapp') ||
str_contains($url, 'api.whatsapp.com'))) {
// Extract digits and build wa.me link
$digits = preg_replace('/[^\d]/', '', $url);
if ($digits) {
$whatsAppUrl = 'https://wa.me/' . $digits;
$whatsAppLabel = $title ?: 'واتساب';
}
}
}

// Fallbacks if not provided via items
if (!$telephoneUrl && isset($menu->phone) && $menu->phone) {
$digits = preg_replace('/[^\d]/', '', $menu->phone);
if ($digits) {
$telephoneUrl = 'tel:' . $digits;
$telephoneLabel = $digits;
}
}
@endphp
<header id="sticky-header" :class="isScrolled ? 'fixed top-0 left-0 right-0 shadow-lg' : 'relative'"
    class="bg-[#E8F1FF] lg:py-[5px] z-[9999] transition-all duration-300" x-data="{
        isScrolled: false,
        mobileMenuOpen: false,
        updateScroll() {
            this.isScrolled = window.scrollY > 50;
        }
    }" x-init="
        updateScroll();
        window.addEventListener('scroll', () => updateScroll());
    ">

    <div class="container">
        <div class="grid grid-cols-12">
            <div class="col-span-12">
                <div class="flex flex-wrap items-center justify-between">
                    <!-- Logo -->
                    <a href="/" class="block" aria-label="Brand">
                        <img class="p-2" src="/images/logo/logo2.png" loading="lazy" width="99" height="38" alt="Logo">
                    </a>
                    <!-- Desktop Menu -->
                    <nav class="flex flex-wrap items-center">
                        <ul
                            class="hidden lg:flex flex-wrap items-center font-lora text-[16px] xl:text-[18px] leading-none text-black">
                            @foreach ($menu->items as $item)
                            <li class="ml-7 xl:ml-[40px] relative group py-[20px]">
                                @php
                                $href = $item['url'] ?? '#';
                                $isExternal = ($item['type'] ?? null) === 'external' || preg_match('#^https?://#',
                                $href);
                                @endphp
                                <a @if(!$isExternal) wire:navigate @endif href="{{ $href }}" @if ($isExternal)
                                    target="_blank" rel="noopener noreferrer" @endif
                                    class="transition-all hover:text-secondary font-medium {{ url()->current() == url($item['url']) ? 'text-secondary dark:text-sky-400' : 'text-gray-700 dark:text-gray-300' }}">

                                    {{ is_array($item['title'] ?? null) ? ($item['title'][app()->getLocale()] ?? $item['title']['ar'] ?? $item['title']['en'] ?? '') : ($item['title'] ?? '') }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </nav>
                    <!-- Right side buttons -->
                    <ul class="flex flex-wrap items-center">
                        <!-- Language Switcher -->
                        {{-- <li class="mr-3 sm:mr-5 xl:mr-[20px] relative group">
                            @if (app()->getLocale() === 'ar')
                            <a href="{{ route('lang.switch', 'en') }}"
                                class="flex items-center gap-2 text-gray-700 hover:text-sky-600 dark:text-gray-300 dark:hover:text-sky-400 transition-colors"
                                aria-label="{{ __('Switch to English') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                    </path>
                                </svg>
                                <span class="hidden xl:inline font-medium">EN</span>
                            </a>
                            @else
                            <a href="{{ route('lang.switch', 'ar') }}"
                                class="flex items-center gap-2 text-gray-700 hover:text-sky-600 dark:text-gray-300 dark:hover:text-sky-400 transition-colors"
                                aria-label="{{ __('Switch to Arabic') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                    </path>
                                </svg>
                                <span class="hidden xl:inline font-medium">AR</span>
                            </a>
                            @endif
                        </li> --}}

                        @if ($whatsAppUrl)
                        <li class="sm:mr-5 xl:mr-[20px] relative group">
                            <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer" aria-label="واتساب"
                                class="flex items-center text-gray-700 hover:text-sky-600 dark:text-gray-300 dark:hover:text-sky-400">
                                <x-icon name="forkawesome-whatsapp" width="32" class="w-[32px] self-start mx-2" />
                            </a>
                        </li>
                        @endif
                        @if ($telephoneUrl)
                        <li>
                            <a href="{{ $telephoneUrl }}" aria-label="اتصل بنا"
                                class="before:rounded-md before:block before:absolute before:left-auto before:right-0 before:inset-y-0 before:-z-[1] before:bg-secondary before:w-0 hover:before:w-full hover:before:left-0 before:transition-all leading-none px-[20px] py-[15px] capitalize font-medium text-white hidden sm:block text-[14px] xl:text-[16px] relative after:block after:absolute after:inset-0 after:-z-[2] after:bg-primary after:rounded-md after:transition-all">
                                {{ $telephoneLabel ?? 'اتصل بنا' }}
                            </a>
                        </li>
                        @endif
                        <li class="mr-2 sm:mr-5 lg:hidden">
                            <!-- Mobile menu button -->
                            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                                class="offcanvas-toggle flex text-[#016450] hover:text-secondary">
                                <svg width="24" height="24" class="fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 448 512">
                                    <path
                                        d="M0 96C0 78.33 14.33 64 32 64H416C433.7 64 448 78.33 448 96C448 113.7 433.7 128 416 128H32C14.33 128 0 113.7 0 96zM0 256C0 238.3 14.33 224 32 224H416C433.7 224 448 238.3 448 256C448 273.7 433.7 288 416 288H32C14.33 288 0 273.7 0 256zM416 448H32C14.33 448 0 433.7 0 416C0 398.3 14.33 384 32 384H416C433.7 384 448 433.7 433.7 448 416 448z" />
                                </svg>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="lg:hidden fixed inset-0 bg-white z-[9999] transform transition-all duration-300 ease-in-out"
        x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full">
        <div class="container h-full overflow-y-auto">
            <div class="flex justify-between items-center py-4 border-b">
                <a href="/" class="block">
                    <img src="/images/icon2.png" class="h-10 w-auto" alt="Logo">
                </a>
                <button @click="mobileMenuOpen = false" class="text-gray-700 hover:text-gray-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="py-4">
                @foreach ($menu->items as $item)
                <a wire:navigate href="{{ $item['url'] }}" @if ($item['type']==='external' ) target="_blank"
                    rel="noopener noreferrer" @endif
                    class="block py-3 px-4 text-gray-700 hover:bg-gray-100 rounded-md {{ request()->is('*'.$item['url'].'*') ? 'text-sky-600 bg-gray-50' : '' }}">
                    {{ is_array($item['title'] ?? null) ? ($item['title'][app()->getLocale()] ?? $item['title']['ar'] ?? $item['title']['en'] ?? '') : ($item['title'] ?? '') }}
                </a>
                @endforeach

                <div class="mt-6 pt-6 border-t">
                    <!-- Language Switcher Mobile -->
                    <div class="mb-4">
                        @if (app()->getLocale() === 'ar')
                        <a href="{{ route('lang.switch', 'en') }}"
                            class="flex items-center py-3 px-4 text-gray-700 hover:bg-gray-100 rounded-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                </path>
                            </svg>
                            {{ __('English') }}
                        </a>
                        @else
                        <a href="{{ route('lang.switch', 'ar') }}"
                            class="flex items-center py-3 px-4 text-gray-700 hover:bg-gray-100 rounded-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                </path>
                            </svg>
                            {{ __('العربية') }}
                        </a>
                        @endif
                    </div>

                    @if ($telephoneUrl)
                    <a href="{{ $telephoneUrl }}" aria-label="اتصل بنا"
                        class="flex items-center py-3 px-4 text-gray-700 hover:bg-gray-100 rounded-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $telephoneLabel ?? 'اتصل بنا' }}
                    </a>
                    @endif

                    @if ($whatsAppUrl)
                    <a href="{{ $whatsAppUrl }}" target="_blank" rel="noopener noreferrer"
                        class="mt-4 block w-full text-center py-3 px-4 bg-primary text-white rounded-md hover:bg-secondary transition-colors"
                        aria-label="واتساب">
                        {{ $whatsAppLabel ?? 'واتساب' }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
@endif
