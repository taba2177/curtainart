<?php

if (! function_exists('crm_theme_css')) {
    /**
     * Generate a <style> tag with CSS custom properties from CRM brand config.
     */
    function crm_theme_css(): ?string
    {
        $brand = config('crm.brand');

        if (empty($brand)) {
            return null;
        }

        $primary   = $brand['primary_color'] ?? '#f1de63';
        $secondary = $brand['secondary_color'] ?? '#d1d1d1';
        $font      = $brand['font_family'] ?? 'Cairo';
        $fontUrl   = $brand['font_url'] ?? null;

        $import = $fontUrl ? "@import url('{$fontUrl}');" : '';

        return "<style>{$import} :root { --crm-primary: {$primary}; --crm-secondary: {$secondary}; --crm-font: '{$font}', sans-serif; }</style>";
    }
}
