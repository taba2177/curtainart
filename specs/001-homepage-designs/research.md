# Research: Three Homepage Design Variants

## Decision 1: Expose each variant through its own public preview page

- Decision: Implement three separate preview pages, one per homepage variant, instead of an in-page toggle or admin-only preview.
- Rationale: Separate preview pages are independently testable, align directly with the clarified spec, keep comparison simple for stakeholders, and avoid coupling preview logic to the live homepage runtime.
- Alternatives considered: A single page with a variant switcher would complicate state and comparison logic; an admin-only preview would make stakeholder review harder; static mockups would not validate the real shared content flow.

## Decision 2: Reuse one shared homepage content pipeline across all variants

- Decision: Keep the existing homepage content source and section-loading behavior as the single source of truth, then map that shared data into variant-specific presentation templates.
- Rationale: The current homepage already loads ordered sections, counts heavy sections, and supports shared SEO/content behavior through the CRM Livewire home component. Reusing that pipeline prevents content duplication and keeps the design review like-for-like.
- Alternatives considered: Duplicating homepage content for each design would increase content management cost; hardcoding section content per variant would break the feature's core requirement to reuse the existing homepage data.

## Decision 3: Add a dedicated variant presentation namespace rather than overloading existing homepage templates

- Decision: Create a dedicated variant-oriented Blade namespace for the new designs while keeping shared layout and content seams explicit.
- Rationale: The current repository already contains multiple homepage component sets, but the new feature needs three clearly reviewable directions with independent styling and section ordering rules. A dedicated namespace reduces accidental regressions in the current homepage and keeps the variants isolated for review.
- Alternatives considered: Reusing the current `homepage` and `homepage3` directories directly risks mixing review artifacts with production templates; one giant conditional template would make design differences harder to maintain and test.

## Decision 4: Treat ui-ux-pro outputs as art direction input, then adapt typography for Arabic support

- Decision: Use ui-ux-pro for variant-level design systems, layout guidance, and conversion patterns, but choose final type pairings that fully support Arabic and bilingual rendering.
- Rationale: ui-ux-pro produced strong direction for editorial, modular, and calm storytelling patterns, but some suggested Latin-first font pairings are not safe for Arabic glyph coverage. The implementation should preserve the current RTL- and Arabic-friendly baseline while still differentiating the variants through hierarchy, spacing, weight, and supporting Latin typography where appropriate.
- Alternatives considered: Applying MCP-suggested Latin font pairings directly would risk broken Arabic rendering; keeping one identical type system across all variants would weaken the creative distinction.

## Decision 5: Preserve current lazy-loading behavior for heavy sections

- Decision: Keep the existing heavy-section threshold and lazy-loading strategy in the homepage rendering path, and make each variant compatible with both initially loaded and delayed section content.
- Rationale: The existing CRM home component already separates light and heavy sections and lazy-loads larger content groups. Respecting that behavior avoids introducing a performance regression during the redesign.
- Alternatives considered: Eager-loading every section for the preview pages would simplify template logic but would risk unnecessary rendering cost and deviate from the existing homepage behavior.

## Decision 6: Mark preview pages as non-primary SEO surfaces

- Decision: Keep the live homepage as the canonical primary entry and treat the three variant preview pages as review surfaces that should not compete in search indexing.
- Rationale: The feature explicitly distinguishes live and preview states. Preview pages exist for review, not discovery, so they should not dilute SEO signals or create duplicate-public-content ambiguity.
- Alternatives considered: Making all preview pages canonical public alternatives would conflict with the clarified requirement that only one approved variant becomes the live homepage.

## Decision 7: Keep interior pages out of scope even if homepage header/footer treatments change

- Decision: Allow homepage-specific header and footer redesign within each variant, but do not require those changes to propagate to interior pages in this feature.
- Rationale: This preserves a tight delivery scope and keeps implementation focused on the homepage experience while still allowing each design concept to feel complete.
- Alternatives considered: Immediate site-wide header/footer rollout would expand the scope into a broader redesign and create unnecessary planning complexity.

## Design Direction Summary from ui-ux-pro

- Editorial premium: Use asymmetric composition, trust-heavy storytelling, refined visual rhythm, and premium contrast between headline and supporting copy.
- Bold modular: Use stronger section contrast, card-based modularity, CTA prominence, and sharper hierarchy to emphasize conversion.
- Calm storytelling: Use more whitespace, softer transitions, narrative sequencing, and quieter trust-building cues while keeping action paths obvious.
