<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookView;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookViewFactory extends Factory
{
    protected $model = BookView::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'book_id' => Book::factory(),
            'user_id' => $this->faker->randomElement([null, User::factory()]),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'viewed_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
