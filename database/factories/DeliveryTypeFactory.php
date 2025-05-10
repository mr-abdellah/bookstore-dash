<?php

namespace Database\Factories;

use App\Models\DeliveryType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DeliveryTypeFactory extends Factory
{
    protected $model = DeliveryType::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'name' => $this->faker->company() . ' Delivery',
            'logo_url' => $this->faker->imageUrl(200, 200, 'business'),
            'api_code' => Str::random(10),
            'estimated_delay' => $this->faker->randomElement([1, 2, 3, 5, 7]), // Integer days
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
