<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Taba\Crm\Models\CrmSetting;

/**
 * Brand-and-content settings for مصنع فن الستارة (Art of Curtains Factory).
 *
 * Values map onto the `crm_*` keys read by frontend/src/app/components/*.
 * Source of truth for content is the live upstream WordPress site at
 * https://forestgreen-ant-818944.hostingersite.com — when in doubt, the
 * upstream site wins, not earlier spec docs.
 *
 * The seeder uses updateOrCreate per key so it can be re-run on an existing
 * database without losing other rows.
 */
class CrmSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ── Contact ───────────────────────────────────────────────────
            [
                'key' => 'crm_contact_phone',
                'value' => '+966554373327',
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'Phone Number', 'ar' => 'رقم الهاتف'],
                'description' => ['en' => 'Business contact phone number', 'ar' => 'رقم هاتف العمل'],
                'is_translatable' => false,
                'order' => 1,
            ],
            [
                'key' => 'crm_contact_whatsapp',
                'value' => '966554373327',
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'WhatsApp Number', 'ar' => 'رقم واتساب'],
                'description' => ['en' => 'WhatsApp number (digits only, used as wa.me path)', 'ar' => 'رقم واتساب بدون رموز'],
                'is_translatable' => false,
                'order' => 2,
            ],
            [
                'key' => 'crm_contact_email',
                'value' => 'artcurtains.sa@gmail.com',
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'Email Address', 'ar' => 'البريد الإلكتروني'],
                'description' => ['en' => 'Business contact email', 'ar' => 'البريد الإلكتروني للعمل'],
                'is_translatable' => false,
                'order' => 3,
            ],
            [
                'key' => 'crm_contact_address',
                'value' => ['en' => 'طريق الصحابة، حي اشبيلية، الرياض 13225', 'ar' => 'طريق الصحابة، حي اشبيلية، الرياض 13225'],
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'Street Address', 'ar' => 'عنوان الشارع'],
                'description' => ['en' => 'Business street address', 'ar' => 'عنوان الشارع للعمل'],
                'is_translatable' => true,
                'order' => 4,
            ],
            [
                'key' => 'crm_contact_city',
                'value' => ['en' => 'الرياض', 'ar' => 'الرياض'],
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'City', 'ar' => 'المدينة'],
                'description' => ['en' => 'Business city', 'ar' => 'مدينة العمل'],
                'is_translatable' => true,
                'order' => 5,
            ],
            [
                'key' => 'crm_contact_postal_code',
                'value' => '13225',
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'Postal Code', 'ar' => 'الرمز البريدي'],
                'description' => ['en' => 'Business postal code', 'ar' => 'الرمز البريدي للعمل'],
                'is_translatable' => false,
                'order' => 6,
            ],
            [
                'key' => 'crm_contact_latitude',
                'value' => '24.7248',
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'Latitude', 'ar' => 'خط العرض'],
                'description' => ['en' => 'Location latitude coordinate', 'ar' => 'إحداثي خط العرض'],
                'is_translatable' => false,
                'order' => 7,
            ],
            [
                'key' => 'crm_contact_longitude',
                'value' => '46.7481',
                'type' => 'text',
                'group' => 'contact',
                'label' => ['en' => 'Longitude', 'ar' => 'خط الطول'],
                'description' => ['en' => 'Location longitude coordinate', 'ar' => 'إحداثي خط الطول'],
                'is_translatable' => false,
                'order' => 8,
            ],

            // ── Social ─────────────────────────────────────────────────────
            // The frontend (footer.html, home.html) reads `crm_social_*`. The
            // duplicate `crm_contact_*` legacy keys below are kept so admin UIs
            // that group under 'contact' continue to find their fields.
            [
                'key' => 'crm_social_facebook',
                'value' => 'https://www.facebook.com/profile.php?id=61559157211411',
                'type' => 'text',
                'group' => 'social',
                'label' => ['en' => 'Facebook URL', 'ar' => 'رابط فيسبوك'],
                'description' => ['en' => 'Facebook page URL', 'ar' => 'رابط صفحة فيسبوك'],
                'is_translatable' => false,
                'order' => 1,
            ],
            [
                'key' => 'crm_social_twitter',
                'value' => 'https://x.com/art_of_curtains',
                'type' => 'text',
                'group' => 'social',
                'label' => ['en' => 'Twitter/X URL', 'ar' => 'رابط تويتر/X'],
                'description' => ['en' => 'Twitter/X profile URL', 'ar' => 'رابط حساب تويتر/X'],
                'is_translatable' => false,
                'order' => 2,
            ],
            [
                'key' => 'crm_social_instagram',
                'value' => 'https://www.instagram.com/artcurtains_ksa',
                'type' => 'text',
                'group' => 'social',
                'label' => ['en' => 'Instagram URL', 'ar' => 'رابط إنستجرام'],
                'description' => ['en' => 'Instagram profile URL', 'ar' => 'رابط حساب إنستجرام'],
                'is_translatable' => false,
                'order' => 3,
            ],
            [
                'key' => 'crm_social_tiktok',
                'value' => 'https://www.tiktok.com/@artcurtains.sa',
                'type' => 'text',
                'group' => 'social',
                'label' => ['en' => 'TikTok URL', 'ar' => 'رابط تيك توك'],
                'description' => ['en' => 'TikTok profile URL', 'ar' => 'رابط حساب تيك توك'],
                'is_translatable' => false,
                'order' => 4,
            ],
            [
                'key' => 'crm_social_snapchat',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => ['en' => 'Snapchat URL', 'ar' => 'رابط سناب شات'],
                'description' => ['en' => 'Snapchat profile URL', 'ar' => 'رابط حساب سناب شات'],
                'is_translatable' => false,
                'order' => 5,
            ],
            [
                'key' => 'crm_social_youtube',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => ['en' => 'YouTube URL', 'ar' => 'رابط يوتيوب'],
                'description' => ['en' => 'YouTube channel URL', 'ar' => 'رابط قناة يوتيوب'],
                'is_translatable' => false,
                'order' => 6,
            ],
            [
                'key' => 'crm_social_linkedin',
                'value' => '',
                'type' => 'text',
                'group' => 'social',
                'label' => ['en' => 'LinkedIn URL', 'ar' => 'رابط لينكد إن'],
                'description' => ['en' => 'LinkedIn company URL', 'ar' => 'رابط صفحة لينكد إن'],
                'is_translatable' => false,
                'order' => 7,
            ],

            // ── Business ──────────────────────────────────────────────────
            [
                'key' => 'crm_business_name',
                'value' => ['en' => 'مصنع فن الستارة', 'ar' => 'مصنع فن الستارة'],
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Business Name', 'ar' => 'اسم العمل'],
                'description' => ['en' => 'Your business or company name', 'ar' => 'اسم عملك أو شركتك'],
                'is_translatable' => true,
                'order' => 1,
            ],
            [
                'key' => 'crm_business_tagline',
                'value' => ['en' => 'فصل ستائرك على كيف كيفك', 'ar' => 'فصل ستائرك على كيف كيفك'],
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Business Tagline', 'ar' => 'الشعار التسويقي'],
                'description' => ['en' => 'Short marketing slogan', 'ar' => 'شعار قصير'],
                'is_translatable' => true,
                'order' => 2,
            ],
            [
                'key' => 'crm_business_description',
                'value' => [
                    'en' => 'مصنع فن الستارة نفتخر بتوفير معدات حديثة وفريق من الحرفيين الماهرين ملتزمين بتقديم ستائر عالية الجودة للمساحات السكنية والتجارية والحكومية.',
                    'ar' => 'مصنع فن الستارة نفتخر بتوفير معدات حديثة وفريق من الحرفيين الماهرين ملتزمين بتقديم ستائر عالية الجودة للمساحات السكنية والتجارية والحكومية.',
                ],
                'type' => 'textarea',
                'group' => 'business',
                'label' => ['en' => 'Business Description', 'ar' => 'نبذة عن العمل'],
                'description' => ['en' => 'One-paragraph company description used in hero/footer', 'ar' => 'فقرة وصف الشركة'],
                'is_translatable' => true,
                'order' => 3,
            ],
            [
                'key' => 'crm_business_logo',
                'value' => '/storage/images/curtainsart/logo.svg',
                'type' => 'image',
                'group' => 'business',
                'label' => ['en' => 'Business Logo', 'ar' => 'شعار العمل'],
                'description' => ['en' => 'Company logo image', 'ar' => 'صورة شعار الشركة'],
                'is_translatable' => false,
                'order' => 4,
            ],
            [
                'key' => 'crm_business_favicon',
                'value' => '/storage/images/curtainsart/favicon.jpg',
                'type' => 'image',
                'group' => 'business',
                'label' => ['en' => 'Favicon', 'ar' => 'أيقونة المفضلة'],
                'description' => ['en' => 'Website favicon (small icon)', 'ar' => 'أيقونة الموقع الصغيرة'],
                'is_translatable' => false,
                'order' => 5,
            ],
            [
                'key' => 'crm_business_founded_year',
                'value' => '2016',
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Founded Year', 'ar' => 'سنة التأسيس'],
                'description' => ['en' => 'Year the business was founded', 'ar' => 'سنة تأسيس العمل'],
                'is_translatable' => false,
                'order' => 6,
            ],
            [
                'key' => 'crm_business_founded_label',
                'value' => ['en' => 'سنة التأسيس', 'ar' => 'سنة التأسيس'],
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Founded Year Label', 'ar' => 'تسمية سنة التأسيس'],
                'description' => ['en' => 'Caption shown next to the founded year', 'ar' => 'تسمية تظهر بجانب سنة التأسيس'],
                'is_translatable' => true,
                'order' => 7,
            ],
            [
                'key' => 'crm_business_year_founded',
                'value' => '2016',
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Footer Year', 'ar' => 'سنة التذييل'],
                'description' => ['en' => 'Year shown in footer copyright', 'ar' => 'سنة تظهر في حقوق الملكية بالتذييل'],
                'is_translatable' => false,
                'order' => 8,
            ],
            [
                'key' => 'crm_business_stats',
                // Live WP stats (verified 2026-05-02): 900+ projects, 320+ in
                // progress, 47+ government bodies, 10+ years experience.
                'value' => json_encode([
                    ['value' => '900+', 'label' => ['en' => 'مشروع منجز', 'ar' => 'مشروع منجز']],
                    ['value' => '320+', 'label' => ['en' => 'طلب قيد التنفيذ', 'ar' => 'طلب قيد التنفيذ']],
                    ['value' => '47+',  'label' => ['en' => 'جهة حكومية',     'ar' => 'جهة حكومية']],
                    ['value' => '10+',  'label' => ['en' => 'سنوات خبرة',      'ar' => 'سنوات خبرة']],
                ], JSON_UNESCAPED_UNICODE),
                'type' => 'json',
                'group' => 'business',
                'label' => ['en' => 'Business Stats', 'ar' => 'إحصائيات العمل'],
                'description' => ['en' => 'Hero stats bar (value + Arabic label)', 'ar' => 'شريط الإحصائيات في الهيرو'],
                'is_translatable' => false,
                'order' => 9,
            ],
            [
                'key' => 'crm_business_price_range',
                'value' => 'SAR 250 - SAR 50000',
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Price Range', 'ar' => 'النطاق السعري'],
                'description' => ['en' => 'Business price range (e.g., SAR 500 - SAR 20000)', 'ar' => 'النطاق السعري للخدمات'],
                'is_translatable' => false,
                'order' => 10,
            ],
            [
                'key' => 'crm_business_opens',
                'value' => '09:00',
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Opening Time', 'ar' => 'وقت الفتح'],
                'description' => ['en' => 'Business opening time (24-hour format)', 'ar' => 'وقت فتح العمل'],
                'is_translatable' => false,
                'order' => 11,
            ],
            [
                'key' => 'crm_business_closes',
                'value' => '22:00',
                'type' => 'text',
                'group' => 'business',
                'label' => ['en' => 'Closing Time', 'ar' => 'وقت الإغلاق'],
                'description' => ['en' => 'Business closing time (24-hour format)', 'ar' => 'وقت إغلاق العمل'],
                'is_translatable' => false,
                'order' => 12,
            ],

            // ── SEO ───────────────────────────────────────────────────────
            [
                'key' => 'crm_seo_default_title',
                'value' => [
                    'en' => 'مصنع فن الستارة | افضل مصنع ستائر بالرياض و المملكة',
                    'ar' => 'مصنع فن الستارة | افضل مصنع ستائر بالرياض و المملكة',
                ],
                'type' => 'text',
                'group' => 'seo',
                'label' => ['en' => 'Default SEO Title', 'ar' => 'عنوان SEO الافتراضي'],
                'description' => ['en' => 'Default meta title for pages', 'ar' => 'عنوان الميتا الافتراضي للصفحات'],
                'is_translatable' => true,
                'order' => 1,
            ],
            [
                'key' => 'crm_seo_default_description',
                'value' => [
                    'en' => 'تصنيع وتفصيل جميع أنواع الستائر — رول، أمريكي، خشبية، معدنية، عمودية، رومانية، زيبرا، شتر — بالرياض. ضمان شامل وأسعار تنافسية.',
                    'ar' => 'تصنيع وتفصيل جميع أنواع الستائر — رول، أمريكي، خشبية، معدنية، عمودية، رومانية، زيبرا، شتر — بالرياض. ضمان شامل وأسعار تنافسية.',
                ],
                'type' => 'textarea',
                'group' => 'seo',
                'label' => ['en' => 'Default SEO Description', 'ar' => 'وصف SEO الافتراضي'],
                'description' => ['en' => 'Default meta description for pages', 'ar' => 'وصف الميتا الافتراضي للصفحات'],
                'is_translatable' => true,
                'order' => 2,
            ],

            // ── API Keys ──────────────────────────────────────────────────
            [
                'key' => 'crm_gemini_api_key',
                'value' => env('GEMINI_API_KEY', ''),
                'type' => 'text',
                'group' => 'api',
                'label' => ['en' => 'Gemini API Key', 'ar' => 'مفتاح Gemini API'],
                'description' => ['en' => 'Google Gemini AI API key for AI features', 'ar' => 'مفتاح Google Gemini AI للميزات الذكية'],
                'is_translatable' => false,
                'order' => 1,
            ],

            // ── Brand / Theme ─────────────────────────────────────────────
            [
                'key' => 'crm_brand_primary_color',
                'value' => '#0074b3',
                'type' => 'text',
                'group' => 'brand',
                'label' => ['en' => 'Primary Color', 'ar' => 'اللون الأساسي'],
                'description' => ['en' => 'Primary brand color (hex)', 'ar' => 'اللون الأساسي للعلامة التجارية'],
                'is_translatable' => false,
                'order' => 1,
            ],
            [
                'key' => 'crm_brand_secondary_color',
                'value' => '#005a8e',
                'type' => 'text',
                'group' => 'brand',
                'label' => ['en' => 'Secondary Color', 'ar' => 'اللون الثانوي'],
                'description' => ['en' => 'Secondary brand color (hex)', 'ar' => 'اللون الثانوي للعلامة التجارية'],
                'is_translatable' => false,
                'order' => 2,
            ],
            [
                'key' => 'crm_brand_accent_color',
                'value' => '#64c5d8',
                'type' => 'text',
                'group' => 'brand',
                'label' => ['en' => 'Accent Color', 'ar' => 'اللون المميز'],
                'description' => ['en' => 'Accent brand color (hex)', 'ar' => 'اللون المميز'],
                'is_translatable' => false,
                'order' => 3,
            ],
            [
                'key' => 'crm_brand_font_family',
                'value' => 'Tajawal',
                'type' => 'text',
                'group' => 'brand',
                'label' => ['en' => 'Font Family', 'ar' => 'نوع الخط'],
                'description' => ['en' => 'Google Font family name', 'ar' => 'اسم خط Google'],
                'is_translatable' => false,
                'order' => 4,
            ],
            [
                'key' => 'crm_brand_font_url',
                'value' => 'https://fonts.bunny.net/css?family=tajawal:400,500,600,700,800',
                'type' => 'text',
                'group' => 'brand',
                'label' => ['en' => 'Font URL', 'ar' => 'رابط الخط'],
                'description' => ['en' => 'Font stylesheet URL (bunny or google)', 'ar' => 'رابط ملف CSS للخط'],
                'is_translatable' => false,
                'order' => 5,
            ],

            // ── Navigation Visibility ─────────────────────────────────────
            [
                'key' => 'crm_nav_hidden_items',
                'value' => [],
                'type' => 'json',
                'group' => 'navigation',
                'label' => ['en' => 'Hidden Navigation Items', 'ar' => 'عناصر التنقل المخفية'],
                'description' => ['en' => 'Sidebar items hidden by admin', 'ar' => 'عناصر القائمة الجانبية المخفية'],
                'is_translatable' => false,
                'order' => 1,
            ],
            [
                'key' => 'crm_nav_force_shown_items',
                'value' => [],
                'type' => 'json',
                'group' => 'navigation',
                'label' => ['en' => 'Force-Shown Navigation Items', 'ar' => 'عناصر التنقل المعروضة دائماً'],
                'description' => ['en' => 'Items shown even when empty', 'ar' => 'عناصر تظهر حتى لو كانت فارغة'],
                'is_translatable' => false,
                'order' => 2,
            ],
        ];

        foreach ($settings as $setting) {
            CrmSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        $this->command->info(sprintf('✅ CrmSettingsSeeder: %d keys upserted.', count($settings)));
    }
}
