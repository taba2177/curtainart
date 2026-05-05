# Quickstart: Three Homepage Design Variants

## Prerequisites

- PHP 8.2+
- Composer dependencies installed
- Node dependencies installed
- Configured application database with homepage CRM content available

## Local Setup

1. Run `composer install`
2. Run `npm install`
3. Ensure the application environment is configured and the database is reachable
4. If local content is not present yet, run the project's migration and seed flow once the database is ready
5. Start the app with `php artisan serve`
6. Start frontend assets with `npm run dev`

## Review the Variants

1. Open the live homepage at `http://127.0.0.1:8000/`
2. Open `http://127.0.0.1:8000/preview/home/editorial-premium`
3. Open `http://127.0.0.1:8000/preview/home/bold-modular`
4. Open `http://127.0.0.1:8000/preview/home/calm-storytelling`

## Validate the Experience

1. Compare all three preview pages using the same homepage content
2. Switch between Arabic and English and confirm layout flow remains readable
3. Review desktop and mobile viewport behavior for header, hero, CTA, section transitions, and footer
4. Confirm sections with sparse or delayed content still render gracefully

## Approve a Variant

1. Select the preferred variant after stakeholder review
2. Promote the chosen variant by updating `App\\Support\\HomepageVariants::LIVE_VARIANT`
3. Keep the remaining two variants as preview-only review artifacts

## Implementation Notes

1. Preview routes are registered in `routes/web.php` before the catch-all redirect
2. Variant previews render through `App\\Http\\Controllers\\HomepagePreviewController`
3. Shared homepage content still comes from the existing CRM section pipeline
4. Non-primary preview pages send `noindex,nofollow` metadata
