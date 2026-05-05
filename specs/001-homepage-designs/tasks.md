# Tasks: Three Homepage Design Variants

**Input**: Design documents from `/specs/001-homepage-designs/`
**Prerequisites**: plan.md, spec.md, research.md, data-model.md, contracts/homepage-preview-routes.md, quickstart.md

**Tests**: No dedicated test-first tasks were generated because the feature specification did not explicitly request a TDD or test-only workflow. Validation is covered through implementation and quickstart review tasks.

**Organization**: Tasks are grouped by user story so each story can be implemented and validated independently.

## Phase 1: Setup (Shared Infrastructure)

**Purpose**: Prepare the project structure for homepage variant implementation.

- [x] T001 Create homepage variant view scaffolding in resources/views/components/homepage-variants/ and resources/views/preview/home/
- [x] T002 Create preview controller scaffold in app/Http/Controllers/HomepagePreviewController.php
- [x] T003 [P] Create variant catalog scaffold in app/Support/HomepageVariants.php

---

## Phase 2: Foundational (Blocking Prerequisites)

**Purpose**: Establish routing, shared rendering, and variant resolution before any user story work begins.

**⚠️ CRITICAL**: No user story work can begin until this phase is complete.

- [x] T004 Update routes/web.php to register /preview/home/{variant} routes before the catch-all redirect
- [x] T005 Create the shared preview wrapper in resources/views/home-preview.blade.php and resources/views/components/homepage-variants/shared/layout.blade.php
- [x] T006 Implement variant slug metadata and live/preview selection rules in app/Support/HomepageVariants.php
- [x] T007 Refactor resources/views/vendor/crm/livewire/home.blade.php to introduce a variant-aware section rendering seam while preserving heavy-section lazy loading
- [x] T008 Create shared homepage variant chrome in resources/views/components/homepage-variants/shared/header.blade.php and resources/views/components/homepage-variants/shared/footer.blade.php

**Checkpoint**: Foundation ready. Preview routes, shared layout, and variant resolution are available for story implementation.

---

## Phase 3: User Story 1 - Review Three Distinct Homepage Directions (Priority: P1) 🎯 MVP

**Goal**: Deliver three complete, clearly different previewable homepage variants for stakeholder review.

**Independent Test**: Open `/preview/home/editorial-premium`, `/preview/home/bold-modular`, and `/preview/home/calm-storytelling` and verify each page renders a complete homepage with the same underlying content but clearly distinct visual direction.

### Implementation for User Story 1

- [x] T009 [P] [US1] Build the editorial premium section set in resources/views/components/homepage-variants/editorial/
- [x] T010 [P] [US1] Build the bold modular section set in resources/views/components/homepage-variants/bold/
- [x] T011 [P] [US1] Build the calm storytelling section set in resources/views/components/homepage-variants/calm/
- [x] T012 [US1] Wire preview page rendering and variant labels in app/Http/Controllers/HomepagePreviewController.php and resources/views/home-preview.blade.php
- [x] T013 [US1] Add preview comparison chrome and variant identification in resources/views/home-preview.blade.php and resources/views/components/homepage-variants/shared/layout.blade.php

**Checkpoint**: User Story 1 is complete when stakeholders can review three distinct homepage variants on separate preview pages.

---

## Phase 4: User Story 2 - Preserve the Existing Reusable Homepage Content (Priority: P2)

**Goal**: Reuse the current homepage section pipeline across all three variants without duplicate content entry.

**Independent Test**: Load any preview variant and confirm the existing homepage section list, ordering source, and section content render through the variant templates without creating duplicate homepage data.

### Implementation for User Story 2

- [x] T014 [P] [US2] Add shared section-to-template mapping for existing section_component values in app/Support/HomepageVariants.php
- [x] T015 [US2] Implement section presentation resolution for existing section types in resources/views/vendor/crm/livewire/home.blade.php and resources/views/home-preview.blade.php
- [x] T016 [P] [US2] Create shared empty and short-content fallbacks in resources/views/components/homepage-variants/shared/empty-state.blade.php and resources/views/components/homepage-variants/shared/section-fallback.blade.php
- [x] T017 [US2] Update the variant directories resources/views/components/homepage-variants/editorial/, resources/views/components/homepage-variants/bold/, and resources/views/components/homepage-variants/calm/ to handle missing and sparse content gracefully
- [x] T018 [US2] Keep live homepage content reuse aligned with the approved variant mapping in app/Support/HomepageVariants.php and resources/views/vendor/crm/livewire/home.blade.php

**Checkpoint**: User Story 2 is complete when all variants reuse the same homepage content source and handle missing or short sections safely.

---

## Phase 5: User Story 3 - Deliver a Usable Experience Across Locale and Device Contexts (Priority: P3)

**Goal**: Make all variants readable and usable in Arabic and English on desktop and mobile.

**Independent Test**: Review the live homepage and all three preview variants in Arabic and English at desktop and mobile viewport sizes, confirming header, hero, CTA, section flow, and footer remain readable and usable.

### Implementation for User Story 3

- [x] T019 [P] [US3] Add variant design tokens, responsive spacing, and motion rules to resources/css/app.css
- [x] T020 [P] [US3] Update resources/views/components/layouts/app.blade.php and resources/views/components/homepage-variants/shared/layout.blade.php for variant-aware RTL/LTR and preview metadata classes
- [x] T021 [US3] Adapt resources/views/components/homepage-variants/shared/header.blade.php and resources/views/components/homepage-variants/shared/footer.blade.php for Arabic/English content growth and mobile navigation behavior
- [x] T022 [US3] Add non-primary preview metadata and locale-safe page labeling in app/Http/Controllers/HomepagePreviewController.php and resources/views/home-preview.blade.php
- [x] T023 [US3] Tune the variant directories resources/views/components/homepage-variants/editorial/, resources/views/components/homepage-variants/bold/, and resources/views/components/homepage-variants/calm/ for mobile and RTL layout fidelity

**Checkpoint**: User Story 3 is complete when the variants remain usable across both locales and across desktop/mobile layouts.

---

## Phase 6: Polish & Cross-Cutting Concerns

**Purpose**: Finalize documentation, approval flow, and end-to-end validation across the feature.

- [x] T024 [P] Document preview URLs, approval flow, and live variant promotion in specs/001-homepage-designs/quickstart.md and README.md
- [x] T025 [P] Review preview route behavior and preview-only metadata in routes/web.php, app/Http/Controllers/HomepagePreviewController.php, and resources/views/home-preview.blade.php
- [x] T026 Run quickstart validation for `/` and all three preview URLs across Arabic/English and desktop/mobile, then record follow-up notes in specs/001-homepage-designs/quickstart.md

---

## Dependencies & Execution Order

### Phase Dependencies

- **Setup (Phase 1)**: No dependencies. Can start immediately.
- **Foundational (Phase 2)**: Depends on Setup completion. Blocks all user story work.
- **User Story 1 (Phase 3)**: Starts after Foundational. Establishes the MVP preview experience.
- **User Story 2 (Phase 4)**: Starts after Foundational. Prefer to execute after User Story 1 because it deepens the shared content integration across the same variant files.
- **User Story 3 (Phase 5)**: Starts after Foundational. Prefer to execute after User Stories 1 and 2 because it refines the same layout, preview, and variant surfaces for RTL and responsive quality.
- **Polish (Phase 6)**: Starts after all targeted user stories are complete.

### User Story Dependencies

- **User Story 1 (P1)**: No dependency on other stories after Foundational.
- **User Story 2 (P2)**: Independent from a business perspective after Foundational, but shares files with User Story 1 and is safer to execute after the preview surfaces exist.
- **User Story 3 (P3)**: Independent from a business perspective after Foundational, but depends on variant surfaces being present so locale and responsive refinements can be applied meaningfully.

### Within Each User Story

- Shared scaffolding before route wiring.
- Route wiring before final preview validation.
- Shared layout and chrome before variant-specific tuning.
- Variant-specific sections before content fallback and responsive refinement.

### Parallel Opportunities

- Setup task T003 can run in parallel with T001-T002.
- In User Story 1, T009, T010, and T011 can run in parallel because they target different variant directories.
- In User Story 2, T014 and T016 can run in parallel because they target different files.
- In User Story 3, T019 and T020 can run in parallel because they target different files.
- In Polish, T024 and T025 can run in parallel before T026 final validation.

---

## Parallel Example: User Story 1

```bash
# Build the three design directions in parallel:
Task: "Build the editorial premium section set in resources/views/components/homepage-variants/editorial/"
Task: "Build the bold modular section set in resources/views/components/homepage-variants/bold/"
Task: "Build the calm storytelling section set in resources/views/components/homepage-variants/calm/"
```

## Parallel Example: User Story 2

```bash
# Prepare shared integration pieces in parallel:
Task: "Add shared section-to-template mapping for existing section_component values in app/Support/HomepageVariants.php"
Task: "Create shared empty and short-content fallbacks in resources/views/components/homepage-variants/shared/empty-state.blade.php and resources/views/components/homepage-variants/shared/section-fallback.blade.php"
```

## Parallel Example: User Story 3

```bash
# Refine global usability in parallel:
Task: "Add variant design tokens, responsive spacing, and motion rules to resources/css/app.css"
Task: "Update resources/views/components/layouts/app.blade.php and resources/views/components/homepage-variants/shared/layout.blade.php for variant-aware RTL/LTR and preview metadata classes"
```

---

## Implementation Strategy

### MVP First (User Story 1 Only)

1. Complete Phase 1: Setup.
2. Complete Phase 2: Foundational.
3. Complete Phase 3: User Story 1.
4. Validate the three preview pages with shared content.
5. Demo the design comparison flow before deepening content/fallback behavior.

### Incremental Delivery

1. Deliver previewable variant pages first with User Story 1.
2. Add full shared content reuse and graceful section fallback behavior with User Story 2.
3. Finish RTL, bilingual, and responsive quality with User Story 3.
4. Complete documentation and final review validation in Polish.

### Parallel Team Strategy

1. One developer completes route/controller/catalog groundwork in Phases 1 and 2.
2. After Foundational is complete, separate developers can own editorial, bold, and calm variant directories in parallel.
3. Shared integration, fallback, and RTL/responsive polish can be split across backend/view wiring and CSS/layout refinement.

---

## Notes

- All task lines follow the required checklist format: checkbox, ID, optional `[P]`, optional story label, and exact path reference.
- The recommended MVP scope is **User Story 1 only**, because it satisfies the primary stakeholder review goal.
- Preview pages are planned as review artifacts; the live homepage remains a single approved variant.
