# Data Model: Three Homepage Design Variants

## Entity: HomepageVariant

- Purpose: Represents one of the three reviewable homepage design directions.
- Fields:
  - `slug`: Stable identifier for routing and selection.
  - `label`: Human-readable variant name shown to stakeholders.
  - `direction`: Editorial premium, bold modular, or calm storytelling.
  - `preview_path`: Review URL for the variant.
  - `status`: `preview`, `approved`, or `live`.
  - `header_footer_mode`: Whether the variant uses default or variant-specific homepage chrome.
  - `seo_mode`: Whether the page is primary/live or preview/non-primary.
- Relationships:
  - Has many `VariantSectionPresentation` records.
  - Can be referenced by one `DesignReviewDecision`.
- Validation rules:
  - `slug` must be unique across variants.
  - Exactly three variants exist for this feature.
  - Only one variant can be `live` at a time.

## Entity: SharedHomepageSection

- Purpose: Represents a reusable homepage content block already sourced from the current site content.
- Fields:
  - `section_id`: Existing underlying section identifier.
  - `section_component`: Shared section type used by the homepage.
  - `default_order`: Existing section order from the source content.
  - `posts_count`: Number of items available to the section.
  - `is_heavy`: Whether the section participates in lazy loading.
  - `is_optional`: Whether the section may be omitted gracefully.
- Relationships:
  - Appears in many `VariantSectionPresentation` records.
- Validation rules:
  - Must map to an existing homepage section type.
  - Must support rendering with short, missing, or delayed content.

## Entity: VariantSectionPresentation

- Purpose: Defines how a shared homepage section is presented inside a specific design variant.
- Fields:
  - `variant_slug`: Parent variant identifier.
  - `section_component`: Shared content section being rendered.
  - `presentation_order`: Order of appearance within the variant.
  - `layout_template`: Variant-specific Blade presentation template.
  - `emphasis_mode`: Primary, supporting, trust, narrative, or compact treatment.
  - `fallback_behavior`: Empty, short-content, and lazy-load handling rule.
- Relationships:
  - Belongs to `HomepageVariant`.
  - References one `SharedHomepageSection`.
- Validation rules:
  - Every variant must cover the same core section set.
  - Order may differ by variant.
  - Presentation rules must remain compatible with lazy-loaded heavy sections.

## Entity: DesignReviewDecision

- Purpose: Captures the outcome of stakeholder review.
- Fields:
  - `selected_variant_slug`: Approved variant.
  - `review_date`: Date of selection.
  - `notes`: Optional rationale or requested refinements.
  - `deployment_target`: Whether the approved variant is ready for live homepage promotion.
- Relationships:
  - References one `HomepageVariant` as selected.
- Validation rules:
  - Selected variant must be one of the three defined variants.
  - Selection promotes one variant toward `live`; the remaining two stay `preview`.

## State Transitions

- `HomepageVariant.status`: `preview` → `approved` → `live`
- Non-selected variants remain `preview` after review.
- A variant cannot skip directly to `live` without being approved.
