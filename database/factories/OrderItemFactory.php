<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        $book = Book::inRandomOrder()->first() ?? Book::factory()->create();

        return [
            'id' => Str::uuid()->toString(),
            'order_id' => Order::factory(),
            'book_id' => $book->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'unit_price' => $book->price,
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
