<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\PublishingHouse;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BookStoreSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $publishingHouse = PublishingHouse::first();
        $authors = Author::where('publishing_house_id', $publishingHouse->id)->get();
        $categories = Category::where('publishing_house_id', $publishingHouse->id)->get();

        for ($i = 0; $i < 50; $i++) {
            Book::create([
                'author_id' => $authors->random()->id,
                'category_id' => $categories->random()->id,
                'publishing_house_id' => $publishingHouse->id,
                'title' => $faker->sentence(3),
                'description' => $faker->paragraph(5),
                'price' => $faker->randomFloat(2, 10, 100),
                'language' => $faker->randomElement(['en', 'fr', 'ar']),
                'dimensions' => $faker->randomElement(['A4', 'A5', 'Letter']),
                'pages_count' => $faker->numberBetween(50, 500),
                'quantity' => $faker->numberBetween(1, 100),
            ]);
        }
    }
}
