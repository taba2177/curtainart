@props(['posts', 'section', 'sourceComponent', 'isHeavy' => false])

@php
    $category = $posts->first()?->postCategory;
    $title = $category->name ?? $section->name ?? __('Section');
@endphp

<section class="variant-generic variant-generic--calm bg-white/80 dark:bg-slate-900/80 border border-teal-100 dark:border-teal-900"
    id="{{ $category->slug ?? $section->slug ?? 'section-' . $section->id }}">
    <div class="px-4 md:px-6 py-3 border-b border-teal-100 dark:border-teal-900 flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 min-w-0">
            <span class="w-[2px] h-6 bg-teal-400 dark:bg-teal-700 flex-shrink-0"></span>
            <h3 class="text-sm md:text-base font-semibold text-slate-700 dark:text-slate-200 tracking-wide truncate">
                {{ $title }}
            </h3>
        </div>
        <span class="text-[10px] uppercase font-semibold tracking-[0.18em] text-teal-700 dark:text-teal-400">Story</span>
    </div>

    <div class="p-2 md:p-3">
        @if (view()->exists('components.' . str_replace('.', '/', $sourceComponent)))
            <x-dynamic-component :component="$sourceComponent" :posts="$posts" />
        @else
            <x-homepage-variants.shared.section-fallback :section="$section" />
        @endif
    </div>
</section>
