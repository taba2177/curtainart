🎨 Task:
Convert any Blade file inside the homepage/ folder into a Fully Dynamic Section Component that depends on only one variable:

@props(['posts'])


✔ The file must work exactly like the following code methodology (Dynamic layout → based on posts count):

If $posts->count() === 1 → Single Spotlight design or any standerd from best ui/ux standers

If $posts->count() === 2 → 2 Columns Split design or any standerd from best ui/ux standers

If $posts->count() >= 3 → Grid / Masonry design or any standerd from best ui/ux standers

✔ The following values must be automatically extracted only from:

$category = $posts->first()->postCategory


✔ Fully preserve the original homepage file design (colors – spacing – containers – animations – custom CSS).
✔ Merge Tailwind classes without removing or breaking any existing Custom CSS.
✔ Must support:

Rich content

@markdown or partials

Excerpt

Icon or Image fallback

Group Hover Effects

✔ Clean the code, make it Production-Ready, and comment only essential parts.
✔ No new variables allowed except $posts.
✔ Do not break the original design structure, only improve it.

Output Requirements:

🔹 I want complete, clean Blade code, ready to paste into the file.
🔹 Same quality level as this example (which is the Standard):

https://pastebin.com/raw/ibNnSectionExample

🔹 Must follow the exact same structure:

Section Header → from category

Dynamic Layout → 1 / 2 / 3+

Same method for using icons / images

Same method for include partials

Important:

Do not deviate from the original design used in homepage files.

Do not change any colors — must stick to:

bg-primary-color

text-primary-color-light

other custom vars

Do not use any external styles.

Do not add any unnecessary new IDs or classes.

🔥 Finally:
I want code only, no explanation.

use in icons <X-icon name="{{ $post->icon }}"/> dont use <x-heroicon-o-... or any others
