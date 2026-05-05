<?php

/**
 * Posts seed for مصنع فن الستارة. Content is taken from the live upstream
 * WordPress site (forestgreen-ant-818944.hostingersite.com / curtainart.sa)
 * verbatim wherever the upstream copy still applies; testimonial quotes and
 * client labels are placeholder content marked with a TODO comment so the
 * site owner can drop in real reviews when available.
 *
 * post_category_id maps to database/seeders/data/post_categories.php (1..12):
 *   1  homepage     (hero)
 *   2  about        (about)
 *   3  services     (services-icons-grid)
 *   4  value-props  (service-benefit)
 *   5  products     (product-types-grid)
 *   6  gallery      (our-works) — single post; `images` drives the swiper
 *   7  why-us       (why-choose-us)
 *   8  team         (team-grid)
 *   9  clients      (trust-strip)
 *  10  testimonials (testimonials)
 *  11  booking      (booking-form)
 *  12  contact      (no home section)
 */

$t = static fn(string $v) => json_encode(['en' => $v, 'ar' => $v], JSON_UNESCAPED_UNICODE);
$img = static fn(string ...$paths) => json_encode($paths, JSON_UNESCAPED_UNICODE);
$now = '2025-01-01 00:00:00';

/**
 * Build the rich product metadata blob used by the product detail page.
 * Stored as plain JSON (not wrapped in {en, ar}) since the site is
 * Arabic-only — the post-detail component reads .gallery / .types /
 * .materials / .specs / .features directly off the parsed object.
 */
$productMeta = static function (array $extras): string {
    return json_encode([
        'subtitle'  => $extras['subtitle']  ?? '',
        'gallery'   => $extras['gallery']   ?? [],
        'types'     => $extras['types']     ?? [],
        'materials' => $extras['materials'] ?? [],
        'specs'     => $extras['specs']     ?? [],
        'features'  => $extras['features']  ?? [],
    ], JSON_UNESCAPED_UNICODE);
};

// Shared product detail extras + features (most products carry a 2-image
// gallery — the main product photo plus the two product-detail variants
// downloaded from the upstream WP site).
$productDetailImages = [
    '/images/curtainsart/products/roll-detail-1.webp',
    '/images/curtainsart/products/roll-detail-2.webp',
];
$standardFeatures = [
    'مقاسات مخصصة بدقة عالية',
    'مقاومة الأشعة فوق البنفسجية',
    'تركيب احترافي بضمان شامل',
    'استشارة وزيارة مجانية',
];

return [
    // ── Homepage / Hero (category 1) ──────────────────────────────────────
    [
        'id' => 1, 'post_category_id' => 1, 'slug' => 'hero',
        'title'   => $t('مصنع فن الستارة'),
        'content' => $t('افضل مصنع ستائر بالرياض و المملكة. ستائر رول، ستائر ويفي، ستائر رومانية، ستائر معدنية، ستائر خشبية، ستائر قماشية، ألواح شتر — كل أنواع الستائر بأيدي حرفيين متخصصين.'),
        'icon' => 'star', 'images' => $img('/images/curtainsart/hero/hero-main.webp'),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── About (category 2) ────────────────────────────────────────────────
    [
        'id' => 2, 'post_category_id' => 2, 'slug' => 'about-us',
        'title'   => $t('من نحن'),
        'content' => $t('مصنع فن الستارة نقدم ستائر عالية الجودة تناسب جميع المساحات، سواء كانت سكنية، تجارية، أو حكومية. نمتلك معدات حديثة وفريقًا من الحرفيين الماهرين الملتزمين بتقديم منتجات تتجاوز توقعات عملائنا في التصميم والجودة والمتانة.'),
        'icon' => 'building-office', 'images' => $img('/images/curtainsart/about/tailoring.jpg'),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    // "What we serve" tags (residential / commercial / government / hospitals)
    // are surfaced as inline pills in the about section's HTML — no separate
    // posts needed.

    // ── Services / services-icons-grid (category 3) — 6 service cards ─────
    // Each service card gets a real curtain installation photo so the
    // services grid feels grounded in actual work — not just abstract icons.
    [
        'id' => 3, 'post_category_id' => 3, 'slug' => 'service-warranty',
        'title'   => $t('ضمان ما بعد البيع'),
        'content' => $t('ضمان شامل على جميع منتجاتنا يغطي الاستبدال أو الإصلاح في حال وجود أي عيب في التصنيع.'),
        'icon' => 'shield-check', 'images' => $img('/images/curtainsart/gallery/01.jpg'),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 4, 'post_category_id' => 3, 'slug' => 'service-consultation',
        'title'   => $t('استشارات مجانية'),
        'content' => $t('فريقنا يقدم استشارة مجانية لاختيار الخامات والتصاميم المناسبة لمساحتك وذوقك.'),
        'icon' => 'chat-bubble', 'images' => $img('/images/curtainsart/about/tailoring.jpg'),
        'order' => 2, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 5, 'post_category_id' => 3, 'slug' => 'service-pricing',
        'title'   => $t('أسعار تنافسية'),
        'content' => $t('أفضل الأسعار في السوق مع الحفاظ على الجودة العالية ومستوى التشطيب الفاخر.'),
        'icon' => 'tag', 'images' => $img('/images/curtainsart/gallery/02.jpg'),
        'order' => 3, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 6, 'post_category_id' => 3, 'slug' => 'service-visit',
        'title'   => $t('زيارة ومعاينة مجانية'),
        'content' => $t('احجز زيارة مجانية ويجيك أحد المختصين لين عندك بكاتلوجاتنا الفاخرة.'),
        'icon' => 'truck', 'images' => $img('/images/curtainsart/gallery/04.jpg'),
        'order' => 4, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 7, 'post_category_id' => 3, 'slug' => 'service-custom',
        'title'   => $t('تفصيل حسب الطلب'),
        'content' => $t('نفصل لك ستائرك بمقاسات دقيقة وتصميم مخصص يناسب تفاصيل المكان وذوقك الشخصي.'),
        'icon' => 'paint-brush', 'images' => $img('/images/curtainsart/gallery/06.jpg'),
        'order' => 5, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 8, 'post_category_id' => 3, 'slug' => 'service-installation',
        'title'   => $t('تركيب وبرمجة'),
        'content' => $t('تركيب احترافي على يد فنيين متخصصين، مع برمجة الستائر الذكية وتشغيلها بكفاءة.'),
        'icon' => 'wrench', 'images' => $img('/images/curtainsart/gallery/07.jpg'),
        'order' => 6, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Value Props / service-benefit (category 4) — 3 cards ─────────────
    [
        'id' => 9, 'post_category_id' => 4, 'slug' => 'value-warranty',
        'title'   => $t('ضمان'),
        'content' => $t('نقدم ضمانًا شاملاً على جميع منتجاتنا لضمان رضا عملائنا، يشمل الضمان استبدال أو إصلاح الستائر في حال وجود أي عيوب.'),
        'icon' => 'shield-check', 'images' => json_encode([]),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 10, 'post_category_id' => 4, 'slug' => 'value-quality',
        'title'   => $t('جودة'),
        'content' => $t('نفخر بالجودة العالية التي نقدمها في كل منتج، حيث نستخدم أفضل المواد وأحدث التقنيات لضمان تقديم ستائر تدوم طويلاً.'),
        'icon' => 'sparkles', 'images' => json_encode([]),
        'order' => 2, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 11, 'post_category_id' => 4, 'slug' => 'value-pricing',
        'title'   => $t('سعر'),
        'content' => $t('نسعى لتقديم أفضل الأسعار دون المساومة على الجودة، لنضمن لعملائنا الحصول على منتجات فاخرة بأسعار تنافسية.'),
        'icon' => 'currency-dollar', 'images' => json_encode([]),
        'order' => 3, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Products / product-types-grid (category 5) — 8 curtain types ─────
    [
        'id' => 12, 'post_category_id' => 5, 'slug' => 'roll-curtains',
        'title'   => $t('ستائر رول'),
        'content' => $t('ستائر رول هي خيار عصري وأنيق يوفر تحكمًا ممتازًا في الضوء والخصوصية. تتكون من قماش متين يلتف حول أسطوانة في الجزء العلوي من النافذة، مما يسهل رفعها وخفضها حسب الحاجة، وتعمل بسلسلة يدوية أو محرك كهربائي.'),
        'icon' => 'sun', 'images' => $img('/images/curtainsart/products/roll.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'تحكم ممتاز بالضوء والخصوصية',
            'gallery'  => ['/images/curtainsart/products/roll.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'تعتيم', 'description' => 'مصممة لحجب الضوء تمامًا، مما يوفر الظلام الكامل في الغرفة'],
                ['name' => 'شفافة', 'description' => 'توفر قدرًا من الخصوصية مع السماح بدخول الضوء الطبيعي'],
                ['name' => 'مزدوجة دوبل', 'description' => 'تجمع بين ستارة تعتيم وستارة شفافة في نظام واحد'],
                ['name' => 'شفافة-معتمة', 'description' => 'تجمع بين أقسام شفافة وأخرى معتمة لمرونة كاملة'],
            ],
            'materials' => ['قماش بوليستر', 'قماش قطني', 'قماش PVC'],
            'specs'    => [
                ['title' => 'البكرات', 'description' => 'أسطوانة من الألمنيوم أو البلاستيك القوي، يلتف حولها القماش'],
                ['title' => 'تحكم يدوي', 'description' => 'نظام حبال أو سلاسل لرفع وخفض الستائر بسهولة'],
                ['title' => 'تحكم كهربائي', 'description' => 'محرك كهربائي مع جهاز تحكم عن بُعد أو تطبيق ذكي'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 13, 'post_category_id' => 5, 'slug' => 'american-curtains',
        'title'   => $t('ستائر أمريكي'),
        'content' => $t('ستائر أمريكي تتميز بتصميماتها الكلاسيكية التي تضيف لمسة من الأناقة والرقي إلى أي غرفة. مناسبة للمنازل التي تبحث عن أجواء فاخرة وهادئة، وتُصنع من خامات راقية بطبقات قماش متعددة.'),
        'icon' => 'home', 'images' => $img('/images/curtainsart/products/american.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'كلاسيكية فاخرة بلمسة عصرية',
            'gallery'  => ['/images/curtainsart/products/american.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'كلاسيكي بطبقة واحدة', 'description' => 'قماش فاخر مع طيات منسدلة كلاسيكية'],
                ['name' => 'مع بطانة تعتيم', 'description' => 'طبقتان: قماش خارجي فاخر + بطانة لحجب الضوء'],
                ['name' => 'مع شيفون', 'description' => 'تتوسطها طبقة شيفون شفافة تمنحها مظهرًا منسابًا'],
            ],
            'materials' => ['قطيفة', 'حرير صناعي', 'كتان طبيعي'],
            'specs'    => [
                ['title' => 'سكة الستارة', 'description' => 'سكة معدنية مزخرفة تُثبت أعلى النافذة'],
                ['title' => 'الحلقات', 'description' => 'حلقات معدنية تنزلق على السكة بسلاسة'],
                ['title' => 'حبال السحب', 'description' => 'حبال خفية لتحريك الستارة بمظهر نظيف'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 2, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 14, 'post_category_id' => 5, 'slug' => 'wooden-curtains',
        'title'   => $t('ستائر خشبية'),
        'content' => $t('ستائر خشبية تضيف لمسة من الطبيعة والأناقة إلى أي مساحة داخلية. تُصنع من الخشب عالي الجودة لتمنح المكان دفئًا ومتانة دائمة، وتتوفر بشرائح بأحجام مختلفة لتناسب جميع أنواع النوافذ.'),
        'icon' => 'tree', 'images' => $img('/images/curtainsart/products/wooden.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'دفء الخشب الطبيعي وأناقة لا تنتهي',
            'gallery'  => ['/images/curtainsart/products/wooden.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'شرائح 25mm', 'description' => 'مناسبة للنوافذ الصغيرة ومظهر خفيف'],
                ['name' => 'شرائح 50mm', 'description' => 'الأكثر شيوعًا — توازن مثالي بين الإضاءة والخصوصية'],
                ['name' => 'شرائح 63mm', 'description' => 'مظهر فخم للنوافذ الكبيرة والمساحات الواسعة'],
            ],
            'materials' => ['خشب البلوط', 'خشب الباسوود', 'خشب صناعي بلمسة طبيعية'],
            'specs'    => [
                ['title' => 'الشرائح الخشبية', 'description' => 'شرائح خشبية معالجة لمقاومة الرطوبة والحرارة'],
                ['title' => 'مفاتيح الإمالة', 'description' => 'حبل لإمالة الشرائح والتحكم باتجاه الإضاءة'],
                ['title' => 'حبال الرفع', 'description' => 'حبال متوازنة لرفع الستارة كاملة'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 3, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 15, 'post_category_id' => 5, 'slug' => 'metal-curtains',
        'title'   => $t('ستائر معدنية'),
        'content' => $t('ستائر معدنية تُعرف بمتانتها ومقاومتها العالية للتآكل. تُستخدم بشكل شائع في المكاتب والمساحات التجارية لما تتميز به من تصميم عملي وقوي، ومتوفرة بشرائح بسماكات مختلفة وألوان متعددة.'),
        'icon' => 'bolt', 'images' => $img('/images/curtainsart/products/metal.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'متانة وأناقة للمكاتب والمحلات',
            'gallery'  => ['/images/curtainsart/products/metal.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'شرائح 16mm', 'description' => 'الأخف وزنًا — مناسبة للنوافذ الصغيرة والمكاتب'],
                ['name' => 'شرائح 25mm', 'description' => 'الاختيار المتوازن — الأكثر استخدامًا في المساحات التجارية'],
                ['name' => 'شرائح 50mm', 'description' => 'مظهر قوي للقاعات والمنشآت الصناعية'],
            ],
            'materials' => ['ألمنيوم خفيف', 'ستيل مطلي', 'طلاء بودرة مقاوم للخدش'],
            'specs'    => [
                ['title' => 'الشرائح المعدنية', 'description' => 'شرائح ألمنيوم بطلاء بودرة مقاوم للصدأ'],
                ['title' => 'مكنزم الرفع', 'description' => 'مكنزم ميكانيكي متين لتشغيل سلس'],
                ['title' => 'تثبيت احترافي', 'description' => 'دعامات مقاومة للصدأ تضمن ثباتًا دائمًا'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 4, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 16, 'post_category_id' => 5, 'slug' => 'vertical-curtains',
        'title'   => $t('ستائر عمودية'),
        'content' => $t('ستائر عمودية تُستخدم بشكل شائع في المكاتب والمساحات التجارية. تتميز بقدرتها على التحكم الدقيق بالضوء وتغطية النوافذ الكبيرة بسهولة، وتعمل بسكة علوية مع شرائح قابلة للدوران.'),
        'icon' => 'bars-3', 'images' => $img('/images/curtainsart/products/vertical.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'الحل المثالي للنوافذ الكبيرة',
            'gallery'  => ['/images/curtainsart/products/vertical.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'قماش بوليستر', 'description' => 'الأكثر شيوعًا — خفيف وسهل التنظيف'],
                ['name' => 'PVC مقاوم', 'description' => 'مقاوم للرطوبة — مناسب للحمامات والمطابخ'],
                ['name' => 'مع تظليل ضوئي', 'description' => 'بطانة عاكسة لتقليل دخول الحرارة'],
            ],
            'materials' => ['بوليستر مقاوم', 'فايبر', 'PVC صناعي'],
            'specs'    => [
                ['title' => 'الشرائح العمودية', 'description' => 'شرائح قابلة للدوران 180 درجة للتحكم بالإضاءة'],
                ['title' => 'السكة العلوية', 'description' => 'سكة ألمنيوم بمكنزم انزلاق هادئ'],
                ['title' => 'حبال أو سلسلة', 'description' => 'تحكم بفتح الستارة وإمالة الشرائح'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 5, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 17, 'post_category_id' => 5, 'slug' => 'roman-curtains',
        'title'   => $t('ستائر روماني'),
        'content' => $t('ستائر رومانية هي خيار أنيق يضيف لمسة من الرقي إلى أي غرفة. تتكون من ألواح قماشية تُطوى أفقياً عند الرفع لتمنح مظهراً كلاسيكياً فاخراً، وتجمع بين دفء القماش وعملية ستائر الرول.'),
        'icon' => 'swatch', 'images' => $img('/images/curtainsart/products/roman.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'أناقة كلاسيكية بطيات قماشية فاخرة',
            'gallery'  => ['/images/curtainsart/products/roman.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'مسطحة', 'description' => 'بدون طيات ظاهرة — مظهر نظيف وعصري'],
                ['name' => 'كلاسيكية', 'description' => 'طيات أفقية متساوية تتشكل عند الرفع'],
                ['name' => 'شلال', 'description' => 'طيات ناعمة تنسدل بمظهر شلالي راقي'],
            ],
            'materials' => ['قطن مصري', 'كتان طبيعي', 'حرير صناعي'],
            'specs'    => [
                ['title' => 'القماش الرئيسي', 'description' => 'قماش معالج لمقاومة البقع وسهل التنظيف'],
                ['title' => 'قضبان أفقية', 'description' => 'قضبان تتيح طي الستارة بشكل موحد'],
                ['title' => 'حبال الرفع', 'description' => 'نظام حبال خفي لرفع الستارة بسلاسة'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 6, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 18, 'post_category_id' => 5, 'slug' => 'zebra-curtains',
        'title'   => $t('ستائر زيبرا'),
        'content' => $t('ستائر زيبرا تجمع بين الخصوصية والتحكم في الضوء من خلال مزيج من ألواح شفافة ومعتمة تُستخدم بتناوب لتعطي مرونة كاملة طوال اليوم. حركة دوران بسيطة تتيح لك تبديل النمط من شفاف لمعتم.'),
        'icon' => 'eye', 'images' => $img('/images/curtainsart/products/zebra.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'مرونة كاملة بين الشفافية والإعتام',
            'gallery'  => ['/images/curtainsart/products/zebra.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'كلاسيك زيبرا', 'description' => 'ألواح متناوبة شفافة ومعتمة بنسب متساوية'],
                ['name' => 'بلاك آوت زيبرا', 'description' => 'الألواح المعتمة تحجب الضوء بنسبة 100٪'],
                ['name' => 'موتورايز زيبرا', 'description' => 'تحكم كهربائي بريموت أو تطبيق ذكي'],
            ],
            'materials' => ['بوليستر مقاوم', 'فايبر متين', 'بلاك آوت اختياري'],
            'specs'    => [
                ['title' => 'الألواح المتناوبة', 'description' => 'شرائط شفافة ومعتمة متبادلة في قماش واحد'],
                ['title' => 'البكرة الدوارة', 'description' => 'بكرة علوية تدور لتغيير وضع الشفافية'],
                ['title' => 'تحكم كهربائي اختياري', 'description' => 'محرك كهربائي يعمل بريموت أو تطبيق ذكي'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 7, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 19, 'post_category_id' => 5, 'slug' => 'shutter-panels',
        'title'   => $t('ألواح الشتر'),
        'content' => $t('ألواح الشتر تتميز بالمتانة والأناقة وتُستخدم للتحكم في الضوء والخصوصية والتهوية. تُصنع من خامات عالية الجودة لمقاومة الاستخدام المستمر، وتُركب بإطار خشبي يضفي على النوافذ مظهرًا معماريًا فاخرًا.'),
        'icon' => 'shield', 'images' => $img('/images/curtainsart/products/shutter.webp'),
        'metadata' => $productMeta([
            'subtitle' => 'متانة معمارية مع تحكم كامل بالنوافذ',
            'gallery'  => ['/images/curtainsart/products/shutter.webp', ...$productDetailImages],
            'types'    => [
                ['name' => 'شتر كامل', 'description' => 'يغطي النافذة بالكامل من أعلى لأسفل'],
                ['name' => 'كافيه ستايل', 'description' => 'يغطي النصف السفلي فقط — يسمح بدخول الضوء'],
                ['name' => 'علوي وسفلي مستقل', 'description' => 'لوحان منفصلان للتحكم بكل جزء على حدة'],
            ],
            'materials' => ['PVC مقاوم للماء', 'خشب صلب', 'ألمنيوم مطلي'],
            'specs'    => [
                ['title' => 'الشرائح القابلة للإمالة', 'description' => 'شرائح يمكن إمالتها للتحكم بالإضاءة والتهوية'],
                ['title' => 'الإطار المعماري', 'description' => 'إطار يضفي على النافذة مظهرًا فاخرًا'],
                ['title' => 'مكنزم تحكم', 'description' => 'قضيب مركزي أو مفصلات جانبية للتحكم'],
            ],
            'features' => $standardFeatures,
        ]),
        'order' => 8, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Gallery / our-works (category 6) — single post, JPG projects only.
    // The 6 PNG files at gallery/{03,05,08,11,13,16}.png are actually
    // client/partner logos and now live in the `clients` category below.
    [
        'id' => 20, 'post_category_id' => 6, 'slug' => 'projects-gallery',
        'title'   => $t('مشاريعنا'),
        'content' => $t('نماذج من تنفيذنا للستائر في منازل وفيلات ومكاتب وجهات حكومية مختلفة بالمملكة.'),
        'icon' => 'photo',
        'images' => $img(
            '/images/curtainsart/gallery/01.jpg',
            '/images/curtainsart/gallery/02.jpg',
            '/images/curtainsart/gallery/04.jpg',
            '/images/curtainsart/gallery/06.jpg',
            '/images/curtainsart/gallery/07.jpg',
            '/images/curtainsart/gallery/09.jpg',
            '/images/curtainsart/gallery/10.jpg',
            '/images/curtainsart/gallery/12.jpg',
            '/images/curtainsart/gallery/14.jpg',
            '/images/curtainsart/gallery/15.jpg',
            '/images/curtainsart/gallery/17.jpg',
            '/images/curtainsart/gallery/18.jpg',
            '/images/curtainsart/gallery/19.jpg',
            '/images/curtainsart/gallery/20.jpg',
            '/images/curtainsart/gallery/21.jpg',
        ),
        'order' => 1, 'show_in_home' => false, 'is_published' => false,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Why Us / why-choose-us (category 7) ──────────────────────────────
    [
        'id' => 21, 'post_category_id' => 7, 'slug' => 'why-trusted',
        'title'   => $t('موثوق بنا من اكثر من 2000 شركة'),
        'content' => $t('عملاؤنا يشملون أكبر الشركات والمؤسسات في المملكة، من المنازل الفاخرة إلى المشاريع التجارية والحكومية. نفخر بثقة كل من تعامل معنا.'),
        'icon' => 'users', 'images' => json_encode([]),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 22, 'post_category_id' => 7, 'slug' => 'why-government',
        'title'   => $t('+47 جهة حكومية تثق بنا'),
        'content' => $t('نخدم الجهات الحكومية والمستشفيات الكبرى بحلول ستائر تواكب المعايير الرسمية وتلبي متطلبات المؤسسات الحساسة.'),
        'icon' => 'building-library', 'images' => json_encode([]),
        'order' => 2, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 23, 'post_category_id' => 7, 'slug' => 'why-experience',
        'title'   => $t('+10 سنوات خبرة و +900 مشروع منجز'),
        'content' => $t('خبرة تراكمية تزيد عن عشر سنوات في تصنيع وتفصيل الستائر، مع أكثر من 900 مشروع منجز و 320 طلب قيد التنفيذ في المملكة.'),
        'icon' => 'trophy', 'images' => json_encode([]),
        'order' => 3, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Clients / trust-strip (category 9) — actual partner logos ────────
    // These 6 PNG files were originally seeded into gallery/ but are
    // company logos rather than project photos, so they belong here. The
    // `title` is a generic placeholder ("شريك ١"…) since the upstream WP
    // site doesn't expose the actual brand names — site owner can rename
    // them via the admin panel once the real client list is confirmed.
    [
        'id' => 27, 'post_category_id' => 9, 'slug' => 'partner-1',
        'title'   => $t('شريك 1'),
        'content' => $t('ضمن أكثر من 2000 شركة تثق بمنتجاتنا.'),
        'icon' => 'building-office',
        'images' => $img('/images/curtainsart/gallery/03.png'),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 28, 'post_category_id' => 9, 'slug' => 'partner-2',
        'title'   => $t('شريك 2'),
        'content' => $t('ضمن أكثر من 2000 شركة تثق بمنتجاتنا.'),
        'icon' => 'building-office',
        'images' => $img('/images/curtainsart/gallery/05.png'),
        'order' => 2, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 29, 'post_category_id' => 9, 'slug' => 'partner-3',
        'title'   => $t('شريك 3'),
        'content' => $t('ضمن أكثر من 2000 شركة تثق بمنتجاتنا.'),
        'icon' => 'building-office',
        'images' => $img('/images/curtainsart/gallery/08.png'),
        'order' => 3, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 36, 'post_category_id' => 9, 'slug' => 'partner-4',
        'title'   => $t('شريك 4'),
        'content' => $t('ضمن أكثر من 2000 شركة تثق بمنتجاتنا.'),
        'icon' => 'building-office',
        'images' => $img('/images/curtainsart/gallery/11.png'),
        'order' => 4, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 37, 'post_category_id' => 9, 'slug' => 'partner-5',
        'title'   => $t('شريك 5'),
        'content' => $t('ضمن أكثر من 2000 شركة تثق بمنتجاتنا.'),
        'icon' => 'building-office',
        'images' => $img('/images/curtainsart/gallery/13.png'),
        'order' => 5, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 38, 'post_category_id' => 9, 'slug' => 'partner-6',
        'title'   => $t('شريك 6'),
        'content' => $t('ضمن أكثر من 2000 شركة تثق بمنتجاتنا.'),
        'icon' => 'building-office',
        'images' => $img('/images/curtainsart/gallery/16.png'),
        'order' => 6, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Testimonials (category 10) ───────────────────────────────────────
    // TODO(site-owner): replace these placeholder reviews with real customer
    // quotes once available. The upstream WP shows ~18 testimonial THUMBNAILS
    // (screenshots of WhatsApp/social reviews) without extractable text — we
    // synthesize plausible quotes here so the section renders, but the names
    // and quotes are NOT real attributions.
    [
        'id' => 30, 'post_category_id' => 10, 'slug' => 'testimonial-1',
        'title'   => $t('عبدالله المطيري'),
        'content' => $t('فصلوا لي ستائر فيلتي كاملة بدقة وبسعر منافس. التركيب جا في موعده والنتيجة فاقت توقعاتي.'),
        'icon' => 'star', 'images' => json_encode([]),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 31, 'post_category_id' => 10, 'slug' => 'testimonial-2',
        'title'   => $t('سارة العتيبي'),
        'content' => $t('الفريق محترف جدًا والاستشارة المجانية ساعدتني أختار الخامة الأنسب لغرف العائلة. أنصح فيهم.'),
        'icon' => 'star', 'images' => json_encode([]),
        'order' => 2, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 32, 'post_category_id' => 10, 'slug' => 'testimonial-3',
        'title'   => $t('ماجد القحطاني'),
        'content' => $t('نفّذوا مشروع ستائر مكاتبنا في ثلاث فروع بدقة عالية والتنسيق مع فريقنا كان ممتاز من البداية للنهاية.'),
        'icon' => 'star', 'images' => json_encode([]),
        'order' => 3, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
    [
        'id' => 33, 'post_category_id' => 10, 'slug' => 'testimonial-4',
        'title'   => $t('نوف السبيعي'),
        'content' => $t('ستائر رول ذكية بمحرك كهربائي ركّبوها لي وكل شي يشتغل بكفاءة عالية. شغل ولا أنظف.'),
        'icon' => 'star', 'images' => json_encode([]),
        'order' => 4, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Booking / booking-form (category 11) — inline lead form copy ─────
    [
        'id' => 34, 'post_category_id' => 11, 'slug' => 'booking-cta',
        'title'   => $t('احجز زيارة مجانية'),
        'content' => $t('متخصصون في تصميم وتفصيل جميع أنواع الستائر | لإرسال المندوب مجاناً الرجاء إدخال بياناتك ويجيك أحد المختصين بكاتلوجاتنا الفاخرة.'),
        'icon' => 'calendar', 'images' => json_encode([]),
        'order' => 1, 'show_in_home' => true, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],

    // ── Contact (category 12) ─────────────────────────────────────────────
    [
        'id' => 35, 'post_category_id' => 12, 'slug' => 'contact-info',
        'title'   => $t('تواصل معنا'),
        'content' => $t('متخصصون في تصميم وتفصيل جميع أنواع الستائر. العنوان: طريق الصحابة، حي اشبيلية، الرياض 13225 — الهاتف: +966554373327 — البريد: artcurtains.sa@gmail.com'),
        'icon' => 'phone', 'images' => json_encode([]),
        'order' => 1, 'show_in_home' => false, 'is_published' => true,
        'created_at' => $now, 'updated_at' => $now,
    ],
];
