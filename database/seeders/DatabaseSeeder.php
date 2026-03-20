<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DegreeLevelsSeeder::class,
        ]);

        // Legacy seeders live in database/seeds/ (different namespace).
        // Run them manually if needed, e.g.:
        // php artisan db:seed --class=CmsTranslationSeeder
    }
}
