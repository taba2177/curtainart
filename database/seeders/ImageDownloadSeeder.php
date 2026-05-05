<?php

namespace Database\Seeders;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Taba\Crm\Models\Post;

/**
 * Downloads brand assets and product/gallery images from the upstream
 * مصنع فن الستارة WordPress site into public/images/curtainsart/, registers
 * each one as a Curator Media record, and rewrites the path-based references
 * inside post seed data into Media-id references.
 *
 * The two-step rewrite is necessary because the taba/crm Post model casts
 * the `images` column through a getImagesAttribute accessor that does
 * `Media::whereIn('id', $imageIds)` — i.e. it expects integer Media IDs, not
 * file path strings. Posts are seeded first (in PostSeeder) with placeholder
 * paths so the data file stays human-readable; this seeder then resolves
 * those paths to media IDs after the files are on disk.
 *
 * Idempotent: re-runs without redownloading files, recreating Media rows, or
 * re-rewriting post references.
 */
class ImageDownloadSeeder extends Seeder
{
    private const BASE = 'https://forestgreen-ant-818944.hostingersite.com/wp-content/uploads/2024/06';

    /** Local relative path → upstream URL. All URLs verified 200 against live site. */
    private const IMAGES = [
        // Brand
        'logo.svg'             => self::BASE . '/Artboard-1.svg',
        'logo-ar.svg'          => self::BASE . '/%D9%84%D9%88%D8%AC%D9%88.svg',
        'favicon.jpg'          => self::BASE . '/cropped-Artboard-11.jpg',

        // Hero — uses the WP og:image (a high-quality curtain composition)
        'hero/hero-main.webp'  => self::BASE . '/pixlr-image-generator-a0dd6c36-5931-4c6c-9356-d263973f2e5e-768x768-2-copy.webp',

        // About
        'about/tailoring.jpg'  => self::BASE . '/khyatah-1024x683.jpg',

        // Products (8 types)
        'products/roll.webp'     => self::BASE . '/pixlr-image-generator-55887109-9d54-404e-a152-70cfd69c7898-768x768-1-copy-600x600.webp',
        'products/american.webp' => self::BASE . '/%D8%A7%D9%85%D8%B1%D9%8A%D9%83%D9%8A-1-600x600.webp',
        'products/wooden.webp'   => self::BASE . '/golden-oak-tan-41-wooden-blind-50-1-cl5-copy-500x600.webp',
        'products/metal.webp'    => self::BASE . '/%D9%85%D8%B9%D8%AF%D9%86%D9%8A%D8%A9-1-600x600.webp',
        'products/vertical.webp' => self::BASE . '/valencia-dove-26-vertical-blind-1-1000x1000-copy-600x600.webp',
        'products/roman.webp'    => self::BASE . '/pixlr-image-generator-a1327f94-9ba3-4924-94b2-a87bc65b43e0-768x768-1-copy-600x600.webp',
        'products/zebra.webp'    => self::BASE . '/enjoy-thunder-grey-36-enjoy-roller-blind-a2-copy.webp',
        'products/shutter.webp'  => self::BASE . '/perfectfit-white-23-perfect-fit-shutter-2a-1000x1000-copy-600x600.webp',

        // Team — meet the experts behind the curtains (from /about page)
        'team/ceo.png'        => 'https://forestgreen-ant-818944.hostingersite.com/wp-content/uploads/2021/09/team-1-2-copy.png',
        'team/sales.png'      => 'https://forestgreen-ant-818944.hostingersite.com/wp-content/uploads/2021/09/team-1-1.png',
        'team/marketing.png'  => 'https://forestgreen-ant-818944.hostingersite.com/wp-content/uploads/2021/09/team-1-3.png',

        // Company profile PDF — the original site's "بروفايل الشركة" download
        'company-profile.pdf' => 'https://forestgreen-ant-818944.hostingersite.com/wp-content/uploads/2024/07/%D9%87%D9%88%D9%8A%D8%A9-%D9%81%D9%86-%D8%A7%D9%84%D8%B3%D8%AA%D8%A7%D8%B1%D8%A9.pdf',

        // Product detail variants — extras shown on product detail pages
        'products/roll-detail-1.webp' => self::BASE . '/product-details-3-copy.webp',
        'products/roll-detail-2.webp' => self::BASE . '/product-details-4-copy.webp',

        // Gallery / project photos (real photos from the WP site's projects section)
        'gallery/01.jpg' => self::BASE . '/13.jpg',
        'gallery/02.jpg' => self::BASE . '/14-2.jpg',
        'gallery/03.png' => self::BASE . '/15.png',
        'gallery/04.jpg' => self::BASE . '/16-1.jpg',
        'gallery/05.png' => self::BASE . '/17-2.png',
        'gallery/06.jpg' => self::BASE . '/18.jpg',
        'gallery/07.jpg' => self::BASE . '/20.jpg',
        'gallery/08.png' => self::BASE . '/21-1.png',
        'gallery/09.jpg' => self::BASE . '/22-3.jpg',
        'gallery/10.jpg' => self::BASE . '/23-3.jpg',
        'gallery/11.png' => self::BASE . '/24.png',
        'gallery/12.jpg' => self::BASE . '/26-2.jpg',
        'gallery/13.png' => self::BASE . '/27-2.png',
        'gallery/14.jpg' => self::BASE . '/28-2.jpg',
        'gallery/15.jpg' => self::BASE . '/30-2.jpg',
        'gallery/16.png' => self::BASE . '/31.png',
        'gallery/17.jpg' => self::BASE . '/32-1-2.jpg',
        'gallery/18.jpg' => self::BASE . '/33-2-1.jpg',
        'gallery/19.jpg' => self::BASE . '/34.jpg',
        'gallery/20.jpg' => self::BASE . '/35-2.jpg',
        'gallery/21.jpg' => self::BASE . '/37-1.jpg',
    ];

    public function run(): void
    {
        // Files live under the `public` storage disk so Curator's
        // Helpers::getUrl() can resolve them via Storage::disk('public')->url().
        // The `php artisan storage:link` symlink makes them reachable at
        // /storage/images/curtainsart/... in the browser.
        $baseDir = storage_path('app/public/images/curtainsart');
        $this->ensureStorageLink();

        $downloaded = 0;
        $skipped = 0;
        $failed = 0;

        // Step 1: download files
        foreach (self::IMAGES as $relativePath => $url) {
            $dest = $baseDir . '/' . $relativePath;
            if (File::exists($dest) && File::size($dest) > 0) { $skipped++; continue; }
            File::ensureDirectoryExists(dirname($dest));
            $contents = @file_get_contents($url, false, stream_context_create([
                'http' => ['timeout' => 30, 'header' => "User-Agent: CurtainsArtImageSeeder/1.0\r\n"],
            ]));
            if ($contents === false || strlen($contents) < 100) {
                $this->command->warn("  ✗  Failed: images/curtainsart/{$relativePath} <- {$url}");
                $failed++;
                continue;
            }
            File::put($dest, $contents);
            $downloaded++;
        }

        // Step 2: register each downloaded file as a Curator Media row.
        // path→media_id map drives the post-rewrite step below. The seed-data
        // posts.php still uses /images/curtainsart/... paths for readability;
        // those map 1:1 to /storage/images/curtainsart/... at runtime via the
        // storage symlink, but Media records track the disk-relative path.
        $pathToId = [];
        foreach (self::IMAGES as $relativePath => $_) {
            $publicPath = '/images/curtainsart/' . $relativePath;
            $diskPath   = 'images/curtainsart/' . $relativePath;
            $absolute   = $baseDir . '/' . $relativePath;
            if (!File::exists($absolute)) continue;

            $name = pathinfo($relativePath, PATHINFO_FILENAME);
            $ext  = strtolower(pathinfo($relativePath, PATHINFO_EXTENSION));
            $size = File::size($absolute);
            [$w, $h] = $this->safeImageSize($absolute);

            $media = Media::firstOrCreate(
                ['path' => $diskPath, 'disk' => 'public'],
                [
                    'directory'  => dirname($diskPath),
                    'visibility' => 'public',
                    'name'       => $name,
                    'width'      => $w,
                    'height'     => $h,
                    'size'       => $size,
                    'type'       => $this->mimeFor($ext),
                    'ext'        => $ext,
                    'alt'        => $name,
                    'title'      => $name,
                ]
            );
            $pathToId[$publicPath] = $media->id;
        }

        // Step 3: rewrite post references — `images` JSON column gets media
        // IDs instead of file paths, and `image_id` gets the first image's id.
        $rewritten = 0;
        $posts = Post::all();
        foreach ($posts as $post) {
            $raw = DB::table('posts')->where('id', $post->id)->value('images');
            $decoded = is_string($raw) ? json_decode($raw, true) : $raw;
            if (!is_array($decoded) || empty($decoded)) continue;

            $allPaths = collect($decoded)->every(fn($v) => is_string($v) && str_starts_with($v, '/'));
            if (!$allPaths) continue; // already rewritten or non-path values

            $ids = [];
            foreach ($decoded as $p) {
                if (isset($pathToId[$p])) $ids[] = $pathToId[$p];
            }
            if (empty($ids)) continue;

            DB::table('posts')->where('id', $post->id)->update([
                'images'   => json_encode($ids),
                'image_id' => $ids[0],
            ]);
            $rewritten++;
        }

        $this->command->info(sprintf(
            '✅ ImageDownloadSeeder: %d downloaded, %d already-present, %d failed; %d media rows; %d posts re-linked.',
            $downloaded, $skipped, $failed, count($pathToId), $rewritten
        ));
    }

    /**
     * Ensure public/storage → storage/app/public symlink exists so the
     * Curator-generated /storage/... URLs resolve in the browser.
     */
    private function ensureStorageLink(): void
    {
        $link = public_path('storage');
        if (file_exists($link)) return;
        try {
            \Illuminate\Support\Facades\Artisan::call('storage:link');
        } catch (\Throwable $e) {
            $this->command->warn('  ⚠  storage:link failed: ' . $e->getMessage());
        }
    }

    private function safeImageSize(string $absolute): array
    {
        if (!function_exists('getimagesize')) return [null, null];
        $ext = strtolower(pathinfo($absolute, PATHINFO_EXTENSION));
        if ($ext === 'svg') return [null, null];
        $info = @getimagesize($absolute);
        return [$info[0] ?? null, $info[1] ?? null];
    }

    private function mimeFor(string $ext): string
    {
        return match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png'         => 'image/png',
            'webp'        => 'image/webp',
            'svg'         => 'image/svg+xml',
            'gif'         => 'image/gif',
            default       => 'application/octet-stream',
        };
    }
}
