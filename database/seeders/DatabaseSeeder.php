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
        // $this->call(AdminUserSeeder::class);
        // \App\Models\User::factory(10)->create(); // Creates 10 users
        // \App\Models\Author::factory()->create();
        // \App\Models\PublishingHouse::factory(5)->create();
        // \App\Models\Category::factory()->create();
        // \App\Models\Book::factory(50)->create();
        // \App\Models\Stock::factory(50)->create();
        // \App\Models\Order::factory(30)->create();
        // \App\Models\OrderItem::factory(100)->create();
        Category::factory()->count(40)->create();

        // Seed 40 authors
        Author::factory()->count(40)->create();


    }
}
