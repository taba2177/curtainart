# curtainsart — مصنع فن الستارة

Laravel 12 + Angular 19 SPA for a Saudi curtain factory. Uses the `taba/crm` package.

## Stack

- **Backend**: Laravel 12, SQLite (dev), `taba/crm` package, Filament admin, Curator media library
- **Frontend**: Angular 19, Tailwind CSS, RTL Arabic-only, Tajawal font, brand `#0074b3`
- **Build output**: `frontend/` → `public/` (Angular copies `frontend/public/` assets every build)

## Dev commands

```bash
# Backend (from repo root)
php artisan serve --port=8765
php artisan migrate:fresh --seed --force

# Frontend (from frontend/)
npm run build -- --configuration=production
npm start   # dev server on :4200
```

## Key architecture

- `section_component` field on PostCategory drives home-page section dispatch via `@switch` in `home.html`
- **Never touch `frontend2/`** — it is a backup directory
- Curator media: files live in `storage/app/public/images/curtainsart/`, served via `/storage/...` after `php artisan storage:link`
- Post `images` column stores integer Curator Media IDs (not file paths)
- `crm_*` settings keys in `CrmSettingsSeeder` are what Angular reads via `/api/v1/init`

## Seeder run order

`RolesAndPermissions → User → PostCategory → Post → CrmSettings → ImageDownload`

## Content source

Live WP site: `forestgreen-ant-818944.hostingersite.com` / `curtainart.sa`
- Brand: Tajawal font, `#0074b3` primary, year founded 2016
- Stats: 900+ projects / 320+ clients / 47+ government / 10+ years
- Phone: `+966554373327`

## Frontend notes

- Nav and footer links are **hardcoded** in `header.ts` and `footer.ts` (not API-driven)
- `serviceIconFor(post)` in `home.ts` maps post slug/icon field → Lucide icon
- Product detail page: `isProductLayout` = true when category slug is `products`
- Product `metadata` JSON field: `{subtitle, gallery, types, materials, specs, features}`
- Tabby + Tamara BNPL badges shown in product detail sticky info card
- Favicon source: `frontend/public/favicon.ico` + `frontend/public/favicon.svg` (copied to `public/` on every build)
