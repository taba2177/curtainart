<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting CRM database seeding...');
        $this->command->newLine();

        // Create roles and permissions first
        $this->call(RolesAndPermissionsSeeder::class);

        // Then create the user
        $this->call(UserSeeder::class);

        // Seed CurtainsArt categories and posts (data files in seeders/data/)
        $this->call(PostCategorySeeder::class);
        $this->call(PostSeeder::class);

        // Seed CRM settings (must be after posts/categories for SEO defaults)
        $this->call(CrmSettingsSeeder::class);

        // Download brand assets and product/gallery imagery from upstream WP
        // (idempotent — skips files already on disk).
        $this->call(ImageDownloadSeeder::class);

        $this->command->newLine();
        $this->command->info('✅ CRM database seeding completed!');


        // Notification::make()
        //     ->title('Welcome to Filament')
        //     ->body('You are ready to start building your application.')
        //     ->success()
        //     ->sendToDatabase(User::first());
    }
}
