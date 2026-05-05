<x-layouts.preview>
    <x-slot:head>
        <meta name="robots" content="noindex,nofollow">
        <meta name="description" content="{{ $pageTitle }} – {{ config('app.name') }}">
        <title>{{ $pageTitle }} | {{ config('app.name') }}</title>
    </x-slot:head>

    <div class="variant-preview-page {{ $variant['accent_class'] ?? '' }}" data-variant="{{ $variantSlug }}">

        {{-- Preview bar: variant identification and navigation --}}
        <x-homepage-variants.shared.preview-bar
            :variant="$variant"
            :variant-slug="$variantSlug"
            :all-variants="$allVariants" />

        {{-- Variant-specific layout wrapping all sections --}}
        <x-homepage-variants.shared.layout
            :variant="$variant"
            :variant-slug="$variantSlug"
            :sections="$sections"
            :header-categories="$headerCategories"
            :footer-data="$footerData"
            :contact-phone="$contactPhone ?? null"
            :contact-whatsapp="$contactWhatsapp ?? null" />

    </div>
</x-layouts.preview>
