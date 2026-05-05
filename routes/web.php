<?php

use App\Http\Controllers\HomepagePreviewController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Support\Facades\Route;

Route::get("/api/v1/home", [HomeController::class, "index"]);
Route::get("/api/v1/navigation", [HomeController::class, "navigation"]);
Route::get("/api/v1/categories/{slug}", [HomeController::class, "category"]);
Route::get("/api/v1/categories/{category}/{post}", [HomeController::class, "post"]);
Route::post("/api/v1/contact", [HomeController::class, "contact"]);

Route::get('/preview/home/{variant}', [HomepagePreviewController::class, 'show'])
    ->where('variant', 'editorial-premium|bold-modular|calm-storytelling')
    ->name('homepage.preview');

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
// Also map the generic paths BUT only if they don't match admin or api
Route::get('/{slug}', $serveAngular)->where('slug', '^(?!api|admin|livewire|filament|storage|_|lang).*$')->name('angular.category');
Route::get('/{category}/{post}', $serveAngular)->where('category', '^(?!api|admin|livewire|filament|storage|_|lang).*$')->name('angular.post');

