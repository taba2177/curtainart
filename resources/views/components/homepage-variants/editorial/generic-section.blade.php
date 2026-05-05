@props(['posts', 'section', 'sourceComponent', 'isHeavy' => false])

@php
    $category = $posts->first()?->postCategory;
    $title = $category->name ?? $section->name ?? __('Section');
@endphp

<section class="variant-generic variant-generic--editorial bg-white/95 dark:bg-gray-900/90 border border-gray-100 dark:border-gray-800 shadow-sm"
    id="{{ $category->slug ?? $section->slug ?? 'section-' . $section->id }}"
    style="scroll-margin-top:7rem">
    <div class="px-4 md:px-6 pt-6 pb-3 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 min-w-0">
            <span class="w-7 h-[2px] bg-amber-400 flex-shrink-0"></span>
            <h3 class="text-sm md:text-base font-bold text-gray-900 dark:text-white tracking-wide truncate">
                {{ $title }}
            </h3>
        </div>
        <span class="text-[11px] uppercase tracking-[0.18em] text-gray-500 dark:text-gray-400">Editorial</span>
    </div>

    <div class="p-2 md:p-3">
        @if (view()->exists('components.' . str_replace('.', '/', $sourceComponent)))
            <x-dynamic-component :component="$sourceComponent" :posts="$posts" />
        @else
            <x-homepage-variants.shared.section-fallback :section="$section" />
        @endif
    </div>
</section>
