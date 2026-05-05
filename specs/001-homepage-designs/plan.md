# Implementation Plan: Three Homepage Design Variants

**Branch**: `[001-homepage-designs]` | **Date**: 2026-03-17 | **Spec**: [spec.md](./spec.md)
**Input**: Feature specification from `/specs/001-homepage-designs/spec.md`

**Note**: This template is filled in by the `/speckit.plan` command. See `.specify/templates/plan-template.md` for the execution workflow.

## Summary

Create three visually distinct, reviewable homepage variants for the existing Laravel + Taba CRM site by reusing the current homepage section data, exposing each variant through its own preview page, and preserving one clear path for promoting a selected variant to the live homepage. The technical approach is to keep the existing content-loading model intact, add variant-specific presentation layers in published Blade views/components, introduce preview route contracts that do not affect live SEO, and validate the variants through Pest smoke tests plus manual RTL/mobile review.

## Technical Context

**Language/Version**: PHP 8.2, Blade templates, ES modules via Vite  
**Primary Dependencies**: Laravel 12, Livewire, Taba CRM package, Tailwind CSS 3.4, Vite 7, Pest, ui-ux-pro MCP for design research  
**Storage**: Existing MySQL-backed CRM content tables for posts, categories, and settings  
**Testing**: Pest feature tests, Laravel route/view smoke checks, manual responsive + RTL review  
**Target Platform**: Server-rendered web application for modern desktop and mobile browsers  
**Project Type**: Laravel monolith with package-driven homepage rendering and published Blade view overrides  
**Performance Goals**: Preserve current homepage lazy-loading behavior for heavy sections, avoid duplicate content models, and keep preview pages within the same rendering class as the current homepage  
**Constraints**: Reuse existing homepage section data, do not modify vendor package source, support Arabic and English, support RTL and mobile, keep interior pages out of scope  
**Scale/Scope**: 3 preview variants, 1 live adoption path, reuse the existing homepage section library and shared header/footer/layout overrides

## Constitution Check

*GATE: Must pass before Phase 0 research. Re-check after Phase 1 design.*

- Constitution file is an unfilled template with placeholder principles only; there are no enforceable project-specific gates to fail.
- Gate status before Phase 0: PASS.
- Gate status after Phase 1 design: PASS.

## Project Structure

### Documentation (this feature)

```text
specs/001-homepage-designs/
├── plan.md              # This file (/speckit.plan command output)
├── research.md          # Phase 0 output (/speckit.plan command)
├── data-model.md        # Phase 1 output (/speckit.plan command)
├── quickstart.md        # Phase 1 output (/speckit.plan command)
├── contracts/
│   └── homepage-preview-routes.md
└── tasks.md             # Phase 2 output (/speckit.tasks command - NOT created by /speckit.plan)
```

### Source Code (repository root)

```text
app/
├── Providers/
│   └── Filament/
├── Models/
└── Policies/

routes/
└── web.php

resources/
├── css/
│   └── app.css
├── js/
│   └── app.js
└── views/
  ├── components/
  │   ├── layouts/
  │   ├── header.blade.php
  │   ├── footer.blade.php
  │   ├── homepage/
  │   ├── homepage3/
  │   └── homepage-variants/
  ├── livewire/
  │   └── home.blade.php
  └── vendor/
    └── crm/
      └── livewire/
        └── home.blade.php

tests/
├── Feature/
└── TestCase.php

vendor/
└── taba/
  └── crm/
    └── src/
      └── Livewire/
        └── Home.php
```

**Structure Decision**: Keep the work inside the existing Laravel app and published CRM view override surface. Add homepage-variant presentation files under `resources/views/components`, keep shared content loading in the current homepage Livewire flow, introduce preview route handling in `routes/web.php`, and cover route/render regressions with Pest feature tests. Do not modify vendor package source.

## Complexity Tracking

No constitution violations requiring justification.
