@props(['posts', 'section', 'sourceComponent', 'isHeavy' => false])

@php
    $category = $posts->first()?->postCategory;
    $title = $category->name ?? $section->name ?? __('Section');
@endphp

<section class="variant-generic variant-generic--bold bg-white dark:bg-gray-900 border border-slate-200 dark:border-slate-700"
    id="{{ $category->slug ?? $section->slug ?? 'section-' . $section->id }}">
    <div class="px-4 md:px-6 py-3 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/60 flex items-center justify-between gap-4">
        <div class="flex items-center gap-2 min-w-0">
            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 flex-shrink-0"></span>
            <h3 class="text-sm md:text-base font-extrabold text-slate-900 dark:text-slate-100 tracking-tight truncate">
                {{ $title }}
            </h3>
        </div>
        <span class="text-[10px] uppercase font-bold tracking-[0.18em] text-rose-700">Modular</span>
    </div>

    <div class="p-2 md:p-3">
        @if (view()->exists('components.' . str_replace('.', '/', $sourceComponent)))
            <x-dynamic-component :component="$sourceComponent" :posts="$posts" />
        @else
            <x-homepage-variants.shared.section-fallback :section="$section" />
        @endif
    </div>
</section>
