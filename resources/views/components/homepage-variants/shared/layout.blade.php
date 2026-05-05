@props(['variant', 'variantSlug', 'sections', 'headerCategories' => null, 'footerData' => null, 'contactPhone' => null, 'contactWhatsapp' => null])
@php
    use App\Support\HomepageVariants;
    use Taba\Crm\Livewire\Home as HomeComponent;
@endphp

<div class="variant-layout variant-layout--{{ $variantSlug }} max-w-[1920px] mx-auto"
    data-variant="{{ $variantSlug }}"
    data-locale="{{ app()->getLocale() }}"
    data-dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- Skip-to-content link (keyboard a11y) --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:z-[60] focus:bg-amber-600 focus:text-white focus:px-4 focus:py-2 focus:rounded focus:outline-none">
        {{ __('Skip to content') }}
    </a>

    {{-- Variant header --}}
    <x-homepage-variants.shared.header :variant="$variant" :categories="$headerCategories" />

    {{-- Main content: render sections through variant-specific templates --}}
    <main class="variant-main pb-16" id="main-content">
        @forelse ($sections as $section)
            @php
                $templateSuffix = HomepageVariants::templateSuffixFor($section->section_component);
                $specificComponent = $variant['component_dir'] . '.' . $templateSuffix;
                $originalComponent = 'homepage.' . $section->section_component;
                $genericComponent = $variant['component_dir'] . '.generic-section';
                $isHeavy = $section->posts_count > HomeComponent::HEAVY_SECTION_THRESHOLD
                        || ($section->HEAVY_SECTION ?? false);
            @endphp

            @if ($section->section_component)
                <div class="variant-section" wire:key="variant-section-{{ $section->id }}" data-section="{{ $section->section_component }}">
                    @if (view()->exists('components.' . str_replace('.', '/', $specificComponent)))
                        <x-dynamic-component :component="$specificComponent" :posts="$section->posts" />
                    @elseif (view()->exists('components.' . str_replace('.', '/', $genericComponent)))
                        <x-dynamic-component
                            :component="$genericComponent"
                            :posts="$section->posts"
                            :section="$section"
                            :source-component="$originalComponent"
                            :is-heavy="$isHeavy" />
                    @elseif (view()->exists('components.' . str_replace('.', '/', $originalComponent)))
                        <x-dynamic-component :component="$originalComponent" :posts="$section->posts" />
                    @else
                        <x-homepage-variants.shared.section-fallback :section="$section" />
                    @endif
                </div>
            @endif
        @empty
            <x-homepage-variants.shared.empty-state />
        @endforelse
    </main>

    {{-- Variant footer --}}
    <x-homepage-variants.shared.footer :variant="$variant" :categories="$headerCategories" :footer-data="$footerData" />

    {{-- Floating contact buttons --}}
    @if($contactPhone || $contactWhatsapp)
        <x-homepage-variants.shared.floating-contact :phone="$contactPhone" :whatsapp="$contactWhatsapp" />
    @endif

    {{-- Back to top button --}}
    <button
        x-data="{ visible: false, init() { window.addEventListener('scroll', () => { this.visible = window.scrollY > 600; }, { passive: true }); } }"
        x-show="visible"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
        aria-label="{{ __('Back to top') }}"
        class="fixed bottom-6 start-6 z-50 w-11 h-11 rounded-full bg-gray-900 text-white flex items-center justify-center shadow-lg focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2"
        style="transition:transform 0.2s ease;cursor:pointer"
        @mouseenter="$el.style.transform='scale(1.1)'"
        @mouseleave="$el.style.transform='scale(1)'">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>

</div>
