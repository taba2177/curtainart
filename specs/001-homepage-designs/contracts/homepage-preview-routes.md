# Contract: Homepage Preview Routes

## Purpose

Define the externally reviewable route behavior for the three homepage design variants and the live homepage relationship.

## Route Set

### Live Homepage

- Route: `GET /`
- Behavior: Renders the currently approved live homepage presentation.
- Content source: Existing shared homepage content pipeline.
- SEO: Primary homepage surface.

### Variant Preview: Editorial Premium

- Route: `GET /preview/home/editorial-premium`
- Behavior: Renders the editorial premium homepage variant using the shared homepage section data.
- Audience: Stakeholder review.
- SEO: Non-primary preview surface.

### Variant Preview: Bold Modular

- Route: `GET /preview/home/bold-modular`
- Behavior: Renders the bold modular homepage variant using the shared homepage section data.
- Audience: Stakeholder review.
- SEO: Non-primary preview surface.

### Variant Preview: Calm Storytelling

- Route: `GET /preview/home/calm-storytelling`
- Behavior: Renders the calm storytelling homepage variant using the shared homepage section data.
- Audience: Stakeholder review.
- SEO: Non-primary preview surface.

## Shared Contract Rules

- All preview routes must render the same core homepage sections and content as the live homepage source.
- Preview routes may change section order, hierarchy, and presentation but may not require duplicate content entry.
- Preview routes must support Arabic and English rendering and respect RTL/LTR layout behavior.
- Preview routes must remain compatible with sections that lazy-load or render short/empty content.
- Preview routes must be clearly labeled by variant name so stakeholders can compare them.
- Preview routes must not introduce a permanent multi-theme public homepage mode.

## Failure and Edge Behavior

- If a section has no content, the preview route must render a graceful omission or compact fallback rather than a broken block.
- If a heavy section loads late, the preview route must still render a coherent initial state.
- If preview access is requested before a final design is approved, the live homepage route remains unchanged.
