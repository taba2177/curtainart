@props(['variant', 'variantSlug', 'allVariants'])

<div class="variant-preview-shell variant-preview-bar bg-gray-900 print:hidden" role="navigation" aria-label="Design variant selector">
    <div class="container mx-auto px-4 py-2.5 flex flex-col sm:flex-row items-center justify-between gap-2">

        {{-- Label --}}
        <div class="flex items-center gap-2 text-xs font-semibold text-amber-300 uppercase tracking-wider">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            {{ __('Design Review') }}
        </div>

        {{-- Variant switcher --}}
        <div class="flex flex-wrap items-center justify-center gap-2">
            @foreach ($allVariants as $slug => $v)
                @if ($slug === $variantSlug)
                    <span class="variant-chip is-active inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold cursor-default
                        bg-amber-400 text-gray-950 dark:bg-amber-500 dark:text-gray-950">
                        <span class="w-2 h-2 rounded-full bg-gray-950/40 inline-block"></span>
                        {{ app()->getLocale() === 'ar' ? $v['label_ar'] : $v['label'] }}
                        <span class="text-gray-950/60 font-normal">({{ __('current') }})</span>
                    </span>
                @else
                    <a href="{{ route('homepage.preview', ['variant' => $slug]) }}"
                        class="variant-chip inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold
                            text-gray-100 hover:bg-slate-600/80 hover:text-white dark:text-gray-300 dark:hover:bg-slate-700/80 dark:hover:text-white transition-colors duration-200">
                        {{ app()->getLocale() === 'ar' ? $v['label_ar'] : $v['label'] }}
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Live homepage link --}}
        <a href="{{ url('/') }}" class="text-xs text-gray-300 hover:text-white transition-colors flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v9h5v-6h4v6h5V10" />
            </svg>
            {{ __('Live Homepage') }}
        </a>

    </div>
</div>
