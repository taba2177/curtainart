{{-- Renders when the homepage has no sections configured --}}
<section class="flex flex-col items-center justify-center py-24 px-4 text-center bg-gray-50 dark:bg-gray-900">
    <div class="max-w-md">
        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-6" fill="none" stroke="currentColor"
            viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h2 class="text-xl font-bold text-gray-700 dark:text-gray-300 mb-2">
            {{ __('No Content Yet') }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Add homepage sections from the CRM admin panel to populate this preview.') }}
        </p>
    </div>
</section>
