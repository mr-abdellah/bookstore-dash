<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\PublishingHouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'author_id' => Author::factory(),
            'category_id' => Category::factory(),
            'publishing_house_id' => PublishingHouse::factory(),
            'discount_id' => null,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(5),
            'price' => $this->faker->randomFloat(2, 500, 5000),
            'language' => $this->faker->randomElement(['Arabic', 'French', 'English']),
            'dimensions' => $this->faker->randomElement(['14x21 cm', '16x24 cm', '20x28 cm']),
            'pages_count' => $this->faker->numberBetween(100, 600),
            'images' => [
                $this->faker->imageUrl(300, 400, 'books'),
                $this->faker->imageUrl(300, 400, 'books'),
            ],
            'created_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
        ];
    }
}
