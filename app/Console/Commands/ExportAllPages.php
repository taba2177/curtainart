<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Taba\Crm\Models\PostCategory;
use Taba\Crm\Models\Post;

class ExportAllPages extends Command
{
    protected $signature = 'export:all {--output=public/export} {--anchors=#}';
    protected $description = 'Export home, categories, and posts to static files, then anchorize outer links on home.';

    public function handle(): int
    {
        $outputDir = $this->option('output') ?? 'public/export';
        $anchorReplacement = $this->option('anchors') ?? '#';
        File::ensureDirectoryExists($outputDir);

        $urls = [];
        // Home
        $urls['/'] = 'index.html';

        // Categories
        try {
            $categories = PostCategory::query()->orderBy('order', 'asc')->get();
            foreach ($categories as $cat) {
                $slug = $cat->slug;
                if (!$slug) continue;
                $urls['/'.ltrim($slug, '/')] = trim($slug, '/').'/index.html';
            }
        } catch (\Throwable $e) {
            $this->warn('Skipping categories: '.$e->getMessage());
        }

        // Posts
        try {
            $posts = Post::query()->orderBy('order','asc')->get();
            foreach ($posts as $post) {
                $url = $post->url ?? null;
                if (!$url) continue;
                // ensure leading slash
                $path = parse_url($url, PHP_URL_PATH) ?: '/';
                $cleanPath = '/'.ltrim($path, '/');
                if ($cleanPath === '/') continue; // already included
                $urls[$cleanPath] = trim($cleanPath, '/').'/index.html';
            }
        } catch (\Throwable $e) {
            $this->warn('Skipping posts: '.$e->getMessage());
        }

        // Copy static assets (build, css, js, images) from public to export
        $publicPath = public_path();
        $this->info('Copying assets...');
        foreach (['build','css','js','images'] as $assetDir) {
            $src = $publicPath.DIRECTORY_SEPARATOR.$assetDir;
            $dest = rtrim($outputDir, '/\\').DIRECTORY_SEPARATOR.$assetDir;
            if (is_dir($src)) {
                File::ensureDirectoryExists($dest);
                File::copyDirectory($src, $dest);
                $this->line("✔ Copied assets: {$assetDir}");
            }
        }

        $this->info('Exporting pages: '.count($urls));

        foreach ($urls as $url => $filename) {
            try {
                $response = app()->handle(Request::create($url, 'GET'));
                $status = method_exists($response, 'getStatusCode') ? $response->getStatusCode() : 200;
                if ($status >= 400) {
                    $this->warn("Skipping {$url}, status {$status}");
                    continue;
                }
                $html = $response->getContent();
                if (empty($html)) {
                    $this->warn("Empty content for {$url}");
                    continue;
                }
                // Rewrite absolute asset URLs to relative paths for portability
                $html = $this->rewriteAssetsToRelative($html);

                $targetPath = rtrim($outputDir, '/\\').DIRECTORY_SEPARATOR.$filename;
                File::ensureDirectoryExists(dirname($targetPath));
                File::put($targetPath, $html);
                $this->line("✔ Exported {$url} -> {$filename}");
            } catch (\Throwable $e) {
                $this->warn("Error exporting {$url}: ".$e->getMessage());
            }
        }

        // Post-process home: rewrite outer links to anchors (only <a> tags)
        $homePath = rtrim($outputDir, '/\\').DIRECTORY_SEPARATOR.'index.html';
        if (File::exists($homePath)) {
            $homeHtml = File::get($homePath);
            // Replace only anchor hrefs, not <link rel=...> or other tags
            $rewritten = preg_replace_callback('/<a\s+[^>]*href\s*=\s*"([^"]+)"[^>]*>/i', function($m) use ($anchorReplacement) {
                $href = $m[1];
                if (preg_match('/^(#|tel:|mailto:|javascript:)/i', $href)) {
                    return $m[0];
                }
                return str_replace($href, $anchorReplacement, $m[0]);
            }, $homeHtml);
            File::put($homePath, $rewritten);
            $this->info('Anchorized links on home page.');
        } else {
            $this->warn('Home page not found to anchorize.');
        }

        $this->info('Export complete: '.$outputDir);
        return self::SUCCESS;
    }

    /**
     * Convert absolute public asset paths to relative ones for static export.
     */
    protected function rewriteAssetsToRelative(string $html): string
    {
        // Handle common asset prefixes
        $patterns = [
            // href/src="/build/..." -> href/src="./build/..."
            '/(href|src)\s*=\s*"\/build\//i' => '$1="./build/',
            '/(href|src)\s*=\s*"\/css\//i'   => '$1="./css/',
            '/(href|src)\s*=\s*"\/js\//i'    => '$1="./js/',
            '/(href|src)\s*=\s*"\/images\//i'=> '$1="./images/',
            // Absolute localhost URLs to relative
            '/(href|src)\s*=\s*"https?:\/\/localhost\/(build\/)/i' => '$1="./$2',
            '/(href|src)\s*=\s*"https?:\/\/localhost\/(css\/)/i'   => '$1="./$2',
            '/(href|src)\s*=\s*"https?:\/\/localhost\/(js\/)/i'    => '$1="./$2',
            '/(href|src)\s*=\s*"https?:\/\/localhost\/(images\/)/i'=> '$1="./$2',
            '/(href|src)\s*=\s*"https?:\/\/localhost\/(storage\/)/i'=> '$1="./$2',
        ];
        foreach ($patterns as $pattern => $replace) {
            $html = preg_replace($pattern, $replace, $html);
        }
        return $html;
    }
}
