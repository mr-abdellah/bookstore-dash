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
        $path = public_path('csv/books.csv');
        $handle = fopen($path, 'r');
        $headers = fgetcsv($handle, 0, ';');

        // Read one random row
        $rows = [];
        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            $rows[] = $row;
        }
        fclose($handle);

        $book = $this->faker->randomElement($rows);
        $bookData = array_combine($headers, $book);

        return [
            'id' => Str::uuid()->toString(),
            'author_id' => Author::pluck('id')->random(),
            'category_id' => Category::pluck('id')->random(),
            'publishing_house_id' => PublishingHouse::pluck('id')->random(),
            'discount_id' => null,
            'title' => $bookData['Book-Title'],
            'description' => $this->faker->paragraph(5),
            'price' => $this->faker->randomFloat(2, 500, 5000),
            'language' => $this->faker->randomElement(['Arabic', 'French', 'English']),
            'dimensions' => $this->faker->randomElement(['14x21 cm', '16x24 cm', '20x28 cm']),
            'pages_count' => $this->faker->numberBetween(100, 600),
            'images' => [$bookData['Image-URL-L']],
            'cover' => $bookData['Image-URL-L'],
            'created_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-3 years', 'now'),
        ];
    }
}
