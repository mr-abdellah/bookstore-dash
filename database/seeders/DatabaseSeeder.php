<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Category;
use App\Models\PlatformSettings;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Category::factory()->count(40)->create();
        // Author::factory()->count(40)->create();
        \App\Models\Book::factory(50)->create();

    }
}
