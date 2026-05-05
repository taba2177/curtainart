@props(['variant', 'categories' => null, 'footerData' => null])
@php
    $categories = $categories ?? \Taba\Crm\Models\PostCategory::RegisterInHeader();
    $footerData = $footerData ?? [
        'businessDescription' => \Taba\Crm\Models\CrmSetting::get('crm_business_description') ?? config('app.name'),
        'businessName' => \Taba\Crm\Models\CrmSetting::get('crm_business_name') ?? config('app.name'),
    ];
    $variantClass = $variant['accent_class'] ?? '';
@endphp

<footer class="variant-footer {{ $variantClass }}-footer bg-gray-900 dark:bg-gray-950 text-gray-300 pt-10 pb-6 mt-auto">
    <div class="container mx-auto px-4">

        {{-- Brand & tagline --}}
        <div class="flex flex-col items-center text-center mb-8">
            <a href="{{ url('/') }}" rel="home" class="inline-block mb-4 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}"
                    class="h-14 w-auto mx-auto" width="140" height="44" loading="lazy" />
            </a>
            <p class="text-sm text-gray-400 max-w-sm">
                {{ $footerData['businessDescription'] }}
            </p>
        </div>

        {{-- Navigation links --}}
        <nav aria-label="{{ __('Footer navigation') }}"
            class="flex flex-wrap justify-center gap-x-6 gap-y-2 mb-8">
            @foreach ($categories as $category)
                <a href="{{ route('dynamic.route', ['slug' => $category->slug]) }}"
                    class="text-sm text-gray-300 hover:text-white transition-colors duration-200 focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                    {{ $category->name }}
                </a>
            @endforeach
        </nav>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-700 pt-4 text-center text-xs text-gray-300">
            © {{ date('Y') }}
            <a href="{{ url('/') }}" class="hover:text-white transition-colors focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 rounded">
                {{ $footerData['businessName'] }}
            </a>
            — {{ __('All rights reserved') }}
        </div>

    </div>
</footer>
