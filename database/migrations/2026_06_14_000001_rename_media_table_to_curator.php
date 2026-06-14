<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * filament-curator v4 renamed its table from `media` to `curator`.
     * Existing databases seeded under v3 still hold the old `media` table,
     * which breaks the Post `image` relation (it queries `curator`).
     * Rename it in place to preserve already-stored media records.
     */
    public function up(): void
    {
        if (Schema::hasTable('media') && ! Schema::hasTable('curator')) {
            Schema::rename('media', 'curator');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('curator') && ! Schema::hasTable('media')) {
            Schema::rename('curator', 'media');
        }
    }
};
