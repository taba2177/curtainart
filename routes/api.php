<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/ping', function () { return ['status' => 'ok']; });

Route::prefix('v1')->group(function () {
    Route::get('/home',                          [HomeController::class, 'index']);
    Route::get('/navigation',                    [HomeController::class, 'navigation']);
    Route::get('/categories/{slug}',             [HomeController::class, 'category']);
    Route::get('/categories/{category}/{post}',  [HomeController::class, 'post']);
    Route::post('/contact',                      [HomeController::class, 'contact']);
});
