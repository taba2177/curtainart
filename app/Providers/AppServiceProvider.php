<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Console\Commands\ExportHome;
use App\Console\Commands\ExportAllPages;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register artisan commands.
     */
    public function commands($commands = []): void
    {
        $commands = array_merge($commands, [ExportHome::class, ExportAllPages::class]);
        parent::commands($commands);
    }
}
