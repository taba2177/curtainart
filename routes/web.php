<?php

use Illuminate\Support\Facades\Route;

$serveAngular = function () {
    $indexPath = public_path('app.html');
    if (!file_exists($indexPath)) {
        abort(404, 'Angular app not built.');
    }
    $html = file_get_contents($indexPath);

    // Inject CRM theme CSS custom properties into the <head>
    $themeCss = crm_theme_css();
    if ($themeCss) {
        $html = str_replace('</head>', $themeCss . "\n</head>", $html);
    }

    return response($html, 200, ['Content-Type' => 'text/html']);
};

Route::get('/', $serveAngular)->name('angular.home');
Route::get('/contact', $serveAngular)->name('angular.contact');
// Serve Angular for all frontend paths, excluding Laravel-reserved prefixes
Route::get('/{slug}', $serveAngular)->where('slug', '^(?!api|admin|livewire|filament|storage|_|lang).*$')->name('angular.category');
Route::get('/{category}/{post}', $serveAngular)->where('category', '^(?!api|admin|livewire|filament|storage|_|lang).*$')->name('angular.post');
