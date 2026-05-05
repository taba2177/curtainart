@props(['section'])
{{-- Graceful fallback for section types that don't have a variant-specific template yet --}}
<section class="section-fallback py-10 px-4 border-y border-dashed border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50"
    aria-label="{{ $section->name ?? 'Section' }}">
    <div class="container mx-auto text-center max-w-xl">
        <span class="inline-block px-3 py-1 mb-3 text-xs font-mono font-semibold text-gray-400 dark:text-gray-500
            bg-gray-100 dark:bg-gray-800 rounded-full border border-gray-200 dark:border-gray-700">
            {{ $section->section_component ?? 'unknown' }}
        </span>
        <p class="text-sm text-gray-400 dark:text-gray-500">
            {{ $section->name ?? __('This section will appear here.') }}
        </p>
    </div>
</section>
