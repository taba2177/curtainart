<?php

namespace App\Http\Controllers;

use App\Support\HomepageVariants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Taba\Crm\Livewire\Home as HomeComponent;
use Taba\Crm\Models\CrmSetting;
use Taba\Crm\Models\PostCategory;

class HomepagePreviewController extends Controller
{
    /**
     * Render a specific homepage design variant for stakeholder review.
     */
    public function show(string $variant): View
    {
        $variantConfig = HomepageVariants::find($variant);

        abort_if($variantConfig === null, 404);

        $sections = $this->loadSections();

        // Header categories — used by both header and footer
        $headerCategories = PostCategory::RegisterInHeader();

        // Footer settings — cached for 1 hour
        $footerData = Cache::remember('homepage_footer_data', 3600, fn () => [
            'businessDescription' => CrmSetting::get('crm_business_description') ?? config('app.name'),
            'businessName' => CrmSetting::get('crm_business_name') ?? config('app.name'),
        ]);

        // Contact info for floating buttons
        $contactPhone = CrmSetting::get('crm_contact_phone');
        $contactWhatsapp = CrmSetting::get('crm_contact_whatsapp') ?? $contactPhone;

        $pageTitle = app()->getLocale() === 'ar'
            ? ($variantConfig['label_ar'] . ' - معاينة')
            : ($variantConfig['label'] . ' - Preview');

        return view('preview.home.show', [
            'variant'            => $variantConfig,
            'variantSlug'        => $variant,
            'allVariants'        => HomepageVariants::all(),
            'sections'           => $sections,
            'pageTitle'          => $pageTitle,
            'headerCategories'   => $headerCategories,
            'footerData'         => $footerData,
            'contactPhone'       => $contactPhone,
            'contactWhatsapp'    => $contactWhatsapp,
        ]);
    }

    /**
     * Load homepage sections the same way the live homepage does.
     */
    private function loadSections()
    {
        return PostCategory::whereNotNull('section_component')
            ->parentOnly()
            ->with(['posts' => function ($query) {
                $query->where('show_in_home', true)->published()->orderBy('order', 'asc');
            }])
            ->withCount(['posts' => function ($query) {
                $query->where('show_in_home', true)->published();
            }])
            ->orderBy('order', 'asc')
            ->get();
    }
}
