<?php

namespace App\Support;

/**
 * Catalog of available homepage design variants.
 *
 * Provides slug-to-config resolution, live variant selection,
 * and section-to-template mapping used by all three design directions.
 */
class HomepageVariants
{
    /**  The slug of the currently live/approved variant. Change this to promote. */
    const LIVE_VARIANT = 'editorial-premium';

    /** All available homepage design variants. */
    private static array $variants = [
        'editorial-premium' => [
            'slug'          => 'editorial-premium',
            'label'         => 'Editorial Premium',
            'label_ar'      => 'التحرير الراقي',
            'description'   => 'Asymmetric composition, trust-heavy storytelling, refined visual rhythm.',
            'status'        => 'preview',   // preview | approved | live
            'component_dir' => 'homepage-variants.editorial',
            'accent_class'  => 'variant-editorial',
        ],
        'bold-modular' => [
            'slug'          => 'bold-modular',
            'label'         => 'Bold Modular',
            'label_ar'      => 'النمطي الجريء',
            'description'   => 'Card-based modularity, CTA prominence, sharper hierarchy.',
            'status'        => 'preview',
            'component_dir' => 'homepage-variants.bold',
            'accent_class'  => 'variant-bold',
        ],
        'calm-storytelling' => [
            'slug'          => 'calm-storytelling',
            'label'         => 'Calm Storytelling',
            'label_ar'      => 'السرد الهادئ',
            'description'   => 'Whitespace-led narrative, softer transitions, quiet trust-building.',
            'status'        => 'preview',
            'component_dir' => 'homepage-variants.calm',
            'accent_class'  => 'variant-calm',
        ],
    ];

    /**
     * Mapping from CRM section_component names to variant-specific presentation templates.
     * Format: section_component => variant_template_suffix
     * The full component path is built as: {variant.component_dir}.{template_suffix}
     * Falls back to shared template if a variant-specific one is absent.
     */
    private static array $sectionTemplateMap = [
        'hero'             => 'hero',
        'services'         => 'services',
        'about'            => 'about',
        'testimonials'     => 'testimonials',
        'our-projects'     => 'projects',
        'our-blog'         => 'blog',
        'contact-us'       => 'contact',
        'our-service'      => 'services',
        'features'         => 'features',
        'four-cards'       => 'four-cards',
        'cta-box'          => 'cta',
        'stats-counter'    => 'stats',
        'team'             => 'team',
        'our-faqs'         => 'faqs',
        'partners'         => 'partners',
        'brands'           => 'brands',
        'gallery'          => 'gallery',
        'pricing'          => 'pricing',
        'timeline'         => 'timeline',
        'video'            => 'video',
        'newsletter'       => 'newsletter',
        'what-i-do'        => 'what-i-do',
        'why-choose-us'    => 'why-choose-us',
        'mission'          => 'mission',
        'service-benefit'  => 'service-benefit',
        'journey-section'  => 'journey',
        'blog-section'     => 'blog',
        'location'         => 'location',
    ];

    /** Return template suffix for a section_component. */
    public static function templateSuffixFor(string $sectionComponent): string
    {
        return self::$sectionTemplateMap[$sectionComponent] ?? $sectionComponent;
    }

    /** Return all variant configs as an array keyed by slug. */
    public static function all(): array
    {
        return self::$variants;
    }

    /** Find a variant config by slug, or return null. */
    public static function find(string $slug): ?array
    {
        return self::$variants[$slug] ?? null;
    }

    /** Return the slug of the live variant. */
    public static function liveSlug(): string
    {
        return self::LIVE_VARIANT;
    }

    /**
     * Resolve the Blade component name for a given section_component and variant.
     * Returns the variant-specific component path if the view exists,
     * otherwise falls back to the shared passthrough.
     */
    public static function resolveComponentFor(string $sectionComponent, array $variantConfig): string
    {
        $suffix   = self::templateSuffixFor($sectionComponent);
        $specific = $variantConfig['component_dir'] . '.' . $suffix;

        if (view()->exists('components.' . str_replace('.', '/', $specific))) {
            return $specific;
        }

        // Fall back to the original homepage component
        return 'homepage.' . $sectionComponent;
    }
}
