<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ExportHome extends Command
{
    protected $signature = 'export:home {--output=public/export} {--anchors=#}';
    protected $description = 'Render the home page and export a static index.html with anchor-only links';

    public function handle(): int
    {
        $outputDir = $this->option('output') ?? 'public/export';
        $anchorReplacement = $this->option('anchors') ?? '#';

        $this->info('Rendering home page...');
        $response = app()->handle(Request::create('/', 'GET'));
        $html = $response->getContent();

        if (empty($html)) {
            $this->error('Home page returned empty content.');
            return self::FAILURE;
        }

        // Rewrite links to anchors: replace hrefs that are not anchors/mail/tel to #
        $rewritten = preg_replace(
            '/href\s*=\s*"(?!#|tel:|mailto:|javascript:)[^"]+"/i',
            'href="' . $anchorReplacement . '"',
            $html
        );

        // Ensure directory exists
        File::ensureDirectoryExists($outputDir);
        $path = rtrim($outputDir, '/\\') . DIRECTORY_SEPARATOR . 'index.html';
        File::put($path, $rewritten);

        $this->info("Exported home to: {$path}");
        return self::SUCCESS;
    }
}
